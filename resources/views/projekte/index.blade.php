@extends('layouts.app')

@section('content')
    <h1>Projekte</h1>
    <a href="/projekte/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-8">
            Filter:
            <br>
            <a href="/projekte/?geraeteklasse_id=1" class="btn btn-info mr-4">MS</a>
            <a href="/projekte/?geraeteklasse_id=2" class="btn btn-info mr-4">MS-Trike</a>
            <a href="/projekte/?geraeteklasse_id=11" class="btn btn-info mr-4">UL-Trike</a>
            <a href="/projekte/?geraeteklasse_id=3" class="btn btn-info mr-4">3-ACHS</a>
            <a href="/projekte/?geraeteklasse_id=5" class="btn btn-info mr-4">MC</a>
            <a href="/projekte/?geraeteklasse_id=6" class="btn btn-info mr-4">VTOL</a>
            <a href="/projekte/" class="btn btn-warning">Reset</a>
            <br><br>
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/projekte/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Geräteklasse</th>
                    <th scope="col">Kategorie</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Status</th>
                    <th scope="col">Kunde</th>
                    <th scope="col">Notiz</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($projekte) > 0)
                @foreach($projekte as $projekt)
                <tr>
                    <td style=min-width:50px>{{ $projekt->name }}</td>
                    <td style=min-width:50px>{{ $projekt->projektGeraeteklasse->name }}</td>
                    <td style=min-width:50px>{{ $projekt->projektKategorie->name }}</td>
                    <td style=min-width:50px>{{ $projekt->projektTyp->name }}</td>
                    <td style=min-width:50px>{{ $projekt->projektStatus->name }}</td>
                    <td style=min-width:50px>{{ $projekt->kunde->matchcode }}</td>
                    <td style=min-width:50px>{{ Str::limit($projekt->notiz,15,'...') }}</td>
                    <td style=min-width:50px>
                        @if($projekt->updated_at > $projekt->created_at) 
                            geändert: {{ $projekt->updated_at }} / {{ $projekt->user->name }}
                        @else
                            erstellt: {{ $projekt->created_at }} / {{ $projekt->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/kunden/{{$projekt->kunde_id}}" class="btn btn-primary">
                            <span class="oi" data-glyph="arrow-thick-right" title="zum Kunde" aria-hidden="true"></span>
                        </a></td>
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $projekte->appends(request()->query())->links() }}
        </table>
    </div>
@endsection


