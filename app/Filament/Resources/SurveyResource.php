<?php

namespace App\Filament\Resources;

use App\Enums\SurveyTypeEnum;
use App\Filament\Resources\SurveyResource\Pages;
use App\Models\Survey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Content';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.content');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.survey_management');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.surveys');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.survey');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основна інформація')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Назва анкети')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('Опис')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true),
                    ]),
                Forms\Components\Section::make('Питання анкети')
                    ->schema([
                        Forms\Components\Repeater::make('questions')
                            ->label('Питання')
                            ->schema([
                                Forms\Components\Textarea::make('question')
                                    ->label('Текст питання')
                                    ->required()
                                    ->maxLength(65535),
                                Forms\Components\Select::make('type')
                                    ->label('Тип питання')
                                    ->options(SurveyTypeEnum::getOptions())
                                    ->live()
                                    ->required(),
                                Forms\Components\Repeater::make('options')
                                    ->schema([
                                        Forms\Components\TextInput::make('option')
                                            ->label('Варіант відповіді')
                                            ->required()
                                    ])
                                    ->label('Варіанти відповідей')
                                    ->visible(fn (callable $get) => $get('type') === SurveyTypeEnum::CUSTOM->value)
                                    ->columns(1),
                                Forms\Components\TextInput::make('order')
                                    ->label('Порядок')
                                    ->integer()
                                    ->default(fn ($get) => $get('repeater_index') + 1),
                            ])
                            ->orderColumn('order')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Назва')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Статус')
                    ->placeholder('Всі')
                    ->trueLabel('Активні')
                    ->falseLabel('Неактивні'),
            ])
            ->actions([
                Tables\Actions\Action::make('qrcode')
                    ->label('QR-код')
                    ->icon('heroicon-o-qr-code')
                    ->url(fn (Survey $record) => route('filament.admin.resources.surveys.qrcode', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Основна інформація')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Назва анкети'),
                        Infolists\Components\TextEntry::make('description')
                            ->label('Опис')
                            ->columnSpanFull(),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Активна')
                            ->boolean(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Створено')
                            ->dateTime('d.m.Y H:i'),
                    ]),
                Infolists\Components\Section::make('Посилання')
                    ->schema([
                        Infolists\Components\TextEntry::make('public_url')
                            ->label('Публічне посилання')
                            ->url(fn (Survey $record) => route('surveys.show', $record))
                            ->openUrlInNewTab()
                            ->state(fn (Survey $record) => route('surveys.show', $record)),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getActions(): array
    {
        return [
            Forms\Components\Actions::make('qrCode')
                ->label('QR-код')
                ->url(fn (Survey $record) => static::getUrl('qrcode', ['record' => $record]))
                ->icon('heroicon-o-qr-code'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'view' => Pages\ViewSurvey::route('/{record}'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
            'qrcode' => Pages\QrcodeSurvey::route('/{record}/qrcode'),
        ];
    }
}
