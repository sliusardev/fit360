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
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Manage';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.manage');
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
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('600')
                            ->columnSpanFull(),

                        Toggle::make('is_enabled')
                            ->label(trans('dashboard.enabled'))
                            ->default(true),

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

                ToggleColumn::make('is_enabled')
                    ->label(trans('dashboard.enabled')),

                TextColumn::make('title')
                    ->label(trans('dashboard.title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('trainers.name')
                    ->label(trans('dashboard.trainers'))
                    ->listWithLineBreaks()
                    ->bulleted(),

                TextColumn::make('start_time')
                    ->sortable()
                    ->dateTime('d.m.Y H:i')
                    ->label(trans('dashboard.start_time')),

                TextColumn::make('available_slots')
                    ->sortable()
                    ->label(trans('dashboard.available_slots')),

                TextColumn::make('price')
                    ->sortable()
                    ->money('UAH')
                    ->label(trans('dashboard.price')),
            ])
            ->filters([
                Filter::make('only_enabled')
                    ->label(trans('dashboard.only_enabled'))
                    ->query(fn (Builder $query): Builder => $query->active())
                    ->toggle(),

                Filter::make('finished')
                    ->label(trans('dashboard.finished'))
                    ->query(fn (Builder $query): Builder => $query->old())
                    ->toggle(),

                Filter::make('not_started')
                    ->label(trans('dashboard.not_started'))
                    ->query(fn (Builder $query): Builder => $query->notStarted())
                    ->toggle(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\ReplicateAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('start_time', 'desc');
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
