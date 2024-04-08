@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Create Category')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf   
        <h4>Create Category</h4>

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
                            name="name" aria-label="Category Name"  value="{{ old('name') }}" required />
                        @error('name')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="category-description">Description</label>
                        <textarea class="form-control" id="category-description" placeholder="Category Description"
                            name="description" aria-label="Category Description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category-parent">Parent Category</label>
                        <select class="form-control" id="category-parent" name="parent_id">
                            <option value="" selected disabled>Select Parent Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category-image">Image</label>
                        <input type="file" class="form-control" id="exampleInputFile" name="image" accept="image/*" aria-label="Category Image" onchange="previewImage(this)" />
                        @error('image')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                        <li class="list-inline-item">
                            <img id="previewImage" src="" height="200px" class="mt-2">
                        </li>
                    </div> 
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-plus me-1"></span>Add New Category
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
