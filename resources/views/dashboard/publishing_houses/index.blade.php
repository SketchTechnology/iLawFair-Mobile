@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Users')


@section('content')

    <h4>Users</h4>
    <div class="card">
        <h5 class="card-header">Users Table</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover">

                    <thead class="table-dark">
                        <tr>

                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($publishingHouses as $publishingHouse)
                            <tr>

                                <td>
                                    {{ ($publishingHouses->currentPage() - 1) * $publishingHouses->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $publishingHouse->name }}</td>
                                <td>{{ $publishingHouse->email }}</td>
                                <td>{{ $publishingHouse->address }}</td>
                                <td>{{ $publishingHouse->phone }}</td>

                                <td>
                                    <a class="btn btn-primary d-flex align-items-center me-3" href="{{ route('publishing-houses.books', $publishingHouse->id) }}">View Books</a>
                                </td>






                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('publishing-houses.edit', $publishingHouse->id) }}">
                                                <i class="ti ti-pencil me-1"></i>
                                                Edit
                                            </a>

                                            <form action="{{ route('publishing-houses.destroy', $publishingHouse->id) }}"
                                                method="POST" class="d-inline" id="deleteForm{{ $publishingHouse->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item"
                                                    onclick="confirmDelete('{{ $publishingHouse->id }}')">
                                                    <i class="ti ti-trash me-1"></i>
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                    <!-- SweetAlert script -->
                                    <script>
                                        function confirmDelete(authorId) {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: 'You want to delete this publishingHouse!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('deleteForm' + authorId).submit();
                                                }
                                            });
                                        }
                                    </script>

                                </td>
                            </tr>
                        @endforeach




                    </tbody>

                </table>

            </div>

        </div>
        {{ $publishingHouses->links() }}

    </div>


@endsection
