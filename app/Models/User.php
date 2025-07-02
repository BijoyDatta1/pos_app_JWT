<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $attributes = ['otp' => '0'];
    protected $fillable = ['firstName', 'lastName', 'email', 'mobile','password','otp'];

}
