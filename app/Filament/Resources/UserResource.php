<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Authentication';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.authentication');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.users');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.users');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.user');
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

                        TextInput::make('email')
                            ->label(trans('dashboard.email'))
                            ->required()
                            ->email()
                            ->unique(table: static::$model, ignorable: fn ($record) => $record),

                        TextInput::make('password')
                            ->label(trans('dashboard.password'))
                            ->same('passwordConfirmation')
                            ->password()
                            ->maxLength(255)
                            ->required(fn ($component, $get, $livewire, $model, $record, $set, $state) => $record === null)
                            ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : ''),

                        TextInput::make('passwordConfirmation')
                            ->label(trans('dashboard.password_confirmation'))
                            ->password()
                            ->dehydrated(false)
                            ->maxLength(255),

                        Select::make('roles')
                            ->multiple()
                            ->preload()
                            ->relationship('roles', 'name'),

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

                TextColumn::make('email')
                    ->label(trans('dashboard.email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label(trans('dashboard.roles'))
                    ->listWithLineBreaks(),

                TextColumn::make('email_verified_at')
                    ->label(trans('dashboard.email_verified_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(trans('dashboard.created'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->multiple()
                    ->relationship('roles', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
