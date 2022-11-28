<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->all();
        $salaries = (new Salary())->getAll($searchData ?? [])->paginate(config('const.page.limit'));
        return view('admin.salaries.index', compact('salaries','searchData'));
    }
}
