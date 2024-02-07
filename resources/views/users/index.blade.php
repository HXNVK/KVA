@extends('layouts.app')

@section('content')
<div class="m-3">
    <h1>Benutzer <a class="d-inline btn btn-primary" href="{{ route('users.create') }}">+</a></h1>
    <div class="row">
        @include('internals.messages')
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Rolle</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        {{ $user->id }}
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        @foreach($user->roles as $role)
                        {{ $role->name }}
                        @endforeach
                    </td>
                    <td>
                        <a class="btn btn-dark" href="{{ route('users.edit', $user->id) }}">edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection