<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Salary extends Model
{   
    use HasFactory, SoftDeletes;
    protected $table = 'salaries';
    protected $primaryKey = 'id';

    protected $fillable = [
        'member_id',
        'monthly_salary',
    ];

    public function member() {
        return $this->belongsTo(PcmMember::class, 'member_id', 'id');
    }

    public function countDayWorked() {
        return $this->hasMany(DayWorked::class, 'member_id', 'member_id')
            ->select([
                DB::raw('count(*) as total_day'),
                'day_workeds.member_id',
            ])
            ->groupBy('member_id');
    }

    public function getAll($data) {
        $now = Carbon::now();
        $month = isset($data['month']) ? $data['month'] : $now->month;
        $year = isset($data['year']) ? $data['year'] : $now->year;

        $query = self::query();

        if ($data) {
            $query->whereRaw('MONTH(created_at) = ' . $month)
                ->whereRaw('YEAR(created_at) = ' . $year);
        }

        $query->with('member');

        $query->with(['countDayWorked' => function($queryDayWork) use ($month, $year){
            $queryDayWork->whereRaw('MONTH(created_at) = ' . $month)
                  ->whereRaw('YEAR(created_at) = ' . $year);
        }]);

        $query->with('countDayWorked');

        return $query;
    }

    public function checkSalaryExist($memberId, $month, $year){
        $query = self::query();

        $query->where('member_id', $memberId);
        $query->whereRaw('MONTH(created_at) = ' . $month)
            ->whereRaw('YEAR(created_at) = ' . $year);

        return $query;
    }
}
