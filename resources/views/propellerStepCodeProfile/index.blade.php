@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/propellerStepCode" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <h1>Eingabe - Profile</h1>
    <a href="/propellerStepCodeProfile/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Beschreibung</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerStepCodeProfile) > 0)
                @foreach($propellerStepCodeProfile as $propellerStepCodeProfil)
                <tr>
                    <td style=min-width:50px>{{ $propellerStepCodeProfil->name }}</td>
                    <td style=min-width:50px>{{ $propellerStepCodeProfil->beschreibung }}</td>
                    <td style=min-width:50px>
                        @if($propellerStepCodeProfil->updated_at > $propellerStepCodeProfil->created_at) 
                            geändert: {{ $propellerStepCodeProfil->updated_at }} / {{ $propellerStepCodeProfil->user->name }}
                        @else
                            erstellt: {{ $propellerStepCodeProfil->created_at }} / {{ $propellerStepCodeProfil->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeProfile/{{$propellerStepCodeProfil->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
        </table>
    </div>
@endsection

