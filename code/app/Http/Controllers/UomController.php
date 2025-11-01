<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UomController extends Controller
{
    public function create()
    {
        return view('uoms.create');
    }
    
    public function edit($id)
    {
        return view('uoms.edit', compact('id'));
    }
}
