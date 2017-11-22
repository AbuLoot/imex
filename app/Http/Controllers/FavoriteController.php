<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Product;
use App\Country;
use App\Order;

class FavoriteController extends Controller
{
    public function clearFavorites()
    {
        Session::forget('items');

        return redirect('/');
    }

    public function toggleFavorite(Request $request, $id)
    {
        if (Session::has('favorites')) {

            $favorites = Session::get('favorites');

			if (in_array($id, $favorites['products_id'])) {
				$css_class = '';
				unset($favorites['products_id'][$id]);
			}
			else {
				$css_class = 'text-success';
            	$favorites['products_id'][$id] = $id;
			}

            $count = count($favorites['products_id']);

            Session::set('favorites', $favorites);

            return response()->json(['id' => $id, 'cssClass' => $css_class, 'countFavorites' => $count]);
        }

        $favorites = [];
        $favorites['products_id'][$id] = $id;

        Session::set('favorites', $favorites);

        return response()->json(['id' => $id, 'cssClass' => 'text-success', 'countFavorites' => 1]);
    }

    public function favorites()
    {
        if (Session::has('items')) {

            $items = Session::get('items');
            $products = Product::whereIn('id', $items['products_id'])->get();
        }
        else {
            $products = collect();
        }

        return view('site.favorites', compact('products'));
    }

    public function order()
    {
        $countries = Country::all();

        if (Session::has('items')) {

            $items = Session::get('items');
            $products = Product::whereIn('id', $items['products_id'])->get();

        }

        return view('site.order', compact('products', 'countries'));
    }

    public function destroy($id)
    {
        $items = Session::get('items');

        unset($items['products_id'][$id]);

        Session::set('items', $items);

        return redirect('favorites');
    }
}