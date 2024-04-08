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
                            <th></th>
                             <th>created at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($authors as $author)
                            <tr>

                                <td>
                                    {{ ($authors->currentPage() - 1) * $authors->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $author->name }}</td>
                                <td>
                                    <a class="btn btn-primary d-flex align-items-center me-3" href="{{ route('authors.books', $author->id) }}">View Books</a>
                                </td>

                               

                                <td>
                                    {{ \Carbon\Carbon::parse($author->created_at)->format('Y-m-d') }}
                                </td>



                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('authors.edit', $author->id) }}">
                                                <i class="ti ti-pencil me-1"></i>
                                                Edit
                                            </a>

                                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="d-inline" id="deleteForm{{ $author->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item" onclick="confirmDelete('{{ $author->id }}')">
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
                                                text: 'You want to delete this author!',
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
        {{ $authors->links() }}

    </div>


@endsection
