@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Author')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <form action="{{ route('authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h4>Edit Author</h4>

        <div class="col-12 col-lg-8">
            <!-- Author Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Author Information</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="author-name">Name</label>
                        <input type="text" class="form-control" id="author-name" placeholder="Author Name"
                            name="name" aria-label="Author Name" value="{{ $author->name }}" required />
                        @error('name')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="author-image">Image</label>
                        <input type="file" id="author-image"  class="form-control"  name="image" accept="image/*" aria-label="Author Image" />
                        @error('image')
                            <div style="color: red; font-weight: bold"> {{ $message }}</div>
                        @enderror
                    </div>

                    @if ($author->image)
                        <li class="list-inline-item">
                            <img id="previewImage" src="{{ asset('uploads/' . $author->image) }}" height="200px">
                        </li>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <span class="ti-xs ti ti-check me-1"></span>Update Author
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
                }a
                reader.readAsDataURL(input.files[0]);
            }
        }
    
        // Event listener to trigger the image preview when a file is selected
        $("#author-image").change(function() {
            previewImage(this);
        });
    </script>
@endsection
