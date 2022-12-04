<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PcmDmsCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\PcmUser;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{

    public function index()
    {
        try{
            $newTours = (new Tour())->getNew()->get();
            $categories = (new PcmDmsCategory())->getDiscovery()->get();
            $fTours = (new Tour())->getFeatured()->get();
            $mTours = (new Tour())->getMostOrder();
            $mTours1 = $mTours->skip(0)->take(4)->get();
            $mTours2 = $mTours->skip(4)->take(4)->get();
            return view('front.home.index', compact('newTours', 'categories', 'fTours', 'mTours1', 'mTours2'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('group. message: '. $e->getMessage());
            abort(500);
        }
    }

    public function userLogout()
    {
        Auth::logout();

        return redirect()->back();
    }

    public function changeLanguage($language)
    {
        Session::put('website_language', $language);

        return redirect()->back();
    }

    public function showProfile(Request $request)
    {
        try{
            $id = $request->id;
            $user = (new PcmUser())->find($id);

            return view('front.home.profile', compact('user'));
        } catch(\Exception $e) {
            log::error('group. message: '. $e->getMessage());
            abort(500);
        }
    }

    public function updateProfile(Request $request)
    {
        try{
            $id = auth('web')->id();

            $rule = [
                'name' => ['required', 'max:255'],
                'phone_number' => ['nullable', 'max:16', 'regex:/^(\(?\+[0-9]{0,4}\)?)?[0-9]+$/'],
                'address' => ['nullable' ,'max:255'],
                'gender_id' => ['in:1,2,3'],
                'birthdate' => ['nullable', 'before:today'],
            ];

            $validator = Validator::make($request->input(), $rule);
            if ($validator->fails()) {
                $messagesErrors = $validator->errors();
                return redirect()->route('home.profile.show', $id)->withInput($request->input())->withErrors($messagesErrors);
            }

            $user = PcmUser::findOrFail($id);
            $user->fill($request->input());
            $user->save();

            return redirect()->route('home.profile.show', $id);
        } catch(\Exception $e) {
            log::error('group. message: '. $e->getMessage());
            abort(500);
        }
    }

}
