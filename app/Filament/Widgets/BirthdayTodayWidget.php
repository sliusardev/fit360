<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\Action;

class BirthdayTodayWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        $today = Carbon::now()->format('m-d');

        return $table
            ->query(
                User::query()->whereRaw("DATE_FORMAT(birth_day, '%m-%d') = ?", [$today])
            )
            ->columns([

                TextColumn::make('name')->label(__('dashboard.name')),
                TextColumn::make('last_name')->label(__('dashboard.last_name')),
                TextColumn::make('age')
                    ->label(__('dashboard.age'))
                    ->getStateUsing(function ($record) {
                        if ($record->birth_day) {
                            return Carbon::parse($record->birth_day)->age;
                        }
                        return null;
                    }),
                TextColumn::make('phone')->label(__('dashboard.phone')),
                TextColumn::make('birth_day')->date('M Y')->label(__('dashboard.birth_day')),


            ])
            ->actions([
                Action::make('edit')
                    ->label(__('dashboard.edit'))
                    ->url(fn ($record) => '/admin/users/' . $record->id . '/edit', true),
            ])
            ->defaultSort('name') // Sort by name by default
            ->emptyStateHeading(__('dashboard.no_birth_days_today'));
    }

    public function getColumnSpan(): int | string | array
    {
        return 2;
    }

    public static function getSort(): int
    {
        return 2;
    }

    protected function getTableHeading(): string
    {
        return __('dashboard.birth_days_today');
    }
}
