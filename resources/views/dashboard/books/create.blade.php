@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Create Book')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf   
        <h4>Create Book</h4>

        <div class="col-12 col-lg-8">
            <!-- Book Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Book Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="book-title">Title</label>
                        <input type="text" class="form-control" id="book-title" placeholder="Book Title"
                            name="title" aria-label="Book Title"  value="{{ old('title') }}" required />
                        @error('title')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="book-description">Description</label>
                        <textarea class="form-control" id="book-description" placeholder="Book Description"
                            name="description" aria-label="Book Description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                  

                    <div class="mb-3">
                        <label class="form-label" for="author">Author</label>
                        <select class="form-control" id="author" name="author_id">
                            <option value="" selected disabled>Select Author</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="mb-3">
                        <label class="form-label" for="category">Category</label>
                        <select class="form-control" id="category" name="category_id">
                            <option value="" selected disabled>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="mb-3">
                        <label class="form-label" for="publishing_house">Publishing House</label>
                        <select class="form-control" id="publishing_house" name="publishing_house_id">
                            <option value="" selected disabled>Select Publishing House</option>
                            @foreach($publishingHouses as $publishingHouse)
                                <option value="{{ $publishingHouse->id }}">{{ $publishingHouse->name }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="mb-3">
                        <label class="form-label" for="price">Price</label>
                        <input type="text" class="form-control" id="price" placeholder="Price"
                            name="price" aria-label="Price"  value="{{ old('price') }}" required />
                        @error('price')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="sale_price">Sale Price</label>
                        <input type="text" class="form-control" id="sale_price" placeholder="Sale Price"
                            name="sale_price" aria-label="Sale Price"  value="{{ old('sale_price') }}" />
                        @error('sale_price')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="published_year">Published Year</label>
                        <input type="text" class="form-control" id="published_year" placeholder="Published Year"
                            name="published_year" aria-label="Published Year"  value="{{ old('published_year') }}" required />
                        @error('published_year')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="book-image">Image</label>
                        <input type="file" class="form-control" id="book-image" name="image" accept="image/*" aria-label="Book Image" onchange="previewImage(this)" />
                        @error('image')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                        <li class="list-inline-item">
                            <img id="previewImage" src="" height="200px" class="mt-2">
                        </li>
                    </div> 

                    <div class="mb-3">
                        <label class="form-label" for="book-file">Book File</label>
                        <input type="file" id="book-file" class="form-control" name="file" accept=".pdf,.docx,.epub" aria-label="Book File" />
                        @error('file')
                            <div style="color: red; font-weight: bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-plus me-1"></span>Add New Book
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
		$("#book-image").change(function() {
			previewImage(this);
		});
	</script>
@endsection
