@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/propellerStepCode" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <h1>Eingabe - Ebenen Wurzel "F"</h1>
    <a href="/propellerStepCodeWurzelnF/create" class="btn btn-success">
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
            @if(count($psc_WurzelnF) > 0)
                @foreach($psc_WurzelnF as $psc_WurzelF)
                <tr>
                    <td style=min-width:50px>{{ $psc_WurzelF->name }}</td>
                    <td style=min-width:50px>{{ $psc_WurzelF->beschreibung }}</td>
                    <td style=min-width:50px>
                        @if($psc_WurzelF->updated_at > $psc_WurzelF->created_at) 
                            geändert: {{ $psc_WurzelF->updated_at }} / {{ $psc_WurzelF->user->name }}
                        @else
                            erstellt: {{ $psc_WurzelF->created_at }} / {{ $psc_WurzelF->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeWurzelnF/{{$psc_WurzelF->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerStepCodeWurzelnF/{{$psc_WurzelF->id}}" class="btn btn-default">
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
        {{ $psc_WurzelnF->appends(request()->query())->links() }}
    </div>
@endsection

