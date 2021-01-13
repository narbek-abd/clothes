<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
	public function index(ProductsFilterRequest $request)
	{
		$products = Product::query();

		if (isset ($request->price_from) ) {
			$products->where('price', '>=', $request->price_from);
		} 

		if (isset ($request->price_to) ) {
			$products->where('price', '<=', $request->price_to);
		} 

		foreach (['new', 'hit', 'recommend'] as $field) {
			if (isset ($request->$field) ) {
				$products->where($field, '=', 1);
			} 
		}

		$products = $products->paginate(3)->withPath("?" . $request->getQueryString());
		return view('index', ['products' => $products]);
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
