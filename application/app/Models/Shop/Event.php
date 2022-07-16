<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'shop_events';

    protected $fillable = [
        'model',
        'model_id',
        'text',
        'shop_id',
        'type',
        'author_name',
    ];
}
