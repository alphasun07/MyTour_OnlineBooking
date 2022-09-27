<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcmDmsOrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "pcm_dms_order_item";

    protected $fillable = [
        'order_id',
        'document_id',
        'download_code',
        'downloaded',
        'order_date',
        'item_price',
        'license_code'
    ];
}
