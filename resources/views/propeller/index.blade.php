@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Propeller</h1>
    <a href="/propeller/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-8">
            Filter:
            <br>
            <a href="/propeller/?artikelkreis=H05" class="btn btn-info mr-4">H05</a>
            <a href="/propeller/?artikelkreis=H10" class="btn btn-info mr-4">H10</a>
            <a href="/propeller/?artikelkreis=H20" class="btn btn-info mr-4">H20</a>
            <a href="/propeller/?artikelkreis=H25" class="btn btn-info mr-4">H25</a>
            <a href="/propeller/?artikelkreis=H30" class="btn btn-info mr-4">H30</a>
            <a href="/propeller/?artikelkreis=H40" class="btn btn-info mr-4">H40</a>
            <a href="/propeller/?artikelkreis=H45" class="btn btn-info mr-4">H45</a>
            <a href="/propeller/?artikelkreis=H50" class="btn btn-info mr-4">H50</a>
            <a href="/propeller/?artikelkreis=H60" class="btn btn-info mr-4">H60</a>
            <a href="/propeller/" class="btn btn-warning">Reset</a>
            <br><br>
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::open(['url' => '/propeller/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}    
        </div>
    </div>
    <button id = "propellerliste" type="button" class="btn btn-info mb-2">Propellerliste</button>
    <div class="row propellerliste">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">name</th>
                    <th scope="col">artikelnummer</th>
                    <th scope="col">Notiz</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerObjects) > 0)
                @foreach($propellerObjects as $propeller)
                <tr>
                    <td style=min-width:50px>{{ $propeller->name }}</td>
                    <td style=min-width:50px>{{ $propeller->artikelnummer }}</td>
                    <td style=min-width:50px>{{ Str::limit($propeller->notiz,15,'...') }}</td>
                    <td style=min-width:50px>
                        @if($propeller->updated_at > $propeller->created_at) 
                            geändert: {{ $propeller->updated_at }} / {{ $propeller->user->name }}
                        @else
                            erstellt: {{ $propeller->created_at }} / {{ $propeller->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/propeller/{{$propeller->id}}/edit" class="btn btn-warning">
                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a></td>
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $propellerObjects->appends(request()->query())->links() }}
        </table>
    </div>
    <script>
        $(document).ready(function() {
            // $("#propellerliste").ready(function(){
            //     $(".propellerliste").toggle();
            // });
            $("#propellerliste").click(function(){
                $(".propellerliste").toggle();
            });
        });
     </script>

@endsection


