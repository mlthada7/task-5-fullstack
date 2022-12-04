@extends('blog.layouts.boilerplate')

@section('content')

<div class="row justify-content-center my-3">
    <div class="col-10 col-md-6 col-lg-4">
        @if(session()->has('status'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div style="max-height: 350px; overflow:hidden" class="mb-3">
            <img src="{{ asset('storage/'.$post->image) }}" class="img-fluid" alt="">
        </div>
        <h2 class="mb-3 fw-bold">{{ $post->title }}</h2>
        <div class="mb-4">
            {{ $post->content }}
        </div>
        @if($post->user->id === auth()->user()->id)
        <div class="mb-2">
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">Edit</a>
            <form action="{{ route('posts.destroy', $post->id) }}}}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
        @endif
        <a href="{{ route('posts.index') }}" class="text-decoration-none d-block mt-3">Back to Posts</a>
    </div>
</div>

@endsection
