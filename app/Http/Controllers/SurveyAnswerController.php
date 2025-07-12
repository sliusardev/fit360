<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurveyAnswerController extends Controller
{
    /**
     * Store a new survey answer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Survey $survey)
    {
        // Validate that the survey is active
        if (!$survey->is_active) {
            abort(404);
        }

        // Get answers from request
        $answers = $request->input('answers', []);

        // Basic validation
        $validator = Validator::make(['answers' => $answers], [
            'answers' => 'required|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Process and format the data
        $formattedAnswers = [];
        foreach ($survey->questions as $index => $question) {
            // Skip if no answer provided for this question
            if (!isset($answers[$index])) {
                continue;
            }

            $formattedAnswers[] = [
                'question_id' => $index,
                'question' => $question['question'],
                'type' => $question['type'],
                'answer' => $answers[$index],
            ];
        }

        // Store the answer
        SurveyAnswer::create([
            'survey_id' => $survey->id,
            'data' => $formattedAnswers,
        ]);

        return redirect()->route('home')->with('success', 'Thank you for your feedback!');
    }
}
