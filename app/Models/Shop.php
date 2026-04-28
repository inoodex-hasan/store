<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;


    private static $shop;


    protected $fillable = [
        'name',
        'location',
    ];


    public static function newShop($request)
    {
        self::$shop = new Shop();
        self::$shop->name             = $request->name;
        self::$shop->location         = $request->location;

        self::$shop->save();
    }



    public static function updateShop($request, $id)
    {
        self::$shop = Shop::find($id);

        self::$shop->name             = $request->name;
        self::$shop->location         = $request->location;
        self::$shop->save();
    }



    public static function deleteShop($id)
    {
        self::$shop = Shop::find($id);

        self::$shop->delete();
    }



}
