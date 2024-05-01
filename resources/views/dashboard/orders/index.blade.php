@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'orders')


@section('content')

    <h4>orders</h4>
    <div class="card">
        <h5 class="card-header">orders Table</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover">

                    <thead class="table-dark">
                        <tr>

                            <th>Customer name</th>
                            <th>Order-ID</th>
                            <th>book Name</th>
                            <th>Publisher Name</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orders as $order)
                            <tr>

                                <td>
                                {{ $order->user->name }}
                                </td>
                                <td>{{$order->id }}</td>
                                <td>
                               
                                <ul>
        @foreach ($order->orderItems as $orderItems)
            <li>{{ $orderItems->book->title }}</li>
        @endforeach
    </ul>
                                </td>
                                <td>
    <ul>
        @foreach ($order->orderItems as $orderItem) <!-- Correct variable name -->
        <li>{{ $orderItem->book->publishingHouse->name }}</li>
        @endforeach
    </ul>
</td>
                                <td>
                                    {{ $order->total_price }}
                                </td>
                            

                               
                    

                                <td>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                           
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline" id="deleteForm{{ $order->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item" onclick="confirmDelete('{{ $order->id }}')">
                                                    <i class="ti ti-trash me-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                
                                    <!-- SweetAlert script -->
                                    <script>
                                        function confirmDelete(orderId) {
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
                                                    document.getElementById('deleteForm' + orderId).submit();
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
      

    </div>


@endsection
