<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    public function index()
    {
        $priceLists = PriceList::query()->orderByDesc('created_at')->get();
        return themeView('price-list.index', compact('priceLists'));
    }

    public function show($id)
    {
        $priceList = PriceList::query()->where('id', $id)->active()->first();
        return themeView('price-list.show', compact('priceList'));
    }
}
