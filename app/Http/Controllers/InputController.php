<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'name' => 'required|min:3|max:60',
            'phone' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return redirect('/#contact-form')->withErrors($validator)->withInput();
        }

        $app = new App;
        $app->name = $request->name;
        $app->email = $request->email;
        $app->phone = $request->phone;
        $app->message = $request->message;
        $app->save();

        // Email subject.
        $subject = "Japan Import - novaya zayavka ot $request->name";

        // Email content.
        $content = "<h2>Japan Import</h2>";
        $content .= "<b>Имя: $request->name</b><br>";
        $content .= "<b>Номер: $request->phone</b><br>";
        $content .= "<b>Email: $request->email</b><br>";
        $content .= "<b>Текст: $request->message</b><br>";
        $content .= "<b>Дата: " . date('Y-m-d') . "</b><br>";
        $content .= "<b>Время: " . date('G:i') . "</b>";

        $headers = "From: info@jpi.kz \r\n" .
                   "MIME-Version: 1.0" . "\r\n" . 
                   "Content-type: text/html; charset=UTF-8" . "\r\n";

        // Send the email.
        if (mail('issayev.adilet@gmail.com', $subject, $content, $headers)) {
            $status = 'alert-success';
            $message = 'Ваша заявка принято.';
        }
        else {
            $status = 'alert-danger';
            $message = 'Произошла ошибка.';
        }

        return redirect()->back()->with([
            'alert' => $status,
            'message' => $message
        ]);
    }
}
