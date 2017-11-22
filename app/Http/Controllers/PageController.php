<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Page;
use App\Option;
use App\Product;
use App\Company;
use App\Category;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.main');
    }

    public function brands()
    {
        $companies = Company::all();
        $page = Page::where('slug', 'brands')->firstOrFail();

        return view('pages.brands')->with(['page' => $page, 'companies' => $companies]);
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.page')->with('page', $page);
    }

    public function categoryProducts(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        $products = Product::where('status', 1)->where('category_id', $category->id)->paginate(27);


        return view('pages.catalog')->with([
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function brandProducts($company_slug)
    {
        $page = Page::where('slug', 'catalog')->firstOrFail();
        $company = Company::where('slug', $company_slug)->first();

        return view('pages.catalog')->with(['page' => $page, 'products_title' => $page->title, 'products' => $company->products]);
    }

    public function product($product_id, $product_slug)
    {
        $product = Product::where('id', $product_id)->firstOrFail();
        $category = Category::where('id', $product->category_id)->firstOrFail();

        return view('pages.product')->with(['product' => $product]);
    }

    public function contacts()
    {
        $page = Page::where('slug', 'kontakty')->firstOrFail();

        return view('pages.contacts')->with('page', $page);
    }
}
