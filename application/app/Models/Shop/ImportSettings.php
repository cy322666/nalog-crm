<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportSettings extends Model
{
    use HasFactory;

    protected $table = 'shop_import_settings';

    protected $fillable = [
        'entity_type',
        'import_id',
        'column',
        'key',
    ];
}
