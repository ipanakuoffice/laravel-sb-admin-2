<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    //
    public function index()
    {
        return view('menu_examination.index');
    }
}
