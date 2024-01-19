@extends('layouts.app')

@section('content')
<a href="/propellerFormen" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Neue Propellerform</h1>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => 'PropellerFormenController@store', 'method' => 'POST']) !!}
            <div class="form-group row">
                <label for="propeller_modell_wurzel_id" class="col-sm-1 col-form-label">Alu Modell Wurzel</label>
                <div class="col-sm-2">
                    <select class="form-control" name="propeller_modell_wurzel_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerModellWurzeln as $propellerModellWurzel)
                        <option value="{{ $propellerModellWurzel->id }}" {{ old('propeller_modell_wurzel_id') == $propellerModellWurzel->id ? 'selected' : '' }}>{{ $propellerModellWurzel->name }}</option>
                        @endforeach
                    </select>            
                </div>
            </div>
            <div class="form-group row">
                <label for="propeller_modell_blatt_id" class="col-sm-1 col-form-label">Alu Modell Blatt</label>
                <div class="col-sm-4">
                    <select class="form-control" name="propeller_modell_blatt_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerModellBlaetter as $propellerModellBlatt)
                        <option value="{{ $propellerModellBlatt->id }}" {{ old('propeller_modell_blatt_id') == $propellerModellBlatt->id ? 'selected' : '' }}>{{ $propellerModellBlatt->name }} ({{ $propellerModellBlatt->propellerModellBlattTyp->name_alt }}) / {{ $propellerModellBlatt->propellerModellKompatibilitaet->name }} mit Blatt-Basis-Winkel: {{ $propellerModellBlatt->winkel }}°</option>
                        @endforeach
                    </select>            
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('anzahl','Formenanzahl',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-2">
                    {{Form::number('anzahl','', ['class' => 'form-control','step' => '1', 'min' => '1', 'placeholder' =>' Beispiel: 2'])}}
                </div>
            </div>
            {{-- <div class="form-group row">
                {{Form::label('winkel','abweichender Winkel',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-2">
                    {{Form::number('winkel', '', ['class' => 'form-control','step' => '0.5', 'min' => '3', 'max' => '30', 'placeholder' =>' Beispiel: 8'])}}
                </div>
            </div> --}}
            <div class="form-group row">
                {{Form::label('kommentar','Kommentar',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-2">
                    {{Form::textarea('kommentar','', ['class' => 'form-control','placeholder' =>'100 Zeichen für Infos'])}}
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
        @endsection
    </div>
</div>