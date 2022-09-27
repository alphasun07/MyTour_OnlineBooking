<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Requests\Admin\MemberRequest;
use App\Models\PcmUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $searchData = $request->except('page');
            $users = (new PcmUser)->getAll($searchData);
            return view('admin.users.member.index', compact('users', 'searchData'));
        } catch (\Exception $e) {
            log::error('group. message: ' . $e->getMessage());
            abort(500);
        }
    }

    public function addDetail(Request $request, $id = null)
    {
        try {
            $randomReferralCode = (new Helper())->makeRandomReferralCode();
            $user = !empty($id) ? PcmUser::find($id) : null;
            if (!empty($id) && is_null($user)) {
                return redirect()->route('admin.user.list');
            }
            return view('admin.users.member.add', compact('user', 'randomReferralCode'));
        } catch (\Exception $e) {
            log::error('group. message: ' . $e->getMessage());
            abort(500);
        }
    }

    public function store(MemberRequest $request)
    {
        try {
            $dataPost = $request->all();
            $id = $dataPost['user_id'] ?? 0;
            if (!is_null($dataPost['password'])) {
                $dataPost['password'] = Hash::make($dataPost['password']);
            } else {
                unset($dataPost['password']);
            }

            if(isset($dataPost['referral_code']) && !is_null($dataPost['referral_code']) && (new PcmUser())->getByReferralCode($dataPost['referral_code'], $dataPost['user_id'])->first()){
                return redirect()->back()->withInput()->withErrors(['referral_code' => 'This referral code already exists.']);
            }

            if (!$id) {
                PcmUser::create($dataPost);
            } else {
                $user = PcmUser::findOrFail($id);
                $user->fill($dataPost);
                $user->save();
            }
            $request->session()->flash('success', 'Data has been saved');
            return redirect()->route('admin.member.list');
        } catch (\Exception $e) {
            Log::info('---store user---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.member.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            PcmUser::where('id', $id)->delete();
            $request->session()->flash('success', 'User has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.member.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete User---');
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function ajaxGetRandomCode()
    {
        try{
            $code = (new Helper())->makeRandomReferralCode();

            return response()->json([
                'success' => true,
                'code' => $code,
            ]);

        } catch (\Exception $e) {
            Log::info('---ajaxGetRandomCodeError---');
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "An error has occurred",
            ]);
        }
    }
}
