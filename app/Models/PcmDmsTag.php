<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcmDmsTag extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'hits',
    ];

    public function getAll($data = false)
    {
        $query = self::query();
        if ($data) {
            $query->where('title', 'LIKE', "%{$data}%");
        }
        return $query;
    }

    public function getTagTitleByID($id)
    {
        $tag = self::where('id', $id)->first();
        return $tag;
    }
}