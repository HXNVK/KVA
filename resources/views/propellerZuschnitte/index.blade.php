@extends('layouts.app')

@section('content')
    <h1>Propeller Zuschnitte</h1>
    <a href="/propellerZuschnitte/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-2">
            {!! Form::open(['url' => '/propellerZuschnitte/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}  
            <br>  
        </div>
        <div class="col-md-2">
            <a href="/propellerZuschnitte/" class="btn btn-xs btn-warning">Reset</a>
            <br>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('name','Name')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Bezeichnung</th>
                    <th scope="col">Typen</th>
                    <th scope="col">Durchmesser Min [m] </th>
                    <th scope="col">Durchmesser Max [m] </th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerZuschnitte) > 0)
                @foreach($propellerZuschnitte as $propellerZuschnitt)
                <tr>
                    <td style=min-width:150px>{{ $propellerZuschnitt->name }}</td>
                    <td style=min-width:100px>{{ $propellerZuschnitt->bezeichnung }}</td>
                    <td style=min-width:100px>{{ $propellerZuschnitt->typen }}</td>
                    <td style=min-width:100px>{{ $propellerZuschnitt->durchmesser_min }}</td>
                    <td style=min-width:100px>{{ $propellerZuschnitt->durchmesser_max }}</td>
                    <td style=min-width:100px>
                        @if($propellerZuschnitt->updated_at > $propellerZuschnitt->created_at) 
                            geändert: {{ $propellerZuschnitt->updated_at }} / {{ $propellerZuschnitt->user->name }}
                        @else
                            erstellt: {{ $propellerZuschnitt->created_at }} / {{ $propellerZuschnitt->user->name }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/propellerZuschnitte/{{$propellerZuschnitt->id}}/edit" class="btn btn-primary">
                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['PropellerZuschnitteController@destroy', $propellerZuschnitt->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Zuschnittplans $propellerZuschnitt->name.&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $propellerZuschnitte->appends(request()->query())->links() }}
        </table>
    </div>
@endsection
