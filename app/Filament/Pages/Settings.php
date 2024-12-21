<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\CustomFieldService;
use App\Services\SettingService;
use App\Services\ThemeService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Artisan;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';

    protected static string $view = 'filament.pages.settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'System';

    public ?array $data = [];
    /**
     * @var array|string[]
     */
    private array $parameters;
    private ?Setting $settings;

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.system');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.settings');
    }

    public function getTitle(): string | Htmlable
    {
        return trans('dashboard.settings');
    }

    public function __construct()
    {
        $this->settings = SettingService::connect();
        $this->parameters = $this->settings->data ?? [];
    }

    public function mount(): void
    {
        $this->form->fill($this->parameters);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Setting Tabs')
                    ->tabs([
                        Tab::make('Global')
                            ->label(trans('dashboard.global_settings'))
                            ->schema([
                                TextInput::make('site_name')
                                    ->label(trans('dashboard.site_name')),

                                RichEditor::make('slogan')
                                    ->label(trans('dashboard.slogan')),

                                RichEditor::make('about_us')
                                    ->label(trans('dashboard.about_us'))
                                    ->fileAttachmentsDisk('local')
                                    ->fileAttachmentsVisibility('storage')
                                    ->fileAttachmentsDirectory('public/settings'),

                                FileUpload::make('logo')
                                    ->label(trans('dashboard.logo'))
                                    ->directory('settings')
                                    ->image()
                                    ->imageEditor()
                                    ->columnSpanFull(),

                                Select::make('theme')
                                    ->label(trans('dashboard.theme'))
                                    ->options(
                                        resolve(ThemeService::class)->getAllTemplatesNames()
                                    )
                                    ->default('default')
                                    ->required(),
                            ]),

                        Tab::make('Contacts')
                            ->label(trans('dashboard.contacts'))
                            ->schema([
                                RichEditor::make('contacts')
                                    ->label(trans('dashboard.contacts'))
                                    ->fileAttachmentsDisk('local')
                                    ->fileAttachmentsVisibility('storage')
                                    ->fileAttachmentsDirectory('public/settings'),

                                TextArea::make('google_map_code')
                                    ->label(trans('dashboard.google_map_code'))
                            ]),

                        Tab::make('SEO')
                            ->schema(CustomFieldService::fields('seo_fields')),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $result = $this->form->getState();

        if (isset($this->settings->data)) {
            $this->settings->data = $result;
            $this->settings->save();
        }

        Artisan::call('optimize:clear');

        Notification::make()
            ->title(trans('dashboard.success'))
            ->icon('heroicon-o-sparkles')
            ->iconColor('success')
            ->send();
    }

    public function getActions(): array
    {
        return [

            ActionGroup::make([
                Action::make('Clear Cache')
                    ->label(trans('dashboard.clear_cache'))
                    ->action(function () {
                        Artisan::call('optimize:clear');

                        Notification::make()
                            ->title(trans('dashboard.success'))
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success'),

                Action::make('Run Migrations')
                    ->label(trans('dashboard.run_migrations'))
                    ->action(function () {
                        Artisan::call('migrate --force');

                        Notification::make()
                            ->title(trans('dashboard.success'))
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success'),
            ]),

        ];
    }

}
