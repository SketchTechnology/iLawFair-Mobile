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
                            <th>title</th>
                              <th>Author</th>
                             <th>Category</th>
                             <th>Publishing House</th>
                             <th>Sale Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($books as $book)
                            <tr>

                                <td>
                                    {{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author->name }}</td>
                                <td>{{ $book->category->name }}</td>
                                <td>{{ $book->publishingHouse->name }}</td>
                                <td>{{ $book->sale_price }}</td>
                               
                               

                               

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('books.edit', $book->id) }}">
                                                <i class="ti ti-pencil me-1"></i>
                                                Edit
                                            </a>

                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline" id="deleteForm{{ $book->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item" onclick="confirmDelete('{{ $book->id }}')">
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
                                                text: 'You want to delete this book!',
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
        {{ $books->links() }}

    </div>


@endsection
