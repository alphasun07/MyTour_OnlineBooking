<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\PcmDmsConfig;
use App\Models\PcmPage;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        $config = (new PcmDmsConfig())->getData();
        $pages = (new PcmPage())->all();
        return view('admin.dms.config.index', ['authgroup' => 'admin'], compact('config', 'pages'));
    }

    public function store(Request $request)
    {
        try {
            (new PcmDmsConfig())->storeConfig($request);
            return redirect()->route('admin.dms.config')->with('success', 'Configuration data saved');
        } catch (\Exception $e) {
            Log::error("ConfigController store" . $e->getMessage());
            return redirect()->route('admin.dms.config')->with('error', 'Configuration data save error');
        }
    }
}
