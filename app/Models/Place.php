<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'places';

    protected $fillable = [
        'country',
        'name',
        'city',
        'province',
        'address',
    ];

    public function getAll($data = false)
    {
        $query = self::query();
        if ($data) {
            $query->where('city', 'LIKE', "%{$data}%")
            ->orWhere('province', 'LIKE', "%{$data}%")
            ->orWhere('country', 'LIKE', "%{$data}%")
            ->orWhere('address', 'LIKE', "%{$data}%");
        }
        return $query;
    }
}
