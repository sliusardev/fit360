<?php

namespace App\Filament\Panel\Pages\Auth;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\Company;
use App\Models\PaymentPlan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Str;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        ...$this->getNewFields(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getNewFields(): array
    {
        return [
            TextInput::make('last_name')
                ->label(trans('dashboard.last_name'))
                ->required(),

            TextInput::make('middle_name')
                ->label(trans('dashboard.middle_name')),

            TextInput::make('phone')
                ->label(trans('dashboard.phone'))
                ->unique($this->getUserModel())
                ->required(),

            DatePicker::make('birth_day')
                ->label(trans('dashboard.birth_day'))
                ->date()
                ->required(),

            Select::make('gender')
                ->label(trans('dashboard.gender'))
                ->required()
                ->options(GenderEnum::allValuesTranslated())
                ->preload(),
        ];
    }

    public function register(): ?RegistrationResponse
    {
        parent::register();

        $user = auth()->user();

        $user->assignRole(RoleEnum::CLIENT->value);

        return app(RegistrationResponse::class);
    }

}
