<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'location',
        'quantity_before',
        'quantity_change',
        'quantity_after',
        'reference_type',
        'reference_id',
        'created_by',
    ];

    /**
     * Log a stock movement.
     */
    public static function log(
        $productId,
        $type,
        $location,
        $quantityBefore,
        $quantityChange,
        $referenceType,
        $referenceId = null,
        $createdBy = null
    ) {
        return self::create([
            'product_id'      => $productId,
            'type'            => $type,
            'location'        => $location,
            'quantity_before' => $quantityBefore,
            'quantity_change' => $quantityChange,
            'quantity_after'  => $quantityBefore + $quantityChange,
            'reference_type'  => $referenceType,
            'reference_id'    => $referenceId,
            'created_by'      => $createdBy ?? auth()->id(),
        ]);
    }

    // ---- Relationships ----

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'location');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'location');
    }

    // ---- Accessors ----

    public function getTypeLabelAttribute()
    {
        return $this->type == 1 ? 'Shop' : 'Warehouse';
    }

    public function getReferenceTypeLabelAttribute()
    {
        $labels = [
            'opening_stock' => 'Opening Stock',
            'stock_update'  => 'Stock Update',
            'stock_delete'  => 'Stock Deleted',
            'sale'          => 'Sales Deduction',
            'transfer_out'  => 'Transfer Out',
            'transfer_in'   => 'Transfer In',
            'return'        => 'Product Return',
        ];
        return $labels[$this->reference_type] ?? $this->reference_type;
    }
}
