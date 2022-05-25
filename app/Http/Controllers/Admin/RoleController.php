<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'alpha']
        ]);
        $role = Role::create([
            'name' => $request->name
        ]);
        return  $role;
    }

}
