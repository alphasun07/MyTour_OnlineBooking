<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DayWorked;
use App\Models\PcmMember;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
                $createdSalary = (new Salary)->create([
                    'member_id'         => $dayWorked->id,
                    'monthly_salary'    => ((PcmMember::SORT_NO_SALARY_LIST)[$dayWorked->sort_no]) * $dayWorked->total_day
                ]);
                $dayId = (new DayWorked())->getByMemberId($dayWorked->id, $now->month, $now->year)->pluck('id')->toArray();
                (new DayWorked())->whereIn('id', $dayId)->update(['salary_id' => $createdSalary->id]);
            } else {
                $check->update([
                    'monthly_salary'    => ((PcmMember::SORT_NO_SALARY_LIST)[$dayWorked->sort_no]) * $dayWorked->total_day
                ]);
                $dayId = (new DayWorked())->getByMemberId($dayWorked->id, $now->month, $now->year)->pluck('id')->toArray();
                (new DayWorked())->whereIn('id', $dayId)->update(['salary_id' => $check->id]);
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

    public function store(Request $request)
    {
        try {
            $dataPost = $request->all();
            $id = $dataPost['id'] ?? 0;
            if (!$id) {
                Salary::create($dataPost);
                $request->session()->flash('success', 'Salary has been created');
            } else {
                $salary = Salary::findOrFail($id);
                $salary->fill($dataPost);
                $salary->save();
                $request->session()->flash('success', 'Salary has been updated');
            }
            return redirect()->route('admin.salary.list');
        } catch (\Exception $e) {
            Log::info('---store service---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.salary.list');
        }
    }
}
