<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->except('page');
        $coupons = (new Coupon())->getAll($searchData);
        return view('admin.coupon.index', compact('coupons', 'searchData'));
    }

    public function detail($id = 0)
    {
        $coupon = !empty($id) ? Coupon::find($id) : null;
        if (!empty($id) && is_null($coupon)) {
            return redirect()->route('admin.coupon.list');
        }
        return view('admin.coupon.detail', compact('coupon'));
    }

    public function store(CouponRequest $request)
    {
        try {
            $dataPost = $request->all();
            $id = $dataPost['id'] ?? 0;
            if (!$id) {
                Coupon::create($dataPost);
                $request->session()->flash('success', 'Coupon has been created');
            } else {
                $category = Coupon::findOrFail($id);
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
            $category = Coupon::find($id);
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
            $coupon = (new Coupon())->getCouponOfDocucmentByCode($dataPost['document_id'], $dataPost['coupon_code']);
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
