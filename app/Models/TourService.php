<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourService extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tour_services';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tour_id',
        'service_id',
    ];

    public function getByTourId($tour_id){
        $query = self::select(['*']);
        $query->where('tour_id', $tour_id);

        return $query;
    }
}
