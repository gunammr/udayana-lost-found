<?php

namespace App\Http\Controllers;

class LostItemController extends Controller
{
    public function create()
    {
        return view('lost-items.create');
    }
}
