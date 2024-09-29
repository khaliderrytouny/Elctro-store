@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-8">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Client</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Delivered</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->qty }}</td>
                            <td>{{ $order->price }} DH</td>
                            <td>{{ $order->total }} DH</td>
                            <td>
                                @if($order->paid)
                                    <i class="fas fa-check text-success"></i>
                                @else
                                    <i class="fas fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if($order->delivered)
                                    <i class="fas fa-check text-success"></i>
                                @else
                                    <i class="fas fa-times text-danger"></i>
                                @endif
                            </td>
                            <td class="d-flex flex-row justify-content-center align-items-center">
                                <form method="POST" action="{{ route("orders.update", $order->id) }}">
                                    @csrf
                                    @method("PUT")
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form id="delete-form-{{ $order->id }}" method="POST" action="{{ route("orders.destroy", $order->id) }}">
                                    @csrf
                                    @method("DELETE")
                                    <button
                                        onclick="event.preventDefault();
                                            if(confirm('Do you really want to delete the order {{ $order->id }} ?'))
                                                document.getElementById('delete-form-{{ $order->id }}').submit();"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
