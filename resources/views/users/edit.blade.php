@extends('layouts.app')

@section('content')
    <h1>Benutzer editieren</h1>
    <div class="p-3">
        <form action="{{ route('users.update', $user->id) }}" method="post">
            @csrf
            @method('put')
                    @include('users.partials.form')
                <button class="btn btn-primary mr-2">Speichern</button>
                <a href="{{ route('users.index') }}" class="btn btn-danger">Abbrechen</a>
        </form>
    </div>
@endsection