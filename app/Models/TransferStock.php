<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransferStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'stock_from',
        'stock_to',
        'quantity'
    ];

    /**
     * Transfer stock from warehouse to shop.
     *
     * @param array $data ['product_id', 'stock_from', 'stock_to', 'quantity']
     * @throws \Exception
     */
    public static function transfer($data)
    {
        DB::transaction(function () use ($data) {

            $quantity = (int) $data['quantity'];

            if ($quantity <= 0) {
                throw new \Exception("Quantity must be greater than zero.");
            }

            // 1. Check warehouse stock exists
            $warehouseStock = Stock::where([
                'product_id' => $data['product_id'],
                'location'   => $data['stock_from'],
                'type'       => 2 // Warehouse
            ])->first();

            if (!$warehouseStock) {
                throw new \Exception("No stock found in the specified warehouse.");
            }

            // 2. Check if enough stock is available
            if ($warehouseStock->quantity < $quantity) {
                throw new \Exception("Not enough stock in warehouse!");
            }

            // 3. Create transfer record
            $transfer = self::create($data);

            // 4. Decrease warehouse stock quantity
            $warehouseQtyBefore = $warehouseStock->quantity;
            $warehouseStock->decrement('quantity', $quantity);

            // Log warehouse deduction (transfer_out)
            \App\Models\StockMovement::log(
                $data['product_id'],
                2, // Warehouse
                $data['stock_from'],
                $warehouseQtyBefore,
                -$quantity,
                'transfer_out',
                $transfer->id
            );

            // 5. Increase or create shop stock quantity
            $shopStock = Stock::where([
                'product_id' => $data['product_id'],
                'location'   => $data['stock_to'],
                'type'       => 1 // Shop
            ])->first();

            if ($shopStock) {
                $shopQtyBefore = $shopStock->quantity;
                $shopStock->increment('quantity', $quantity);
                $shopQtyAfter = $shopStock->quantity;
            } else {
                Stock::create([
                    'product_id' => $data['product_id'],
                    'location'   => $data['stock_to'],
                    'quantity'   => $quantity,
                    'type'       => 1, // Shop
                ]);
                $shopQtyBefore = 0;
                $shopQtyAfter = $quantity;
            }

            // Log shop addition (transfer_in)
            \App\Models\StockMovement::log(
                $data['product_id'],
                1, // Shop
                $data['stock_to'],
                $shopQtyBefore,
                $quantity,
                'transfer_in',
                $transfer->id
            );
        });
    }

    // Relationships

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'stock_from');
    }

    public function toShop()
    {
        return $this->belongsTo(Shop::class, 'stock_to');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'stock_from');
        // stock_from column stores warehouse_id
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'stock_to');
        // stock_to column stores shop_id
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
