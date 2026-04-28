<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsReceivable extends Model
{
    use HasFactory;
    protected $table = 'account_receivables';

   protected $fillable = ['customer_id', 'due_amount', 'created_at', 'updated_at'];

    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}


// AccountsReceivableController.php



}
