@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Propeller Modell Blatt</h1>
    <a href="/propellerModellBlaetter/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    {{-- <a href="{{action('PropellerModellBlaetterController@blattmodellePDF')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br><br> --}}
    <div class="row">
        <div class="col-md-8">
            <a href="{{action('PropellerModellBlaetterController@blattmodelle_D05_PDF')}}" class="btn btn-warning">PDF D05-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellBlaetterController@blattmodelle_D10_PDF')}}" class="btn btn-warning">PDF D10-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellBlaetterController@blattmodelle_D20_PDF')}}" class="btn btn-warning">PDF D20-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellBlaetterController@blattmodelle_D25_PDF')}}" class="btn btn-warning">PDF D25-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellBlaetterController@blattmodelle_D30_PDF')}}" class="btn btn-warning">PDF D30-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellBlaetterController@blattmodelle_D45_PDF')}}" class="btn btn-warning">PDF D45-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            <a href="{{action('PropellerModellBlaetterController@blattmodelle_D50_PDF')}}" class="btn btn-warning">PDF D50-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a>
            {{-- <a href="{{action('PropellerModellBlaetterController@blattmodelle_D60_PDF')}}" class="btn btn-warning">PDF D60-0
                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
            </a> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <br>
            <a href="/propellerModellBlaetter/?designklasse=D05-0" class="btn btn-info">D05-0</a>
            <a href="/propellerModellBlaetter/?designklasse=D10-0" class="btn btn-info">D10-0</a>
            <a href="/propellerModellBlaetter/?designklasse=D20-0" class="btn btn-info">D20-0</a>
            <a href="/propellerModellBlaetter/?designklasse=D25-0" class="btn btn-info">D25-0</a>
            <a href="/propellerModellBlaetter/?designklasse=D30-0" class="btn btn-info">D30-0</a>
            <a href="/propellerModellBlaetter/?designklasse=D45-0" class="btn btn-info">D45-0</a>
            <a href="/propellerModellBlaetter/?designklasse=D50-0" class="btn btn-info">D50-0</a>
            <a href="/propellerModellBlaetter/" class="btn btn-warning">Reset</a>
            <br><br>
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/propellerModellBlaetter/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('name','Name')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('propellerModellKompatibilitaet.name','Kompatibilität')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('propellerModellBlattTyp.name','Typ')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('propellerModellBlattTyp.name_alt','Typ (alt)')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Designklasse</th>
                    <th scope="col">@sortablelink('propellerVorderkantenTyp.text','Vorderkantentyp')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Logo</th>
                    <th scope="col">Bereichslänge [mm]</th>
                    <th scope="col">Drehrichtung</th>
                    <th scope="col">Winkel [°]</th>
                    <th scope="col">Pitch mitte Po [mm]</th>
                    <th scope="col">Pitch 75%R [mm]</th>
                    <th scope="col">Pitch aussen Pr [mm]</th>
                    <th scope="col">Profillaenge 75%R [mm]</th>
                    <th scope="col">Zoom Faktor [-]</th>
                    <th scope="col">Kommentar</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerModellBlaetter) > 0)
                @foreach($propellerModellBlaetter as $propellerModellBlatt)
                <tr>
                    <td style=min-width:220px>{{ $propellerModellBlatt->name }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->propellerModellBlattTyp->text }}</td>                
                    <td style=min-width:50px>{{ $propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->propellerKlasseDesign->name }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->propellerVorderkantenTyp->text }}</td>
                    <td style=min-width:50px>
                        @if($propellerModellBlatt->propeller_modell_blatt_logo_id == NULL)
                            <option value="1">-</option>
                        @else
                            {{ $propellerModellBlatt->propellerModellBlattLogo->text }}
                        @endif
                    </td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->bereichslaenge}}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->propellerDrehrichtung->text }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->winkel }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->pitch_mitte }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->pitch_75 }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->pitch_aussen }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->profil_laenge_75 }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->zoom_faktor }}</td>
                    <td style=min-width:50px>{{ $propellerModellBlatt->kommentar }}</td>
                    <td style=min-width:50px>
                        @if($propellerModellBlatt->updated_at > $propellerModellBlatt->created_at) 
                            geändert: {{ $propellerModellBlatt->updated_at }} / {{ $propellerModellBlatt->user->name }}
                        @else
                            erstellt: {{ $propellerModellBlatt->created_at }} / {{ $propellerModellBlatt->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerModellBlaetter/{{$propellerModellBlatt->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td style=min-width:50px>
                        <a href="/propellerModellBlaetter/{{$propellerModellBlatt->id}}" class="btn btn-default">
                            <span class="oi" data-glyph="layers" title="dublizieren" aria-hidden="true">
                        </a>
                    </td>
                    <td>
                        {{-- {!! Form::open(['action' => ['PropellerModellBlaetterController@destroy', $propellerModellBlatt->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Blattmodells $propellerModellBlatt->name.&quot;)"])}}
                        {!! Form::close() !!} --}}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $propellerModellBlaetter->appends(request()->query())->links() }}
        </table>
    </div>
@endsection

