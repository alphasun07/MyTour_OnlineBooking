<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Support\Facades\Log;
use App\Models\PcmDmsCategory;
use App\Models\DtbPost;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $searchData = $request->except('page');
        $parent_categories = (new PcmDmsCategory)->getAll($searchData,true)->paginate(config('const.page.limit'));
        $parent_ids = (new PcmDmsCategory())->getListCategory()->pluck('parent_id')->toArray();
        $parent_ids = array_unique(array_filter($parent_ids));
        return view('admin.category.index', ['authgroup' => 'admin'], compact('parent_categories', 'searchData', 'parent_ids'));
    }

    public function addDetail($id = 0)
    {
        $category = PcmDmsCategory::find($id);
        $parent_categories = (new PcmDmsCategory())->getListCategory(true)->get();
        $list_parent_ids = [];
        $category_label = '';
        if (!is_null($category) && ($category->parent_id!=0)) {
            $category_label = (new Helper())->getTreeLabelCategory($category);
            $list_parent_ids = (new Helper())->getAllParentCategoryByChild($category->parent_id);
        }
        return view('admin.category.detail', ['authgroup' => 'admin'], compact('category', 'parent_categories', 'category_label', 'list_parent_ids'));
    }

    public function store(CategoryRequest $request)
    {
        try {
            $data_post = $request->all();
            $id = $data_post['category_id'] ?? 0;
            $data = $this->_processData($data_post);
            if (!$id) {
                PcmDmsCategory::create($data);
            } else {
                $category = PcmDmsCategory::findOrFail($id);
                $category->fill($data);
                $category->save();
            }
            $request->session()->flash('success', 'Category has been created.');
            return redirect()->route('admin.category.list');
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::info('---store category---');
            Log::error($e->getMessage());
            $request->session()->flash('error', "An error has occurred");
            return redirect()->route('admin.category.list');
        }
    }

    private function _processData($data_request)
    {
        $id = $data_request['category_id'] ?? 0;
        $data['name'] = $data_request['name'] ?? '';

        if ($id != $data_request['parent_id']) {
            $data['parent_id'] = $data_request['parent_id'] ?? 0;
        }
        if (!$id) {
            $maxSortNo = PcmDmsCategory::max('ordering');
            $data['ordering'] = $maxSortNo + 1;
        }
        $data['description'] = $data_request['description'] ?? '';
        $data['category_thumb'] = $data_request['category_thumb'] ?? '';
        $data['published'] = $data_request['published'] ?? PcmDmsCategory::PUBLISHED_ON;
        return $data;
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $category = PcmDmsCategory::find($id);
            PcmDmsCategory::where('parent_id', $id)->update(['parent_id' => $category->parent_id]);
            $category->delete();
            $request->session()->flash('success', 'Category has been deleted.');
            return [
                'success' => true,
                'redirectTo' => route("admin.category.list")
            ];
        } catch (\Exception $e) {
            Log::info('---Delete category---');
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function updateOrdering(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->ids;
            if ($ids) {
                foreach ($ids as $sortNo => $id) {
                    if ($id) {
                        PcmDmsCategory::where([
                            'id' => $id
                        ])->update(['ordering' => $sortNo]);
                    }
                }
            }
            DB::commit();
            $request->session()->flash('success', 'Category has been saved.');
            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("category updateSortNo:" . $e->getMessage());
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function removeImageEdit($slider, $new_image, $filed)
    {
        if ($slider[$filed] != $new_image) {
            ImageHelper::removeImage($slider[$filed], PcmDmsCategory::FOLDER_IMAGE);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $image_url_pc = $request->file('pc_image_dz');
            $file_image = null;
            if (!empty($image_url_pc)) {
                $file_image = $image_url_pc;
            } else {
                return response()->json([
                    'success' => false,
                    'file_name' => null
                ]);
            }
            $file_name = ImageHelper::saveImageStorage($file_image, PcmDmsCategory::FOLDER_IMAGE);

            return response()->json([
                'success' => true,
                'file_name' => $file_name
            ]);
        } catch (\Exception $e) {
            Log::info('---uploadImageCategory---');
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'errorMessage' => "An error has occurred"
            ]);
        }
    }

    public function removeImage(Request $request)
    {
        try {
            $post_data = $request->all();
            ImageHelper::removeImage($post_data['image'], PcmDmsCategory::FOLDER_IMAGE);
            return response()->json([
                'success' => true,
                'file_name' => $post_data['image']
            ]);
        } catch (\Exception $e) {
            Log::info('---removeImageCategory---');
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'errorMessage' => "An error has occurred"
            ]);
        }
    }

    public function getImageInfo(Request $request)
    {
        try {
            $post_data = $request->all();
            $folder = PcmDmsCategory::FOLDER_IMAGE;
            $image_info = ImageHelper::getImageInfo($post_data['image'], $folder);
            return response()->json([
                'success' => true,
                'imageInfo' => $image_info
            ]);
        } catch (\Exception $e) {
            Log::info('---removeImageAjaxError---');
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'errorMessage' => "An error has occurred"
            ]);
        }
    }
}
