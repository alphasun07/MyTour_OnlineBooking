<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PcmDmsCategory;
use App\Models\PcmDmsDocument;

class CategoryController extends Controller
{
    public function show($id) {
        $category = (new PcmDmsCategory())->getCategoryTitleByID($id);

        return view('front.dms.category.index', compact('category'));
    }
}
