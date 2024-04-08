@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts.layoutMaster')

@section('title', 'Edit Publishing House')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<form action="{{ route('publishing-houses.update', $publishingHouse->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <h4>Edit Publishing House</h4>

    <div class="col-12 col-lg-8">
        <!-- Publishing House Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-tile mb-0">Publishing House Information</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="publishing-house-name">Name</label>
                    <input type="text" class="form-control" id="publishing-house-name" placeholder="Publishing House Name"
                        name="name" aria-label="Publishing House Name" value="{{ $publishingHouse->name }}" required />
                    @error('name')
                        <div style="color: red; font-weight: bold"> {{ $message }}</div>
                    @enderror
                </div>

             

                <div class="mb-3">
                    <label class="form-label" for="publishing-house-address">Address</label>
                    <input type="text" class="form-control" id="publishing-house-address" placeholder="Publishing House Address"
                        name="address" aria-label="Publishing House Address" value="{{ $publishingHouse->address }}" />
                    @error('address')
                        <div style="color: red; font-weight: bold"> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="publishing-house-email">Email</label>
                    <input type="email" class="form-control" id="publishing-house-email" placeholder="Publishing House Email"
                        name="email" aria-label="Publishing House Email" value="{{ $publishingHouse->email }}" />
                    @error('email')
                        <div style="color: red; font-weight: bold"> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="publishing-house-phone">Phone</label>
                    <input type="text" class="form-control" id="publishing-house-phone" placeholder="Publishing House Phone"
                        name="phone" aria-label="Publishing House Phone" value="{{ $publishingHouse->phone }}" />
                    @error('phone')
                        <div style="color: red; font-weight: bold"> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="publishing-house-image">Image</label>
                    <input type="file" id="publishing-house-image" class="form-control" name="image" accept="image/*" aria-label="Publishing House Image" onchange="previewImage(this)" />
                    @error('image')
                        <div style="color: red; font-weight: bold"> {{ $message }}</div>
                    @enderror
                </div>

                @if ($publishingHouse->image)
                    <li class="list-inline-item">
                        <img id="previewImage" src="{{ asset('uploads/' . $publishingHouse->image) }}" height="200px">
                    </li>
                @endif
            </div>
            <button type="submit" class="btn btn-primary mb-2">
                <span class="ti-xs ti ti-check me-1"></span>Update Publishing House
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
    $("#publishing-house-image").change(function() {
        previewImage(this);
    });
</script>
@endsection
