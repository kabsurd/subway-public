@extends('orders.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SubWay - Orders</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('meals.index') }}">
                    Back</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Meal Status</th>
            <th>Date</th>
            <th width="350px">Action</th>
        </tr>
        @foreach ($orders as $order)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $order->meal->status }}</td>
                <td>{{ $order->created_at->format('d M Y - H:i') }}</td>
                <td>
                    <a class="btn btn-info"
                       href="{{ route('orders.show',$order->id) }}"
                       target="_blank">Show</a>

                </td>
            </tr>
        @endforeach
    </table>

    {!! $orders->links() !!}

@endsection
