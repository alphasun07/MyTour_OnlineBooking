<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PcmUser;
use App\Models\Tour;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->except('page');
        $orders = (new Order)->getAll($searchData['name'] ?? '')->paginate(config('const.page.limit'));

        return view('admin.order.index', compact('orders', 'searchData'));
    }

    public function detail($id = 0)
    {
        $order = $id ? (new Order)->find($id) : null;
        if($id && is_null($order)){
            return redirect()->route('admin.order.list');
        }

        $users = (new PcmUser())->getAllUsers([])->get();
        $tours = (new Tour())->getAll()->get();

        return view('admin.order.detail', compact('order', 'users', 'tours'));
    }

    public function store(OrderRequest $request)
    {
        try{
            $dataOrder = $request->all();
            $id = $dataOrder['id'] ?? null;

            if(!$id){
                Order::create($dataOrder);
            }else{
                $order = Order::findOrFail($id);
                $order->fill($dataOrder);
                $order->save();
            }

            $request->session()->flash('success', 'Order has been saved.');
            return redirect()->route('admin.order.list');
        } catch (\Exception $e) {
            Log::info('---store tag---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error occurred.");
            return redirect()->route('admin.order.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            Order::whereId($id)->delete();
            $request->session()->flash('success', 'Order has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.order.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete order---');
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getUsers(Request $request)
    {
        try{
            $data = $request->all() ?? [];
            $key = $data['key'] ?? '';
            $user_id = $data['user_id'] ?? '';
            $users = (new PcmUser())->getAllUsers(isset($data['key']) ? $data['key'] : '')->paginate(config('const.page.limit')) ?? [];
            $page = view('admin.common.user-paginate', compact('users', 'user_id', 'key'))->render();

            return response()->json([
                'success' => true,
                'page' => $page,
            ]);
        } catch (\Exception $e) {
            Log::info('---getUsersAjaxError---');
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'errorMessage' => "An error has occurred",
            ]);
        }
    }

    public function getUserByReferralCode(Request $request)
    {
        try{
            $code = $request->code ?? '';
            $userIdChose = $request->userIdChose ?? '';

            $user = (new PcmUser())->getByReferralCode($code, $userIdChose)->first() ?? '';

            if(!$user){
                return response()->json([
                    'success' => false,
                    'message' => 'This referral code does not exist.',
                ]);
            }

            return response()->json([
                'success' => true,
                'code' => $code,
                'name' => $user->name,
            ]);

        } catch (\Exception $e) {
            Log::info('---getUserByReferralCodeError---');
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "An error has occurred",
            ]);
        }
    }
}
