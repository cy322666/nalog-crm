<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'shop_payment_statuses';

    public const NEW_STATUS_ID = 201;
    public const WIN_STATUS_ID = 202;
    public const LOST_STATUS_ID = 203;

    public const WIN_STATUS_NAME = 'Оплачен';
    public const LOST_STATUS_NAME = 'Отменен';
    public const NEW_STATUS_NAME = 'Новый';

    protected $fillable = [
        'name',
        'status_id',
        'type',
        'is_system',
        'shop_id',
    ];
}
