@extends('meals.layout')

@section('content')
    <div class="overview">
        <div class="row">
            <div class="margin-tb">
                <div class="pull-left">
                    <h2>Order overview</h2>
                    <h4>{{ $meal->created_at->format('d M Y - H:i') }}</h4>
                </div>
            </div>
        </div>

        @foreach ($meal->orders as $order)
            <hr>
            <h3>Ordered by: {{$order->user->name}}</h3>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Bread:</strong>
                        {{ Bread::where( 'key', $order->bread )->first()->value }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Length:</strong>
                        {{ BreadLength::where( 'key', $order->length )->first()->value }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Oven baked:</strong>
                        {{ $order->oven_baked === 1 ? "Yes" : "No"  }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Extra bacon:</strong>
                        {{ $order->extra_bacon === 1 ? "Yes" : "No"  }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Double meat:</strong>
                        {{ $order->double_meat === 1 ? "Yes" : "No" }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Extra cheese:</strong>
                        {{ $order->extra_cheese === 1 ? "Yes" : "No"  }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Flavour:</strong>
                        {{ Flavour::where( 'key', $order->taste )->first()->value }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Sauce:</strong>
                        {{ Sauce::where( 'key', $order->sauce )->first()->value }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Vegetables:</strong>
                        <span>{{ $order->vegetables->lettuce === 1 ? 'Lettuce' : '' }}</span>
                        <span>{{ $order->vegetables->onion === 1 ? 'Onion' : '' }}</span>
                        <span>{{ $order->vegetables->paprika === 1 ? 'Paprika' : '' }}</span>
                        <span>{{ $order->vegetables->tomato === 1 ? 'Tomato' : '' }}</span>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection
