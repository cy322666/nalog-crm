<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const TYPE = 3;

    protected $table = 'shop_tasks';

    protected $fillable = [
        'title',
        'text',
        'model_id',
        'model_type',
        'responsible_id',
        'type_id',
        'shop_id',
        'execute_at',
        'execute_to',
        'is_execute',
        'task_id',
        'is_failed',
        'creator_id',
    ];

    public function link()
    {
        //TODO
        $resourceModel = $this->model_type::$resource;

        return $resourceModel::getUrl('edit', ['record' => $this->model_id]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'entity_id', 'id')
            ->where('entity_type', 'order');
    }

    public function responsibleName()
    {
        return $this->responsible()->first()->name;
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_employee_id', 'id');
    }

    public function label()
    {
        $propertyName = $this->model_type::$propertyForTaskTitle;

        return (new $this->model_type)->find($this->model_id)->$propertyName;
    }

    //TODO no use
    public function type()
    {
        return $this->hasOne(TaskType::class, 'id', 'type_id');
    }

    public static function generateId(): int
    {
        return rand(100000, 999999);
    }
}
