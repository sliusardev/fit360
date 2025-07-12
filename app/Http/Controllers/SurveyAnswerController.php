<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveyAnswerController extends Controller
{
    public function store(Request $request, Survey $survey)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
        ]);

        $response = SurveyResponse::create([
            'survey_id' => $survey->id,
            'response_token' => Str::uuid(),
        ]);

        foreach ($request->answers as $questionId => $answer) {
            SurveyAnswer::create([
                'survey_response_id' => $response->id,
                'survey_question_id' => $questionId,
                'answer' => $answer,
            ]);
        }

        return redirect()->route('surveys.thankyou', ['token' => $response->response_token]);
    }

    public function showThankYou(Request $request)
    {
        $token = $request->get('token');
        $response = $token ? SurveyResponse::where('response_token', $token)->first() : null;
        $survey = $response ? $response->survey : null;

        return themeView('surveys.thankyou', compact('survey', 'response'));
    }
}
