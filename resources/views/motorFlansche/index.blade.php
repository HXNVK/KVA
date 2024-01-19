@extends('layouts.app')

@section('content')
    <h1>Flansche</h1>
    <a href="/motorFlansche/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-2 mb-4">
            {!! Form::open(['url' => '/motorFlansche/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-md-4 mb-4">
            <a href="/motorFlansche/" class="btn btn-warning">Reset</a>
        </div>
    </div>
    <button id = "ABCFilter" type="button" class="btn btn-info mb-2">ABC Filter</button>
    <div class="row">
        <div class="col-md-10 mb-4 ABCFilter">
            <a href="/motorFlansche/?abcSuche=A" class="btn btn-info mr-4">A</a>
            <a href="/motorFlansche/?abcSuche=B" class="btn btn-info mr-4">B</a>
            <a href="/motorFlansche/?abcSuche=C" class="btn btn-info mr-4">C</a>
            <a href="/motorFlansche/?abcSuche=D" class="btn btn-info mr-4">D</a>
            <a href="/motorFlansche/?abcSuche=E" class="btn btn-info mr-4">E</a>
            <a href="/motorFlansche/?abcSuche=F" class="btn btn-info mr-4">F</a>
            <a href="/motorFlansche/?abcSuche=G" class="btn btn-info mr-4">G</a>
            <a href="/motorFlansche/?abcSuche=H" class="btn btn-info mr-4">H</a>
            <a href="/motorFlansche/?abcSuche=I" class="btn btn-info mr-4">I</a>
            <a href="/motorFlansche/?abcSuche=J" class="btn btn-info mr-4">J</a>
            <a href="/motorFlansche/?abcSuche=K" class="btn btn-info mr-4">K</a>
            <a href="/motorFlansche/?abcSuche=L" class="btn btn-info mr-4">L</a>
            <a href="/motorFlansche/?abcSuche=M" class="btn btn-info mr-4">M</a>
            <a href="/motorFlansche/?abcSuche=N" class="btn btn-info mr-4">N</a>
            <a href="/motorFlansche/?abcSuche=O" class="btn btn-info mr-4">O</a>
            <a href="/motorFlansche/?abcSuche=P" class="btn btn-info mr-4">P</a>
            <a href="/motorFlansche/?abcSuche=Q" class="btn btn-info mr-4">Q</a>
            <a href="/motorFlansche/?abcSuche=R" class="btn btn-info mr-4">R</a>
            <a href="/motorFlansche/?abcSuche=S" class="btn btn-info mr-4">S</a>
            <a href="/motorFlansche/?abcSuche=T" class="btn btn-info mr-4">T</a>
            <a href="/motorFlansche/?abcSuche=U" class="btn btn-info mr-4">U</a>
            <a href="/motorFlansche/?abcSuche=V" class="btn btn-info mr-4">V</a>
            <a href="/motorFlansche/?abcSuche=W" class="btn btn-info mr-4">W</a>
            <a href="/motorFlansche/?abcSuche=X" class="btn btn-info mr-4">X</a>
            <a href="/motorFlansche/?abcSuche=Y" class="btn btn-info mr-4">Y</a>
            <a href="/motorFlansche/?abcSuche=Z" class="btn btn-info mr-4">Z</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 mb-4 ABCFilter">
            <a href="/motorFlansche/?abcSuche=1" class="btn btn-info mr-4">1</a>
            <a href="/motorFlansche/?abcSuche=2" class="btn btn-info mr-4">2</a>
            <a href="/motorFlansche/?abcSuche=3" class="btn btn-info mr-4">3</a>
            <a href="/motorFlansche/?abcSuche=4" class="btn btn-info mr-4">4</a>
            <a href="/motorFlansche/?abcSuche=5" class="btn btn-info mr-4">5</a>
            <a href="/motorFlansche/?abcSuche=6" class="btn btn-info mr-4">6</a>
            <a href="/motorFlansche/?abcSuche=7" class="btn btn-info mr-4">7</a>
            <a href="/motorFlansche/?abcSuche=8" class="btn btn-info mr-4">8</a>
            <a href="/motorFlansche/?abcSuche=9" class="btn btn-info mr-4">9</a>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Anzahl Schrauben</th>
                    <th scope="col">Schraubengroesse</th>
                    <th scope="col">MZ Durchmesser</th>
                    <th scope="col">MZ Hoehe</th>
                    <th scope="col">TK Durchmesser</th>
                    <th scope="col">Zentrierdurchmesser</th>
                    <th scope="col">Zentrierhöhe</th>
                    <th scope="col">Passende AP</th>
                    <th scope="col">Bemerkungen</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($motorFlansche) > 0)
                @foreach($motorFlansche as $motorFlansch)
                <tr>
                    <td style=min-width:50px>{{ $motorFlansch->id }}</td>
                    <td style=min-width:250px>{{ $motorFlansch->motorFlanschname }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->anzahl_schrauben }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->schraubengroesse }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->mitnehmerzapfen_durchmesser }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->mitnehmerzapfen_hoehe }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->teilkreis_durchmesser }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->zentrier_durchmesser }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->zentrier_hoehe }}</td>
                    <td style=min-width:50px>{{ $motorFlansch->andruckplatte }}</td>
                    <td style=min-width:100px>{{ Str::limit($motorFlansch->bemerkung_flansch,15,'...siehe bearbeiten') }}</td>
                    <td style=min-width:100px>
                        @if($motorFlansch->updated_at > $motorFlansch->created_at) 
                            geändert: {{ $motorFlansch->updated_at }} / {{ $motorFlansch->username }}
                        @else
                            erstellt: {{ $motorFlansch->created_at }} / {{ $motorFlansch->username }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/motorFlansche/{{$motorFlansch->id}}/edit" class="btn btn-primary">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td style=min-width:100px>
                        <a href="/motorFlansche/{{$motorFlansch->id}}" class="btn btn-default">
                            <span class="oi" data-glyph="layers" title="dublizieren" aria-hidden="true">
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['MotorFlanscheController@destroy', $motorFlansch->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Flansches [$motorFlansch->motorFlanschname] von $motorFlansch->motorname .&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $motorFlansche->appends(request()->query())->links() }}
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("#ABCFilter").ready(function(){
                $(".ABCFilter").toggle();
            });
            $("#ABCFilter").click(function(){
                $(".ABCFilter").toggle();
            });
        });
     </script>
@endsection
