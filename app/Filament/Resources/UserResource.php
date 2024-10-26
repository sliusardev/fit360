<?php

namespace App\Filament\Resources;

use App\Enums\GenderEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
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

                        TextInput::make('last_name')
                            ->label(trans('dashboard.last_name'))
                            ->required(),

                        TextInput::make('middle_name')
                            ->label(trans('dashboard.middle_name')),

                        TextInput::make('email')
                            ->label(trans('dashboard.email'))
                            ->required()
                            ->email()
                            ->unique(table: static::$model, ignorable: fn ($record) => $record),

                        TextInput::make('phone')
                            ->label(trans('dashboard.phone'))
                            ->required()
                            ->unique(table: static::$model, ignorable: fn ($record) => $record),

                        DatePicker::make('birth_day')
                            ->label(trans('dashboard.birth_day'))
                            ->date()
                            ->required(),

                        Select::make('gender')
                            ->label(trans('dashboard.gender'))
                            ->required()
                            ->options(GenderEnum::allValuesTranslated())
                            ->preload(),

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

                TextColumn::make('last_name')
                    ->label(trans('dashboard.last_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label(trans('dashboard.phone'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label(trans('dashboard.roles'))
                    ->sortable()
                    ->listWithLineBreaks(),

                TextColumn::make('created_at')
                    ->label(trans('dashboard.created'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label(trans('dashboard.roles'))
                    ->multiple()
                    ->preload()
                    ->relationship('roles', 'name')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
