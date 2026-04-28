<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UserManage extends Model
{
    use HasFactory;

    private static $user_manage;



    public static function newUserManage($request)
    {
        self::$user_manage = new UserManage();

        self::$user_manage->shop_id   = $request->shop_id;
        self::$user_manage->user_id   = $request->user_id;
        self::$user_manage->role_id   = $request->role_id;



        self::$user_manage->save();
    }





    public static function userManageUpdate($request, $id)
    {
        self::$user_manage = UserManage::find($id);

        self::$user_manage->shop_id    = $request->shop_id;
        self::$user_manage->user_id   = $request->user_id;
        self::$user_manage->role_id   = $request->role_id;

        self::$user_manage->save();
    }




    public static function deleteUserManage($id)
    {
        self::$user_manage = UserManage::find($id);

        self::$user_manage->delete();
    }


    // Relation php artisan optimize
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }



}
