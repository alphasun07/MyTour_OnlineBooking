<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Place;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function show($id)
    {
        $tour = (new Tour())->getById($id)->first();
        $placeIds = explode(',', $tour->places);
        $places = (new Place())->whereIn('id', $placeIds)->get();

        return view('front.post.detail', compact('tour', 'places'));
    }

    public function book(Request $request, $id)
    {
        $tour = (new Tour())->getById($id)->first();
        $placeIds = explode(',', $tour->places);
        $places = (new Place())->whereIn('id', $placeIds)->get();

        return view('front.post.booking', compact('tour', 'places'));
    }

    public function checkoutShow(Request $request, $id)
    {
        $dataGet = $request->all();
        $tour = (new Tour())->getById($id)->first();

        return view('front.post.checkout', compact('tour', 'dataGet'));
    }

    public function checkout(Request $request)
    {
        try {
            $dataPost = $request->all();
            $tour = (new Tour())->getById($request->tour_id)->first();
            $userId = 1;
            $dataPost['tour_id'] = $tour->id;
            $dataPost['user_id'] = $userId;

            $order = Order::create($dataPost);

            return redirect('https://squareup.com/us/en/online-checkout');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back();
        }
    }
}
