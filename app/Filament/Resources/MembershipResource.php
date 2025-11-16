<?php

namespace App\Filament\Resources;

use App\Enums\MembershipsAccessTypeEnum;
use App\Enums\MembershipsDurationTypeEnum;
use App\Filament\Resources\MembershipResource\Pages;
use App\Models\Membership;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationGroup = 'Manage';

    public static function getNavigationGroup(): string
    {
        return trans('dashboard.manage');
    }

    public static function getNavigationLabel(): string
    {
        return trans('dashboard.memberships');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('dashboard.memberships');
    }

    public static function getModelLabel(): string
    {
        return trans('dashboard.membership');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(trans('dashboard.name'))
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label(trans('dashboard.description'))
                            ->rows(4)
                            ->columnSpanFull(),

                        Grid::make(3)
                            ->schema([
                                Select::make('access_type')
                                    ->label(trans('dashboard.access_type'))
                                    ->options(MembershipsAccessTypeEnum::allValuesTranslated())
                                    ->required()
                                    ->native(false),

                                Select::make('duration_type')
                                    ->label(trans('dashboard.duration_type'))
                                    ->options(MembershipsDurationTypeEnum::allValuesTranslated())
                                    ->required()
                                    ->reactive()
                                    ->native(false),

                                TextInput::make('price')
                                    ->label(trans('dashboard.price'))
                                    ->numeric()
                                    ->prefix('₴')
                                    ->required(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('duration_days')
                                    ->label(trans('dashboard.duration_days'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),

                                TextInput::make('visit_limit')
                                    ->label(trans('dashboard.visit_limit'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->visible(fn (callable $get) => $get('duration_type') === MembershipsDurationTypeEnum::VISITS->value),
                            ]),

                        Toggle::make('is_enabled')
                            ->label(trans('dashboard.is_enabled'))
                            ->inline(false)
                            ->default(true),
                    ])->columns(1),
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
                BadgeColumn::make('access_type')
                    ->label(trans('dashboard.access_type'))
                    ->colors([
                        'primary',
                    ])
                    ->formatStateUsing(fn (MembershipsAccessTypeEnum $state): string => trans('dashboard.' . $state->value)),
                BadgeColumn::make('duration_type')
                    ->label(trans('dashboard.duration_type'))
                    ->colors([
                        'success' => fn (MembershipsDurationTypeEnum $state): bool => $state === MembershipsDurationTypeEnum::UNLIMITED,
                        'warning' => fn (MembershipsDurationTypeEnum $state): bool => $state === MembershipsDurationTypeEnum::VISITS,
                    ])
                    ->formatStateUsing(fn (MembershipsDurationTypeEnum $state): string => trans('dashboard.' . $state->value)),
                TextColumn::make('duration_days')
                    ->label(trans('dashboard.duration_days'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('visit_limit')
                    ->label(trans('dashboard.visit_limit'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->label(trans('dashboard.price'))
                    ->money('UAH')
                    ->sortable(),
                IconColumn::make('is_enabled')
                    ->boolean()
                    ->label(trans('dashboard.is_enabled')),
                TextColumn::make('created_at')
                    ->label(trans('dashboard.created'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('access_type')
                    ->label(trans('dashboard.access_type'))
                    ->options(MembershipsAccessTypeEnum::allValuesTranslated()),
                SelectFilter::make('duration_type')
                    ->label(trans('dashboard.duration_type'))
                    ->options(MembershipsDurationTypeEnum::allValuesTranslated()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberships::route('/'),
            'create' => Pages\CreateMembership::route('/create'),
            'edit' => Pages\EditMembership::route('/{record}/edit'),
        ];
    }
}
