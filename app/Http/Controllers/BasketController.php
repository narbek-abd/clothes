<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
	public function basket()
	{
		$orderId = session('orderId');

		if( !is_null($orderId) ) {
			$order = Order::findOrFail($orderId);
		} else {
			return abort(404);
		}

		return view('basket', compact('order'));
	}

	public function basketPlace()
	{
		$orderId = session('orderId');

		if( is_null($orderId) ) {
			return redirect()->route('index');
		}
		$order = Order::find($orderId);

		return view('order', ['order' => $order]);
	}	

	public function basketConfirm(Request $request)
	{
		$orderId = session('orderId');

		if( is_null($orderId) ) {
			return redirect()->route('index');
		}
		$order = Order::find($orderId);
		$success = $order->saveOrder($request->name, $request->phone);

		if( $success ) {
			session()->flash('success', 'Ваш заказ принят в обработку!');
		} else {
			session()->flash('warning', 'Ошибка');
		}

		return redirect()->route('index');
	}

	public function basketAdd($productId)
	{
		$orderId = session('orderId');

		if( is_null($orderId) ) {
			$order = Order::create();
			session(['orderId' => $order->id]);
		} else {
			$order = Order::find($orderId);
		}

		if($order->products()->where('product_id', $productId)->first() ) {
			$pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
			$pivotRow->count++;
			$pivotRow->save();
		} else {
			$order->products()->attach($productId);
		}

		if (Auth::check()) {
			$order->user_id = Auth::id();
			$order->save();
		}

		$product = Product::find($productId);
		session()->flash('success', 'Добавлен товар ' . $product->name);

		return redirect()->route('basket');
	}	

	public function basketRemove($productId)
	{
		$orderId = session('orderId');

		if( is_null($orderId) ) {
			return redirect()->route('basket');
		}

		$order = Order::find($orderId);

		if($order->products()->where('product_id', $productId)->first()) {
			$pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
			if($pivotRow->count < 2) {
				$order->products()->detach($productId);
			} else {
				$pivotRow->count--;
				$pivotRow->save();
			}
		}

		$product = Product::find($productId);
		session()->flash('warning', 'Удален товар  ' . $product->name);

		return redirect()->route('basket');
	}
}
