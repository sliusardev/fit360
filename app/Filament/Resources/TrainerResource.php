<?php

namespace App\Filament\Resources;

use App\Enums\RoleEnum;
use App\Filament\Resources\TrainerResource\Pages;
use App\Filament\Resources\TrainerResource\RelationManagers;
use App\Models\Trainer;
use App\Models\User;
use App\Services\UserService;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainerResource extends Resource
{
    protected static ?string $model = Trainer::class;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Manage';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.manage');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.trainers');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.trainers');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.trainer');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([

                        TextInput::make('name')
                            ->label(trans('dashboard.name'))
                            ->required(),

                        RichEditor::make('specialization')
                            ->label(trans('dashboard.specialization')),

                        RichEditor::make('description')
                            ->label(trans('dashboard.description')),

                        Select::make('user_id')
                            ->label(trans('dashboard.user'))
                            ->preload()
                            ->searchable()
                            ->relationship('user', 'name')
                            ->options(UserService::getUsersTrainerList()),

                        FileUpload::make('avatar')
                            ->label(trans('dashboard.avatar'))
                            ->directory('users')
                            ->columnSpanFull()
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('600'),

                    ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                ImageColumn::make('avatar'),

                TextColumn::make('name')
                    ->label(trans('dashboard.name'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainers::route('/'),
            'create' => Pages\CreateTrainer::route('/create'),
            'edit' => Pages\EditTrainer::route('/{record}/edit'),
        ];
    }
}
