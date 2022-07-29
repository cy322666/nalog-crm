<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'shop_events';

    const UPDATED_AT = null;

    protected $fillable = [
        'model',
        'model_id',
        'title',
        'shop_id',
        'type',
        'author_name',
    ];
}
