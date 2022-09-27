<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminRequest;
use App\Models\PcmMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $searchData = $request->except('page');
            $members = (new PcmMember)->getAll($searchData);

            return view('admin.users.admin.index', compact('members', 'searchData'));
        } catch (\Exception $e) {
            log::error('group. message: ' . $e->getMessage());
            abort(500);
        }
    }

    public function addDetail(Request $request, $id = null)
    {
        try {
            $member = !empty($id) ? PcmMember::find($id) : null;
            if (!empty($id) && is_null($member)) {
                return redirect()->route('admin.list');
            }
            return view('admin.users.admin.add', compact('member'));
        } catch (\Exception $e) {
            log::error('group. message: ' . $e->getMessage());
            abort(500);
        }
    }

    public function store(AdminRequest $request)
    {
        try {
            $dataPost = $request->all();
            $id = $dataPost['member_id'] ?? 0;
            if (!is_null($dataPost['password'])) {
                $dataPost['password'] = Hash::make($dataPost['password']);
            } else {
                unset($dataPost['password']);
            }

            if (!$id) {
                PcmMember::create($dataPost);
            } else {
                $user = PcmMember::findOrFail($id);
                $user->fill($dataPost);
                $user->save();
            }
            $request->session()->flash('success', 'Data has been saved');
            return redirect()->route('admin.list');
        } catch (\Exception $e) {
            Log::info('---store member---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            if (\auth('admin')->id() == $request->id) {

                $request->session()->flash('error', "You can't delete yourself.");
                return [
                    'success' => true,
                    'redirectTo' => route("admin.list")
                ];
            }
            $admin = PcmMember::find($request->id);
            $admin->delete();
            $request->session()->flash('success', 'User has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete User---');
            Log::error($e->getMessage());
            throw $e;
        };
    }

}
