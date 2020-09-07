@extends('orders.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit user</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}">
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

    <form action="{{ route('users.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="name"
                   class="col-xs-12 col-sm-12 col-md-12">Name
                type</label>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <input type="text" id="name" name="name" required="required"
                       class="form-control" value="{{$user->name}}">
                </input>
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
