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

    }

    public function my()
    {

    }
}
