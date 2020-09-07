@extends('meals.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SubWay - Meals</h2>
            </div>
            <div class="pull-right">
                @auth
                    <a class="btn btn-info"
                       href="{{ route('orders.index') }}">
                        Previous orders</a>
                @endauth
                @if($isAdmin)


                    <a class="btn btn-success"
                       href="/meals/add-meal">
                        Create New meal</a>

                    <a class="btn btn-primary users "
                       href="{{ route('users.index') }}">
                        Users</a>

                @endif
                @auth
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}"
                          method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                @endauth
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
            <th>Status</th>
            <th>Orders</th>
            <th>Date</th>
            <th width="350px">Action</th>
        </tr>
        @foreach ($meals as $meal)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $meal->status }}</td>
                <td>{{  count($meal->orders) }}</td>
                <td>{{ $meal->created_at->format('d M Y - H:i') }}</td>
                <td>
                    <a class="btn btn-info"
                       href="{{ route('meals.show',$meal->id) }}">Show</a>

                    @if($isAdmin)
                        <a class="btn btn-primary"
                           href="{{ route('changestatus', $meal->id) }}">Change
                            status</a>
                        <form class='button'
                              action="{{ route('meals.destroy',$meal->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete
                            </button>
                        </form>
                    @endif

                </td>
            </tr>
        @endforeach
    </table>

    {!! $meals->links() !!}

@endsection
