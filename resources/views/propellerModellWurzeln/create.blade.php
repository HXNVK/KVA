@extends('layouts.app')

@section('content')
<a href="/propellerModellWurzeln" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Neues Wurzelmodell</h1>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => 'PropellerModellWurzelnController@store', 'method' => 'POST']) !!}
            <div class="form-group row">
                {{Form::label('name','W',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col">
                    <select class="form-control col-sm-1" name="propeller_klasse_geometrie_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerKlasseGeometrien as $propellerKlasseGeometrie)
                        <option value="{{ $propellerKlasseGeometrie->id }}" {{ old('propeller_klasse_geometrie_id') == $propellerKlasseGeometrie->id ? 'selected' : '' }}>{{ $propellerKlasseGeometrie->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control col-sm-1" name="propeller_drehrichtung_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerDrehrichtungen as $propellerDrehrichtung)
                        <option value="{{ $propellerDrehrichtung->id }}" {{ old('propeller_drehrichtung_id') == $propellerDrehrichtung->id ? 'selected' : '' }}>{{ $propellerDrehrichtung->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control col-sm-1" name="propeller_modell_kompatibilitaet_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
                        <option value="{{ $propellerModellKompatibilitaet->id }}" {{ old('propeller_modell_kompatibilitaet_id') == $propellerModellKompatibilitaet->id ? 'selected' : '' }}>{{ $propellerModellKompatibilitaet->name }}</option>
                        @endforeach
                    </select>
                    Winkel
                    {{Form::number('winkel', 0, ['class' => 'form-controll','step' => '0.5','min' => '-10', 'max' => '20', 'placeholder' =>'Bsp.: -5'])}}
                    Konuswinkel
                    {{Form::number('konuswinkel','', ['class' => 'form-controll','step' => '1','min' => '1', 'max' => '8', 'placeholder' =>'Bsp.: 4'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('bereichslaenge','Bereichslänge [mm]',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-2">
                    {{Form::number('bereichslaenge','', ['class' => 'form-controll','step' => '1', 'min' => '1', 'placeholder' =>'Bsp.: 150'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('kommentar','Kommentar',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-2">
                    {{Form::textarea('kommentar','', ['class' => 'form-controll','rows' => 4, 'cols' => 20, 'placeholder' =>'100 Zeichen für Infos'])}}
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
        @endsection
    </div>
</div>
