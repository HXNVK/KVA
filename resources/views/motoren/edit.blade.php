@extends('layouts.app')

@section('content')
<a href="/kunden/{{$motor->kunde_id}}" class="btn btn-success">
    <span class="oi" data-glyph="home" title="Dashboard Motor" aria-hidden="true"></span>
</a>
<h1>Motor {{ $motor->name }} bearbeiten von {{ $motor->kunde->matchcode }} [{{ $motor->kunde->name1 }}]</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                {!! Form::open(['action' => ['MotorenController@update', $motor->id], 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{Form::label('kunde_id','Kunden ID',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kunde_id',$motor->kunde->id, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('name','Name',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('name',$motor->name, ['class' => 'form-control','placeholder' =>'Bsp.: 915iS'])}}
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="motor_arbeitsweise_id" class="col-sm-3 col-form-label">Arbeitsweise</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_arbeitsweise_id">
                                <option value="{{ $motor->motorArbeitsweise->id }}">{{ $motor->motorArbeitsweise->name }}</option>
                                @foreach($motorArbeitsweisen as $motorArbeitsweise)
                                <option value="{{ $motorArbeitsweise->id }}" {{ old('motor_arbeitsweise_id') == $motorArbeitsweise->id ? 'selected' : '' }}>{{ $motorArbeitsweise->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="motor_status_id" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_status_id">
                                <option value="{{ $motor->motorStatus->id }}">{{ $motor->motorStatus->name }}</option>
                                @foreach($motorStatusObjects as $motorStatus)
                                <option value="{{ $motorStatus->id }}" {{ old('motor_status_id') == $motorStatus->id ? 'selected' : '' }}>{{ $motorStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="projekt_geraeteklasse_id" class="col-sm-3 col-form-label">Geräteklasse</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="projekt_geraeteklasse_id">
                                <option value="{{ $motor->projektGeraeteklasse->id }}">{{ $motor->projektGeraeteklasse->name }}</option>
                                @foreach($projektGeraeteklassen as $projektGeraeteklasse)
                                <option value="{{ $projektGeraeteklasse->id }}" {{ old('projekt_geraeteklasse_id') == $projektGeraeteklasse->id ? 'selected' : '' }}>{{ $projektGeraeteklasse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="motor_typ_id" class="col-sm-3 col-form-label">Typ</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_typ_id">
                                <option value="{{ $motor->motorTyp->id }}">{{ $motor->motorTyp->name }}</option>
                                @foreach($motorTypen as $motorTyp)
                                <option value="{{ $motorTyp->id }}" {{ old('motor_typ_id') == $motorTyp->id ? 'selected' : '' }}>{{ $motorTyp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="motor_kupplung_id" class="col-sm-3 col-form-label">Kupplung</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_kupplung_id">
                                <option value="{{ $motor->motorKupplung->id }}">{{ $motor->motorKupplung->name }}</option>
                                @foreach($motorKupplungen as $motorKupplung)
                                <option value="{{ $motorKupplung->id }}" {{ old('motor_kupplung_id') == $motorKupplung->id ? 'selected' : '' }}>{{ $motorKupplung->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="motor_kuehlung_id" class="col-sm-3 col-form-label">Kühlung</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_kuehlung_id">
                                <option value="{{ $motor->motorKuehlung->id }}">{{ $motor->motorKuehlung->name }}</option>
                                @foreach($motorKuehlungen as $motorKuehlung)
                                <option value="{{ $motorKuehlung->id }}" {{ old('motor_kuehlung_id') == $motorKuehlung->id ? 'selected' : '' }}>{{ $motorKuehlung->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="motor_drehrichtung_id" class="col-sm-3 col-form-label">Drehrichtung</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_drehrichtung_id">
                                <option value="{{ $motor->motorDrehrichtung->id }}">{{ $motor->motorDrehrichtung->text }}</option>
                                @foreach($motorDrehrichtungen as $motorDrehrichtung)
                                <option value="{{ $motorDrehrichtung->id }}" {{ old('motor_drehrichtung_id') == $motorDrehrichtung->id ? 'selected' : '' }}>{{ $motorDrehrichtung->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('zylinderanzahl','Zylinderanzahl',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('zylinderanzahl',$motor->zylinderanzahl, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '12', 'placeholder' =>'Bsp.: 4'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('hubraum','Hubraum [ccm]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('hubraum',$motor->hubraum, ['class' => 'form-control','step' => '1','min' => '50', 'max' => '6000', 'placeholder' =>'Bsp.: 1220'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('bohrung','Bohrung [mm]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('bohrung',$motor->bohrung, ['class' => 'form-control','step' => '0.1','min' => '40', 'max' => '300', 'placeholder' =>'Bsp.: 65'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('hub','Hub [mm]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('hub',$motor->hub, ['class' => 'form-control','step' => '0.1','min' => '40', 'max' => '100', 'placeholder' =>'Bsp.: 75'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('nenndrehzahl','Nenndrehzahl [U/min]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('nenndrehzahl',$motor->nenndrehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '20000', 'placeholder' =>'Bsp.: 5800'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('nennleistung','Nennleistung [kW]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('nennleistung',$motor->nennleistung, ['class' => 'form-control','step' => '0.1','min' => '2', 'max' => '200', 'placeholder' =>'Bsp.: 74'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('realleistung','Realleistung [kW]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('realleistung',$motor->realleistung, ['class' => 'form-control','step' => '0.1','min' => '2', 'max' => '200', 'placeholder' =>'Bsp.: 70'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('revision','Revision / Baujahr',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('revision',$motor->revision, ['class' => 'form-control','step' => '1','min' => '1950', 'placeholder' =>'Bsp.: 2020'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kennlinie','Kennlinie vorhanden',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            @if($motor->kennlinie == 1)
                                    {{Form::checkbox('kennlinie', '1',true)}} 
                                @else
                                    {{Form::checkbox('kennlinie', '1',false)}}
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kraftstoffZufuhr','Kraftstoff Zufuhr',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            @if($motor->kraftstoffZufuhr == 'Vergaser' || $motor->kraftstoffZufuhr == NULL)
                                {{Form::radio('kraftstoffZufuhr', 'Vergaser', 'checked')}} Vergaser<br>
                                {{Form::radio('kraftstoffZufuhr', 'Einspritzung')}} Einspritzung<br>
                                {{Form::radio('kraftstoffZufuhr', 'keine')}} keine -> Elektro<br>
                            @endif
                            @if($motor->kraftstoffZufuhr == 'Einspritzung')
                                {{Form::radio('kraftstoffZufuhr', 'Vergaser')}} Vergaser<br>
                                {{Form::radio('kraftstoffZufuhr', 'Einspritzung','checked')}} Einspritzung<br>
                                {{Form::radio('kraftstoffZufuhr', 'keine')}} keine -> Elektro<br>
                            @endif
                            @if($motor->kraftstoffZufuhr == 'keine')
                                {{Form::radio('kraftstoffZufuhr', 'Vergaser')}} Vergaser<br>
                                {{Form::radio('kraftstoffZufuhr', 'Einspritzung')}} Einspritzung<br>
                                {{Form::radio('kraftstoffZufuhr', 'keine','checked')}} keine -> Elektro<br>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('vergaserInfo','Vergaserinfo',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('vergaserInfo',$motor->vergaserInfo, ['class' => 'form-control', 'rows' => 2, 'cols' => 10, 'placeholder' =>'100 Zeichen für Infos'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz',$motor->notiz, ['class' => 'form-control','rows' => 4, 'cols' => 10, 'placeholder' =>'100 Zeichen für Infos'])}}
                        </div>
                    </div>
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit('ändern', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>    
</div>
@endsection