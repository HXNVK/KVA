@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/propellerStepCode" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <h1>Eingabe - Blockdaten für Wurzelmodelle</h1>
    <a href="/propellerStepCodeWurzelBloecke/create" class="btn btn-success">
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
            @if(count($psc_wurzelBloecke) > 0)
                @foreach($psc_wurzelBloecke as $psc_wurzelBlock)
                <tr>
                    <td style=min-width:50px>{{ $psc_wurzelBlock->name }}</td>
                    <td style=min-width:50px>{{ $psc_wurzelBlock->beschreibung }}</td>
                    <td style=min-width:50px>
                        @if($psc_wurzelBlock->updated_at > $psc_wurzelBlock->created_at) 
                            geändert: {{ $psc_wurzelBlock->updated_at }} / {{ $psc_wurzelBlock->user->name }}
                        @else
                            erstellt: {{ $psc_wurzelBlock->created_at }} / {{ $psc_wurzelBlock->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeWurzelBloecke/{{$psc_wurzelBlock->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeWurzelBloecke/{{$psc_wurzelBlock->id}}" class="btn btn-default">
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
        {{ $psc_wurzelBloecke->appends(request()->query())->links() }}
    </div>
@endsection

