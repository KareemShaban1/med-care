<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'total',
        'status',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
