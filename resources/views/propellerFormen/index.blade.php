@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Propellerformen</h1>
    <div class="row">
        <div class="col-lg-6">
            <a href="/propellerFormen/create" class="btn btn-success">
                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> neue Propellerform</span>
            </a>
        </div>
        <div class="col-lg-6">
            <a href="/propellerFormen/auftrag/fb018" class="btn btn-success">
                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> FB018 Formenbauauftrag</span>
            </a>
        </div>
    </div>

    <br><br>
    <div class="row">
        <div class="col-md-8">
            <a href="{{action('PropellerFormenController@formen_GF25_0_PDF')}}" class="btn btn-warning">PDF GF25-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GF26_0_PDF')}}" class="btn btn-warning">PDF GF26-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GF30_0_PDF')}}" class="btn btn-warning">PDF GF30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GF31_0_PDF')}}" class="btn btn-warning">PDF GF31-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <!-- <a href="{{action('PropellerFormenController@formen_GV30_0_PDF')}}" class="btn btn-warning">PDF GV30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a> -->
            <a href="{{action('PropellerFormenController@formen_GK30_0_PDF')}}" class="btn btn-warning">PDF GK30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GF40_0_PDF')}}" class="btn btn-warning">PDF GF40-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GF45_0_PDF')}}" class="btn btn-warning">PDF GF45-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GF50_0_PDF')}}" class="btn btn-warning">PDF GF50-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            <a href="{{action('PropellerFormenController@formen_GV30_0_PDF')}}" class="btn btn-warning">PDF GV30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GV50_0_PDF')}}" class="btn btn-warning">PDF GV50-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GAV40_0_PDF')}}" class="btn btn-warning">PDF GA/V40-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GAV40_1_PDF')}}" class="btn btn-warning">PDF GA/V40-1
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerFormenController@formen_GAV60_0_PDF')}}" class="btn btn-warning">PDF GA/V60-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            Filter:
            <br>
            <a href="/propellerFormen/?geometrieklasse=GF05-0" class="btn btn-info mr-4">GF05-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF10-0" class="btn btn-info mr-4">GF10-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF20-0" class="btn btn-info mr-4">GF20-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF25-0" class="btn btn-info mr-4">GF25-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF26-0" class="btn btn-info mr-4">GF26-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF30-0" class="btn btn-info">GF30-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF31-0" class="btn btn-info">GF31-0</a>
            <a href="/propellerFormen/?geometrieklasse=GV30-0" class="btn btn-info">GV30-0</a>
            <a href="/propellerFormen/?geometrieklasse=GK30-0" class="btn btn-info mr-4">GK30-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF40-0" class="btn btn-info mr-4">GF40-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF45-0" class="btn btn-info mr-4">GF45-0</a>
            <a href="/propellerFormen/?geometrieklasse=GF50-0" class="btn btn-info mr-4">GF50-0</a>
            <br>
            <a href="/propellerFormen/?geometrieklasse=GV50" class="btn btn-info mr-4">GV50</a>
            <a href="/propellerFormen/?geometrieklasse=GA/V40" class="btn btn-info">GA/V40</a>
            <a href="/propellerFormen/?geometrieklasse=GA/V60" class="btn btn-info">GA/V60</a>
            <a href="/propellerFormen/" class="btn btn-warning">Reset</a>
            <br><br> 
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/propellerFormen/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
    </div>
    <div class="row">
        <table class="table table-striped table-hover" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('name','Name')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('name_kurz','Name (kurz)')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Blatt-Alu-Modell</th>
                    <th scope="col">Blatt-Basis-Winkel</th> 
                    <th scope="col">Wurzel-Alu-Modell</th>
                    <th scope="col">Formen Anzahl</th>
                    <th scope="col">Kommentar</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerFormen) > 0)
                @foreach($propellerFormen as $propellerForm)
                <tr>
                    <td style=min-width:330px>{{ $propellerForm->name }}</td>
                    <td style=min-width:220px>{{ $propellerForm->name_kurz }}</td>
                    <td style=min-width:220px>{{ $propellerForm->propellerModellBlatt->name }}</td>
                    <td style=min-width:220px>{{ $propellerForm->propellerModellBlatt->winkel }}</td>
                    <td style=min-width:220px>{{ $propellerForm->propellerModellWurzel->name }}</td>
                    <td style=min-width:100px>{{ $propellerForm->anzahl }}</td>
                    <td style=min-width:100px>{{ $propellerForm->kommentar }}</td>
                    <td style=min-width:100px>
                        @if($propellerForm->updated_at > $propellerForm->created_at) 
                            geändert: {{ $propellerForm->updated_at }} / {{ $propellerForm->user->name }}
                        @else
                            erstellt: {{ $propellerForm->created_at }} / {{ $propellerForm->user->name }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/propellerFormen/{{$propellerForm->id}}/edit" class="btn btn-warning">
                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    <td style=min-width:100px>                  
                        <a href="/propellerFormen/{{$propellerForm->id}}" class="btn btn-default">
                        <span class="oi" data-glyph="layers" title="duplizieren" aria-hidden="true"></span>
                        </a></td>
                    <td>
                        {!! Form::open(['action' => ['PropellerFormenController@destroy', $propellerForm->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen der Form $propellerForm->name .&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $propellerFormen->appends(request()->query())->links() }}
        </table>
    </div>
@endsection

