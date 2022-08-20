<?php

namespace App\Models\Shop;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'shop_notifications';

    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'message',
        'title',
        'level',
        'link',
    ];

    public function read()
    {
        $this->read_at = Carbon::now()->format('Y-m-d');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
