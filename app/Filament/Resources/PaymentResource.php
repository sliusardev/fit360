<?php

namespace App\Filament\Resources;

use App\Enums\PaymentStatusEnum;
use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationGroup = 'Manage';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.manage');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.payments');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.payments');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.payment');
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')
                ->sortable(),
            TextColumn::make('user.full_name')
                ->label(trans('dashboard.user'))
                ->sortable()
                ->searchable(),
            TextColumn::make('amount')
                ->label(trans('dashboard.amount'))
                ->money('UAH')
                ->sortable(),
            TextColumn::make('payable_type')
                ->label(trans('dashboard.payment_type'))
                ->formatStateUsing(fn (string $state): string => class_basename($state)),
            TextColumn::make('status')
                ->label(trans('dashboard.status'))
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    PaymentStatusEnum::PAID->value => 'success',
                    PaymentStatusEnum::CREATED->value, PaymentStatusEnum::PENDING->value => 'warning',
                    PaymentStatusEnum::FAILED->value, PaymentStatusEnum::REFUNDED->value => 'danger',
                    default => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => trans('dashboard.' . $state))
                ->sortable(),
            TextColumn::make('provider')
                ->label(trans('dashboard.provider')),
            TextColumn::make('created_at')
                ->label(trans('dashboard.created'))
                ->dateTime('d.m.Y H:i')
                ->sortable(),
        ])
        ->filters([
            SelectFilter::make('status')
                ->label(trans('dashboard.status'))
                ->options(function () {
                    $options = [];
                    foreach (PaymentStatusEnum::cases() as $case) {
                        $options[$case->value] = trans('dashboard.' . $case->value);
                    }
                    return $options;
                }),
        ])
        ->actions([
            ViewAction::make()
                ->label(trans('dashboard.details'))
                ->modalHeading(fn (Payment $record) => trans('dashboard.payment_details') . ' #' . $record->id)
                ->modalContent(fn (Payment $record) => static::getPaymentDetailsView($record)),
        ])
        ->defaultSort('created_at', 'desc');
    }

    private static function getPaymentDetailsView(Payment $payment): HtmlString
    {
        $details = [];

        $details[] = '<div class="space-y-4 text-sm">';

        // Payment info
        $details[] = '<div class="border rounded p-4">';
        $details[] = '<h3 class="text-lg font-medium mb-2">' . trans('dashboard.payment_information') . '</h3>';
        $details[] = '<div class="grid grid-cols-2 gap-2">';
        $details[] = '<div><strong>' . trans('dashboard.id') . ':</strong> ' . $payment->id . '</div>';
        $details[] = '<div><strong>' . trans('dashboard.invoice_id') . ':</strong> ' . $payment->invoice_id . '</div>';
        $details[] = '<div><strong>' . trans('dashboard.amount') . ':</strong> ' . number_format($payment->amount, 2) . ' ' . $payment->currency . '</div>';
        $details[] = '<div><strong>' . trans('dashboard.status') . ':</strong> ' . trans('dashboard.' . $payment->status) . '</div>';
        $details[] = '<div><strong>' . trans('dashboard.provider') . ':</strong> ' . $payment->provider . '</div>';
        $details[] = '<div><strong>' . trans('dashboard.created') . ':</strong> ' . $payment->created_at->format('d.m.Y H:i') . '</div>';
        $details[] = '</div>';
        $details[] = '</div>';

        // User info
        if ($payment->user) {
            $details[] = '<div class="border rounded p-4">';
            $details[] = '<h3 class="text-lg font-medium mb-2">' . trans('dashboard.user_information') . '</h3>';
            $details[] = '<div class="grid grid-cols-2 gap-2">';
            $details[] = '<div><strong>' . trans('dashboard.name') . ':</strong> ' . $payment->user->full_name . '</div>';
            $details[] = '<div><strong>' . trans('dashboard.email') . ':</strong> ' . $payment->user->email . '</div>';
            if ($payment->user->phone) {
                $details[] = '<div><strong>' . trans('dashboard.phone') . ':</strong> ' . $payment->user->phone . '</div>';
            }
            $details[] = '</div>';
            $details[] = '</div>';
        }

        // Activity info (if payment is for an activity)
        if ($payment->payable_type == Activity::class && $payment->payable) {
            $activity = $payment->payable;
            $details[] = '<div class="border rounded p-4">';
            $details[] = '<h3 class="text-lg font-medium mb-2">' . trans('dashboard.activity_information') . '</h3>';
            $details[] = '<div class="grid grid-cols-2 gap-2">';
            $details[] = '<div><strong>' . trans('dashboard.title') . ':</strong> ' . $activity->title . '</div>';
            $details[] = '<div><strong>' . trans('dashboard.start_time') . ':</strong> ' . $activity->startTimeHuman() . '</div>';
            $details[] = '<div><strong>' . trans('dashboard.duration') . ':</strong> ' . $activity->duration_minutes . ' ' . trans('dashboard.minutes') . '</div>';

            // Activity trainers
            if ($activity->trainers && $activity->trainers->count() > 0) {
                $trainerNames = $activity->trainers->pluck('name')->join(', ');
                $details[] = '<div><strong>' . trans('dashboard.trainers') . ':</strong> ' . $trainerNames . '</div>';
            }

            $details[] = '<div><strong>' . trans('dashboard.price') . ':</strong> ' . number_format($activity->price, 2) . '</div>';
            if ($activity->discount) {
                $details[] = '<div><strong>' . trans('dashboard.discount') . ':</strong> ' . $activity->discount . '</div>';
            }
            $details[] = '</div>';
            $details[] = '</div>';
        }

        // Any payload data
        if (!empty($payment->payload)) {
            $details[] = '<div class="border rounded p-4">';
            $details[] = '<h3 class="text-lg font-medium mb-2">' . trans('dashboard.additional_information') . '</h3>';
            $details[] = '<div class="overflow-auto max-h-56 text-xs">';
            $details[] = '<pre>' . json_encode($payment->payload, JSON_PRETTY_PRINT) . '</pre>';
            $details[] = '</div>';
            $details[] = '</div>';
        }

        $details[] = '</div>';

        return new HtmlString(implode("\n", $details));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
