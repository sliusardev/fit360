<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contacts()
    {
        return view('site.pages.contacts');
    }
}
