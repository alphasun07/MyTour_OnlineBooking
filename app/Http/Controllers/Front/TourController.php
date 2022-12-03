<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function show($id)
    {
        $tour = (new Tour())->getById($id)->first();
        return view('front.post.detail', compact('tour'));
    }
}
