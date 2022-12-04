@extends('blog.layouts.boilerplate')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <h1 class="mb-4 text-center">Edit Category</h1>
        <div class="col-10 col-md-6 col-lg-4 mb-3">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mb-5">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name', $category->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
