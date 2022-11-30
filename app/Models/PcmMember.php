<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class PcmMember extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = "pcm_members";

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'login_id',
        'phone_number',
        'address',
        'gender_id',
        'birthdate',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const SORT_NO_ADMIN = 1;
    const SORT_NO_STAFF_MANAGER = 2;
    const SORT_NO_ACCOUNTANT = 3;

    const SORT_NO_SALARY_LIST = [
        self::SORT_NO_ADMIN => 250000,
        self::SORT_NO_STAFF_MANAGER => 200000,
        self::SORT_NO_ACCOUNTANT => 150000,
    ];

    const GENDER = [
        '1'  =>  'Male',
        '2'  =>  'Female',
        '3'  =>  'Other',
    ];

    public static function getMember($id)
    {
        $member = self::findOrFail($id);
        return $member->first();
    }

    public static function getMembers()
    {
        $users = self::select('*')->whereNull('deleted_at')->orderBy('created_at', 'asc');
        return $users->paginate(15);
    }
    public function getAll($params)
    {
        $query = self::select(['*']);
        if (isset($params['name'])) {
            $query->whereRaw("CONCAT(login_id,' ',name,phone_number,' ') LIKE ?")
                ->setBindings(['%' . $params['name'] . '%']);
        }
        return $query->orderBy('id')->paginate(config('const.page.limit'));
    }

    public function getMemberAndDayWorked($month, $year){
        $query = self::select(['*']);

        $queryDayWork = (new DayWorked)->select([
            DB::raw('count(*) as total_day'),
            'day_workeds.member_id',
        ])->whereRaw('MONTH(created_at) = ' . $month)
            ->whereRaw('YEAR(created_at) = ' . $year)
            ->groupBy('member_id');

        $query->joinSub($queryDayWork, 'count_day_worked', function($join){
            $join->on('count_day_worked.member_id', '=', 'pcm_members.id');
        });

        return $query;
    }
}
