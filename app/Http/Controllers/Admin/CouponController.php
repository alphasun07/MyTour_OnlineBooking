<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\PcmDmsCoupon;
use App\Models\PcmDmsDocument;
use App\Models\PcmUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    private $document;
    private $user;

    public function __construct(PcmDmsDocument $document, PcmUser $user)
    {
        $this->document = $document;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $searchData = $request->except('page');
        $coupons = (new PcmDmsCoupon())->getAll($searchData);
        return view('admin.dms.coupon.index', compact('coupons', 'searchData'));
    }

    public function addDetail($id = 0)
    {
        $documents = $this->document->all();
        $users = $this->user->all();
        $coupon = !empty($id) ? PcmDmsCoupon::find($id) : null;
        if (!empty($id) && is_null($coupon)) {
            return redirect()->route('admin.coupon.list');
        }
        return view('admin.dms.coupon.detail', compact('coupon', 'documents', 'users'));
    }

    public function store(CouponRequest $request)
    {
        try {
            $dataPost = $request->all();
            $id = $dataPost['coupon_id'] ?? 0;
            if (!$id) {
                PcmDmsCoupon::create($dataPost);
                $request->session()->flash('success', 'Coupon has been created');
            } else {
                $category = PcmDmsCoupon::findOrFail($id);
                $category->fill($dataPost);
                $category->save();
                $request->session()->flash('success', 'Coupon has been updated');
            }
            return redirect()->route('admin.coupon.list');
        } catch (\Exception $e) {
            Log::info('---store coupon---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.coupon.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $category = PcmDmsCoupon::find($id);
            $category->delete();
            $request->session()->flash('success', 'Coupon has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.coupon.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete coupon---');
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function check(Request $request)
    {
        try {
            $dataPost = $request->all();
            $coupon = (new PcmDmsCoupon())->getCouponOfDocucmentByCode($dataPost['document_id'], $dataPost['coupon_code']);
            if ($coupon && $coupon->times > $coupon->used) {
                return [
                    'status' => true,
                    'message' => 'Success'
                ];
            }

            return [
                'status' => false,
                'message' => 'Coupon code has expired'
            ];
            
        } catch (\Exception $e) {
            Log::info('---check coupon---');
            Log::error($e->getMessage());
            return [
                'status' => false,
                'message' => 'Invalid coupon code'
            ];
        }
    }
}
