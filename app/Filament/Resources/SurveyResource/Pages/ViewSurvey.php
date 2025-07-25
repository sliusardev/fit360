<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSurvey extends ViewRecord
{
    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('qrcode')
                ->label('QR-код')
                ->url(fn () => static::getResource()::getUrl('qrcode', ['record' => $this->record])),
            Actions\EditAction::make(),
        ];
    }
}
