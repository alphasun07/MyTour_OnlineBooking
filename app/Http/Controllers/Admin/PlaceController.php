<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->input();
        $places = (new Place())->getAll($searchData['name'] ?? '')->paginate(config('const.page.limit'));
        return view('admin.place.index', ['authgroup' => 'admin'], compact('places','searchData'));
    }

    public function addDetail($id = 0)
    {
        $place = !empty($id) ? Place::find($id) : null;
        if (!empty($id) && is_null($place)) {
            return redirect()->route('admin.place.list');
        }
        return view('admin.place.detail', compact('place'));
    }

    public function store(Request $request)
    {
        try {
            $dataPost = $request->all();
            $id = $dataPost['id'] ?? 0;
            if (!$id) {
                Place::create($dataPost);
                $request->session()->flash('success', 'Place has been created');
            } else {
                $category = Place::findOrFail($id);
                $category->fill($dataPost);
                $category->save();
                $request->session()->flash('success', 'Place has been updated');
            }
            return redirect()->route('admin.place.list');
        } catch (\Exception $e) {
            Log::info('---store place---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.place.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $category = Place::find($id);
            $category->delete();
            $request->session()->flash('success', 'place has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.place.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete place---');
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
