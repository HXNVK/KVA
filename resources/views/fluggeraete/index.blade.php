@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Fluggeräte</h1>
    <a href="/fluggeraete/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/fluggeraete/?', 'method' => 'get']) !!}
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
                    <th scope="col">Hersteller</th>
                    <th scope="col">Spannweite [m]</th>
                    <th scope="col">Vmax [km/h]</th>
                    <th scope="col">Vreise [km/h]</th>
                    <th scope="col">Vmin [km/h]</th>
                    <th scope="col">Leermasse [kg]</th>
                    <th scope="col">MTOW [kg]</th>
                    <th scope="col">Kennblattnummer</th>
                    <th scope="col">DS [mm]</th>
                    <th scope="col">ASGP</th>
                    <th scope="col">SPGP</th>
                    <th scope="col">SPKP</th>
                    <th scope="col">Notiz</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($fluggeraete) > 0)
                @foreach($fluggeraete as $fluggeraet)
                <tr>
                    <td style=min-width:50px>{{ $fluggeraet->name }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->kunde->matchcode }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->spannweite }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->v_max }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->v_reise }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->v_min }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->leermasse }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->mtow }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->kennblattnummer }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->artikel05Distanzscheibe->name }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->artikel06ASGP->name }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->artikel06SPGP->name }}</td>
                    <td style=min-width:50px>{{ $fluggeraet->artikel06SPKP->name }}</td>
                    <td style=min-width:50px>{{ Str::limit($fluggeraet->notiz,15,'...') }}</td>
                    <td style=min-width:50px>
                        @if($fluggeraet->updated_at > $fluggeraet->created_at) 
                            geändert: {{ $fluggeraet->updated_at }} / {{ $fluggeraet->user->name }}
                        @else
                            erstellt: {{ $fluggeraet->created_at }} / {{ $fluggeraet->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/fluggeraete/{{$fluggeraet->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/kunden/{{$fluggeraet->kunde_id}}" class="btn btn-primary">
                            <span class="oi" data-glyph="arrow-thick-right" title="zum Kunde" aria-hidden="true"></span>
                        </a></td>
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $fluggeraete->appends(request()->query())->links() }}
        </table>
    </div>
@endsection


