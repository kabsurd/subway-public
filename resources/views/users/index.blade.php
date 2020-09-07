@extends('users.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SubWay - Users</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}">
                    Create New User</a>
                <a class="btn btn-primary" href="{{ route('meals.index') }}">
                    Back</a>
            </div>

        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Admin</th>
            <th>Auth link</th>
            <th width="350px">Action</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->admin}}</td>
                <td>
                    <a href="/code-login/{{$user->auth_code}}">{{$user->auth_code}}</a>
                </td>
                <td>
                    <a class="btn btn-primary"
                       href="{{ route('users.edit',$user->id) }}">Edit</a>
                    @if(Auth::id() != $user->id)
                        <form class='button'
                              action="{{ route('users.destroy',$user->id) }}"
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

    {!! $users->links() !!}

@endsection
