<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DayWorked extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "day_workeds";
    protected $primaryKey = 'id';

    protected $fillable = [
        'member_id',
        'salary_id',
        'days_count',
        'created_at',
    ];

    public function member() {
        return $this->belongsTo(PcmMember::class, 'member_id', 'id');
    }

    public function getBySalaryId($salary_id){
        $query = self::select(['*']);
        $query->where('salary_id', $salary_id);
        $query->with('member');

        return $query;
    }

    public function getByMemberId($memberId, $month, $year){
        $query = self::query();

        $query->where('member_id', $memberId);
        $query->whereRaw('MONTH(created_at) = ' . $month)
            ->whereRaw('YEAR(created_at) = ' . $year);

        return $query;
    }

    public function getTotalDay($salary_id){
        $query = self::select([
            DB::raw('count(*) as total'),
            'day_workeds.member_id',
        ]);

        $query->where('salary_id', $salary_id);
        $query->groupBy('salary_id');
        return $query;
    }
}
