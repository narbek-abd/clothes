@extends('master')
@section('title', 'Категории')

@section('content')
            @foreach ($categories as $category)
            <div class="panel">
                <a href="/category/{{ $category->code }}">
                    <img src="{{ Storage::url($category->image) }}">
                    <h2>{{ $category->name }}</h2>
                </a>
                <p>
                 {{ $category->description }}
             </p>
         </div>
         @endforeach
@stop