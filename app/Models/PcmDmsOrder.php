<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PcmDmsOrder extends Model
{
    use HasFactory, SoftDeletes;

    const PUBLISHED_OFF = 0;
    const PUBLISHED_ON = 1;

    protected $table = "pcm_dms_orders";
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'organization',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'fax',
        'email',
        'payment_method',
        'total_amount',
        'discount',
        'transaction_id',
        'payment_date',
        'published',
        'comment',
        'license_code',
        'payment_amount',
        'payment_currency',
        'order_number',
        'amount',
        'email_sent',
        'customer_ip',
        'referral_code'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\PcmUser', 'id', 'user_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\PcmDmsCountry', 'country_id', 'country');
    }

    public function documents()
    {
        return $this->belongsToMany(PcmDmsDocument::class, 'pcm_dms_order_item', 'order_id', 'document_id');
    }

    public function orderItem()
    {
        return $this->hasMany(PcmDmsOrderItem::class, 'order_id', 'id');
    }

    public function scopePublish($query)
    {
        return $query->where('pcm_dms_orders.published', self::PUBLISHED_ON);
    }

    public function getAll($data = null)
    {
        $query = self::query();
        if ($data) {
            $query->where('first_name', 'LIKE', '%' . $data . '%')
                ->orWhere('last_name', 'LIKE', '%' . $data . '%')
                ->orWhere('email', 'LIKE', '%' . $data . '%')
                ->orWhere('referral_code', 'LIKE', '%' . $data . '%');
        }
        $query->orderBy('created_at', 'desc');
        return $query;
    }

    public function get12Months($year = null)
    {
        if (is_null($year)) {
            $year = Carbon::now()->year;
        }
        $today = Carbon::parse('01/01/' . $year)->format('d/m/Y');
        $month_names = [
            (new Carbon($today))
        ];
        for ($i = 1; $i <= 11; $i++) {
            $month_names[$i] = (new Carbon($today))->addMonth();
            $today = (new Carbon($today))->addMonth();
        }
        return $month_names;
    }

    public function getRevenueStatistics($months)
    {
        $list_statistics = [];
        $total_session = [];
        foreach ($months as $month_start) {
            $list_total_amount_in_month = PcmDmsOrder::whereNotNull('payment_date')->whereBetween('payment_date', [$month_start->toDateString(), $month_start->addDays(30)->toDateString()])->where('published', self::PUBLISHED_ON)->pluck('total_amount')->toArray();
            $list_statistics[] = array_sum($list_total_amount_in_month);
            $total_session[] = count($list_total_amount_in_month);
        }
        return [
            'list_statistics' => $list_statistics,
            'total_session' => $total_session,
        ];
    }

    public function getYearStart()
    {
        $yearMin = self::whereNotNull('payment_date')->orderBy('payment_date', 'asc')->first()->payment_date ?? Carbon::now();
        $yearMin = Carbon::createFromFormat('Y-m-d H:i:s', $yearMin)->year;
        return $yearMin;
    }

    public function getByUserId($user_id)
    {
        $orders = self::where('user_id', $user_id)
            ->orderBy('payment_date')
            ->Publish()
            ->get();
        return $orders;
    }

    public function getOrderByUser($user)
    {
        $query = self::select([
            'pcm_dms_documents.id',
            'pcm_dms_documents.title',
            'pcm_dms_documents.price',
            'pcm_dms_documents.prevent_download_type',
            'pcm_dms_documents.number_days',
            'pcm_dms_documents.number_downloads',
            'pcm_dms_order_item.downloaded',
            DB::raw('pcm_dms_orders.id AS order_id'),
            // DB::raw('DATEDIFF(' . $now . ', pcm_dms_orders.payment_date) AS days_different')
        ])
            ->join('pcm_dms_order_item', 'pcm_dms_orders.id', '=', 'pcm_dms_order_item.order_id')
            ->join('pcm_dms_documents', 'pcm_dms_order_item.document_id', '=', 'pcm_dms_documents.id')
            ->Publish()
            ->where('pcm_dms_orders.user_id', $user->id);
        return $query->get();
    }

    public static function formatInvoiceNumber($id, $config)
	{
		return $config->invoice_prefix . str_pad($id, $config->invoice_number_length ? $config->invoice_number_length : 4, '0', STR_PAD_LEFT);
	}
}
