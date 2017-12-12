<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Validator;

use App\App;
use App\Product;

class InputController extends Controller
{
    public function search(Request $request)
    {
        $text = trim(strip_tags($request->text));

	    $products = Product::where('status', 1)
	        ->where(function($query) use ($text) {
	            return $query->where('barcode', 'LIKE', '%'.$text.'%')
	            ->orWhere('title', 'LIKE', '%'.$text.'%')
	            ->orWhere('oem', 'LIKE', '%'.$text.'%');
	        })->take(10)->get();

        return view('site.found', compact('text', 'products'));
    }

    public function searchAjax(Request $request)
    {
        $text = trim(strip_tags($request->text));

        $products = Product::where('status', 1)
            ->where(function($query) use ($text) {
                return $query->where('barcode', 'LIKE', '%'.$text.'%')
                    ->orWhere('title', 'LIKE', '%'.$text.'%')
                    ->orWhere('oem', 'LIKE', '%'.$text.'%');
            })->take(12)->get();

        return response()->json($products);
    }

    public function filterProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'options_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        $products = Product::where('status', 1)->whereIn('id', $request->options_id)->paginate(27);

        return response()->json(view('site.products', ['products' => $products])->render());
    }

    public function sendApp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:60',
            'phone' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $app = new App;
        $app->name = $request->name;
        $app->email = $request->email;
        $app->phone = $request->phone;
        $app->message = $request->site . '<br>' . $request->message;
        $app->save();

        $name = $request->name;

        try {

            Mail::send('emails.mail', ['data' => $request->all()], function($message) use ($name) {
                $message->to('imextrd17@gmail.com', 'IMEX TRD')->subject('IMEX TRD - Новая заявка от '.$name);
                $message->from('electron.servant@gmail.com', 'Electron Servant');
            });

            $status = 'alert-success';
            $message = 'Ваша заявка принято.';

        } catch (Exception $e) {
            
            $status = 'alert-danger';
            $message = 'Произошла ошибка: '.$e->getMessage();
        }

        return redirect()->back()->with([
            'alert' => $status,
            'message' => $message
        ]);
    }
}
