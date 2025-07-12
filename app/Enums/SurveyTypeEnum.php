<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SurveyTypeEnum: string implements HasLabel
{
    case YES_NO = 'yes_no';
    case PLUS_MINUS = 'plus_minus';
    case TEXT = 'text';
    case RATING = 'rating';
    case CUSTOM = 'custom'; // For custom answer options

    public function getLabel(): string
    {
        return __('dashboard.survey_type.' . $this->value);
    }

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->getLabel()
        ])->toArray();
    }

    public function hasOptions(): bool
    {
        return match($this) {
            self::CUSTOM => true,
            default => false,
        };
    }
}
