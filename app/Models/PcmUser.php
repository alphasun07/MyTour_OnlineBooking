<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PcmUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = "pcm_users";

    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'gender_id',
        'birthdate',
        'referral_code',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const GENDER = [
        '1'  =>  'Male',
        '2'  =>  'Female',
        '3'  =>  'Other',
    ];

    public static function getUser($id)
    {
        $user = self::find($id);
        return $user->first();
    }

    public static function getUsers()
    {
        $users = self::select('*')->whereNull('deleted_at')->orderBy('created_at', 'asc');
        return $users->paginate(15);
    }
    public function getAll($params)
    {
        $query = self::select(['*']);
        if (isset($params['name'])) {
            $query->whereRaw("CONCAT(name,' ',email,phone_number,' ') LIKE ?")
                ->setBindings(['%' . $params['name'] . '%']);
        }
        return $query->orderBy('id')->paginate(config('const.page.limit'));
    }
    public function getAllUsers($params = null)
    {
        $query = self::select(['*']);
        if ($params) {
            $query->where('name', 'like', '%'.$params.'%');
        }
        return $query->orderBy('name');
    }
    public function getByReferralCode($code, $user_id=0)
    {
        $query = self::select(['*']);
        $query = $query->where('referral_code', $code);
        if($user_id){
            $query = $query->where('id', '!=', $user_id);
        }
    }
    public function getUserID($userId)
    {
        $query = self::select('name')->where('id',$userId)->first();
        return $query;
    }
}
