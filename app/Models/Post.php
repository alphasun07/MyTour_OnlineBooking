<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'posts';
    protected $primaryKey = 'id';

    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Hiện',
        self::STATUS_HIDDEN => 'Ẩn',
    ];

    protected $fillable = [
        'title',
        'brief',
        'content',
        'status',
        'tag',
    ];

    public function getAll($data) {
        $query = self::query();
        if ($data) {
            $query->where('title', 'LIKE', "%{$data}%")
                ->orWhere('content', 'LIKE', "%{$data}%")
                ->orWhere('brief', 'LIKE', "%{$data}%");
        }
        return $query;
    }
}
