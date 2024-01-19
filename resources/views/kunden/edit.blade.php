@extends('layouts.app')

@section('content')
    <a href="/kunden/{{$kunde->id}}" class="btn btn-success">
        <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
    </a>
    <h1>Kunde {{ $kunde->matchcode }} [{{ $kunde->name1 }}] bearbeiten</h1>
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h4 class="card-title mb-4">Stammdaten</h4>
                    </div>
                    {!! Form::open(['action' => ['KundenController@update', $kunde->id],'name' => 'updateKunde', 'method' => 'POST']) !!}
                        <div class="form-group row">
                            {{Form::label('lexware_id','MyFactory ID',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('lexware_id',$kunde->lexware_id, ['class' => 'form-control','placeholder' =>'fünfstellige ID'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('matchcode','Matchcode',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('matchcode',$kunde->matchcode, ['class' => 'form-control','placeholder' =>'Bsp.: Helix'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('name1','Firmenname / Nachname',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('name1',$kunde->name1, ['class' => 'form-control','placeholder' =>'Bsp.: Helix-Carbon GmbH'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('name2','Zusatz / Vorname',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('name2',$kunde->name2, ['class' => 'form-control','placeholder' =>'Bsp.: GmbH'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kunde_typ_id" class="col-sm-4 col-form-label">Typ</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="kunde_typ_id">
                                    <option value="{{ $kunde->kundeTyp->id }}">{{ $kunde->kundeTyp->name }}</option>
                                    @foreach($kundeTypen as $kundeTyp)
                                    <option value="{{ $kundeTyp->id }}" {{ old('kunde_typ_id') == $kundeTyp->id ? 'selected' : '' }}>{{ $kundeTyp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kunde_gruppe_id" class="col-sm-4 col-form-label">Gruppe</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="kunde_gruppe_id">
                                    <option value="{{ $kunde->kundeGruppe->id }}">{{ $kunde->kundeGruppe->name }}</option>
                                    @foreach($kundeGruppen as $kundeGruppe)
                                    <option value="{{ $kundeGruppe->id }}" {{ old('kunde_gruppe_id') == $kundeGruppe->id ? 'selected' : '' }}>{{ $kundeGruppe->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kunde_rating_id" class="col-sm-4 col-form-label">Rating</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="kunde_rating_id">
                                    <option value="{{ $kunde->kundeRating->id }}">{{ $kunde->kundeRating->name }}</option>
                                    @foreach($kundeRatingObjects as $kundeRating)
                                    <option value="{{ $kundeRating->id }}" {{ old('kunde_rating_id') == $kundeRating->id ? 'selected' : '' }}>{{ $kundeRating->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kunde_status_id" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="kunde_status_id">
                                    <option value="{{ $kunde->kundeStatus->id }}">{{ $kunde->kundeStatus->name }}</option>
                                    @foreach($kundeStatusObjects as $kundeStatus)
                                    <option value="{{ $kundeStatus->id }}" {{ old('kunde_status_id') == $kundeStatus->id ? 'selected' : '' }}>{{ $kundeStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('checked','Daten geprüft',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                @if($kunde->checked == 1)
                                        {{Form::radio('checked', '1',true)}} 
                                    @else
                                        {{Form::radio('checked', '1',false)}}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('webseite','Webseite',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('webseite',$kunde->webseite, ['class' => 'form-control','placeholder' =>'Bsp.: www.helix-propeller.de'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::textarea('notiz',$kunde->notiz, ['class' => 'form-control','placeholder' =>'100 Zeichen für Infos'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kunde_aufkleber_id" class="col-sm-4 col-form-label">Aufkleber</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="kunde_aufkleber_id">
                                    <option value="{{ $kunde->kundeAufkleber->id }}">{{ $kunde->kundeAufkleber->name }}</option>
                                    @foreach($kundeAufkleberObjects as $kundeAufkleber)
                                    <option value="{{ $kundeAufkleber->id }}" {{ old('kunde_status_id') == $kundeAufkleber->id ? 'selected' : '' }}>{{ $kundeAufkleber->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{Form::hidden('_method','PUT')}}
                        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
@endsection