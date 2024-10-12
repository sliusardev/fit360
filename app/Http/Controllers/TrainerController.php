<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        return back();
    }

    public function show($id)
    {
        $trainer = Trainer::query()
            ->where("id", $id)
            ->with('user', 'activities')
            ->first();

        return view('site.trainer.show', ['trainer' => $trainer]);
    }
}
