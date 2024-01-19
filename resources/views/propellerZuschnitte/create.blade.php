@extends('layouts.app')

@section('content')
    <h1>Neuen Propeller Zuschnitt AH 015</h1>
    <a href="/propellerZuschnitte" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => 'PropellerZuschnitteController@store', 'method' => 'POST']) !!}
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="alert alert-success print-success-msg" style="display:none">
                <ul></ul>
            </div>

            {{Form::label('geometrieklasse','Propeller Geometrie Klasse:',['class' => 'col-sm-4 col-form-label'])}}
            <div class="col-2 mb-3">            
                <select class="form-control" name="propellerGeometrieklasse_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($propellerGeometrieklassen as $propellerGeometrieklasse)
                    <option value="{{ $propellerGeometrieklasse->id }}" {{ old('propellerGeometrieklasse_id') == $propellerGeometrieklasse->id ? 'selected' : '' }}>{{ $propellerGeometrieklasse->name }}</option>
                    @endforeach
                </select>
            </div>



            {{Form::label('ausfuehrung','Ausführung:',['class' => 'col-sm-4 col-form-label'])}}
            <div class="col-2 mb-3">            
                <select class="form-control" name="propellerAusfuehrung_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($propellerAusfuehrungen as $propellerAusfuehrung)
                    <option value="{{ $propellerAusfuehrung->id }}" {{ old('propellerAusfuehrung_id') == $propellerAusfuehrung->id ? 'selected' : '' }}>{{ $propellerAusfuehrung->name }}</option>
                    @endforeach
                </select>
            </div>

            {{Form::label('typen','Propellertypen:',['class' => 'col-sm-4 col-form-label'])}}
            <div class="col-2 mb-3">
                {{Form::text('typen','', ['class' => 'form-control','placeholder' =>'Bsp.: -GML-GMM-GMZ-'])}}
            </div>

            {{Form::label('durchmesserMin','Durchmesser Min [m]',['class' => 'col-sm-4 col-form-label'])}}
            <div class="col-2">
                {{Form::number('durchmesserMin','', ['class' => 'form-control','step' => '0.1','min' => '0.5', 'max' => '3.0'])}}
            </div>

            {{Form::label('durchmesserMax','Durchmesser Max [m]',['class' => 'col-sm-4 col-form-label'])}}
            <div class="col-2">
                {{Form::number('durchmesserMax','', ['class' => 'form-control','step' => '0.1','min' => '0.5', 'max' => '3.0'])}}
            </div>

            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection