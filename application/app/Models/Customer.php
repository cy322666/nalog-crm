<?php

namespace App\Models;

use App\Filament\Resources\CustomerResource;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Customer extends Model
{
    use HasFactory;

    public static string $resource = CustomerResource::class;

    static public string $entity = 'Клиент';

    static public string $propertyForTaskTitle = 'name';

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
