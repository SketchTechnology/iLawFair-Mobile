@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Category')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h4>Edit Category</h4>

        <div class="col-12 col-lg-8">
            <!-- Category Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Category Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="category-name">Name</label>
                        <input type="text" class="form-control" id="category-name" placeholder="Category Name"
                            name="name" aria-label="Category Name" value="{{ $category->name }}" required />
                        @error('name')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="category-description">Description</label>
                        <textarea class="form-control" id="category-description" placeholder="Category Description"
                            name="description" aria-label="Category Description" required>{{ $category->description }}</textarea>
                        @error('description')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category-parent">Parent Category</label>
                        <select class="form-control" id="category-parent" name="parent_id">
                            <option value="" selected disabled>Select Parent Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category-image">Image</label>
                        <input type="file" id="exampleInputFile"  class="form-control"  name="image" accept="image/*" aria-label="Category Image" />
                        @error('image')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    @if ($category->image)
				<li class="list-inline-item">
					<img id="previewImage" src="{{ asset('uploads/' . $category->image) }}" height="200px">
				</li>
			@endif
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-check me-1"></span>Update Category
                </button>
            </div>

        </div>
    </form>

    <script>
        // Function to preview the uploaded image
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    
        // Event listener to trigger the image preview when a file is selected
        $("#exampleInputFile").change(function() {
            previewImage(this);
        });
    </script>
@endsection
