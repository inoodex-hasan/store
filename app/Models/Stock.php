<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'location',
        'product_id',
        'quantity',
    ];

    private static $stock;




    // When Stock Quantity 0 create a new Row


    //    public static function newStock($request)
    //    {
    //        self::$stock = new Stock();
    //
    //        self::$stock->product_id      = $request->product_id;
    //        self::$stock->quantity        = $request->quantity;
    //        self::$stock->type            = $request->type;
    //
    //        // Determine location ID based on type
    //        if ($request->type == 1) {
    //            // Type = Shop
    //            $locationId = \App\Models\Shop::where('location', $request->location)->value('id');
    //        }
    //        elseif ($request->type == 2) {
    //            // Type = Warehouse
    //            $locationId = \App\Models\Warehouse::where('location', $request->location)->value('id');
    //        }
    //        else {
    //            $locationId = null;
    //        }
    //
    //        self::$stock->location = $locationId;
    //
    //
    //        self::$stock->save();
    //    }


    // When Stock Quantity 0 create a new Row



    //*****Nayeem*****  When Stock Quantity (0) do not create a new row UPDATE existing Row !!!

    public static function newStock($request)
    {
        // First determine the location ID based on type
        if ($request->type == 1) {
            // Type = Shop
            $locationId = \App\Models\Shop::where('location', $request->location)->value('id');
        } elseif ($request->type == 2) {
            // Type = Warehouse
            $locationId = \App\Models\Warehouse::where('location', $request->location)->value('id');
        } else {
            $locationId = null;
        }

        // Try to find existing stock record using the resolved location ID
        $existingStock = self::where([
            'product_id' => $request->product_id,
            'location' => $locationId,
            'type' => $request->type
        ])->first();

        if ($existingStock) {
            // Update existing record instead of creating new one
            $existingStock->quantity += $request->quantity;
            $existingStock->save();
            return;
        }

        // If no existing record, create new one
        self::$stock = new Stock();
        self::$stock->product_id = $request->product_id;
        self::$stock->quantity = $request->quantity;
        self::$stock->type = $request->type;
        self::$stock->location = $locationId;
        self::$stock->save();
    }

    //*****Nayeem*****  When Stock Quantity (0) do not create a new row UPDATE existing Row !!!




    public static function stockUpdate($request, $id)
    {
        self::$stock = Stock::find($id);

        self::$stock->product_id      = $request->product_id;
        self::$stock->quantity        = $request->quantity;
        self::$stock->type            = $request->type;

        // Determine location ID based on type
        if ($request->type == 1) {
            // Type = Shop
            $locationId = \App\Models\Shop::where('location', $request->location)->value('id');
        } elseif ($request->type == 2) {
            // Type = Warehouse
            $locationId = \App\Models\Warehouse::where('location', $request->location)->value('id');
        } else {
            $locationId = null;
        }

        self::$stock->location = $locationId;

        self::$stock->save();
    }


    public static function stockDelete($id)
    {
        self::$stock = Stock::find($id);

        self::$stock->delete();
    }




    // Relation models

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    // public function shop()
    // {
    //     return $this->belongsTo(Shop::class, 'location');
    // }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'location');
    }


    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'location');
    }
}
