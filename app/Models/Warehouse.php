<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;



    private static $ware_house;


    protected $fillable = [
        'name',
        'location',
    ];


    public static function newWareHouse($request)
    {
        self::$ware_house = new Warehouse();
        self::$ware_house->name             = $request->name;
        self::$ware_house->location         = $request->location;

        self::$ware_house->save();
    }



    public static function updateWareHouse($request, $id)
    {
        self::$ware_house = Warehouse::find($id);

        self::$ware_house->name             = $request->name;
        self::$ware_house->location         = $request->location;
        self::$ware_house->save();
    }



    public static function deleteWareHouse($id)
    {
        self::$ware_house = Warehouse::find($id);

        self::$ware_house->delete();
    }


}
