@extends('layouts.app')

@section('content')
<a href="/propellerModellBlaetter" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Blattmodell duplizieren</h1>

{!! Form::open(['action' => 'PropellerModellBlaetterController@store', 'method' => 'POST']) !!}
    <div class="form-group">
        {{Form::label('name','B')}}
        <select class="form-group" name="propeller_klasse_design_id">
            <option value="{{ $propellerModellBlatt->propellerKlasseDesign->id }}">{{ $propellerModellBlatt->propellerKlasseDesign->name }}</option>
            @foreach($propellerKlasseDesigns as $propellerKlasseDesign)
            <option value="{{ $propellerKlasseDesign->id }}" {{ old('propeller_klasse_design_id') == $propellerKlasseDesign->id ? 'selected' : '' }}>{{ $propellerKlasseDesign->name }}</option>
            @endforeach
        </select>
        {{ number_format(2*($propellerModellBlatt->propellerModellKompatibilitaet->rps + $propellerModellBlatt->bereichslaenge)/1000,2) }}m
        <select class="form-group" name="propeller_drehrichtung_id">
            <option value="{{ $propellerModellBlatt->propellerDrehrichtung->id }}">{{ $propellerModellBlatt->propellerDrehrichtung->name }}</option>
            @foreach($propellerDrehrichtungen as $propellerDrehrichtung)
            <option value="{{ $propellerDrehrichtung->id }}" {{ old('propeller_drehrichtung_id') == $propellerDrehrichtung->id ? 'selected' : '' }}>{{ $propellerDrehrichtung->name }}</option>
            @endforeach
        </select>
        <select class="form-group" name="propeller_modell_blatt_typ_id">
            <option value="{{ $propellerModellBlatt->propellerModellBlattTyp->id }}">{{ $propellerModellBlatt->propellerModellBlattTyp->name }} ({{ $propellerModellBlatt->propellerModellBlattTyp->name_alt }}) </option>
            @foreach($propellerModellBlattTypen as $propellerModellBlattTyp)
            <option value="{{ $propellerModellBlattTyp->id }}" {{ old('propeller_modell_blatt_typ_id') == $propellerModellBlattTyp->id ? 'selected' : '' }}>{{ $propellerModellBlattTyp->name }} ({{ $propellerModellBlattTyp->name_alt }})</option>
            @endforeach
        </select>
        <select class="form-group" name="propeller_vorderkanten_typ_id">
            <option value="{{ $propellerModellBlatt->propellerVorderkantenTyp->id }}">{{ $propellerModellBlatt->propellerVorderkantenTyp->text }}</option>
            @foreach($propellerVorderkantenTypen as $propellerVorderkantenTyp)
            <option value="{{ $propellerVorderkantenTyp->id }}" {{ old('propeller_vorderkanten_typ_id') == $propellerVorderkantenTyp->id ? 'selected' : '' }}>{{ $propellerVorderkantenTyp->text }} ({{$propellerVorderkantenTyp->kommentar}})</option>
            @endforeach
        </select>
        <select class="form-group" name="propeller_modell_blatt_logo_id">
            @if($propellerModellBlatt->propeller_modell_blatt_logo_id == NULL)
                <option value="1">NA (kein Logo)</option>
            @else
                <option value="{{ $propellerModellBlatt->propellerModellBlattLogo->id }}">{{ $propellerModellBlatt->propellerModellBlattLogo->name }}</option>
            @endif
            @foreach($propellerLogoTypen as $propellerLogoTyp)
            <option value="{{ $propellerLogoTyp->id }}" {{ old('propeller_modell_blatt_logo_id') == $propellerLogoTyp->id ? 'selected' : '' }}>{{ $propellerLogoTyp->name }} ({{$propellerLogoTyp->text}})</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="propeller_modell_kompatibilitaet_id">Kompatibilitaet</label>
        <select class="form-group" name="propeller_modell_kompatibilitaet_id">
            <option value="{{ $propellerModellBlatt->propellerModellKompatibilitaet->id }}">{{ $propellerModellBlatt->propellerModellKompatibilitaet->name }} mit RPS: {{ $propellerModellBlatt->propellerModellKompatibilitaet->rps }}mm</option>
            @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
            <option value="{{ $propellerModellKompatibilitaet->id }}">{{ $propellerModellKompatibilitaet->name }} mit RPS: {{ $propellerModellKompatibilitaet->rps }}mm</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        {{Form::label('bereichslaenge','Bereichslänge')}}
        {{Form::number('bereichslaenge',$propellerModellBlatt->bereichslaenge, ['class' => 'form-controll','step' => '1', 'min' => '1', 'placeholder' =>'450'])}} (i.d.R. = Durchmesser / 2 - RPS)
    </div>
    <div class="form-group">
        {{Form::label('pitch_mitte','Pitch Mitte Po')}}
        {{Form::number('pitch_mitte',$propellerModellBlatt->pitch_mitte, ['class' => 'form-controll','step' => '1', 'min' => '15','placeholder' =>'725'])}}
    </div>
    <div class="form-group">
        {{Form::label('pitch_aussen','Pitch Aussen Pr')}}
        {{Form::number('pitch_aussen',$propellerModellBlatt->pitch_aussen, ['class' => 'form-controll','step' => '1', 'min' => '3','placeholder' =>'725'])}}
    </div>
    <div class="form-group row">
        {{Form::label('pitch_75','Pitch 75%R [mm]',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('pitch_75',$propellerModellBlatt->pitch_75, ['class' => 'form-control','step' => '1','placeholder' =>'Bsp.: 652'])}}
        </div>
    </div>
    <div class="form-group">
        {{Form::label('winkel','Basis-Winkel')}}
        {{Form::number('winkel',$propellerModellBlatt->winkel, ['class' => 'form-controll','step' => '0.5', 'min' => '3', 'max' => '30', 'placeholder' =>'8'])}}
    </div>

    <div class="form-group">
        {{Form::label('profil_laenge','normierte Profillaenge')}}
        {{Form::number('profil_laenge',$propellerModellBlatt->profil_laenge, ['class' => 'form-controll', 'step' => '0.1', 'min' => '0.1', 'max' => '1', 'placeholder' =>'1'])}}
    </div>
    <div class="form-group">
        {{Form::label('zoom_faktor','Zoom Faktor')}}
        {{Form::text('zoom_faktor',$propellerModellBlatt->zoom_faktor, ['class' => 'form-controll','step' => '0.001','placeholder' =>'1'])}}
    </div>
    <div class="form-group">
        {{Form::label('kommentar','Kommentar')}}
        {{Form::textarea('kommentar',$propellerModellBlatt->kommentar, ['class' => 'form-controll','placeholder' =>'100 Zeichen für Infos'])}}
    </div>
{{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
@endsection