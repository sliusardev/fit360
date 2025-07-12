<?php

        namespace App\Filament\Resources\SurveyResource\RelationManagers;

        use App\Enums\SurveyTypeEnum;
        use Filament\Forms;
        use Filament\Resources\RelationManagers\RelationManager;
        use Filament\Tables;
        use Filament\Tables\Table;
        use Illuminate\Database\Eloquent\Builder;
        use Illuminate\Database\Eloquent\Model;

        class AnswersRelationManager extends RelationManager
        {
            protected static string $relationship = 'answers';

            protected static ?string $recordTitleAttribute = 'id';

            // Remove the static $title property and use the getTitle method instead
            public static function getTitle(Model $ownerRecord, string $pageClass): string
            {
                return 'Відповіді';
            }

            public function table(Table $table): Table
            {
                return $table
                    ->columns([
                        Tables\Columns\TextColumn::make('id')
                            ->label('ID')
                            ->sortable(),
                        Tables\Columns\TextColumn::make('created_at')
                            ->label('Дата')
                            ->dateTime('d.m.Y H:i')
                            ->sortable(),
                        Tables\Columns\TextColumn::make('data')
                            ->label('Кількість відповідей')
                            ->formatStateUsing(function ($state) {
                                // Check if $state is countable before calling count()
                                if (is_array($state)) {
                                    return count($state) . ' питань';
                                }
                                return '0 питань';
                            }),
                    ])
                    // Rest of your code remains unchanged
                    ->filters([
                        // ...
                    ])
                    ->actions([
                        // ...
                    ])
                    ->bulkActions([
                        // ...
                    ])
                    ->emptyStateActions([
                        // No actions needed for empty state
                    ]);
            }

            private function getCustomOptionText($survey, $item)
            {
                $questionIndex = $item['question_id'];
                $optionIndex = $item['answer'];

                if (!isset($survey->questions[$questionIndex]['options'][$optionIndex]['option'])) {
                    return 'Варіант не знайдено';
                }

                return htmlspecialchars($survey->questions[$questionIndex]['options'][$optionIndex]['option']);
            }
        }
