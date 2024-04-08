@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Book')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

{{$errors}}

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h4>Edit Book</h4>

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
                            name="title" aria-label="Book Title" value="{{ $book->title }}" required />
                        @error('title')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="book-description">Description</label>
                        <textarea class="form-control" id="book-description" placeholder="Book Description"
                            name="description" aria-label="Book Description" required>{{ $book->description }}</textarea>
                        @error('description')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                  

                    <div class="mb-3">
                        <label class="form-label" for="book-price">Price</label>
                        <input type="number" step="0.01" class="form-control" id="book-price" placeholder="Book Price"
                            name="price" aria-label="Book Price" value="{{ $book->price }}" required />
                        @error('price')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="book-sale-price">Sale Price</label>
                        <input type="number" step="0.01" class="form-control" id="book-sale-price" placeholder="Book Sale Price"
                            name="sale_price" aria-label="Book Sale Price" value="{{ $book->sale_price }}" />
                        @error('sale_price')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="book-publishing-house">Publishing House</label>
                        <select class="form-control" id="book-publishing-house" name="publishing_house_id">
                            <option value="" selected disabled>Select Publishing House</option>
                            @foreach($publishingHouses as $publishingHouse)
                                <option value="{{ $publishingHouse->id }}" {{ $book->publishing_house_id == $publishingHouse->id ? 'selected' : '' }}>{{ $publishingHouse->name }}</option>
                            @endforeach
                        </select>
                        @error('publishing_house_id')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="book-author">Author</label>
                        <select class="form-control" id="book-author" name="author_id">
                            <option value="" selected disabled>Select Author</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                            @endforeach
                        </select>
                        @error('author_id')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="book-category">Category</label>
                        <select class="form-control" id="book-category" name="category_id">
                            <option value="" selected disabled>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="book-published-year">Published Year</label>
                        <input type="number" class="form-control" id="book-published-year" placeholder="Published Year"
                            name="published_year" aria-label="Published Year" value="{{ $book->published_year }}" required />
                        @error('published_year')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="book-image">Image</label>
                        <input type="file" id="book-image" class="form-control" name="image" accept="image/*" aria-label="Book Image" onchange="previewImage(this)" />
                        @error('image')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    @if ($book->image)
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <img id="previewImage" src="{{ asset('uploads/' . $book->image) }}" height="200px">
                        </div>
                    @endif


                    <div class="mb-3">
                        <label class="form-label" for="book-file">Book File</label>
                        <input type="file" id="book-file" class="form-control" name="file" accept=".pdf,.docx,.epub" aria-label="Book File" />
                        @error('file')
                            <div style="color: red; font-weight: bold">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($book->file_path)
    <div class="mb-3">
        <label class="form-label">Current Book File</label>
        <a href="{{ asset('uploads/' . $book->file_path) }}" target="_blank">Download Book</a>
    </div>
@endif
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-check me-1"></span>Update Book
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
