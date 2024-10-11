<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return view('site.activity.index');
    }

    public function list()
    {
        $activities = Activity::query()
            ->notStarted()
            ->with('users', 'trainers')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('site.activity.list', compact('activities'));
    }

    public function my()
    {
        $activities = auth()->user()->activities()->get();

//        dd($activities);

        return view('site.activity.my', compact('activities'));
    }

    public function show($id)
    {
        $activity = Activity::query()
            ->with('users', 'trainers')
            ->where('id', $id)->first();

        return view('site.activity.show', compact('activity'));
    }

    public function join($id)
    {
        $activity = Activity::query()->where('id', $id)->first();
        $activity->users()->attach(auth()->id());
        return back()->with('success', 'Успишно приєднано!');
    }

    public function cancelJoin($id)
    {
        $activity = Activity::query()->where('id', $id)->first();
        $activity->users()->detach(auth()->id());
        return back()->with('success', 'Успішно скасовано!');
    }
}
