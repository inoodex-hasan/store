<?php

namespace App\Models;

use App\Models\SalesItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_no',
        'customer_id',
        'bill',
        'discount',
        'payble',
        'due',
        'sales_by',
        'status',
    ];




    
    // Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    // Relationship to the User (salesperson)
    public function user()
    {
        return $this->belongsTo(User::class, 'sales_by');
    }








    public function items()
    {
        return $this->hasMany(SalesItem::class, 'order_id');
    }





}
