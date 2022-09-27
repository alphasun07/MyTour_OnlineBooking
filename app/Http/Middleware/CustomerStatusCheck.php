<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DtbCustomer;

class CustomerStatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset($request->customer_id)) {
            $customer_model = new DtbCustomer;
            //顧客ステータスが退会処理中か確認
            $customer_status_check = $customer_model->CustomerStatusCheck($request->customer_id);
            if(!empty($customer_status_check)){
                $request->session()->put('customer_leave_flag', 1);
                /*$request->merge([
                    'customer_leave_flag' => 1,
                ]);*/
            }
        }
        return $next($request);
    }
}
