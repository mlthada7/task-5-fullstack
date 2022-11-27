@extends('recipes.layouts.boilerplate')

@section('content')

<h1 class="mb-4">Resep Terbaru</h1>

@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div id="message"></div>

@if($recipes->count())
<div class="row justify-center">
    @foreach($recipes as $recipe)
    <div class="col-10 col-md-6 col-lg-4 mb-3">
        <div class="card">
            {{-- <input type="hidden" name="recipeId" value="{{ $recipe->id }}" id="recipe-id"> --}}
            <img src="{{ asset('storage/' . $recipe->image) }}" class="img-fluid" alt="">
            <div class="card-body">
                <p class="likesCount">
                    <small class="text-muted">
                        {{ $recipe->likes->count() }} Orang Menyukai ini
                    </small>
                </p>
                <h5 class="card-title">{{ $recipe->title }}</h5>
                <p class="card-text">{{ $recipe->description }}</p>
                <button class="btn btn-secondary likeBtn" data-id="{{ $recipe->id }}">Suka</button>
                <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none btn btn-success">Lihat</a>

            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-center fs-4">No Recipe Found.</p>
@endif

<div class="d-flex justify-content-center">
    {{ $recipes->links() }}
</div>

<script>
    $(".likeBtn").click(function(e) {
        // recipeId dari attribute 'data-id'
        let recipeId = $(this).data('id');

        $.ajax({
            type: "get"
            , url: "{{ route('recipe.like') }}"
            , data: {
                recipe_id: recipeId
            }
            , dataType: "json"
            , success: function(response) {
                if (response.status == 'failed') {
                    $('#message').append(`<div class="alert alert-warning alert-dismissible fade show" role="alert">${response.message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
                    window.scroll({
                        top: 0
                        , behavior: "smooth"
                    });
                } else {
                    $('#message').append(`<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
                    window.scroll({
                        top: 0
                        , behavior: "smooth"
                    });
                    location.reload();
                }
            }
        });
    });

</script>

@endsection
