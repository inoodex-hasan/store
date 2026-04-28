<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserManage;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManageController extends Controller
{


    public function index()
    {
        return view('frontend.pages.user_manage.index',[
            'user_manages' => UserManage::all(),
        ]);
    }


    public function create_user_manage_button()
    {
        return view('frontend.pages.user_manage.create_user_manage',[
            'shops' => Shop::all(),
            'users' => User::all(),
            'roles' => Role::all(),
        ]);
    }


    // ajax/jquery auto fetch
    public function getUserRole($id)
    {
        $user = User::findOrFail($id);

        if ($user->role) {
            return response()->json([
                'role_id' => $user->role->id,
                'role_name' => $user->role->name,
            ]);
        }

        return response()->json(['role_id' => null, 'role_name' => 'N/A']);
    }



    public function storeUserManage(Request $request)
    {
        UserManage::newUserManage($request);
        return redirect('/user-manage')->with('message', 'User info create successfully!');
    }



    public function user_manage_edit($id)
    {
        return view('frontend.pages.user_manage.edit',[

            'user_manage' => UserManage::findOrFail($id),
            'user_manages' => UserManage::all(),

            'shops' => Shop::all(),
            'users' => User::all(),
            'roles' => Role::all(),
        ]);
    }




    public function user_manage_update(Request $request, $id)
    {
        UserManage::userManageUpdate($request, $id);
        return redirect('/user-manage')->with('message', 'User info update successfully!');
    }


    public function user_manage_delete($id)
    {
        UserManage::deleteUserManage($id);
        return back()->with('message', 'User info delete successfully!');
    }



}
