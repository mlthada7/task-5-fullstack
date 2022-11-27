@extends('recipes.layouts.boilerplate')

@section('content')

<div class="row">
    <h1>Tulis Resepmu ...</h1>
    <div class="col-lg-8">
        {{-- POST + /dashboard/posts(route::r) mengarah ke store di resource --}}
        <form action="{{ route('recipes.store') }}" method="POST" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" autofocus value="{{ old('title') }}">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea type="text" class="form-control @error('description')
                    is-invalid
                @enderror" id="description" name="description" value="{{ old('description') }}"></textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3" id="ingredientsField">
                <label for="ingredientName[]" class="form-label">Bahan-bahan</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('ingredientName[]')
                        is-invalid
                    @enderror" id="ingredientName[]" name="ingredientName[]" value="{{ old('ingredientName[]') }}" required>
                    @error('ingredientName[]')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <button class="btn btn-outline-secondary" type="button" id="removeIngredientFieldBtn">X</button>
                </div>
            </div>
            <div class="mb-4">
                <button type="button" class="btn btn-outline-secondary" id="addMoreIngredientFieldBtn">+ Item Bahan</button>
            </div>


            <div class="mb-3" id="methodsField">
                <label for="methodName[0]" class="form-label">Langkah Pembuatan</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('methodName[0]')
                        is-invalid
                    @enderror" id="methodName[0]" name="methodName[0]" value="{{ old('methodName[0]') }}" required>
                    @error('methodName[0]')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <button class="btn btn-outline-secondary" type="button" id="removeMethodFieldBtn">X</button>
                </div>
            </div>
            <div class="mb-4">
                <button type="button" class="btn btn-outline-secondary" id="addMoreMethodFieldBtn">+ Item Langkah</button>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload Foto Masakan</label>
                <input class="form-control @error('image')
                    is-invalid
                @enderror" type="file" name="image" id="image">
                @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- <div class="mb-3">
                <label for="methods" class="form-label">Langkah Pembuatan</label>
                <textarea type="text" class="form-control @error('methods')
                    is-invalid
                @enderror" id="methods" name="methods" value="{{ old('methods') }}"></textarea>
            @error('methods')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
    </div> --}}


    <button type="submit" class="btn btn-primary">Terbitkan Resep</button>
    </form>
</div>
</div>

<script type="text/javascript">
    // Event untuk tambah item
    let i = 0;
    $('#addMoreIngredientFieldBtn').click(function(e) {
        ++i;
        $('#ingredientsField').append('<div class="input-group mb-3"><input type="text" class="form-control @error(" ingredientName[' + i + ']") is-invalid @enderror" id="ingredientName[' + i + ']" name="ingredientName[' + i + ']" value="{{ old("ingredientName[' + i + ']") }}" required> @error("ingredientName[' + i + ']") <div class="invalid-feedback">{{ $message }}</div>@enderror <button class="btn btn-outline-secondary" type="button" id="removeFieldBtn">X</button></div>');
    });
    $(document).on('click', '#removeIngredientFieldBtn', function() {
        $(this).parent().remove();
    });

    // Event untuk tambah langkah pembuatan
    let j = 0;
    $('#addMoreMethodFieldBtn').click(function(e) {
        ++j;
        $('#methodsField').append('<div class="input-group mb-3"><input type="text" class="form-control @error(" methodName[' + j + ']") is-invalid @enderror" id="methodName[' + j + ']" name="methodName[' + j + ']" value="{{ old("methodName[' + j + ']") }}" required> @error("methodName[' + j + ']") <div class="invalid-feedback">{{ $message }}</div>@enderror <button class="btn btn-outline-secondary" type="button" id="removeMethodFieldBtn">X</button></div>');
    });
    $(document).on('click', '#removeMethodFieldBtn', function() {
        $(this).parent().remove();
    });

</script>

@endsection
