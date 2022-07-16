<?php

namespace App\Models\Shop;

use App\Traits\Models\GenerateExternalId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory, GenerateExternalId;

    protected $table = 'shop_order_statuses';

    static string $externalId = 'status_id';

    protected $fillable = [
        'name',
        'type',
        'status_id',
    ];
}
