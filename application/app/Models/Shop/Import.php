<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $table = 'shop_imports';

    protected $fillable = [
        'name',
        'type',
        'count_rows',
        
    ];
}
