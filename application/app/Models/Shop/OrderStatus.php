<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'shop_order_statuses';

    static string $externalId = 'status_id';

    public const NEW_STATUS_ID = 101;
    public const WIN_STATUS_ID = 102;
    public const LOST_STATUS_ID = 103;

    public const WIN_STATUS_NAME = 'Выиграно';
    public const LOST_STATUS_NAME = 'Потеряно';
    public const NEW_STATUS_NAME = 'Новый заказ';

    protected $fillable = [
        'status_id',
        'is_system',
        'name',
        'type',
        'order',
    ];
}
