@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/propellerStepCode" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <h1>Eingabe - Blattebenen</h1>
    <a href="/propellerStepCodeBlaetter/create" class="btn btn-success">
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
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerStepCodeBlaetter) > 0)
                @foreach($propellerStepCodeBlaetter as $propellerStepCodeBlatt)
                <tr>
                    <td style=min-width:50px>{{ $propellerStepCodeBlatt->name }}</td>
                    <td style=min-width:50px>{{ $propellerStepCodeBlatt->beschreibung }}</td>
                    <td style=min-width:50px>
                        @if($propellerStepCodeBlatt->updated_at > $propellerStepCodeBlatt->created_at) 
                            geändert: {{ $propellerStepCodeBlatt->updated_at }} / {{ $propellerStepCodeBlatt->user->name }}
                        @else
                            erstellt: {{ $propellerStepCodeBlatt->created_at }} / {{ $propellerStepCodeBlatt->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeBlaetter/{{$propellerStepCodeBlatt->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeBlaetter/{{$propellerStepCodeBlatt->id}}" class="btn btn-default">
                            <span class="oi" data-glyph="layers" title="dublizieren" aria-hidden="true">
                        </a>
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
        </table>
        {{ $propellerStepCodeBlaetter->appends(request()->query())->links() }}
    </div>
@endsection

