@extends('layouts.app')

@section('content')
    <h1>Materialien</h1>
    <a href="/materialien/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <br><br>
    <a href="{{action('MaterialienController@materialienPDF')}}" class="btn btn-warning">PDF 
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="row">
        <div class="col-md-2">
            {!! Form::open(['url' => '/materialien/?', 'method' => 'get']) !!}
            {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Suche...']) !!}
            {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            {!! Form::close() !!}  
            <br>  
        </div>
        <div class="col-md-2">
            <a href="/materialien/" class="btn btn-xs btn-warning">Reset</a>
            <br>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('name','Name')<span class="oi" data-glyph="elevator"></span></th>
                    <th scope="col">Name (lang)</th>
                    <th scope="col">Hersteller</th>
                    <th scope="col">Gruppe</th>
                    <th scope="col">Typ</th>
                    {{-- <th scope="col">aktuelle HC Chargennr.</th> --}}
                    <th scope="col">Flächengewicht [g/m^2 bzw. g/L]</th>
                    <th scope="col">Zugfestigkeit [MPa]</th>
                    <th scope="col">eModul [MPa]</th>
                    <th scope="col">Dichte [g/cm^3]</th>
                    <th scope="col">Bruchdehung [%]</th>
                    <th scope="col">Therm. Ausdehnungskoeff. [10^-6 K^-1]</th>
                    <th scope="col">Kommentar</th>
                    <th scope="col">Eintrag / durch</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($materialien) > 0)
                @foreach($materialien as $material)
                <tr>
                    <td style=min-width:150px>{{ $material->name }}</td>
                    <td style=min-width:150px>{{ $material->name_lang }}</td>
                    <td style=min-width:150px>{{ $material->materialHersteller->name }}</td>
                    <td style=min-width:150px>{{ $material->materialGruppe->name }}</td>
                    <td style=min-width:150px>@if($material->material_typ_id != NULL){{ $material->materialTyp->name }}@endif</td>
                    {{-- <td style=min-width:150px>{{ $material->chargennummer }}</td> --}}
                    <td style=min-width:150px>{{ $material->flaechengewicht }}</td>
                    <td style=min-width:150px>{{ $material->zugfestigkeit }}</td>
                    <td style=min-width:150px>{{ $material->eModul }}</td>
                    <td style=min-width:150px>{{ $material->dichte }}</td>
                    <td style=min-width:150px>{{ $material->bruchdehung }}</td>
                    <td style=min-width:150px>{{ $material->dichteAusdehnungskoeff }}</td>
                    <td style=min-width:100px>{{ $material->kommentar }}</td>
                    <td style=min-width:100px>
                        @if($material->updated_at > $material->created_at) 
                            geändert: {{ $material->updated_at }} / {{ $material->user->name }}
                        @else
                            erstellt: {{ $material->created_at }} / {{ $material->user->name }}
                        @endif
                    </td>
                    <td style=min-width:100px>
                        <a href="/materialien/{{$material->id}}/edit" class="btn btn-primary">
                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['MaterialienController@destroy', $material->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Halbzeugs $material->name.&quot;)"])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $materialien->appends(request()->query())->links() }}
        </table>
    </div>
@endsection
