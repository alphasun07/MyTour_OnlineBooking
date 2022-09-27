<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;
use Illuminate\Support\Facades\Log;
use App\Models\PcmDmsTag;

class TagController extends Controller
{

    public function index(Request $request)
    {
        $searchData = $request->except('page');
        $tags = (new PcmDmsTag())->getAll($searchData['name'] ?? '')->paginate(config('const.page.limit'));
        return view('admin.dms.tag.index', ['authgroup' => 'admin'], compact('tags','searchData'));
    }

    public function detail($id = 0)
    {
        $tag = $id ? (new PcmDmsTag)->find($id) : null;
        if($id && is_null($tag)){
            return redirect()->route('admin.tag.list');
        }

        return view('admin.dms.tag.detail', compact('tag'));
    }

    public function store(TagRequest $request)
    {
        try{
            $dataTag = $request->all();
            $id = $dataTag['id'] ?? null;

            if(!$id){
                PcmDmsTag::create($dataTag);
            }else{
                $tag = PcmDmsTag::findOrFail($id);
                $tag->fill($dataTag);
                $tag->save();
            }

            $request->session()->flash('success', 'Tag has been saved.');
            return redirect()->route('admin.tag.list');
        } catch (\Exception $e) {
            Log::info('---store tag---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error occurred.");
            return redirect()->route('admin.user.list');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            PcmDmsTag::where('id', $id)->delete();
            $request->session()->flash('success', 'Tag has been deleted');
            return [
                'success' => true,
                'redirectTo' => route("admin.tag.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete tag---');
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
