<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
}
