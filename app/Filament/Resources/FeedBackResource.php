<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedBackResource\Pages;
use App\Filament\Resources\FeedBackResource\RelationManagers;
use App\Models\FeedBack;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedBackResource extends Resource
{
    protected static ?string $model = FeedBack::class;

    protected static ?string $navigationIcon = 'heroicon-m-chat-bubble-left-right';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Manage';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.manage');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.feed_backs');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.feed_backs');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.feed_back');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('user_id')
                            ->label(trans('dashboard.client'))
                            ->searchable()
                            ->preload()
                            ->relationship('user', 'full_name'),

                        TextArea::make('text'),

                        Toggle::make('is_enabled')
                            ->label(trans('dashboard.enabled'))
                            ->default(true),
                    ])
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

                TextColumn::make('user.full_name')
                    ->label(trans('dashboard.client')),

                TextColumn::make('created_at')
                    ->label(trans('dashboard.created'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('only_enabled')
                    ->label(trans('dashboard.only_enabled'))
                    ->query(fn (Builder $query): Builder => $query->active())
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFeedBacks::route('/'),
            'create' => Pages\CreateFeedBack::route('/create'),
            'edit' => Pages\EditFeedBack::route('/{record}/edit'),
        ];
    }
}
