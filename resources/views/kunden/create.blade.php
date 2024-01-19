@extends('layouts.app')

@section('content')
<div class="row">
    @include('internals.messages')
</div>
<a href="/kunden" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Kunde neu anlegen</h1>
<div class="row">
    <div class="col">
    {!! Form::open(['action' => 'KundenController@store','name' => 'storeKunde', 'method' => 'POST']) !!}
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="card-title mb-4">Kundendaten</h4>
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('lexware_id','MyFactory ID',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::number('lexwareID','', ['class' => 'form-control','placeholder' =>'fünfstellige ID'])}}
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('matchcode','Matchcode',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::text('matchcode','', ['class' => 'form-control','placeholder' =>'Bsp.: Helix'])}}
                    </div>
                    @if ($errors->has('matchcode'))
                        <span class="text-danger">Matchcode eintragen</span>
                    @endif
                </div>
                <div class="form-group row">
                    {{Form::label('name1','Firmenname / Nachname',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::text('name1','', ['class' => 'form-control','placeholder' =>'Bsp.: Helix-Carbon GmbH'])}}
                    </div>
                    @if ($errors->has('name1'))
                        <span class="text-danger">Firmenname oder Nachname eintragen</span>
                    @endif
                </div>
                <div class="form-group row">
                    {{Form::label('name2','Zusatz / Vorname',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::text('name2','', ['class' => 'form-control','placeholder' =>''])}}
                    </div>
                    @if ($errors->has('name2'))
                        <span class="text-danger">Firmenzusatz oder Vorname eintragen</span>
                    @endif
                </div>
                <div class="form-group row">
                    <label for="kunde_typ_id" class="col-sm-4 col-form-label">Typ</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="kunde_typ_id">
                            <option value="" disabled>Bitte wählen</option>
                            @foreach($kundeTypen as $kundeTyp)
                            <option value="{{ $kundeTyp->id }}" {{ old('kunde_typ_id') == $kundeTyp->id ? 'selected' : '' }}>{{ $kundeTyp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kunde_gruppe_id" class="col-sm-4 col-form-label">Gruppe</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="kunde_gruppe_id">
                            <option value="" disabled>Bitte wählen</option>
                            @foreach($kundeGruppen as $kundeGruppe)
                            <option value="{{ $kundeGruppe->id }}" {{ old('kunde_gruppe_id') == $kundeGruppe->id ? 'selected' : '' }}>{{ $kundeGruppe->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#kundeGruppe">
                            <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kunde_rating_id" class="col-sm-4 col-form-label">Rating</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="kunde_rating_id">
                            <option value="" disabled>Bitte wählen</option>
                            @foreach($kundeRatingObjects as $kundeRating)
                            <option value="{{ $kundeRating->id }}" {{ old('kunde_typ_id') == $kundeRating->id ? 'selected' : '' }}>{{ $kundeRating->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#kundeRating">
                            <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kunde_status_id" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="kunde_status_id">
                            <option value="" disabled>Bitte wählen</option>
                            @foreach($kundeStatusObjects as $kundeStatus)
                            <option value="{{ $kundeStatus->id }}" {{ old('kunde_status_id') == $kundeStatus->id ? 'selected' : '' }}>{{ $kundeStatus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('checked','Daten geprüft',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::radio('checked', '1')}}
                    </div>
                    @if ($errors->has('checked'))
                        <span class="text-danger">{{ $errors->first('checked') }}</span>
                    @endif
                </div>
                <div class="form-group row">
                    {{Form::label('webseite','Webseite',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::text('webseite','', ['class' => 'form-control','placeholder' =>'Bsp.: www.helix-propeller.de'])}}
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::textarea('notiz','', ['class' => 'form-control','placeholder' =>'100 Zeichen für Infos'])}}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kunde_aufkleber_id" class="col-sm-4 col-form-label">Aufkleber</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="kunde_aufkleber_id">
                            <option value="" disabled>Bitte wählen</option>
                            @foreach($kundeAufkleberObjects as $kundeAufkleber)
                            <option value="{{ $kundeAufkleber->id }}" {{ old('kunde_status_id') == $kundeAufkleber->id ? 'selected' : '' }}>{{ $kundeAufkleber->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    </div>
</div>

@endsection
@include('kunden.modalKundeGruppe')

@include('kunden.modalKundeRating')