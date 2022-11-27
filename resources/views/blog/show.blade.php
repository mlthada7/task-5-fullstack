@extends('recipes.layouts.boilerplate')

@section('content')

<div class="row justify-content-center my-3">
    <div class="col-lg-8">
        <div style="max-height: 350px; overflow:hidden" class="mb-3">
            <img src="{{ asset('storage/' . $recipe->image) }}" class="img-fluid" alt="">
        </div>
        <h2 class="mb-3 fw-bold">{{ $recipe->title }}</h2>
        <div class="mb-4">
            {{ $recipe->description }}
        </div>
        <div class="mb-4">
            <h4 class="fw-semibold">Bahan-bahan</h4>
            @foreach($ingredients as $ingredient)
            <span>{{ $ingredient->name }}</span><br>
            @endforeach
        </div>
        <div class="mb-4">
            <h4 class="fw-semibold">Langkah Pembuatan</h4>
            <ol>
                @foreach($methods as $method)
                <li>{{ $method->name }}</li>
                @endforeach
            </ol>
        </div>
    </div>
</div>

@endsection
