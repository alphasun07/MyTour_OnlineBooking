<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DayWorked;
use App\Models\PcmMember;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->all();
        $salaries = (new Salary())->getAll($searchData ?? [])->paginate(config('const.page.limit'));
        return view('admin.salaries.index', compact('salaries','searchData'));
    }

    public function detail(Request $request)
    {
        $now = Carbon::now();
        $daysWorked = (new PcmMember())->getMemberAndDayWorked($now->month, $now->year)->get();

        foreach($daysWorked as $dayWorked){
            $check = (new Salary)->checkSalaryExist($dayWorked->id, $now->month, $now->year)->first();
            if (!$check) {
                (new Salary)->create([
                    'member_id'         => $dayWorked->id,
                    'monthly_salary'    => ((PcmMember::SORT_NO_SALARY_LIST)[$dayWorked->sort_no]) * $dayWorked->total_day
                ]);
            }
        }

        $request->session()->flash('success', 'Lương đã được tính thành công');
        return redirect()->route('admin.salary.list');
    }

    public function detail1(Request $request, $id)
    {
        $paramData = $request->all();
        $salary = (new Salary())->find($id);
        if (is_null($salary)) {
            return redirect()->route('admin.salary.list');
        }

        $members = (new PcmMember())->getAll([]);

        return view('admin.salaries.detail', compact('salary', 'members'));
    }
}
