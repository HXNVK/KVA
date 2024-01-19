@extends('layouts.app')

@section('content')
<a href="/propellerModellBlattTypen" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Neuer Typ</h1>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => 'PropellerModellBlattTypenController@store', 'method' => 'POST']) !!}
        <div class="form-group row">
            <label for="propeller_klasse_design_id" class="col-sm-1 col-form-label">T</label>
            <div class="col-sm-2">
                <select class="form-control" name="propeller_klasse_design_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($propellerKlasseDesigns as $propellerKlasseDesign)
                    <option value="{{ $propellerKlasseDesign->id }}" {{ old('propeller_klasse_design_id') == $propellerKlasseDesign->id ? 'selected' : '' }}>{{ $propellerKlasseDesign->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('umrissform','Umrissform',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('umrissform','', ['class' => 'form-control','placeholder' =>'N'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('profilform','Profilform',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('profilform','', ['class' => 'form-control','placeholder' =>'E'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('profillaenge','Profillänge',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('profillaenge','', ['class' => 'form-control','placeholder' =>'Z'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('name_alt','Name (alt)',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('name_alt','', ['class' => 'form-control','placeholder' =>'-'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('freifeld','Freifeld',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('freifeld','', ['class' => 'form-control','placeholder' =>'-'])}}
            </div>
        </div>
        <div class="form-group row">
            <label for="propeller_modell_kompatibilitaet_id" class="col-sm-1 col-form-label">Kompatibilitaet</label>
            <div class="col-sm-2">
                <select class="form-control" name="propeller_modell_kompatibilitaet_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
                    <option value="{{ $propellerModellKompatibilitaet->id }}" {{ old('propeller_modell_kompatibilitaet_id') == $propellerModellKompatibilitaet->id ? 'selected' : '' }}>{{ $propellerModellKompatibilitaet->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('exclusiv','Exclusivität',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::textarea('exclusiv','', ['class' => 'form-control', 'rows' => 2, 'cols' => 50, 'placeholder' =>'-'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('kunde','Kundenbezug',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('kunde','', ['class' => 'form-control','placeholder' =>'-'])}}
            </div>
        </div>
        <div class="form-group row">
            <label for="projektGeraeteklasse" class="col-sm-1 col-form-label">Projekt Geräteklasse</label>
            <div class="col-sm-2">
                <select class="form-control" name="projekt_geraeteklasse_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($projektGeraeteklassen as $projektGeraeteklasse)
                    <option value="{{ $projektGeraeteklasse->id }}" {{ old('projekt_geraeteklasse_id') == $projektGeraeteklasse->id ? 'selected' : '' }}>{{ $projektGeraeteklasse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('kommentar','Kommentar',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::textarea('kommentar','', ['class' => 'form-control', 'rows' => 2, 'cols' => 50, 'placeholder' =>'Kommentar'])}}
            </div> 
        </div>    
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
        @endsection
    </div>
</div>