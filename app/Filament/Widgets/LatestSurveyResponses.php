<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSurveyResponses extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SurveyResponse::query()
                    ->with('survey')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('survey.title')
                    ->label('Анкета')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Деталі')
                    ->url(fn (SurveyResponse $record) => route('filament.admin.resources.surveys.results', $record->survey))
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
