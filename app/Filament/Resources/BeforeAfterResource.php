<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeforeAfterResource\Pages;
use App\Filament\Resources\BeforeAfterResource\RelationManagers;
use App\Models\BeforeAfter;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BeforeAfterResource extends Resource
{
    protected static ?string $model = BeforeAfter::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Content';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.content');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.before_after');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.before_after');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.before_after');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(trans('dashboard.title'))
                            ->required()
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label(trans('dashboard.description'))
                            ->columnSpanFull(),

                        FileUpload::make('image_collage')
                            ->label(trans('dashboard.collage'))
                            ->directory('before-after')
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('600')
                            ->columnSpanFull(),

                        FileUpload::make('image_before')
                            ->label(trans('dashboard.before'))
                            ->directory('before-after')
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('600'),

                        FileUpload::make('image_after')
                            ->label(trans('dashboard.after'))
                            ->directory('before-after')
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('600'),

                        Toggle::make('is_enabled')
                            ->label(trans('dashboard.enabled'))
                            ->default(true),
                    ])->columns(2),
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
            ])
            ->filters([
                Filter::make('only_enabled')
                    ->label(trans('dashboard.only_enabled'))
                    ->query(fn (Builder $query): Builder => $query->active())
                    ->toggle(),
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
            'index' => Pages\ListBeforeAfters::route('/'),
            'create' => Pages\CreateBeforeAfter::route('/create'),
            'edit' => Pages\EditBeforeAfter::route('/{record}/edit'),
        ];
    }
}
