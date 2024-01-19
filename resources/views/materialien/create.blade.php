@extends('layouts.app')

@section('content')
<a href="/materialien" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Neues Halbzeug</h1>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => 'MaterialienController@store', 'method' => 'POST']) !!}
            <div class="form-group row">
                {{Form::label('name','Name',['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    {{Form::text('name','', ['class' => 'form-control', 'placeholder' =>'Halbzeugname...'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('name_lang','Name (lang)', ['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    {{Form::text('name_lang','', ['class' => 'form-control', 'placeholder' =>'Halbzeugname mit Details...'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('hersteller','Hersteller',['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    <select class="form-control" name="material_hersteller_id">
                        <option value="" disabled>Bitte wählen</option>
                        <option value="">----</option>
                        @foreach($materialHerstellerObjekte as $materialHersteller)
                        <option value="{{ $materialHersteller->id }}" {{ old('material_hersteller_id') == $materialHersteller->id ? 'selected' : '' }}>{{ $materialHersteller->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('material_gruppe_id','Materialgruppe',['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    <select class="form-control" name="material_gruppe_id">
                        <option value="" disabled>Bitte wählen</option>
                        <option value="">----</option>
                        @foreach($materialGruppen as $materialGruppe)
                        <option value="{{ $materialGruppe->id }}" {{ old('material_gruppe_id') == $materialGruppe->id ? 'selected' : '' }}>{{ $materialGruppe->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('material_typ_id','Materialtyp',['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    <select class="form-control" name="material_typ_id">
                        <option value="" disabled>Bitte wählen</option>
                        <option value="">----</option>
                        @foreach($materialTypen as $materialTyp)
                        <option value="{{ $materialTyp->id }}" {{ old('material_typ_id') == $materialTyp->id ? 'selected' : '' }}>{{ $materialTyp->text }} ({{ $materialTyp->name }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="form-group row">
                {{Form::label('chargennummer',' aktuelle Chargennummer', ['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    {{Form::text('chargennummer','', ['class' => 'form-control', 'placeholder' =>'Bsp.: 123/21'])}}
                </div>
            </div> --}}
            <div class="form-group row">
                {{Form::label('flaechengewicht','Flächengewicht [g/m^2]', ['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    {{Form::number('flaechengewicht','', ['class' => 'form-control','step' => '1', 'min' => '50', 'max' => '1500', 'placeholder' =>'Bsp.: 240'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('kommentar','Kommentar',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-2">
                    {{Form::textarea('kommentar','', ['class' => 'form-control','rows' => 4, 'cols' => 20, 'placeholder' =>'100 Zeichen für Infos'])}}
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
        @endsection
    </div>
</div>
