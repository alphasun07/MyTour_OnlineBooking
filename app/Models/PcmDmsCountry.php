<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcmDmsCountry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "pcm_dms_countries";
    protected $primaryKey = 'country_id';

    protected $fillable = [];

    public function getAll($data = null)
    {
        $query = self::query();
        $query->orderBy('name');
        return $query;
    }
}
