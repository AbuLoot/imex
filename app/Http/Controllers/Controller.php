<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Page;
use App\Company;
use App\Category;
use App\Language;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    	$languages = Language::orderBy('sort_id')->get();

    	$pages = Page::where('status', 1)->orderBy('sort_id')->get();
        $companies = Company::where('status', 1)->orderBy('sort_id')->take(5)->get();
        $categories = Category::orderBy('sort_id')->get()->toTree();
        // $categories = Category::orderBy('sort_id')->get();

        view()->share([
            'pages' => $pages, 
            'companies' => $companies, 
            'categories' => $categories, 
            'languages' => $languages,
        ]);
    }
}
