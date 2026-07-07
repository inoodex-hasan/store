<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Log a stock movement whenever stock changes.
     */
    private static function logMovement($productId, $type, $location, $qtyBefore, $qtyAfter, $refType, $refId = null)
    {
        $change = $qtyAfter - $qtyBefore;
        if ($change === 0) return;

        StockMovement::log(
            $productId,
            $type,
            $location,
            $qtyBefore,
            $change,
            $refType,
            $refId
        );
    }


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
            $qtyBefore = $existingStock->quantity;
            // Update existing record instead of creating new one
            $existingStock->quantity += $request->quantity;
            $existingStock->save();

            // Log movement
            self::logMovement(
                $existingStock->product_id,
                $existingStock->type,
                $existingStock->location,
                $qtyBefore,
                $existingStock->quantity,
                'opening_stock'
            );
            return;
        }

        // If no existing record, create new one
        self::$stock = new Stock();
        self::$stock->product_id = $request->product_id;
        self::$stock->quantity = $request->quantity;
        self::$stock->type = $request->type;
        self::$stock->location = $locationId;
        self::$stock->save();

        // Log movement (from 0 to quantity)
        self::logMovement(
            self::$stock->product_id,
            self::$stock->type,
            self::$stock->location,
            0,
            self::$stock->quantity,
            'opening_stock'
        );
    }


    public static function stockUpdate($request, $id)
    {
        self::$stock = Stock::find($id);
        $qtyBefore = self::$stock->quantity;

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

        // Log movement
        self::logMovement(
            self::$stock->product_id,
            self::$stock->type,
            self::$stock->location,
            $qtyBefore,
            self::$stock->quantity,
            'stock_update'
        );
    }


    public static function stockDelete($id)
    {
        self::$stock = Stock::find($id);
        $qtyBefore = self::$stock->quantity;
        $productId = self::$stock->product_id;
        $type = self::$stock->type;
        $location = self::$stock->location;

        self::$stock->delete();

        // Log movement (quantity goes to 0)
        self::logMovement(
            $productId,
            $type,
            $location,
            $qtyBefore,
            0,
            'stock_delete'
        );
    }

    // Relation models

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'location');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'location');
    }
}
