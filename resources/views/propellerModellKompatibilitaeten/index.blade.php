@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Modell Kompatibilitaeten</h1>
    <a href="/propellerModellKompatibilitaeten/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    </br></br>
    <a href="{{action('PropellerModellKompatibilitaetenController@kompatibilitaetenPDF')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    </br></br>
    <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Typen</th>
                <th scope="col">Typen (alt)</th>
                <th scope="col">RPS</th>
                <th scope="col">PLI</th>
                <th scope="col">PS</th>
                <th scope="col">beta</th>
                <th scope="col">PMI</th>
                <th scope="col">PZI</th>
                <th scope="col">block_ay</th>
                <th scope="col">block_fy</th>
                <th scope="col">rand</th>
                <th scope="col">block_rand</th>
                <th scope="col">kommentar</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @if(count($propellerModellKompatibilitaeten) > 0)
            @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
            <tr>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->name }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->typen }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->typen_alt }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->rps }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->pli }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->ps }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->beta }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->pmi }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->pzi }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->block_ay }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->block_fy }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->rand }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->block_rand }}</td>
                <td style=min-width:100px>{{ $propellerModellKompatibilitaet->kommentar }}</td>
                <td style=min-width:100px>
                    @if($propellerModellKompatibilitaet->updated_at > $propellerModellKompatibilitaet->created_at) 
                        geändert: {{ $propellerModellKompatibilitaet->updated_at }} / {{ $propellerModellKompatibilitaet->user->name }}
                    @else
                        erstellt: {{ $propellerModellKompatibilitaet->created_at }} / {{ $propellerModellKompatibilitaet->user->name }}
                    @endif
                </td>
                <td style=min-width:100px>
                    <a href="/propellerModellKompatibilitaeten/{{$propellerModellKompatibilitaet->id}}/edit" class="btn btn-warning">
                    <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                    </a>
                </td>
                <td>
                    {!! Form::open(['action' => ['PropellerModellKompatibilitaetenController@destroy', $propellerModellKompatibilitaet->id], 'method' => 'POST']) !!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen der Kompatibilität $propellerModellKompatibilitaet->name.&quot;)"])}}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        @else
            <p>Keine Daten vorhanden!!!</p>
        @endif
        </tbody>
        {{ $propellerModellKompatibilitaeten->links() }}
    </table>
@endsection
