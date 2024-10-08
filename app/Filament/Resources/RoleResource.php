<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Authentication';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.authentication');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.roles');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.roles');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.role');
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
                        TextInput::make('guard_name')
                            ->label(trans('dashboard.guard_name'))
                            ->required()
                            ->default(config('auth.defaults.guard')),

                        Select::make('permissions')
                            ->multiple()
                            ->relationship('permissions', 'name')
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('name')
                    ->label(trans('dashboard.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('guard_name')
                    ->label(trans('dashboard.guard_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(trans('dashboard.created'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
