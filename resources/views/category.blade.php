@extends('master')
@section('title', "$category->name")

@section('content')
		<h1>{{ $category->name }}</h1>
		<p>{{ $category->description }}</p>

		<div class="row">
			@foreach($category->products as $product)
				@include('card', ['product' => $product])
			@endforeach
		</div>
@stop