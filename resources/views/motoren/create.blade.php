@extends('layouts.app')

@section('content')
<a href="/motoren" class="btn btn-success">
    <span class="oi" data-glyph="home" title="Dashboard Motor" aria-hidden="true"></span>
</a>
@if(isset($kunde_id))
    <h1>Motor neu anlegen für {{ $kunde->matchcode }} [{{ $kunde->name1 }}]</h1>
@else
    <h1>Motor neu anlegen</h1>
@endif
<div class="row">
    <div class="col">
    {!! Form::open(['action' => 'MotorenController@store', 'method' => 'POST']) !!}
    <div class="form-group row">
        <label for="kunde_id" class="col-sm-1 col-form-label">Hersteller</label>
        @if(isset($kunde_id))
            <div class="col-sm-2">
                {{Form::text('kunde_id',$kunde_id, ['class' => 'form-control','readonly' => 'true'])}}
            </div>
        @else
            <div class="col-sm-2">
                <select class="form-control" name="kunde_id">
                    <option value="" disabled>Bitte wählen</option>
                    <option value="">----</option>
                    @foreach($kunden as $kunde)
                    <option value="{{ $kunde->id }}" {{ old('kunde_id') == $kunde->id ? 'selected' : '' }}>{{ $kunde->matchcode }} / {{ $kunde->name1 }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
    <div class="form-group row">
        {{Form::label('name','Motorname',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-2">
            {{Form::text('name','', ['class' => 'form-control','placeholder' =>'Bsp.: 915iS'])}}
        </div>
        @if ($errors->has('name'))
            <span class="text-danger">Motorname fehlt</span>
        @endif
    </div>
    <div class="form-group row">
        <label for="motor_arbeitsweise_id" class="col-sm-1 col-form-label">Arbeitsweise</label>
        <div class="col-sm-2">
            <select class="form-control" name="motor_arbeitsweise_id">
                <option value="" disabled>Bitte wählen</option>
                <option value="">----</option>
                @foreach($motorArbeitsweisen as $motorArbeitsweise)
                <option value="{{ $motorArbeitsweise->id }}" {{ old('motor_arbeitsweise_id') == $motorArbeitsweise->id ? 'selected' : '' }}>{{ $motorArbeitsweise->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="motor_status_id" class="col-sm-1 col-form-label">Status</label>
        <div class="col-sm-2">
            <select class="form-control" name="motor_status_id">
                <option value="" disabled>Bitte wählen</option>
                <option value="">----</option>
                @foreach($motorStatusObjects as $motorStatus)
                <option value="{{ $motorStatus->id }}" {{ old('motor_status_id') == $motorStatus->id ? 'selected' : '' }}>{{ $motorStatus->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="projekt_geraeteklasse_id" class="col-sm-1 col-form-label">Geräteklasse</label>
        <div class="col-sm-2">
            <select class="form-control" name="projekt_geraeteklasse_id">
                <option value="" disabled>Bitte wählen</option>
                <option value="">----</option>
                @foreach($projektGeraeteklassen as $projektGeraeteklasse)
                <option value="{{ $projektGeraeteklasse->id }}" {{ old('projekt_geraeteklasse_id') == $projektGeraeteklasse->id ? 'selected' : '' }}>{{ $projektGeraeteklasse->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="motor_typ_id" class="col-sm-1 col-form-label">Typ</label>
        <div class="col-sm-2">
            <select class="form-control" name="motor_typ_id">
                <option value="" disabled>Bitte wählen</option>
                <option value="">----</option>
                @foreach($motorTypen as $motorTyp)
                <option value="{{ $motorTyp->id }}" {{ old('motor_typ_id') == $motorTyp->id ? 'selected' : '' }}>{{ $motorTyp->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="motor_kupplung_id" class="col-sm-1 col-form-label">Kupplung</label>
        <div class="col-sm-2">
            <select class="form-control" name="motor_kupplung_id">
                <option value="" disabled>Bitte wählen</option>
                <option value="">----</option>
                @foreach($motorKupplungen as $motorKupplung)
                <option value="{{ $motorKupplung->id }}" {{ old('motor_kupplung_id') == $motorKupplung->id ? 'selected' : '' }}>{{ $motorKupplung->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="motor_kuehlung_id" class="col-sm-1 col-form-label">Kühlung</label>
        <div class="col-sm-2">
            <select class="form-control" name="motor_kuehlung_id">
                <option value="" disabled>Bitte wählen</option>
                <option value="">----</option>
                @foreach($motorKuehlungen as $motorKuehlung)
                <option value="{{ $motorKuehlung->id }}" {{ old('motor_kuehlung_id') == $motorKuehlung->id ? 'selected' : '' }}>{{ $motorKuehlung->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="motor_drehrichtung_id" class="col-sm-1 col-form-label">Drehrichtung</label>
        <div class="col-sm-2">
            <select class="form-control" name="motor_drehrichtung_id">
                <option value="" disabled>Bitte wählen</option>
                <option value="">----</option>
                @foreach($motorDrehrichtungen as $motorDrehrichtung)
                <option value="{{ $motorDrehrichtung->id }}" {{ old('motor_drehrichtung_id') == $motorDrehrichtung->id ? 'selected' : '' }}>{{ $motorDrehrichtung->text }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('zylinderanzahl','Zylinderanzahl',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('zylinderanzahl','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '12', 'placeholder' =>'Bsp.: 4'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('hubraum','Hubraum [ccm]',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('hubraum','', ['class' => 'form-control','step' => '1','min' => '50', 'max' => '6000', 'placeholder' =>'Bsp.: 1220'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('bohrung','Bohrung [mm]',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('bohrung','', ['class' => 'form-control','step' => '0.1','min' => '40', 'max' => '300', 'placeholder' =>'Bsp.: 65'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('hub','Hub [mm]',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('hub','', ['class' => 'form-control','step' => '0.1','min' => '40', 'max' => '100', 'placeholder' =>'Bsp.: 75'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('nenndrehzahl','Nenndrehzahl [U/min]',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('nenndrehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '20000', 'placeholder' =>'Bsp.: 5800'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('nennleistung','Nennleistung [kW]',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('nennleistung','', ['class' => 'form-control','step' => '0.1','min' => '2', 'max' => '200', 'placeholder' =>'Bsp.: 74'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('realleistung','Realleistung [kW]',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('realleistung','', ['class' => 'form-control','step' => '0.1','min' => '2', 'max' => '200', 'placeholder' =>'Bsp.: 70'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('revision','Revision / Baujahr',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::number('revision','', ['class' => 'form-control','step' => '1','min' => '1950', 'placeholder' =>'Bsp.: 2020'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('kennlinie','Kennlinie vorhanden',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::checkbox('kennlinie', '1',false)}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('kraftstoffZufuhr','Kraftstoff Zufuhr',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-1">
            {{Form::radio('kraftstoffZufuhr', 'Vergaser')}} Vergaser<br>
            {{Form::radio('kraftstoffZufuhr', 'Einspritzung')}} Einspritzung<br>
            {{Form::radio('kraftstoffZufuhr', 'keine')}} keine -> Elektro<br>
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('vergaserInfo','Vergaser-information',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-2">
            {{Form::textarea('vergaserInfo','', ['class' => 'form-control', 'rows' => 2 , 'cols' => 5, 'placeholder' =>'100 Zeichen für Infos'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('notiz','Notiz',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-2">
            {{Form::textarea('notiz','', ['class' => 'form-control','rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
        </div>
    </div>
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    @endsection
    </div>
</div>