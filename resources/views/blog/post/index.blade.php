@extends('blog.layouts.boilerplate')

@section('content')

<div class="container">
    <h1 class="mb-4">Latest Post</h1>
    <div class="mb-5">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($posts->count())
    <div class="row justify-center">
        @foreach($posts as $post)
        <div class="col-10 col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="position-absolute px-3 py-2 text-white" style="background-color: rgba(0, 0, 0, 0.7)">
                    <a href="/posts?category={{ $post->category->id }}" class="text-white text-decoration-none">{{ $post->category->name }}</a>
                </div>
                @if($post->image)
                <img src="{{ asset('storage/'.$post->image) }}" class="img-fluid" alt="">
                @else
                <img src="https://source.unsplash.com/1200x400?{{ $post->name }}" class="card-img-top" alt="{{ $post->name }}">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p>
                        <small class="text-muted">
                            By. <a href="/posts?author={{ $post->user->name }}" class="text-decoration-none">{{ $post->user->name }}</a> {{ $post->created_at->diffForHumans() }}
                        </small>
                    </p>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none btn btn-outline-primary">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center fs-4">No Post Found.</p>
    @endif

    <div class="text-center">
        {{ $posts->links() }}
    </div>
</div>


@endsection
