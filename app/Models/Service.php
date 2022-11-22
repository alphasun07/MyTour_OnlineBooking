<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'services';
    protected $primaryKey = 'id';

    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Hiện',
        self::STATUS_HIDDEN => 'Ẩn',
    ];

    protected $fillable = [
        'name',
        'description',
        'term_condition',
        'places',
        'price',
        'status',
    ];

    public function getAll($data) {
        $query = self::query();
        if ($data) {
            $query->where('name', 'LIKE', "%{$data}%")
                ->orWhere('description', 'LIKE', "%{$data}%");
        }
        return $query;
    }
}
