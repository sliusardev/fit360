<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Post;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $posts = Post::query()->active()->limit(3)->orderBy('id', 'desc')->get();
        return themeView('activity.index', compact('posts'));
    }

    public function list()
    {
        $activities = Activity::query()
            ->notStarted()
            ->active()
            ->with('users', 'trainers')
            ->orderBy('start_time', 'asc')
            ->get();

        return themeView('activity.list', compact('activities'));
    }

    public function my()
    {
        $activities = auth()->user()->activities()->notStarted()->active()->get();

        return themeView('activity.my', compact('activities'));
    }

    public function myArchive()
    {
        $activities = auth()->user()->activities()->old()->active()->get();

        return themeView('activity.my-archive', compact('activities'));
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

        $payments = $activity->paymentUsers();

        $currentUserPayed = $payments->where('user_id', auth()->id())->first();

        return themeView('activity.show', compact('activity', 'payments', 'currentUserPayed'));
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
        return back()->with('success', 'Успишно скасовано!');
    }
}
