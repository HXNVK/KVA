@extends('layouts.app')

@section('content')
    <h1>Motoren</h1>
    <a href="/motoren/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-8">
            Filter:
            <br>
            <a href="/motoren/?geraeteklasse_id=1" class="btn btn-info mr-4">MS</a>
            <a href="/motoren/?geraeteklasse_id=2" class="btn btn-info mr-4">MS-Trike</a>
            <a href="/motoren/?geraeteklasse_id=11" class="btn btn-info mr-4">UL-Trike</a>
            <a href="/motoren/?geraeteklasse_id=3" class="btn btn-info mr-4">3-ACHS</a>
            <a href="/motoren/?geraeteklasse_id=8" class="btn btn-info mr-4">ECHO</a>
            <a href="/motoren/?geraeteklasse_id=5" class="btn btn-info mr-4">MC</a>
            <a href="/motoren/?geraeteklasse_id=6" class="btn btn-info mr-4">VTOL</a>
            <a href="/motoren/?deleted=1" class="btn btn-warning mr-10"><span class="oi" data-glyph="trash" title="gelöschte Motoren" aria-hidden="true"></span></a>
            <a href="/motoren/" class="btn btn-warning">Reset</a>
            <br><br>
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/motoren/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
    </div>
    <button id = "motorenliste" type="button" class="btn btn-info mb-2">Motorenliste</button>
    <div class="row motorenliste">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Kunde</th>
                    <th scope="col">@sortablelink('name','Motorname')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Geräteklasse</th>
                    <th scope="col">Arbeitsweise</th>
                    <th scope="col">Status</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Kupplung</th>
                    <th scope="col">Kühlung</th>
                    <th scope="col">Drehrichtung</th>
                    <th scope="col">Zylinderanzahl [-]</th>
                    <th scope="col">Hubraum [ccm]</th>
                    <th scope="col">Bohrung [mm]</th>
                    <th scope="col">Hub [mm]</th>
                    <th scope="col">Nenndrehzahl [U/min]</th>
                    <th scope="col">Nennleistung [kW]</th>
                    <th scope="col">Realleistung [kW]</th>
                    <th scope="col">Revision / Baujahr</th>
                    <th scope="col">Vergaser</th>
                    <th scope="col">Kennlinie</th>
                    <th scope="col">Notiz</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($motoren) > 0)
                @foreach($motoren as $motor)
                <tr>
                    <td style=min-width:50px>{{ $motor->kunde->matchcode }}</td>
                    <td style=min-width:50px>{{ $motor->name }}</td>
                    <td style=min-width:50px>{{ $motor->projektGeraeteklasse->name }}</td>
                    <td style=min-width:50px>{{ $motor->motorArbeitsweise->name }}</td>
                    <td style=min-width:50px>{{ $motor->motorStatus->name }}</td>
                    <td style=min-width:50px>{{ $motor->motorTyp->name }}</td>
                    <td style=min-width:50px>{{ $motor->motorKupplung->name }}</td>
                    <td style=min-width:50px>{{ $motor->motorKuehlung->name }}</td>
                    <td style=min-width:50px>{{ $motor->motorDrehrichtung->text }}</td>
                    <td style=min-width:50px>{{ $motor->zylinderanzahl }}</td>
                    <td style=min-width:50px>{{ $motor->hubraum }}</td>
                    <td style=min-width:50px>{{ $motor->bohrung }}</td>
                    <td style=min-width:50px>{{ $motor->hub }}</td>
                    <td style=min-width:50px>{{ $motor->nenndrehzahl }}</td>
                    <td style=min-width:50px>{{ $motor->nennleistung }}</td>
                    <td style=min-width:50px>{{ $motor->realleistung }}</td>
                    <td style=min-width:50px>{{ $motor->revision }}</td>
                    <td style=min-width:50px>{{ $motor->vergaser }}</td>
                    <td style=min-width:50px>                
                        @if($motor->kennlinie == 1)
                                vorhanden 
                            @else
                                nicht vorhanden
                        @endif
                    </td>
                    <td style=min-width:50px>{{ Str::limit($motor->notiz,15,'...') }}</td>
                    <td style=min-width:50px>
                        @if($motor->updated_at > $motor->created_at) 
                            geändert: {{ $motor->updated_at }} / {{ $motor->user->name }}
                        @else
                            erstellt: {{ $motor->created_at }} / {{ $motor->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/motoren/{{$motor->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/kunden/{{$motor->kunde_id}}" class="btn btn-primary">
                            <span class="oi" data-glyph="arrow-thick-right" title="zum Kunde" aria-hidden="true"></span>
                        </a></td>
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $motoren->appends(request()->query())->links() }}
        </table>
    </div>
    <div class="row">
        <div class="col-sm-2 mb-2">
            {{ $motoren->appends(request()->query())->links() }}    
        </div>
    </div>
    <div class="row">
        @if(count($motoren) > 0)
            @foreach($motoren as $key => $motor)
                <div class="col-sm-10 mb-2">
                    <a href="/kunden/{{$motor->kunde_id}}" class="btn btn-primary">
                        <span class="oi" data-glyph="eye" title="zum Kunden" aria-hidden="true"> {{ $motor->name }} ({{ $motor->kunde->matchcode }}) </span>
                    </a> 
                </div>
            @endforeach
        @else
            <p>Keine Daten vorhanden!!!</p>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $("#motorenliste").ready(function(){
                $(".motorenliste").toggle();
            });
            $("#motorenliste").click(function(){
                $(".motorenliste").toggle();
            });
        });
     </script>

@endsection


