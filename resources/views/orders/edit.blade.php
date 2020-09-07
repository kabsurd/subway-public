@extends('orders.layout')

@section('content')
    <script>
        $(document).ready(function () {
            var veggies = {
                'tomato': {{$order->vegetables->tomato}},
                'lettuce':  {{$order->vegetables->lettuce}},
                'onion':  {{$order->vegetables->onion}},
                'paprika':  {{$order->vegetables->paprika}}
            };

            var activeVeggies = [];

            $.each(veggies, function (index, value) {
                if (value === 1) {
                    activeVeggies.push(index);
                }
            });

            $('#vegetable').val(activeVeggies).trigger('change');
        });
    </script>


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit order</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('orders.index') }}">
                    Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your
            input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update',$order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="bread"
                   class="col-xs-12 col-sm-12 col-md-12">Bread
                type</label>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <select id="bread" name="bread" required="required"
                        class="form-control" value="{{$order->bread}}">
                    @foreach (Bread::all() as $breadType)
                        <option value="{{$breadType->key}}">{{$breadType->value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="length"
                   class="col-xs-12 col-sm-12 col-md-12">Bread
                length</label>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <select id="length" name="length"
                        class="form-control"
                        required="required" value="{{$order->length}}">
                    @foreach (BreadLength::all() as $breadLength)
                        <option value="{{$breadLength->key}}">{{$breadLength->value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="taste"
                   class="col-xs-12 col-sm-12 col-md-12">Flavour</label>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <select id="taste" name="taste" class="form-control"
                        required="required" value="{{$order->taste}}">
                    @foreach (Flavour::all() as $flavour)
                        <option value="{{$flavour->key}}">{{$flavour->value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="sauce"
                   class="col-xs-12 col-sm-12 col-md-12">Sauce</label>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <select id="sauce" name="sauce" class="form-control"
                        required="required" value="{{$order->sauce}}">
                    @foreach (Sauce::all() as $sauce)
                        <option value="{{$sauce->key}}">{{$sauce->value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="vegetable"
                   class="col-xs-12 col-sm-12 col-md-12">Vegetables</label>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <select id="vegetable" name="vegetable[]"
                        class="form-control"
                        required="required" multiple>
                    @foreach (Vegetable::getOptions() as $vegetable)
                        <option value="{{$vegetable}}">{{ucfirst($vegetable)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3">Oven
                baked</label>
            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                <input name="oven_baked" id="oven_baked_0"
                       type="checkbox" class="form-control"
                       value="1"
                        {{($order->oven_baked == 1 ? ' checked' : '') }}>
                <label for=" oven_baked_0"
                       class="custom-control-label"></label>
            </div>
            <label class="col-xs-12 col-sm-3 col-md-3">Extra bacon
            </label>
            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                <input name="extra_bacon" id="extra_bacon_0"
                       type="checkbox" class="form-control"
                       value="1"
                        {{($order->extra_bacon == 1 ? ' checked' : '') }}>
                <label for=" extra_bacon_0"
                       class="custom-control-label"></label>
            </div>
            <label class="col-xs-12 col-sm-3 col-md-3">Double meat
            </label>
            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                <input name="double_meat" id="double_meat_0"
                       type="checkbox" class="form-control"
                       value="1"
                        {{($order->double_meat == 1 ? ' checked' : '') }}>
                <label for=" double_meat_0"
                       class="custom-control-label"></label>
            </div>
            <label class="col-xs-12 col-sm-3 col-md-3">Extra cheese
            </label>
            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                <input name="extra_cheese" id="extra_cheese_0"
                       type="checkbox" class="form-control"
                       value="1"
                        {{($order->extra_cheese == 1 ? ' checked' : '') }}>
                <label for=" extra_cheese_0"
                       class="custom-control-label"></label>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button name="submit" type="submit"
                        class="btn btn-primary ">Submit
                </button>
            </div>
        </div>

    </form>
@endsection
