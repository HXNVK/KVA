@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Propeller Modell Wurzel</h1>
    <a href="/propellerModellWurzeln/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    {{-- <a href="{{action('PropellerModellWurzelnController@wurzelmodellePDF')}}" class="btn btn-warning">PDF 
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a> --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF05_0_PDF')}}" class="btn btn-warning">PDF GF05-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF10_0_PDF')}}" class="btn btn-warning">PDF GF10-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF20_0_PDF')}}" class="btn btn-warning">PDF GF20-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF25_0_PDF')}}" class="btn btn-warning">PDF GF25-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF26_0_PDF')}}" class="btn btn-warning">PDF GF26-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF30_0_PDF')}}" class="btn btn-warning">PDF GF30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF31_0_PDF')}}" class="btn btn-warning">PDF GF31-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF40_0_PDF')}}" class="btn btn-warning">PDF GF40-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF45_0_PDF')}}" class="btn btn-warning">PDF GF45-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF50_0_PDF')}}" class="btn btn-warning">PDF GF50-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GF60_0_PDF')}}" class="btn btn-warning">PDF GF60-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-8">
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GK20_0_PDF')}}" class="btn btn-warning">PDF GK20-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GK25_0_PDF')}}" class="btn btn-warning">PDF GK25-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GK30_0_PDF')}}" class="btn btn-warning">PDF GK30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GK40_0_PDF')}}" class="btn btn-warning">PDF GK40-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GK50_0_PDF')}}" class="btn btn-warning">PDF GK50-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GS60_0_PDF')}}" class="btn btn-warning">PDF GS60-1
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GV30_0_PDF')}}" class="btn btn-warning">PDF GV30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GV50_0_PDF')}}" class="btn btn-warning">PDF GV50-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellWurzelnController@wurzelmodelle_GAV60_0_PDF')}}" class="btn btn-warning">PDF GA/V60-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            Filter:
            <br>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF05-0" class="btn btn-xs btn-info mr-4">GF05-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF10-0" class="btn btn-xs btn-info">GF10-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GV10-0" class="btn btn-xs btn-info mr-4">GV10-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF20-0" class="btn btn-xs btn-info">GF20-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GV20-0" class="btn btn-xs btn-info mr-4">GV20-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF25-0" class="btn btn-xs btn-info mr-4">GF25-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF26-0" class="btn btn-xs btn-info mr-4">GF26-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF30-0" class="btn btn-xs btn-info">GF30-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF31-0" class="btn btn-xs btn-info">GF31-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GV30-0" class="btn btn-xs btn-info">GV30-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GK30-0" class="btn btn-xs btn-info mr-4">GK30-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF40-0" class="btn btn-xs btn-info mr-4">GF40-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF45-0" class="btn btn-xs btn-info mr-4">GF45-0</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GF50-0" class="btn btn-xs btn-info">GF50-0</a>

            <a href="/propellerModellWurzeln/?geometrieklasse=GA/V40" class="btn btn-xs btn-info mr-4">GA/V40</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GV50" class="btn btn-xs btn-info mr-4">GV50</a>
            <a href="/propellerModellWurzeln/?geometrieklasse=GA/V60" class="btn btn-xs btn-info">GA/V60</a>
            <a href="/propellerModellWurzeln/" class="btn btn-xs btn-warning">Reset</a>
            <br><br>
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/propellerModellWurzeln/?', 'method' => 'get']) !!}
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
                    <th scope="col">Geometrie Klasse</th>
                    <th scope="col">Drehrichtung</th>
                    <th scope="col">Winkel</th>
                    <th scope="col">Konuswinkel</th>
                    <th scope="col">Bereichslänge [mm]</th>
                    <th scope="col">Kommentar</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerModellWurzeln) > 0)
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                <tr>
                    <td style=min-width:150px>{{ $propellerModellWurzel->name }}</td>
                    <td style=min-width:100px>{{ $propellerModellWurzel->propellerKlasseGeometrie->name }}</td>
                    <td style=min-width:100px>{{ $propellerModellWurzel->propellerDrehrichtung->text }}</td>
                    <td style=min-width:100px>{{ $propellerModellWurzel->winkel }}</td>
                    <td style=min-width:100px>{{ $propellerModellWurzel->konuswinkel }}</td>
                    <td style=min-width:100px>{{ $propellerModellWurzel->bereichslaenge }}</td>
                    <td style=min-width:100px>{{ $propellerModellWurzel->kommentar }}</td>
                    <td style=min-width:100px>
                        @if($propellerModellWurzel->updated_at > $propellerModellWurzel->created_at) 
                            geändert: {{ $propellerModellWurzel->updated_at }} / {{ $propellerModellWurzel->user->name }}
                        @else
                            erstellt: {{ $propellerModellWurzel->created_at }} / {{ $propellerModellWurzel->user->name }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/propellerModellWurzeln/{{$propellerModellWurzel->id}}/edit" class="btn btn-warning">
                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    <td style=min-width:100px>
                        <a href="/propellerModellWurzeln/{{$propellerModellWurzel->id}}" class="btn btn-default">
                        <span class="oi" data-glyph="layers" title="dublizieren" aria-hidden="true">
                        </a></td>
                    <td>
                        {{-- {!! Form::open(['action' => ['PropellerModellWurzelnController@destroy', $propellerModellWurzel->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Wurzelmodells $propellerModellWurzel->name.&quot;)"])}}
                        {!! Form::close() !!} --}}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $propellerModellWurzeln->appends(request()->query())->links() }}
        </table>
    </div>
@endsection
