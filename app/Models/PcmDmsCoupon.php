<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PcmDmsCoupon extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'coupon_type',
        'discount',
        'document_id',
        'times',
        'used',
        'published',
        'user_id',
    ];

    const Public = 1;
    const Private = 0;

    const PUBLISHED = [
        self::Public => 'Yes',
        self::Private => 'No'
    ];

    const Percent = 1;
    const Amount = 0;

    const TYPE = [
        self::Percent => 'Percent',
        self::Amount => 'Amount'
    ];

    public function scopePublish($query)
    {
        return $query->where('pcm_dms_coupons.published', self::Public);
    }

    public function getAll($params)
    {
        $query = self::select(['*']);
        if (isset($params['name'])) {
            $query = $query->whereRaw("CONCAT(code, ' ',coupon_type) LIKE ?")
                ->setBindings(['%' . $params['name'] . '%']);
        }
        return $query->orderBy('id')->paginate(config('const.page.limit'));
    }

    public function getCouponOfDocucmentByCode($document_id, $code)
    {
        return self::where('document_id', $document_id)
                ->where('code', $code)
                ->Publish()
                ->first();
    }

    public function usedCoupon($id) {
        $coupon = self::find($id);
        if ($coupon) {
            $coupon->used = $coupon->used + 1;
            $coupon->save();
        }
    }
}
