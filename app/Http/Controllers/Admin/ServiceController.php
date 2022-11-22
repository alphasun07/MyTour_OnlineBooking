<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->input();
        $services = (new Service())->getAll($searchData['name'] ?? '')->paginate(config('const.page.limit'));
        return view('admin.services.index', compact('services','searchData'));
    }

    public function detail($id = 0)
    {
        $service = !empty($id) ? Service::find($id) : null;

        if (!empty($id) && is_null($service)) {
            return redirect()->route('admin.service.list');
        }
        return view('admin.services.detail', compact('service'));
    }

    public function store(Request $request)
    {
        try {
            $dataPost = $request->all();
            $id = $dataPost['id'] ?? 0;
            if (!$id) {
                Service::create($dataPost);
                $request->session()->flash('success', 'Service has been created');
            } else {
                $service = Service::findOrFail($id);
                $service->fill($dataPost);
                $service->save();
                $request->session()->flash('success', 'Service has been updated');
            }
            return redirect()->route('admin.service.list');
        } catch (\Exception $e) {
            Log::info('---store service---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.service.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $service = Service::find($id);
            $service->delete();
            $request->session()->flash('success', 'Service has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.service.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete service---');
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
