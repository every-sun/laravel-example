<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function indexRoles() : Response{
        $roles = (new Role)::all();
        $users = (new User)::with('roles')->paginate(10);

        return Inertia::render('Role/Index', [
            'roleData' => $roles,
            'userData' => $users
        ]);
    }

    public function storeRole(Request $request){
        $request->validate([
            'name'=>'required|max:255',
        ]);
        $role = (new Role)::create([
            'priority'=> (int)$request->input('priority'),
            'name'=> $request->input('name'),
        ]);
    }

    public function updateUserRole(Request $request, $user_id, $role_id){
        $user = (new User)::find($user_id);
        if(in_array($role_id, $user->roles()->pluck('role_id')->toArray())){
            $user->roles()->detach($role_id);
        }else{
            $user->roles()->attach($role_id);
        }
    }
}
