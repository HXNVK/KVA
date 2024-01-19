@extends('layouts.app')

@section('content')
    <h1>Material Hersteller</h1>
    <a href="/materialHersteller/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <a href="{{action('MaterialHerstellerController@herstellerPDF')}}" class="btn btn-warning">PDF 
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-2">
            {!! Form::open(['url' => '/materialHersteller/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}  
            <br>  
        </div>
        <div class="col-md-2">
            <a href="/materialHersteller/" class="btn btn-xs btn-warning">Reset</a>
            <br>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('name','Name')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Kommentar</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($materialHerstellerObjekte) > 0)
                @foreach($materialHerstellerObjekte as $materialHersteller)
                <tr>
                    <td style=min-width:150px>{{ $materialHersteller->name }}</td>
                    <td style=min-width:100px>{{ $materialHersteller->kommentar }}</td>
                    <td style=min-width:100px>
                        @if($materialHersteller->updated_at > $materialHersteller->created_at) 
                            geändert: {{ $materialHersteller->updated_at }} / {{ $materialHersteller->user->name }}
                        @else
                            erstellt: {{ $materialHersteller->created_at }} / {{ $materialHersteller->user->name }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/materialHersteller/{{$materialHersteller->id}}/edit" class="btn btn-primary">
                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['MaterialHerstellerController@destroy', $materialHersteller->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Herstellers $materialHersteller->name.&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $materialHerstellerObjekte->appends(request()->query())->links() }}
        </table>
    </div>
@endsection
