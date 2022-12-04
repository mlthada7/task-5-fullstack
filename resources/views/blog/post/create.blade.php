@extends('blog.layouts.boilerplate')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <h1 class="mb-4 text-center">Create New Post</h1>
        <div class="col-10 col-md-6 col-lg-4 mb-3">
            <form action="{{ route('posts.store') }}" method="POST" class="mb-5" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" autofocus value="{{ old('title') }}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <input type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" autofocus value="{{ old('content') }}">
                    @error('content')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control @error('image')
                        is-invalid
                    @enderror" type="file" name="image" id="image">
                    @error('image')
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
