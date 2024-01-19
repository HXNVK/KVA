@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/propellerStepCode" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <h1>Eingabe - Ebenen Wurzel "AV"</h1>
    <a href="/propellerStepCodeWurzelnAV/create" class="btn btn-success">
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
            @if(count($psc_WurzelnAV) > 0)
                @foreach($psc_WurzelnAV as $psc_WurzelAV)
                <tr>
                    <td style=min-width:50px>{{ $psc_WurzelAV->name }}</td>
                    <td style=min-width:50px>{{ $psc_WurzelAV->beschreibung }}</td>
                    <td style=min-width:50px>
                        @if($psc_WurzelAV->updated_at > $psc_WurzelAV->created_at) 
                            geändert: {{ $psc_WurzelAV->updated_at }} / {{ $psc_WurzelAV->user->name }}
                        @else
                            erstellt: {{ $psc_WurzelAV->created_at }} / {{ $psc_WurzelAV->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeWurzelnAV/{{$psc_WurzelAV->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td></td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeWurzelnAV/{{$psc_WurzelAV->id}}" class="btn btn-default">
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
        {{ $psc_WurzelnAV->appends(request()->query())->links() }}
    </div>
@endsection

