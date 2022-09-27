<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Address
 * @package app
 */
class BaseModel extends Model
{

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (Auth::guard('admin')->check()) {
                $user = Auth::guard('admin')->user();
                $model->creator_id = $user->id;
            }
        });
    }
}
