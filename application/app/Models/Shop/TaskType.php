<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    protected $table = 'shop_task_types';

    protected $fillable = [
        'title',
        'color',
        'icon',
    ];
}
