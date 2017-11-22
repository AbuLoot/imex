<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Product;
use App\Country;
use App\Order;

class BasketController extends Controller
{
    public function clearBasket()
    {
        Session::forget('items');

        return redirect('/');
    }

    public function addToBasket(Request $request, $id)
    {
        if (Session::has('items')) {

            $items = Session::get('items');

            $items['products_id'][$id] = $id;

            $count = count($items['products_id']);

            Session::set('items', $items);

            return response()->json(['alert' => 'Товар обновлен', 'countItems' => $count]);
        }

        $items = [];
        $items['products_id'][$id] = $id;

        Session::set('items', $items);

        return response()->json(['alert' => 'Товар добавлен', 'countItems' => 1]);
    }

    public function basket()
    {
        $countries = Country::all();

        if (Session::has('items')) {

            $items = Session::get('items');
            $products = Product::whereIn('id', $items['products_id'])->get();
        }
        else {
            $products = collect();
        }

        return view('site.basket', compact('products', 'countries'));
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

    public function storeOrder(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|min:5',
            'city_id' => 'numeric',
            'address' => 'required',
        ]);

        $items = Session::get('items');
        $products = Product::whereIn('id', $items['products_id'])->get();

        $sumCountProducts = 0;
        $sumPriceProducts = 0;

        foreach ($products as $product) {
            $sumCountProducts += $request->count[$product->id];
            $sumPriceProducts += $request->count[$product->id] * $product->price;
        }

        $order = new Order;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->company_name = '';
        $order->data_1 = '';
        $order->data_2 = '';
        $order->data_3 = '';
        $order->legal_address = '';
        $order->address = $request->address;
        $order->city_id = ($request->city_id) ? $request->city_id : 0;
        $order->delivery = trans('orders.get.'.$request->get);
        $order->payment_type = trans('orders.pay.'.$request->pay);
        $order->count = serialize($request->count);
        $order->price = $products->sum('price');
        $order->amount = $sumPriceProducts;
        $order->save();

        $order->products()->attach($items['products_id']);

        Session::forget('items');

        return redirect('/')->with('status', 'Заказ принят!');
    }

    public function destroy($id)
    {
        $items = Session::get('items');

        unset($items['products_id'][$id]);

        Session::set('items', $items);

        return redirect('basket');
    }
}