<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Survey;

#[AllowDynamicProperties]
class QrcodeSurvey extends Page
{
    protected static string $resource = SurveyResource::class;

    protected static string $view = 'filament.resources.survey-resource.pages.qrcode-survey';

    public function getTitle(): string | Htmlable
    {
        return trans('dashboard.survey_qrcode');
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function resolveRecord(int|string $key): Survey
    {
        return Survey::findOrFail($key);
    }

    public function getQrCodeProperty()
    {
        return QrCode::size(200)->generate($this->getSurveyUrlProperty());
    }

    public function getSurveyUrlProperty()
    {
        return route('surveys.show', $this->record);
    }

    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
            'qrCode' => $this->getQrCodeProperty(),
            'surveyUrl' => $this->getSurveyUrlProperty(),
        ];
    }
}
