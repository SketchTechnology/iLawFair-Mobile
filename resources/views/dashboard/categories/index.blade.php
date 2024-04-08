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
                            <th>Parent</th>
                            <th>Description</th>
                            <th>created at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                            <tr>

                                <td>
                                    {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    {{ $category->parent->name ?? "Main" }}
                                </td>

                                <td>
                                    {{ substr($category->description, 0, 20) }}....

                                </td>
                    

                                <td>
                                    {{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d') }}
                                </td>



                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                                <i class="ti ti-pencil me-1"></i>
                                                Edit
                                            </a>
                                
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" id="deleteForm{{ $category->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item" onclick="confirmDelete('{{ $category->id }}')">
                                                    <i class="ti ti-trash me-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                
                                    <!-- SweetAlert script -->
                                    <script>
                                        function confirmDelete(categoryId) {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: 'You want to delete this category!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('deleteForm' + categoryId).submit();
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
        {{ $categories->links() }}

    </div>


@endsection
