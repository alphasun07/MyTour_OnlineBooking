<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Jobs\CheckMailContact;
use App\Models\PcmContactInformation;
use App\Models\PcmDmsConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contact(){
        return view('front.home.contact');
    }

    public function sendContact(Request $request)
    {
        try{
            $data_register = $request->all();
            $rule = [
                'name'                  => ['required', 'max:255'],
                'email'                 => ['required', 'max:255', 'email'],
                'subject'               => ['required', 'max:255'],
                'message'               => ['required'],
            ];

            $validator = Validator::make($request->input(), $rule);
            if ($validator->fails()) {
                $messagesErrors = $validator->errors();
                return redirect()->route('home.post.contact')->withInput($request->input())->withErrors($messagesErrors);
            }

            PcmContactInformation::create($data_register);
            $admin_contact = (new PcmDmsConfig())->getValueConfig('notification_emails') ?? '';
            $site_name = 'Pcmdonation';

            if (!is_null($admin_contact)) {
                $dispatch = dispatch(new CheckMailContact($data_register, $admin_contact, $site_name));
            }

            $request->session()->flash('success', 'Thanks for contacting us.');
            return redirect()->route('home.post.contact')->withInput($request->input());
        } catch (\Exception $e) {
            Log::info('---store register information---');
            Log::error($e->getMessage());
            $request->session()->flash('error', $e->getMessage() ?? 'An error has occurred');
            return redirect()->route('home.post.contact')->withInput($request->input());
        }
    }
}
