@extends('master')
@section('title', 'Продукт')

@section('content')
<h1>{{ $product->name }}</h1>
<h2>{{ $product->category->name }}</h2>
<p>Цена: <b>{{ $product->price }} $</b></p>
<img src="{{ Storage::url($product->image) }}">
<p>{{ $product->description }}</p>

<form action="sss" method="POST">
	<button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
	@csrf
</form>
	@stop
