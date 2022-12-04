<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    public function services() {
        return $this->belongsToMany(Service::class, 'tour_services');
    }

    protected $append = ['status_obj', 'featured_obj'];

    public function getStatusObjAttribute() {
        return (new Helper)->commonObj(self::STATUS_LIST, $this->status);
    }

    public function getFeaturedObjAttribute() {
        return (new Helper)->commonObj(self::FEATURED_LIST, $this->featured);
    }

    public function getAll($data = null) {
        $query = self::query();
        if ($data) {
            $query->where('name', 'LIKE', "%{$data}%")
                ->orWhere('description', 'LIKE', "%{$data}%");
        }
        return $query;
    }

    public function getNew($limit = 10){
        $query = self::query();
        $query->orderBy('created_at', 'desc');
        $query->limit($limit);

        return $query;
    }

    public function getFeatured($limit = 3, $status = self::STATUS_VAL){
        $query = self::query();
        $query->orderBy('created_at', 'desc');
        $query->where('featured', self::FEATURED_ON);
        if ($status) {
            $query->where('status', $status);
        }
        $query->limit($limit);

        return $query;
    }

    public function getMostOrder(){
        $query = self::select(['*']);

        $queryCountOrder = (new Order)->select([
            DB::raw('count(*) as count_order'),
                'orders.tour_id',
        ])->groupBy('tour_id');

        $query->joinSub($queryCountOrder, 'count_order_table', function($join){
            $join->on('count_order_table.tour_id', '=', 'tours.id');
        })->orderBy('count_order_table.count_order', 'desc');

        return $query;
    }

    public function getById($id){
        $query = self::select(['*']);
        $query->where('id', $id);

        $queryCountOrder = (new Order)->select([
            DB::raw('count(*) as count_order'),
                'orders.tour_id',
        ])->groupBy('tour_id');

        $query->leftJoinSub($queryCountOrder, 'count_order_table', function($join){
            $join->on('count_order_table.tour_id', '=', 'tours.id');
        });

        $query->with('services');

        return $query;
    }

    public function getByCategoryId($category_id){
        $query = self::where('category_id', $category_id);

        return $query;
    }
}
