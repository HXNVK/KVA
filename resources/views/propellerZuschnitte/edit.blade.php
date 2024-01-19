@extends('layouts.app')

@section('content')
    <a href="/propellerZuschnitte" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <h1>Propeller Zuschnitt >>>{{ $propellerZuschnitt->name }}<<<</h1>
    <h3>Zuschnitt für ein Blatt {{ $propellerZuschnitt->typen }}</h3>
    {!! Form::open(['action' => ['PropellerZuschnitteController@update', $propellerZuschnitt->id], 'method' => 'POST']) !!}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        {{Form::label('geometrieklasse','Propeller Geometrie Klasse:',['class' => 'col-form-label'])}}
                        <select class="form-control" name="propellerGeometrieklasse_id">
                            <option value="{{ $propellerZuschnitt->propellerKlasseGeometrie->id }}">{{ $propellerZuschnitt->propellerKlasseGeometrie->name }}</option>
                            @foreach($propellerGeometrieklassen as $propellerGeometrieklasse)
                            <option value="{{ $propellerGeometrieklasse->id }}" {{ old('propellerGeometrieklasse_id') == $propellerGeometrieklasse->id ? 'selected' : '' }}>{{ $propellerGeometrieklasse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        {{Form::label('name','Zuschnittname:',['class' => 'col-form-label'])}}
                        {{Form::text('name',$propellerZuschnitt->name, ['class' => 'form-control','placeholder' =>'Bsp.: H30F (-GML-GMM-GMZ-)'])}}
                    </div>
                    <div class="col-3">
                        {{Form::label('ausfuehrung','Ausführung:',['class' => 'col-form-label'])}}
                        <select class="form-control" name="propellerAusfuehrung_id">
                            <option value="{{ $propellerZuschnitt->artikel03Ausfuehrung->id }}">{{ $propellerZuschnitt->artikel03Ausfuehrung->name }} ({{ $propellerZuschnitt->artikel03Ausfuehrung->bauweise }})</option>
                            @foreach($propellerAusfuehrungen as $propellerAusfuehrung)
                            <option value="{{ $propellerAusfuehrung->id }}" {{ old('propellerAusfuehrung_id') == $propellerAusfuehrung->id ? 'selected' : '' }}>{{ $propellerAusfuehrung->name }} ({{ $propellerAusfuehrung->bauweise }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    {{Form::label('typen','Propellertypen:',['class' => 'col-sm-1 col-form-label'])}}
                    <div class="col-2 mb-3">
                        {{Form::text('typen',$propellerZuschnitt->typen, ['class' => 'form-control','placeholder' =>'Bsp.: -GML-GMM-GMZ-'])}}
                    </div>
        
                    {{Form::label('durchmesserMin','Durchmesser Min [m]',['class' => 'col-sm-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('durchmesserMin',$propellerZuschnitt->durchmesser_min, ['class' => 'form-control','step' => '0.1','min' => '0.5', 'max' => '3.0'])}}
                    </div>
        
                    {{Form::label('durchmesserMax','Durchmesser Max [m]',['class' => 'col-sm-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('durchmesserMax',$propellerZuschnitt->durchmesser_max, ['class' => 'form-control','step' => '0.1','min' => '0.5', 'max' => '3.0'])}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        {{Form::label('bezeichnung','Bezeichnung:',['class' => 'col-form-label'])}}
                        {{Form::textarea('bezeichnung', $propellerZuschnitt->artikel03Ausfuehrung->bezeichnung, ['class' => 'form-control', 'rows' => 2, 'readonly' => 'true'])}}
                    </div>
                    <div class="col-3">
                        {{Form::label('bauweise','Bauweise:',['class' => 'col-form-label'])}}
                        {{Form::textarea('bauweise', $propellerZuschnitt->artikel03Ausfuehrung->bauweise, ['class' => 'form-control', 'rows' => 2, 'readonly' => 'true'])}}
                    </div>
                    <div class="col-2 mt-5">
                        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
                    </div>
                </div>
            </div>
        </div>
        {{Form::hidden('_method','PUT')}}
        {!! Form::close() !!}
        <br>
        <div class="row">
            <div class="col-sm-2">
                <h4 class="card-title mb-4">Lagen</h4>
            </div>
            <div class="col-sm-2">
                <a href="/propellerZuschnittLagen/create/?propellerZuschnittId={{$propellerZuschnitt->id}}" class="btn btn-success">
                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row col-sm-8">
                            <table class="table table-striped" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Anzahl</th>
                                        <th>Schablone / Zuschnitt-Maße</th>
                                        <th>Bemerkung</th>
                                        <th>Reihenfolge</th>
                                        <th>Sortiernummer</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($propellerZuschnittLagen) > 0)
                                        @foreach($propellerZuschnittLagen as $propellerZuschnittLage)
                                            <tr>
                                                <td>{{$propellerZuschnittLage->material->name_lang}}</td>
                                                <td>{{$propellerZuschnittLage->anzahl}}</td>
                                                <td>{{$propellerZuschnittLage->propellerZuschnittSchablone->name}}</td>
                                                <td>{{$propellerZuschnittLage->bemerkung}}</td>
                                                <td>{{$propellerZuschnittLage->reihenfolge}}</td>
                                                <td>{{$propellerZuschnittLage->sortiernummer}}</td>
                                                <td>
                                                    <a href="/propellerZuschnittLagen/{{$propellerZuschnittLage->id}}/edit" class="btn btn-warning">
                                                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {!! Form::open(['action' => ['PropellerZuschnittLagenController@destroy', $propellerZuschnittLage->id, 'name' => 'remove'], 'method' => 'POST']) !!}
                                                    {{Form::hidden('_method','DELETE')}}
                                                    {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen der Zuschnittlage ".$propellerZuschnittLage->material->name_lang." .&quot;)"])}}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p class="text-muted mb-0">Keine Einträge vorhanden.</p>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
@endsection