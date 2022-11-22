<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tours';
    protected $primaryKey = 'id';

    const FOLDER_IMAGE = 'tours';

    const STATUS_VAL = 1;
    const STATUS_UNVAL = 0;
    const STATUS_COMMING_SOON = 2;

    const STATUS_LIST = [
        self::STATUS_VAL => 'Co san',
        self::STATUS_UNVAL => 'Khong co san',
        self::STATUS_COMMING_SOON => 'Chuan bi ra mat'
    ];

    const FEATURED_ON = 1;
    const FEATURED_OFF = 0;

    const FEATURED_LIST = [
        self::FEATURED_OFF => 'Tat',
        self::FEATURED_ON => 'Bat',
    ];

    protected $fillable = [
        'name',
        'description',
        'tour_time',
        'places',
        'price_per_person',
        'status',
        'max_person',
        'thumbnail',
        'images',
        'category_id',
        'featured',
    ];

    protected $append = ['status_obj', 'featured_obj'];

    public function getStatusObjAttribute() {
        return (new Helper)->commonObj(self::STATUS_LIST, $this->status);
    }

    public function getFeaturedObjAttribute() {
        return (new Helper)->commonObj(self::FEATURED_LIST, $this->featured);
    }

    public function getAll($data) {
        $query = self::query();
        if ($data) {
            $query->where('name', 'LIKE', "%{$data}%")
                ->orWhere('description', 'LIKE', "%{$data}%");
        }
        return $query;
    }

}
