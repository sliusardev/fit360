<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\SurveyAnswerResource\Pages;
    use App\Models\SurveyAnswer;
    use Filament\Forms;
    use Filament\Forms\Form;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Filament\Infolists;
    use Filament\Infolists\Infolist;

    class SurveyAnswerResource extends Resource
    {
        protected static ?string $model = SurveyAnswer::class;
        protected static ?string $navigationIcon = 'heroicon-o-document-text';
        protected static ?int $navigationSort = 6;
        protected static ?string $navigationGroup = 'Content';

        public static function getNavigationGroup(): string
        {
            return trans('dashboard.content');
        }

        public static function getNavigationLabel(): string
        {
            return trans('dashboard.survey_answers');
        }

        public static function getPluralLabel(): ?string
        {
            return trans('dashboard.survey_answers');
        }

        public static function getModelLabel(): string
        {
            return trans('dashboard.survey_answer');
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('id')
                        ->label('ID')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('survey.title')
                        ->label('Анкета')
                        ->sortable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Дата')
                        ->dateTime('d.m.y H:i')
                        ->sortable(),
                ])
                ->filters([
                    Tables\Filters\SelectFilter::make('survey_id')
                        ->relationship('survey', 'title')
                        ->label('Анкета'),
                ])
                ->actions([
                    Tables\Actions\ViewAction::make(),
                ])
                ->bulkActions([
//                    Tables\Actions\BulkActionGroup::make([
//                        Tables\Actions\DeleteBulkAction::make(),
//                    ]),
                ])->defaultSort('created_at', 'desc');
        }

        public static function infolist(Infolist $infolist): Infolist
        {
            return $infolist
                ->schema([
                    Infolists\Components\Section::make('Інформація про відповідь')
                        ->schema([
                            Infolists\Components\TextEntry::make('survey.title')
                                ->label('Анкета'),
                            Infolists\Components\TextEntry::make('created_at')
                                ->label('Дата створення')
                                ->dateTime('d.m.Y H:i'),
                            Infolists\Components\TextEntry::make('id')
                                ->label('ID'),
                        ]),
                    Infolists\Components\Section::make('Відповіді')
                        ->schema([
                            Infolists\Components\RepeatableEntry::make('data')
                                ->label('Дані відповідей')
                                ->schema([
                                    Infolists\Components\TextEntry::make('question')
                                        ->label('Питання'),
                                    Infolists\Components\TextEntry::make('answer')
                                        ->label('Відповідь')
                                        ->formatStateUsing(function ($state, $record) {

                                            $arrayVariants = ['plus', 'minus', 'yes', 'no'];

                                            if (in_array($state, $arrayVariants)) {
                                                return trans('dashboard.'.$state);
                                            }

                                            return is_array($state) ? implode(', ', $state) : $state;
                                        }),
                                    Infolists\Components\TextEntry::make('type')
                                        ->label('Тип питання')
                                        ->formatStateUsing(function ($state) {
                                            // Map the type value to a user-friendly label using the enum
                                            if (!$state) return null;

                                            // Get the label from the enum if possible
                                            try {
                                                $enum = \App\Enums\SurveyTypeEnum::from($state);
                                                return $enum->getLabel();
                                            } catch (\ValueError $e) {
                                                // Fallback if the value doesn't match any enum case
                                                return $state;
                                            }
                                        }),
                                ])
                        ]),
                ]);
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListSurveyAnswers::route('/'),
                'view' => Pages\ViewSurveyAnswer::route('/{record}'),
            ];
        }
    }
