@extends('layouts.app')

@section('content')
<a href="/kunden/{{$kunde_id}}" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<h1>Neue Adresse anlegen</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4 class="card-title mb-4">Adressdaten</h4>
                </div>
                {!! Form::open(['action' => ['KundeAdressenController@store', $kunde_id], 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{Form::label('id','Kunden ID',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('id', $kunde_id, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>       
                    <div class="form-group row">
                        <label for="kunde_adresse_typ_id" class="col-sm-4 col-form-label">Typ</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="kunde_adresse_typ_id">
                                <option value="" disabled>Bitte wählen</option>
                                @foreach($kundeAdresseTypen as $kundeAdresseTyp)
                                <option value="{{ $kundeAdresseTyp->id }}" {{ old('kunde_adresse_typ_id') == $kundeAdresseTyp->id ? 'selected' : '' }}>{{ $kundeAdresseTyp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('name1','Firmenname / Nachname',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('name1','', ['class' => 'form-control','placeholder' =>'Bsp.: Musterfirma oder Mustermann'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('name2','Zusatz / Vorname',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('name2','', ['class' => 'form-control','placeholder' =>'Bsp.: GmbH oder Max'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('strasse','Strasse',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('strasse','', ['class' => 'form-control','placeholder' =>'Bsp.: Musterstr. 123'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('postleitzahl','PLZ',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('postleitzahl','', ['class' => 'form-control','placeholder' =>'Bsp.: 123 AB 456'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('stadt','Stadt',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('stadt','', ['class' => 'form-control','placeholder' =>'Bsp.: Musterstadt'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kunde_adresse_land_id" class="col-sm-4 col-form-label">Land</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="kunde_adresse_land_id">
                                <option value="" disabled>Bitte wählen</option>
                                @foreach($kundeAdresseLaender as $kundeAdresseLand)
                                <option value="{{ $kundeAdresseLand->id }}" {{ old('kunde_adresse_land_id') == $kundeAdresseLand->id ? 'selected' : '' }}>{{ $kundeAdresseLand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz','', ['class' => 'form-control','rows' => 4, 'placeholder' =>'50 Zeichen für Infos'])}}
                        </div>
                    </div>

                    {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection