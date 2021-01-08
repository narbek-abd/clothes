<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class MainController extends Controller
{
	public function index(Request $request)
	{
		$produts = Product::all();
		return view('index', ['produsts' => $produts]);
	}

	public function categories()
	{
		$categories = Category::all();
		return view('categories', ['categories' => $categories]);
	}

	public function category($cat_slug)
	{
		$category = Category::where('code', $cat_slug)->first();

		

		if($category === null) {
			return abort(404);
		}

		return view('category', ['category' => $category]);
	}


	public function product($product_code)
	{
		$product = Product::where('code', $product_code)->first();
		return view('product', ['product' => $product]);
	}

}
