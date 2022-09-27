<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DtbAccessHistory;

class LoginDayCount
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
        $date = date('Y-m-d');

        if(!isset($request->login_day) && !isset($request->login_flag) && $request->login_day != $date){
            $access_history_model = new DtbAccessHistory;
            $customer_id = $request->customer_id;
            $access_history_model->access_history($customer_id);
            $request->merge([
                'login_day' => $date,
                'login_flag' => 1,
            ]);
        }

        return $next($request);
    }
}
