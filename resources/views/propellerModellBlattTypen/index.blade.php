@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Typen</h1>
    <a href="/propellerModellBlattTypen/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#typennamen">
        Typen <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
    </button>
    <a href="{{action('PropellerModellBlattTypenController@typenPDF')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-8">
            Filter:
            <br>
            <a href="/propellerModellBlattTypen/?designklasse=D05-0" class="btn btn-primary mr-4">D05-0</a>
            <a href="/propellerModellBlattTypen/?designklasse=D10-0" class="btn btn-primary mr-4">D10-0</a>
            <a href="/propellerModellBlattTypen/?designklasse=D20-0" class="btn btn-primary mr-4">D20-0</a>
            <a href="/propellerModellBlattTypen/?designklasse=D25-0" class="btn btn-primary mr-4">D25-0</a>
            <a href="/propellerModellBlattTypen/?designklasse=D30-0" class="btn btn-primary mr-4">D30-0</a>
            <a href="/propellerModellBlattTypen/?designklasse=D50-0" class="btn btn-primary mr-4">D50-0</a>
            <a href="/propellerModellBlattTypen/?designklasse=D60-1" class="btn btn-primary mr-4">D60-1</a>
            <a href="/propellerModellBlattTypen/" class="btn btn-warning">Reset</a>
            <br><br> 
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/propellerModellBlattTypen/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Typ</th>
                    <th scope="col">Typ (1/3) Umrissform</th>
                    <th scope="col">Typ (2/3) Profilform</th>
                    <th scope="col">Typ (3/3) Profillänge</th>
                    <th scope="col">Typ (Alt)</th>
                    <th scope="col">Freifeld</th>
                    <th scope="col">Design Klasse</th>
                    <th scope="col">Kompatibilitaet</th>
                    <th scope="col">Exclusivität</th>
                    <th scope="col">Kunde</th>
                    <th scope="col">Projektklasse</th>
                    <th scope="col">Kommentar</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerModellBlattTypen) > 0)
                @foreach($propellerModellBlattTypen as $propellerModellBlattTyp)
                <tr>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->name }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->umrissform }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->profilform }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->profillaenge }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->name_alt }}</td> 
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->freifeld }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->propellerKlasseDesign->name }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->propellerModellKompatibilitaet->name }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->exclusiv }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->kunde }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->projektGeraeteklasse->name }}</td>
                    <td style=min-width:100px>{{ $propellerModellBlattTyp->kommentar }}</td>
                    <td style=min-width:100px>
                        @if($propellerModellBlattTyp->updated_at > $propellerModellBlattTyp->created_at) 
                            geändert: {{ $propellerModellBlattTyp->updated_at }} / {{ $propellerModellBlattTyp->user->name }}
                        @else
                            erstellt: {{ $propellerModellBlattTyp->created_at }} / {{ $propellerModellBlattTyp->user->name }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/propellerModellBlattTypen/{{$propellerModellBlattTyp->id}}/edit" class="btn btn-warning">
                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    {{-- <td>
                        {!! Form::open(['action' => ['PropellerModellBlattTypenController@destroy', $propellerModellBlattTyp->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Typs $propellerModellBlattTyp->name.&quot;)"])}}
                        {!! Form::close() !!}
                    </td> --}}
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $propellerModellBlattTypen->appends(request()->query())->links() }}
        </table>
    </div>
@endsection

@include('propellerModellBlattTypen.modal')