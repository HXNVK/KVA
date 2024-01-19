@extends('layouts.app')

@section('content')
<a href="/kunden/{{$kunde_id}}" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<h1>Neuen Kontakt anlegen</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4 class="card-title mb-4">Kontaktdaten</h4>
                </div>
                {!! Form::open(['action' => ['KundeKontaktpersonenController@store', $kunde_id], 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{Form::label('id','Kunden ID',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('id', $kunde_id, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>       
                    <div class="form-group row">
                        <label for="kunde_kontaktperson_anrede_id" class="col-sm-4 col-form-label">Typ</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="kunde_kontaktperson_anrede_id">
                                <option value="" disabled>Bitte wählen</option>
                                @foreach($kundeKontaktpersonAnreden as $kundeKontaktpersonAnrede)
                                <option value="{{ $kundeKontaktpersonAnrede->id }}" {{ old('kunde_kontaktperson_anrede_id') == $kundeKontaktpersonAnrede->id ? 'selected' : '' }}>{{ $kundeKontaktpersonAnrede->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('vorname','Vorname',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('vorname',$kunde->name2, ['class' => 'form-control','placeholder' =>'Bsp.: Max'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('nachname','Nachname',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('nachname',$kunde->name1, ['class' => 'form-control','placeholder' =>'Bsp.: Mustermann'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kunde_kontaktperson_position_id" class="col-sm-4 col-form-label">Position / Abteilung</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="kunde_kontaktperson_position_id">
                                <option value="" disabled>Bitte wählen</option>
                                @foreach($kundeKontaktpersonPositionen as $kundeKontaktpersonPosition)
                                <option value="{{ $kundeKontaktpersonPosition->id }}" {{ old('kunde_kontaktperson_position_id') == $kundeKontaktpersonPosition->id ? 'selected' : '' }}>{{ $kundeKontaktpersonPosition->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('buero','Tel. Büro',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('buero','', ['class' => 'form-control','placeholder' =>'Bsp.: Telefonnummer Büro'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('mobile','Tel. Mobil',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('mobile','', ['class' => 'form-control','placeholder' =>'Bsp.: Telefonnummer Mobil'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('email','Email',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('email','', ['class' => 'form-control','placeholder' =>'Bsp.: info@helix-propeller.de'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz','', ['class' => 'form-control','rows' => 2, 'cols' => 50, 'placeholder' =>'100 Zeichen für Infos'])}}
                        </div>
                    </div>
                    {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection