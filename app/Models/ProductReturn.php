<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'sale_id',
        'customer_id',
        'return_date',
        'total_refund_amount',
        'status',
        'reason',
        'notes',
        'processed_by',
        'processed_at'
    ];

    protected $casts = [
        'return_date' => 'date',
        'processed_at' => 'datetime',
        'total_refund_amount' => 'decimal:2'
    ];

    // Relationships
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function items()
    {
        return $this->hasMany(ReturnItem::class, 'return_id');
    }

    // Status helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Calculate total refund amount from items
    public function calculateTotalRefund()
    {
        return $this->items->sum('total_price');
    }

    // Approve return and update stock
    public function approve($userId)
    {
        $this->update([
            'status' => 'approved',
            'processed_by' => $userId,
            'processed_at' => now()
        ]);
    }

    // Complete return and add items back to stock
    public function complete($userId)
    {
        $this->update([
            'status' => 'completed',
            'processed_by' => $userId,
            'processed_at' => now(),
            'total_refund_amount' => $this->calculateTotalRefund()
        ]);

        // Update stock for each item
        foreach ($this->items as $item) {
            $this->addToStock($item);
        }
    }

    // Add returned item back to stock
    private function addToStock($item)
    {
        // Get the sale to find the shop/warehouse
        $sale = $this->sale;
        if (!$sale) return;

        // Find or create stock entry
        $stock = Stock::where('product_id', $item->product_id)
            ->where('type', $sale->type ?? 1) // default to shop
            ->where('location', $sale->location)
            ->first();

        if ($stock) {
            $stock->increment('quantity', $item->quantity);
        } else {
            Stock::create([
                'product_id' => $item->product_id,
                'type' => $sale->type ?? 1,
                'location' => $sale->location,
                'quantity' => $item->quantity
            ]);
        }
    }

    // Reject return
    public function reject($userId, $reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'processed_by' => $userId,
            'processed_at' => now(),
            'notes' => $reason ?? $this->notes
        ]);
    }
}
