@extends('meals.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show meal</h2>
            </div>
            <div class="pull-right">
                @if($meal->status === 'closed')
                    <a class="btn btn-success"
                       href="/meals/{{$meal->id}}/overview">
                        Order list</a>
                @endif
                <a class="btn btn-primary"
                   href="{{ route('meals.index') }}">
                    Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h4>Status:
                    {{ $meal->status }}</h4>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <h3>Orders:</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>User</th>
                        <th>Updated at</th>
                        @auth
                            <th width="280px">Action</th>
                        @endauth
                    </tr>

                    @foreach($meal->orders as $order)
                        <tr>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('d M Y - H:i') }}</td>
                            @auth

                                <td>
                                    <a class="btn btn-info"
                                       href="{{ route('orders.show',$order->id) }}"
                                       target="_blank">Show</a>
                                    @if ($meal->status == Meal::STATUS_OPEN && (Auth::id() === $order->user_id || $isAdmin))
                                        <a class="btn btn-primary"
                                           href="{{ route('orders.edit',$order->id) }}">Edit</a>
                                    @endif
                                    @if ($meal->status == Meal::STATUS_OPEN && (Auth::id() === $order->user_id || $isAdmin))
                                        <form class='button'
                                              action="{{ route('orders.destroy',$order->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    @auth
        @if ($meal->status == Meal::STATUS_OPEN && $meal->orders->where('user_id', Auth::id())->count() < 1)
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <h2>Add your order:</h2>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems
                            with
                            your
                            input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/meals/{{$meal->id}}/add-order" method="POST">
                        @csrf
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="bread"
                                   class="col-xs-12 col-sm-12 col-md-12">Bread
                                type</label>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <select id="bread" name="bread"
                                        required="required"
                                        class="form-control">
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
                                        required="required">
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
                                <select id="taste" name="taste"
                                        class="form-control"
                                        required="required">
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
                                <select id="sauce" name="sauce"
                                        class="form-control"
                                        required="required">
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
                        <h5>Extras</h5>
                        <div class="form-group row">
                            <label class="col-xs-12 col-sm-3 col-md-3">Oven
                                baked</label>
                            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                                <input name="oven_baked" id="oven_baked_0"
                                       type="checkbox" class="form-control"
                                       value="1">
                                <label for="oven_baked_0"
                                       class="custom-control-label"></label>
                            </div>
                            <label class="col-xs-12 col-sm-3 col-md-3">Extra
                                bacon</label>
                            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                                <input name="extra_bacon" id="extra_bacon_0"
                                       type="checkbox" class="form-control"
                                       value="1">
                                <label for="extra_bacon_0"
                                       class="custom-control-label"></label>
                            </div>
                            <label class="col-xs-12 col-sm-3 col-md-3">Double
                                meat</label>
                            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                                <input name="double_meat" id="double_meat_0"
                                       type="checkbox" class="form-control"
                                       value="1">
                                <label for="double_meat_0"
                                       class="custom-control-label"></label>
                            </div>
                            <label class="col-xs-12 col-sm-3 col-md-3">Extra
                                cheese</label>
                            <div class="col-xs-12 col-sm-3 col-md-3 text-left">
                                <input name="extra_cheese"
                                       id="extra_cheese_0"
                                       type="checkbox" class="form-control"
                                       value="1">
                                <label for="extra_cheese_0"
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

                </div>
            </div>
        @endif
    @endauth
@endsection
