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

        $survey->load(['questions']);

        return themeView('surveys.show', compact('survey'));
    }

    public function submit(Request $request, Survey $survey)
    {
        return redirect()->route('surveys.thankyou');
    }

    public function thankYou(Request $request)
    {
        return themeView('surveys.thankyou');
    }
}
