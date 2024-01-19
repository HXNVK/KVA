@extends('layouts.app')

@section('content')
    <h1>Kunden</h1>
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/kunden/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    {{-- Rabattklasse --}}
    <div class="row">
        <div class="col-md-8 mt-2">
            <a href="/kunden/?rating=1" class="btn btn-info mr-4">2%</a>
            <a href="/kunden/?rating=2" class="btn btn-info mr-4">12.5%</a>
            <a href="/kunden/?rating=3" class="btn btn-info mr-4">30%</a>
            <a href="/kunden/?rating=4" class="btn btn-info mr-4">37%</a>
            <a href="/kunden/?rating=5" class="btn btn-info mr-4">40.5%</a>
            <a href="/kunden/?rating=6" class="btn btn-info mr-4">42.6%</a>
            <a href="/kunden/?rating=7" class="btn btn-info mr-4">44%</a>
            <a href="/kunden/?rating=8" class="btn btn-info mr-4">47.5%</a>
            <a href="/kunden/?rating=9" class="btn btn-info mr-4">60%</a>
            <a href="/kunden/?rating=10" class="btn btn-info mr-4">100%</a>
            <a href="/kunden/" class="btn btn-warning">Reset</a>
        </div>
        <div class="col-md-2 mt-2">
            <br>
            {!! Form::open(['url' => '/kunden/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
    </div>
    {{-- Kundengruppen --}}
    <div class="row">
        <div class="col-md-5 mb-2">
            <a href="/kunden/?gruppe=1" class="btn btn-info mr-4">Endkunde</a>
            <a href="/kunden/?gruppe=2" class="btn btn-info mr-4">Händler</a>
            <a href="/kunden/?gruppe=3" class="btn btn-info mr-4">Hersteller</a>
            <a href="/kunden/?gruppe=4" class="btn btn-info mr-4">Motorhersteller</a>       
            <a href="/kunden/?gruppe=5" class="btn btn-info mr-4">Flugschule</a> 
        </div>
    </div>
    {{-- ABC Filter --}}
    <button id = "ABCFilter" type="button" class="btn btn-info mb-2">ABC Filter</button>
    <div class="row">
        <div class="col-md-10 mb-2 ABCFilter">
            <a href="/kunden/?abcSuche=A" class="btn btn-info mr-4">A</a>
            <a href="/kunden/?abcSuche=B" class="btn btn-info mr-4">B</a>
            <a href="/kunden/?abcSuche=C" class="btn btn-info mr-4">C</a>
            <a href="/kunden/?abcSuche=D" class="btn btn-info mr-4">D</a>
            <a href="/kunden/?abcSuche=E" class="btn btn-info mr-4">E</a>
            <a href="/kunden/?abcSuche=F" class="btn btn-info mr-4">F</a>
            <a href="/kunden/?abcSuche=G" class="btn btn-info mr-4">G</a>
            <a href="/kunden/?abcSuche=H" class="btn btn-info mr-4">H</a>
            <a href="/kunden/?abcSuche=I" class="btn btn-info mr-4">I</a>
            <a href="/kunden/?abcSuche=J" class="btn btn-info mr-4">J</a>
            <a href="/kunden/?abcSuche=K" class="btn btn-info mr-4">K</a>
            <a href="/kunden/?abcSuche=L" class="btn btn-info mr-4">L</a>
            <a href="/kunden/?abcSuche=M" class="btn btn-info mr-4">M</a>
            <a href="/kunden/?abcSuche=N" class="btn btn-info mr-4">N</a>
            <a href="/kunden/?abcSuche=O" class="btn btn-info mr-4">O</a>
            <a href="/kunden/?abcSuche=P" class="btn btn-info mr-4">P</a>
            <a href="/kunden/?abcSuche=Q" class="btn btn-info mr-4">Q</a>
            <a href="/kunden/?abcSuche=R" class="btn btn-info mr-4">R</a>
            <a href="/kunden/?abcSuche=S" class="btn btn-info mr-4">S</a>
            <a href="/kunden/?abcSuche=T" class="btn btn-info mr-4">T</a>
            <a href="/kunden/?abcSuche=U" class="btn btn-info mr-4">U</a>
            <a href="/kunden/?abcSuche=V" class="btn btn-info mr-4">V</a>
            <a href="/kunden/?abcSuche=W" class="btn btn-info mr-4">W</a>
            <a href="/kunden/?abcSuche=X" class="btn btn-info mr-4">X</a>
            <a href="/kunden/?abcSuche=Y" class="btn btn-info mr-4">Y</a>
            <a href="/kunden/?abcSuche=Z" class="btn btn-info mr-4">Z</a>
            <a href="/kunden/" class="btn btn-warning">Reset</a>
        </div>
    </div>
    {{-- Kundenliste --}}
    <button id = "kundenliste" type="button" class="btn btn-info mb-2">Kundenliste</button>
    <div class="row kundenliste">
        <table class="table table-striped mb-4" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('id','ID')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('matchcode','Matchcode')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('name1','Firmenname / Nachname')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">@sortablelink('name2','Zusatz / Vorname')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Typ</th>
                    <th scope="col">Gruppe</th>
                    <th scope="col">Rating</th>
                    <th scope="col">checked</th>
                    <th scope="col">Status</th>
                    <th scope="col">Notiz</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($kunden) > 0)
                @foreach($kunden as $kunde)
                <tr>
                    <td style=min-width:50px>{{ $kunde->id }}</td>
                    <td style=min-width:50px>{{ $kunde->matchcode }}</td>
                    <td style=min-width:50px>{{ $kunde->name1 }}</td>
                    <td style=min-width:50px>{{ $kunde->name2 }}</td>
                    <td style=min-width:50px>{{ $kunde->kundeTyp->name }}</td>
                    <td style=min-width:50px>{{ $kunde->kundeGruppe->name }}</td>
                    <td style=min-width:50px>{{ $kunde->kundeRating->name }}</td>
                    <td style=min-width:50px>{{ $kunde->checked }}</td>
                    <td style=min-width:50px>{{ $kunde->kundeStatus->name }}</td>
                    <td style=min-width:50px>{{ Str::limit($kunde->notiz,15,'...') }}</td>
                    <td style=min-width:50px>
                        @if($kunde->updated_at > $kunde->created_at) 
                            geändert: {{ $kunde->updated_at }} / {{ $kunde->user->name }}
                        @else
                            erstellt: {{ $kunde->created_at }} / {{ $kunde->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/kunden/{{$kunde->id}}" class="btn btn-primary">
                        <span class="oi" data-glyph="eye" title="Dashboard" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['KundenController@destroy', $kunde->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Kundens $kunde->name1.&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $kunden->appends(request()->query())->links() }}
        </table>
    </div>
    <div class="row" style="background-color: grey">
        <div class="col-1 mt-2">
            <span class="oi" data-glyph="expand-down" title="Dashboard" aria-hidden="true"> </span>
        </div>
        <div class="col-10">
            <h3><b>Filter- / Sucheergebnis:</b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 mb-2">
            {{ $kunden->appends(request()->query())->links() }}
        </div>
    </div>
    <div class="row">
        @if(count($kunden) > 0)
            @foreach($kunden as $key => $kunde)
                <div class="col-sm-10 mb-2">
                    <a href="/kunden/{{$kunde->id}}" class="btn btn-primary">
                        <span class="oi" data-glyph="eye" title="Dashboard" aria-hidden="true"> {{ $kunde->matchcode }} [{{ $kunde->name1 }}]</span>
                    </a> 
                </div>
            @endforeach
        @else
            <p>Keine Daten vorhanden!!!</p>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $("#ABCFilter").ready(function(){
                $(".ABCFilter").toggle();
            });
            $("#ABCFilter").click(function(){
                $(".ABCFilter").toggle();
            });

            $("#kundenliste").ready(function(){
                $(".kundenliste").toggle();
            });
            $("#kundenliste").click(function(){
                $(".kundenliste").toggle();
            });
        });
     </script>
@endsection


