<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserManagementRoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('menu_user_managemen_role.index');
    }
}
