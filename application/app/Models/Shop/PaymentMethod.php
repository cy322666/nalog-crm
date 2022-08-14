<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'shop_payment_methods';

    protected $fillable = [
        'name',
        'method_id',
        'is_system',
        'shop_id',
    ];
}
