@extends('layouts.app')

@section('content')
    <h1>Getriebe</h1>
    <a href="/motorGetriebe/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-2">
            {!! Form::open(['url' => '/motorGetriebe/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}  
            <br>  
        </div>
    </div>
    <button id = "ABCFilter" type="button" class="btn btn-info mb-2">ABC Filter</button>
    <div class="row">
        <div class="col-md-10 mb-4 ABCFilter">
            <a href="/motorGetriebe/?abcSuche=A" class="btn btn-info mr-4">A</a>
            <a href="/motorGetriebe/?abcSuche=B" class="btn btn-info mr-4">B</a>
            <a href="/motorGetriebe/?abcSuche=C" class="btn btn-info mr-4">C</a>
            <a href="/motorGetriebe/?abcSuche=D" class="btn btn-info mr-4">D</a>
            <a href="/motorGetriebe/?abcSuche=E" class="btn btn-info mr-4">E</a>
            <a href="/motorGetriebe/?abcSuche=F" class="btn btn-info mr-4">F</a>
            <a href="/motorGetriebe/?abcSuche=G" class="btn btn-info mr-4">G</a>
            <a href="/motorGetriebe/?abcSuche=H" class="btn btn-info mr-4">H</a>
            <a href="/motorGetriebe/?abcSuche=I" class="btn btn-info mr-4">I</a>
            <a href="/motorGetriebe/?abcSuche=J" class="btn btn-info mr-4">J</a>
            <a href="/motorGetriebe/?abcSuche=K" class="btn btn-info mr-4">K</a>
            <a href="/motorGetriebe/?abcSuche=L" class="btn btn-info mr-4">L</a>
            <a href="/motorGetriebe/?abcSuche=M" class="btn btn-info mr-4">M</a>
            <a href="/motorGetriebe/?abcSuche=N" class="btn btn-info mr-4">N</a>
            <a href="/motorGetriebe/?abcSuche=O" class="btn btn-info mr-4">O</a>
            <a href="/motorGetriebe/?abcSuche=P" class="btn btn-info mr-4">P</a>
            <a href="/motorGetriebe/?abcSuche=Q" class="btn btn-info mr-4">Q</a>
            <a href="/motorGetriebe/?abcSuche=R" class="btn btn-info mr-4">R</a>
            <a href="/motorGetriebe/?abcSuche=S" class="btn btn-info mr-4">S</a>
            <a href="/motorGetriebe/?abcSuche=T" class="btn btn-info mr-4">T</a>
            <a href="/motorGetriebe/?abcSuche=U" class="btn btn-info mr-4">U</a>
            <a href="/motorGetriebe/?abcSuche=V" class="btn btn-info mr-4">V</a>
            <a href="/motorGetriebe/?abcSuche=W" class="btn btn-info mr-4">W</a>
            <a href="/motorGetriebe/?abcSuche=X" class="btn btn-info mr-4">X</a>
            <a href="/motorGetriebe/?abcSuche=Y" class="btn btn-info mr-4">Y</a>
            <a href="/motorGetriebe/?abcSuche=Z" class="btn btn-info mr-4">Z</a>
            <a href="/motorGetriebe/" class="btn btn-warning">Reset</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 mb-4 ABCFilter">
            <a href="/motorGetriebe/?abcSuche=1" class="btn btn-info mr-4">1</a>
            <a href="/motorGetriebe/?abcSuche=2" class="btn btn-info mr-4">2</a>
            <a href="/motorGetriebe/?abcSuche=3" class="btn btn-info mr-4">3</a>
            <a href="/motorGetriebe/?abcSuche=4" class="btn btn-info mr-4">4</a>
            <a href="/motorGetriebe/?abcSuche=5" class="btn btn-info mr-4">5</a>
            <a href="/motorGetriebe/?abcSuche=6" class="btn btn-info mr-4">6</a>
            <a href="/motorGetriebe/?abcSuche=7" class="btn btn-info mr-4">7</a>
            <a href="/motorGetriebe/?abcSuche=8" class="btn btn-info mr-4">8</a>
            <a href="/motorGetriebe/?abcSuche=9" class="btn btn-info mr-4">9</a>
            <a href="/motorGetriebe/" class="btn btn-warning">Reset</a>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">zu Motor</th>
                    <th scope="col">Art</th>
                    <th scope="col">Untersetzung [1: ]</th>
                    <th scope="col">Bem. Getriebe</th>
                    <th scope="col">Bem. Flansch</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($getriebeObjects) > 0)
                @foreach($getriebeObjects as $getriebe)
                <tr>
                    <td style=min-width:50px>{{ $getriebe->id }}</td>
                    <td style=min-width:250px>{{ $getriebe->motorGetriebename }}</td>
                    <td style=min-width:150px>{{ $getriebe->motorname }}</td>
                    <td style=min-width:150px>{{ $getriebe->motorGetriebeArt }}</td>
                    <td style=min-width:150px>{{ $getriebe->untersetzungszahl }}</td>
                    <td style=min-width:100px>{{ Str::limit($getriebe->bemerkung_getriebe,15,'...siehe bearbeiten') }}</td>
                    <td style=min-width:100px>{{ Str::limit($getriebe->bemerkung_flansch,15,'...siehe bearbeiten') }}</td>
                    <td style=min-width:100px>
                        @if($getriebe->updated_at > $getriebe->created_at) 
                            geändert: {{ $getriebe->updated_at }} / {{ $getriebe->username }}
                        @else
                            erstellt: {{ $getriebe->created_at }} / {{ $getriebe->username }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/motorGetriebe/{{$getriebe->id}}/edit" class="btn btn-primary">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td style=min-width:100px>
                        <a href="/motorGetriebe/{{$getriebe->id}}" class="btn btn-default">
                            <span class="oi" data-glyph="layers" title="dublizieren" aria-hidden="true">
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['MotorGetriebeController@destroy', $getriebe->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Getriebes [$getriebe->name] .&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $getriebeObjects->appends(request()->query())->links() }}
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
