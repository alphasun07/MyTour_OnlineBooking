<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\PcmDmsCategory;
use App\Models\Place;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    public function index(Request $request)
    {
        try {
            $searchData = $request->except('page');
            $tours = (new Tour())->getAll($searchData)->paginate(config('const.page.limit'));

            return view('admin.tours.index', compact('tours', 'searchData'));
        } catch (\Exception $e) {
            Log::error('group. message: ' . $e->getMessage());
            abort(500);
        }
    }

    public function detail($id = 0)
    {
        $tour = !empty($id) ? Tour::find($id) : null;
        $places = (new Place())->getAll()->get();
        $categories = (new PcmDmsCategory())->getListCategory()->get();

        if (!empty($id) && is_null($tour)) {
            return redirect()->route('admin.tour.list');
        }
        return view('admin.tours.detail', compact('tour', 'places', 'categories'));
    }

    public function removeImageEdit($slider, $new_image, $filed)
    {
        if ($slider[$filed] != $new_image) {
            ImageHelper::removeImage($slider[$filed], Tour::FOLDER_IMAGE);
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
            $file_name = ImageHelper::saveImageStorage($file_image, Tour::FOLDER_IMAGE);

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
            ImageHelper::removeImage($post_data['image'], Tour::FOLDER_IMAGE);
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
            $folder = Tour::FOLDER_IMAGE;
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
