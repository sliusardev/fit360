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
            ->active()
            ->with('users', 'trainers')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('site.activity.list', compact('activities'));
    }

    public function my()
    {
        $activities = auth()->user()->activities()->notStarted()->active()->get();

        return view('site.activity.my', compact('activities'));
    }

    public function myArchive()
    {
        $activities = auth()->user()->activities()->old()->active()->get();

        return view('site.activity.my-archive', compact('activities'));
    }

    public function show($id)
    {
        $activity = Activity::query()
            ->active()
            ->with('users', 'trainers')
            ->where('id', $id)->first();

        if (!$activity) {
            return redirect('/');
        }

        return view('site.activity.show', compact('activity'));
    }

    public function join($id)
    {
        $activity = Activity::query()->where('id', $id)->first();

        if(!$activity) {
            return back()->with('error', 'Немає такого заняття');
        }

        $activity->users()->attach(auth()->id());

        return back()->with('success', 'Успишно приєднано!');
    }

    public function cancelJoin($id)
    {
        $activity = Activity::query()->where('id', $id)->first();

        if(!$activity) {
            return back()->with('error', 'Немає такого заняття');
        }

        $activity->users()->detach(auth()->id());
        return back()->with('success', 'Успишно приєднано!');
    }
}
