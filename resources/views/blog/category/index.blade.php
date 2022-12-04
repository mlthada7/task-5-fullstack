@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="mb-4">Latest Categories</h1>
    <div class="mb-5">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session()->has('status'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($categories->count())
    <div class="row justify-center">
        @foreach($categories as $category)
        <div class="col-10 col-md-6 col-lg-4 mb-3">
            <div class="card card-categories shadow-sm">
                {{-- <a href="/products?category={{ $category->id }}" class="text-decoration-none text-dark"> --}}
                <div class="card-body pb-3">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    @if(auth()->user()->id === $category->user->id)
                    <div class="mb-2">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                    @endif
                    {{-- {!! $category->description !!} --}}
                    {{-- <span class="float-end text-decoration-line-through">{{ $category->original_price }}</span> --}}
                </div>
                {{-- </a> --}}
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center fs-4">No Category Found.</p>
    @endif

    <div class="d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>

@endsection
