<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Excel;
use Storage;

use App\Page;
use App\Option;
use App\Product;
use App\Company;
use App\Category;
use App\ImageTrait;

class PageController extends Controller
{
    use ImageTrait;

    public function index()
    {
        return view('pages.main');
    }

    public function import()
    {
        $brand_arr = [];

        Excel::load(public_path('files/data.xls'), function ($reader) use ($brand_arr) {

             foreach ($reader->toArray() as $row) {

                $image_name = mb_strtolower($row['barcode']).'.jpg';

                if (file_exists(public_path('files/photos/'.$image_name))) {

                    $image_org = Storage::get('files/photos/'.$image_name);
                    // $image_src = file_get_contents('files/photos/'.$image_name);

                    $company = Company::where('title', 'LIKE', '%'.$row['brand'].'%')->first();
                    $category = Category::where('title_description', 'LIKE', '%'.$row['category'].'%')->first();

                    $introImage = null;
                    $images = [];
                    $key = 0;

                    $dirName = $category->id.'/'.mb_strtolower($row['barcode']);

                    if ( ! file_exists('img/products/'.$dirName)) {
                        Storage::makeDirectory('img/products/'.$dirName);
                    }

                    $imageName = 'image-'.$key.uniqid().'-'.str_slug($row['title']).'.jpg';

                    // Creating preview image
                    if ($key == 0) {
                        $this->resizeImage($image_org, 180, 220, 'img/products/'.$dirName.'/preview-'.$imageName, 100);
                        $introImage = 'preview-'.$imageName;
                    }

                    // Creating present images
                    $this->resizeImage($image_org, 320, 490, 'img/products/'.$dirName.'/present-'.$imageName, 100);

                    // Storing original images
                    Storage::put('img/products/'.$dirName.'/'.$imageName, $image_org);

                    $images[$key]['image'] = $imageName;
                    $images[$key]['present_image'] = 'present-'.$imageName;

                    $product = new Product;
                    $product->sort_id = $product->count() + 1;
                    $product->category_id = $category->id;
                    $product->slug = str_slug($row['title']);
                    $product->title = $row['title'];
                    $product->company_id = ($company->id) ? $company->id : 0;
                    $product->barcode = $row['barcode'];
                    $product->price = $row['price'];
                    // $product->days = $request->days;
                    // $product->count = $request->count;
                    // $product->condition = $request->condition;
                    // $product->presense = $request->presense;
                    $product->meta_description = $row['title'];
                    $product->description = $row['description'];
                    $product->characteristic = $row['char'];
                    $product->image = $introImage;
                    $product->images = serialize($images);
                    $product->path = $dirName;
                    $product->lang = 'ru';
                    // $product->mode = $request->mode;
                    $product->status = 1;
                    $product->save();
                }
                else {
                    $brand_arr[$row['brand']][] = $row['brand'];
                }
             }

             print_r($brand_arr);
        });
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

        $products = Product::where('status', 1)->where('category_id', $category->id)->paginate(20);

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
