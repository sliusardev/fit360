<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Activity;
use App\Services\UserService;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Team';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.team');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.activities');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.activities');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.activity');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(trans('dashboard.name'))
                            ->required(),

                        Select::make('trainers')
                            ->label(trans('dashboard.trainers'))
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->relationship('trainers', 'name'),

                        RichEditor::make('description')
                            ->label(trans('dashboard.description')),

                        DateTimePicker::make('start_time')
                            ->label(trans('dashboard.start_time'))
                            ->minDate(now()->toDateString())
                            ->seconds(false),

                        TextInput::make('duration_minutes')
                            ->label(trans('dashboard.duration_minutes'))
                            ->numeric()
                            ->postfix('Хвилин'),

                        TextInput::make('available_slots')
                            ->label(trans('dashboard.available_slots'))
                            ->numeric(),

                        TextInput::make('price')
                            ->label(trans('dashboard.price'))
                            ->numeric()
                            ->prefix('UAH'),

                        FileUpload::make('image')
                            ->label(trans('dashboard.image'))
                            ->directory('activities')
                            ->image()
                            ->columnSpanFull(),

                    ])
                    ->collapsible()
                    ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('title')
                    ->label(trans('dashboard.title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('trainers.name')
                    ->label(trans('dashboard.trainers'))
                    ->listWithLineBreaks()
                    ->bulleted(),

                TextColumn::make('start_time')
                    ->label(trans('dashboard.start_time')),

                TextColumn::make('available_slots')
                    ->label(trans('dashboard.available_slots')),

                TextColumn::make('price')
                    ->label(trans('dashboard.price')),


            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
