<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayWorked extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "day_workeds";
    protected $primaryKey = 'id';

}
