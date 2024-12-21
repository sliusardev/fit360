<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::all();
        return themeView('trainer.index', compact('trainers'));
    }

    public function show($id)
    {
        $trainer = Trainer::query()
            ->where("id", $id)
            ->with('user', 'activities')
            ->first();

        if (!$trainer) {
            return redirect('/');
        }

        return themeView('trainer.show', ['trainer' => $trainer]);
    }
}
