<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['customerName', 'customerEmail', 'customerMobile', 'user_id'];
    protected $table = "customers";
}
