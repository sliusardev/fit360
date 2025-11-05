<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipUserResource\Pages;
use App\Models\Membership;
use App\Models\MembershipUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class MembershipUserResource extends Resource
{
    protected static ?string $model = MembershipUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = 'Manage';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.manage');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.membership_users') ?: 'Membership Users';
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.membership_users') ?: 'Membership Users';
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.membership_user') ?: 'Membership User';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label(trans('dashboard.user') ?: 'User')
                                    ->relationship('user', 'name')
                                    ->options(User::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('membership_id')
                                    ->label(trans('dashboard.membership') ?: 'Membership')
                                    ->relationship('membership', 'name')
                                    ->options(Membership::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),

                        Grid::make(3)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label(trans('dashboard.start_date') ?: 'Start date')
                                    ->native(false)
                                    ->required(),

                                DatePicker::make('end_date')
                                    ->label(trans('dashboard.end_date') ?: 'End date')
                                    ->native(false)
                                    ->required(),

                                TextInput::make('visit_limit')
                                    ->label(trans('dashboard.visit_limit') ?: 'Visit limit')
                                    ->numeric()
                                    ->minValue(1)
                                    ->nullable(),
                            ]),

                        Toggle::make('is_enabled')
                            ->label(trans('dashboard.is_enabled') ?: 'Enabled')
                            ->inline(false)
                            ->default(true),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')
                    ->label(trans('dashboard.user') ?: 'User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('membership.name')
                    ->label(trans('dashboard.membership') ?: 'Membership')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label(trans('dashboard.start_date') ?: 'Start date')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(trans('dashboard.end_date') ?: 'End date')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('visit_limit')
                    ->label(trans('dashboard.visit_limit') ?: 'Visit limit')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_enabled')
                    ->label(trans('dashboard.is_enabled') ?: 'Enabled')
                    ->boolean(),
                BadgeColumn::make('status')
                    ->label(trans('dashboard.status') ?: 'Status')
                    ->colors([
                        'success' => fn ($record): bool => $record->is_active,
                        'danger' => fn ($record): bool => ! $record->is_active,
                    ])
                    ->formatStateUsing(function ($record) {
                        return $record->is_active
                            ? (trans('dashboard.active') ?: 'Active')
                            : (trans('dashboard.expired') ?: 'Expired');
                    }),
            ])
            ->filters([
                Filter::make('active')
                    ->label(trans('dashboard.active') ?: 'Active')
                    ->query(function (Builder $query) {
                        return $query->where('is_enabled', true)
                            ->whereDate('end_date', '>=', now()->toDateString());
                    })
                    ->toggle(),
                Filter::make('expired')
                    ->label(trans('dashboard.expired') ?: 'Expired')
                    ->query(function (Builder $query) {
                        return $query->where(function ($q) {
                            $q->where('is_enabled', false)
                              ->orWhereDate('end_date', '<', now()->toDateString());
                        });
                    })
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembershipUsers::route('/'),
            'create' => Pages\CreateMembershipUser::route('/create'),
            'edit' => Pages\EditMembershipUser::route('/{record}/edit'),
        ];
    }
}
