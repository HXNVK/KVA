@extends('layouts.app')

@section('content')
<a href="/propellerModellBlaetter" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Neues Blattmodell</h1>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => 'PropellerModellBlaetterController@store', 'method' => 'POST']) !!}
            <div class="form-group row">
                {{Form::label('name','B',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col">
                    <select class="form-control col-sm-1" name="propeller_klasse_design_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerKlasseDesigns as $propellerKlasseDesign)
                        <option value="{{ $propellerKlasseDesign->id }}" {{ old('propeller_klasse_design_id') == $propellerKlasseDesign->id ? 'selected' : '' }}>{{ $propellerKlasseDesign->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control col-sm-1" name="propeller_drehrichtung_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerDrehrichtungen as $propellerDrehrichtung)
                        <option value="{{ $propellerDrehrichtung->id }}" {{ old('propeller_drehrichtung_id') == $propellerDrehrichtung->id ? 'selected' : '' }}>{{ $propellerDrehrichtung->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control col-sm-2" name="propeller_modell_blatt_typ_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerModellBlattTypen as $propellerModellBlattTyp)
                        <option value="{{ $propellerModellBlattTyp->id }}" {{ old('propeller_modell_blatt_typ_id') == $propellerModellBlattTyp->id ? 'selected' : '' }}>{{ $propellerModellBlattTyp->name }} ({{ $propellerModellBlattTyp->name_alt }})</option>
                        @endforeach
                    </select>
                    <select class="form-control col-sm-1" name="propeller_vorderkanten_typ_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerVorderkantenTypen as $propellerVorderkantenTyp)
                        <option value="{{ $propellerVorderkantenTyp->id }}" {{ old('propeller_vorderkanten_typ_id') == $propellerVorderkantenTyp->id ? 'selected' : '' }}>{{ $propellerVorderkantenTyp->text }} ({{$propellerVorderkantenTyp->kommentar}})</option>
                        @endforeach
                    </select>
                    <select class="form-control col-sm-2" name="propeller_modell_blatt_logo_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerLogoTypen as $propellerLogoTyp)
                        <option value="{{ $propellerLogoTyp->id }}" {{ old('propeller_modell_blatt_logo_id') == $propellerLogoTyp->id ? 'selected' : '' }}>{{ $propellerLogoTyp->name }} ({{$propellerLogoTyp->text}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="propeller_modell_kompatibilitaet_id" class="col-sm-1 col-form-label">Kompatibilitaet</label>
                <div class="col-sm-2">
                    <select class="form-control" name="propeller_modell_kompatibilitaet_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
                        <option value="{{ $propellerModellKompatibilitaet->id }}" {{ old('propeller_modell_kompatibilitaet_id') == $propellerModellKompatibilitaet->id ? 'selected' : '' }}>{{ $propellerModellKompatibilitaet->name }} mit RPS: {{ $propellerModellKompatibilitaet->rps }}mm</option>
                        @endforeach
                    </select>            
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('bereichslaenge','Bereichslänge [mm]',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-2">
                    {{Form::number('bereichslaenge','', ['class' => 'form-control','step' => '1', 'min' => '1', 'placeholder' =>'Bsp.: 450'])}} (i.d.R. = Durchmesser / 2 - RPS)
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('pitch_mitte','Pitch Mitte Po [mm]',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-1">
                    {{Form::number('pitch_mitte','', ['class' => 'form-control','step' => '1','placeholder' =>'Bsp.: 725'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('pitch_aussen','Pitch Aussen Pr [mm]',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-1">
                    {{Form::number('pitch_aussen','', ['class' => 'form-control','step' => '1','placeholder' =>'Bsp.: 725'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('pitch_75','Pitch 75%R [mm]',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-1">
                    {{Form::number('pitch_75','', ['class' => 'form-control','step' => '1','placeholder' =>'Bsp.: 652'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('winkel','Basis-Winkel',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-1">
                    {{Form::number('winkel','', ['class' => 'form-control','step' => '0.5','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 8'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('profil_laenge_75','Profillaenge 75%R [mm]',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-1">
                    {{Form::number('profil_laenge_75','', ['class' => 'form-control', 'step' => '0.1', 'min' => '1', 'max' => '500', 'placeholder' =>'Bsp.: 116'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('profil_laenge','normierte Profillaenge',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-1">
                    {{Form::number('profil_laenge','', ['class' => 'form-control', 'step' => '0.1', 'min' => '0.1', 'max' => '1', 'placeholder' =>'Bsp.: 1'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('zoom_faktor','Zoom Faktor',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-1">
                    {{Form::number('zoom_faktor','', ['class' => 'form-control','step' => '0.001', 'min' => '0.001', 'placeholder' =>'Bsp.: 1'])}}
                </div>
            </div>
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