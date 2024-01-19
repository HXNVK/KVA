@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/propellerStepCode" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <h1>Eingabe - Blockdaten für Blattmodelle</h1>
    <a href="/propellerStepCodeBlattBloecke/create" class="btn btn-success">
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
            @if(count($psc_blattBloecke) > 0)
                @foreach($psc_blattBloecke as $psc_blattBlock)
                <tr>
                    <td style=min-width:50px>{{ $psc_blattBlock->name }}</td>
                    <td style=min-width:50px>{{ $psc_blattBlock->beschreibung }}</td>
                    <td style=min-width:50px>
                        @if($psc_blattBlock->updated_at > $psc_blattBlock->created_at) 
                            geändert: {{ $psc_blattBlock->updated_at }} / {{ $psc_blattBlock->user->name }}
                        @else
                            erstellt: {{ $psc_blattBlock->created_at }} / {{ $psc_blattBlock->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeBlattBloecke/{{$psc_blattBlock->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeBlattBloecke/{{$psc_blattBlock->id}}" class="btn btn-default">
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
        {{ $psc_blattBloecke->appends(request()->query())->links() }}
    </div>
@endsection

