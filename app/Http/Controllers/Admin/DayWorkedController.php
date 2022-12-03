<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DayWorked;
use App\Models\PcmMember;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DayWorkedController extends Controller
{
    public function index(Request $request, $salary_id)
    {
        $searchData = $request->all();
        $daysWorked = (new DayWorked())->getBySalaryId($salary_id)->paginate(config('const.page.limit'));
        return view('admin.days_worked.index', compact('daysWorked','searchData','salary_id'));
    }

    public function detail($salary_id, $id = 0)
    {
        $dayWorked = !empty($id) ? DayWorked::find($id) : null;
        $members = (new PcmMember())->getAll([]);

        if (!empty($id) && is_null($dayWorked)) {
            return redirect()->route('admin.salary.dayWorked.index', ['salary_id' => $salary_id]);
        }

        return view('admin.days_worked.detail', compact('dayWorked', 'members'));
    }

    public function store(Request $request)
    {
        try {
            $now = Carbon::now();
            $dataPost = $request->all();
            $id = $dataPost['id'] ?? 0;
            if (!$id) {
                $dayWorked = DayWorked::create($dataPost);
                $request->session()->flash('success', 'Day worked has been created');
            } else {
                $dayWorked = DayWorked::findOrFail($id);
                $dayWorked->fill($dataPost);
                $dayWorked->save();
                $request->session()->flash('success', 'Day worked has been updated');
            }

            $check = (new Salary())->checkSalaryExist($dataPost['member_id'], $now->month, $now->year)->first();
            if ($check) {
                $member = (new PcmMember())->find($dataPost['member_id']);
                (new Salary)->update([
                    'monthly_salary'    => ((PcmMember::SORT_NO_SALARY_LIST)[$member->sort_no]) * $dayWorked->total_day
                ]);
                $dayId = (new DayWorked())->getByMemberId($dataPost['member_id'], $now->month, $now->year)->pluck('id')->toArray();
                (new DayWorked())->whereIn('id', $dayId)->update(['salary_id' => $check->id]);
            }

            return redirect()->route('admin.salary.dayWorked.index', ['salary_id' => ($dataPost['salary_id'] ?? 0)]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::info('---store service---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.salary.dayWorked.index', ['salary_id' => ($dataPost['salary_id'] ?? 0)]);
        }
    }
}
