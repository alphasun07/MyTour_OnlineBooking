<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderService extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'order_services';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'service_id',
    ];

    public function getByOrderId($order_id){
        $query = self::select(['*']);
        $query->where('order_id', $order_id);

        return $query;
    }
}
