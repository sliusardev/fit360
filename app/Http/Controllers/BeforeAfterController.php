<?php

namespace App\Http\Controllers;

use App\Models\BeforeAfter;
use Illuminate\Http\Request;

class BeforeAfterController extends Controller
{
    public function index() {
        $beforeAfterList = BeforeAfter::query()->active()->orderByDesc('created_at')->paginate(10);
        return view('site.before-after.index', ['beforeAfterList' => $beforeAfterList]);
    }

    public function show($id)
    {
        $item = BeforeAfter::query()->where('id', $id)->first();
        return view('site.before-after.show', ['item' => $item]);
    }

}
