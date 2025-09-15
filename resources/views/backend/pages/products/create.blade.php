@extends('backend.layouts.app')

@section('title')
Add Product
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/bundles/jquery-selectric/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/bundles/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/bundles/summernote/summernote-bs4.css') }}">
<style>
    .cover-image-preview,
    #callback-preview {
        width: 400px;

    }
</style>
@endpush

@section('content')
<div class="card mt-3 mx-3">
    <div class="card-header">
        <h4>{{ __('Add Product') }}</h4>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-body">


            <div class="form-group row mb-5">
                <label class="col-form-label  col-12 col-md-4 col-lg-3">
                    {{ __('Category') }}
                </label>
                <div class="col-sm-12 col-md-8">
                    <select name="category_id" class="form-control">
                        <option value="" disabled selected>{{ __('Choose From List') }}</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-5">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-form-label col-12 col-md-4 col-lg-3">
                            {{ __('Product Name') }}
                        </label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                autocomplete="off">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>


            <div class="form-group row mb-5">
                <label class="col-form-label col-12 col-md-3 col-lg-3">{{ __('Product Description') }}</label>
                <div class="col-sm-12 col-md-9">
                    <textarea class="summernote @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"></textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-md-4">
                    <div class="form-check form-switch mt-4">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror" id="status" name="status" value="1">
                        <label class="form-check-label" for="status">{{ __('Status') }}</label>

                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check form-switch mt-4">
                        <input type="hidden" name="featured" value="0">
                        <input type="checkbox" class="form-check-input @error('featured') is-invalid @enderror" id="featured" name="featured" value="1">
                        <label class="form-check-label" for="featured">{{ __('Featured') }}</label>
                        @error('featured')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-check form-switch mt-4">
                        <label for="product_type" class="form-label">{{ __('Product Type') }}</label>
                        <select name="product_type" class="form-control @error('product_type') is-invalid @enderror">
                            <option value="normal">{{ __('Normal') }}</option>
                            <option value="best_seller">{{ __('Best Seller') }}</option>
                            <option value="new_arrival">{{ __('New Arrival') }}</option>
                            <option value="popular">{{ __('Popular') }}</option>
                            <option value="top_rated">{{ __('Top Rated') }}</option>
                        </select>
                        @error('product_type')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group row mb-3">
                <!-- stock -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stock" class="form-label">{{ __('Stock') }}</label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" value="{{ old('stock') }}">
                        @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- price -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price" class="form-label">{{ __('Price') }}</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}">
                        @error('price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- old_price -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="old_price" class="form-label">{{ __('Old Price') }}</label>
                        <input type="number" name="old_price" class="form-control @error('old_price') is-invalid @enderror" id="old_price" value="{{ old('old_price') }}">
                        @error('old_price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="row mb-2">
                <div class="form-group">
                    <label for="main_image" class="form-label">{{ __('Main Image') }}<span class="text-danger">*</span></label>
                    <input class="form-control @error('image') is-invalid @enderror" name="image" id="main_image" type="file" accept="image/*">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div id="main_image_preview" class="mt-2">
                        <!-- Preview will be inserted here -->
                    </div>

                </div>

                <div class="form-group">
                    <label for="images" class="form-label">{{ __('Images') }}<span class="text-danger">*</span></label>
                    <input class="form-control @error('gallery') is-invalid @enderror" name="gallery[]" id="images" type="file" accept="image/*"
                        multiple="multiple">
                    <div id="images_preview" class="mt-2 d-flex flex-wrap gap-2">
                        <!-- Previews will be inserted here -->
                    </div>

                </div>
            </div>



            <div class="form-group row mb-5">
                <div class="col-sm-12 col-md-12">
                    <button class="btn btn-primary" type="submit">{{ __('Add Product') }}</button>
                </div>
            </div>


        </div>
    </form>

</div>
@endsection

@push('scripts')
<script src="{{ asset('backend/assets/bundles/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('backend/assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('backend/assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('backend/assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $('#main_image').on('change', function(e) {
            previewMainImage(e);
        });

        function previewMainImage(event) {
            const input = event.target;
            const previewContainer = $('#main_image_preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.html(`<img src="${e.target.result}" alt="Main Image Preview" style="max-height: 150px;">`);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.html('');
            }
        }

        $('#images').on('change', function(e) {
            previewImages(e);
        });

        function previewImages(event) {
            const input = event.target;
            const previewContainer = $('#images_preview');
            previewContainer.html(''); // Clear previous previews

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = `<img src="${e.target.result}" alt="Image Preview" style="max-height: 100px; border-radius: 5px;">`;
                        previewContainer.append(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }


        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush