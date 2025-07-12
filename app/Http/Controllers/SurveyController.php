<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveyController extends Controller
{
    public function show(Survey $survey)
    {
        if (!$survey->is_active) {
            abort(404);
        }

        return themeView('surveys.show', compact('survey'));
    }

    public function submit(Request $request, Survey $survey)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
        ]);

//        $response = SurveyResponse::query()->create([
//            'survey_id' => $survey->id,
//            'response_token' => Str::uuid(),
//        ]);
//
//        foreach ($request->answers as $questionId => $answer) {
//            SurveyAnswer::query()->create([
//                'survey_response_id' => $response->id,
//                'survey_question_id' => $questionId,
//                'answer' => $answer,
//            ]);
//        }
//
//        return redirect()->route('surveys.thankyou', ['token' => $response->response_token]);
    }

    public function thankYou(Request $request)
    {
        $token = $request->get('token');
        $response = $token ? SurveyResponse::where('response_token', $token)->first() : null;
        $survey = $response ? $response->survey : null;

        return themeView('surveys.thankyou', compact('survey', 'response'));
    }
}
