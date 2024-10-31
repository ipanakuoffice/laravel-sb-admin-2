<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementPermissionController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('menu_user_managemen_permission.index');
    }

    public function getData(Request $request)
    {
        $usersWithRoles = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.name', 'roles.name as role_name')
            ->get();

        return response()->json($usersWithRoles);
    }
}
