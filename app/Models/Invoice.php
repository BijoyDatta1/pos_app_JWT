<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'customer_id', 'total', 'payable', 'vat', 'discount'];
    protected $table = "invoices";

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
