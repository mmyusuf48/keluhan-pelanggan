<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class keluhanController extends Controller
{
    function store(Request $request) {

        dd($request->all());

    }

    function update(Request $request, $id)  {

    }
}
