<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedBackRequest;
use App\Models\FeedBack;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::query()
            ->with('user')
            ->active()
            ->orderByDesc('created_at')->paginate(15);

        $hasFeedBack = false;

        if(auth()->check()) {
            $hasFeedBack = auth()->user()->feedBacks()->count();
        }

        return themeView('feedback.index', compact('feedbacks', 'hasFeedBack'));
    }

    public function store(FeedBackRequest $request)
    {
        FeedBack::query()->create([
            'user_id' => auth()->id(),
            'text' => $request->text,
            'is_enabled' => true,
        ]);

        return redirect()->back()->with('success', 'Дякуємо за відгук!');
    }
}
