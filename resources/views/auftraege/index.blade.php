@extends('layouts.app')

@section('content')
    <h1>Aufträge</h1>
    <div class="row">
        <div class="col-md-3">
            <br>
            {!! Form::open(['url' => '/auftraege/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
        <div class="col-md-2">
            <a href="/auftraege/" class="btn btn-warning">Reset</a>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Typ</th>
                    <th scope="col">@sortablelink('kundeMatchcode','Kunde')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Anzahl</th>
                    <th scope="col">@sortablelink('propeller','Propeller')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Ausführung</th>
                    <th scope="col">Farbe</th>
                    <th scope="col">@sortablelink('projekt','Projekt')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('auftrag_status_id','Status')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('updated_at','Datum')<span class="oi" data-glyph="elevator"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($auftraege) > 0)
                @foreach($auftraege as $auftrag)
                <tr>
                    <td style=width:5%>{{ $auftrag->id }}</td>
                    <td style=width:50px>{{ $auftrag->auftragTyp->name }}</td>
                    <td style=width:50px>{{ $auftrag->kundeMatchcode }}</td>
                    <td style=width:50px>{{ $auftrag->anzahl }}</td>
                    <td style=width:200px>{{ $auftrag->propeller }}</td>
                    <td style=width:50px>{{ $auftrag->ausfuehrung }}</td>
                    <td style=width:50px>{{ $auftrag->farbe }}</td>
                    <td style=width:150px>{{ $auftrag->projekt }}</td>
                    <td style=width:150px>{{ $auftrag->auftragStatus->name }}</td>
                    <td style=width:150px>
                        @if($auftrag->updated_at > $auftrag->created_at) 
                            geändert: {{ $auftrag->updated_at }} / {{ $auftrag->user->name }}
                        @else
                            erstellt: {{ $auftrag->created_at }} / {{ $auftrag->user->name }}
                        @endif
                    </td>
                    <td style=width:150px>
                        @switch($auftrag->auftrag_status_id)
                        @case(1)
                            @if($auftrag->auftrag_typ_id == 1)
                                <a href="/auftraege/{{$auftrag->id}}" class="btn btn-primary btn-sm mb-2">
                                    <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Büro</span>
                                </a>
                                @break
                            @else
                                <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-primary btn-sm mb-2">
                                    <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Büro</span>
                                </a>
                                @break     
                            @endif
                        @case(2)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-dark btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Fertigung</span>
                            </a>
                            @break
                        @case(3)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-purple btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Fertigung EXT HX</span>
                            </a>
                            @break
                        @case(4)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-warning btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Endfertigung</span>
                            </a>
                            @break
                        @case(8)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-success btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Versendet</span>
                            </a>
                            @break
                        @case(9)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-secondary btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Lamination</span>
                            </a>
                            @break
                        @case(10)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-danger btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Lagerbestand geprüft</span>
                            </a>
                            @break
                        @case(11)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-secondary btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Formenbau</span>
                            </a>
                            @break
                        @case(13)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-light btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Storniert</span>
                            </a>
                            @break
                        @case(14)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-success btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Versand</span>
                            </a>
                            @break
                        @case(15)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Eingangslager </span>
                            </a>
                            @break
                        @case(16)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Teillieferung </span>
                            </a>
                            @break
                        @case(17)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-secondary btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Entgratung </span>
                            </a>
                            @break
                        @case(18)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-info btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Fertigung EXT KJ</span>
                            </a>
                            @break
                        @case(19)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-primary btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Teillieferung</span>
                            </a>
                            @break
                        @case(20)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-light active btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Fertigung EXT HD / ZUL </span>
                            </a>
                            @break
                        @case(21)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-warning active btn-sm mb-2">
                                <span class="oi" data-glyph="external-link" title="zum Auftrag" aria-hidden="true"> Endf. Werkstatt </span>
                            </a>
                            @break
                        @case(22)
                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-check active btn-sm mb-2">
                                <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Prüfung </span>
                            </a>
                            @break
                    @endswitch
                    </td>
                    <td style=width:150px>
                        <a href="/kunden/{{$auftrag->kundeID}}" class="btn btn-primary">
                            <span class="oi" data-glyph="arrow-thick-right" title="zum Kunde" aria-hidden="true"> zu Kunde</span>
                        </a></td>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['AuftraegeController@destroy', $auftrag->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Auftrags $auftrag->id.&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $auftraege->appends(request()->query())->links() }}
        </table>
    </div>
@endsection


