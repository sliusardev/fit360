<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use App\Models\Survey;
use Filament\Resources\Pages\Page;

class SurveyResults extends Page
{
    protected static string $resource = SurveyResource::class;
    protected static string $view = 'filament.resources.survey-resource.pages.survey-results';

    public Survey $record;

    public function mount(Survey $record): void
    {
        $this->record = $record;
        $this->record->load('questions.answers', 'responses.answers.question');
    }

    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
            'questionsData' => $this->getQuestionsData(),
            'responsesCount' => $this->record->responses->count(),
        ];
    }

    protected function getQuestionsData(): array
    {
        $questionsData = [];

        foreach ($this->record->questions as $question) {
            $answers = $question->answers;

            if (in_array($question->type, ['yes_no', 'plus_minus', 'rating'])) {
                $answerCounts = $answers->pluck('answer')->countBy();
                $total = $answers->count() ?: 1; // Avoid division by zero

                $chartData = [];
                foreach ($answerCounts as $answer => $count) {
                    $chartData[] = [
                        'label' => $answer,
                        'value' => $count,
                        'percentage' => round(($count / $total) * 100),
                    ];
                }

                $questionsData[] = [
                    'id' => $question->id,
                    'question' => $question->question,
                    'type' => $question->type,
                    'chartData' => $chartData,
                    'textAnswers' => null,
                ];
            } else {
                $questionsData[] = [
                    'id' => $question->id,
                    'question' => $question->question,
                    'type' => $question->type,
                    'chartData' => null,
                    'textAnswers' => $answers->pluck('answer', 'created_at')->toArray(),
                ];
            }
        }

        return $questionsData;
    }
}
