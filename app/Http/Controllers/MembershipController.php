<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::query()->active()->orderBy('id', 'desc')->paginate(10);
        return themeView('memberships.index', compact('memberships'));
    }

    public function show(string $id)
    {
        $membership = Membership::query()->where('id', $id)->with('users')->first();
        $subscribers = $membership->users;
        $alreadySubscribed = $subscribers->where('id', auth()->user()->id)->first();
        return themeView('memberships.show', compact('membership', 'alreadySubscribed'));
    }

    public function my()
    {
        $user = auth()->user();
        $memberships = $user->memberships()
            ->withPivot('start_date', 'end_date', 'visit_limit', 'is_enabled')
            ->orderBy('membership_user.created_at', 'desc')
            ->get();

        return themeView('memberships.my', compact('memberships'));
    }
}
