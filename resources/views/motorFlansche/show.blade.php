@extends('layouts.app')

@section('content')
<a href="/motorFlansche" class="btn btn-success">
    <span class="oi" data-glyph="home" title="Dashboard Motor" aria-hidden="true"></span>
</a>
<h1>Motorflansch {{ $motorFlansch->name }} dublizieren</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                {!! Form::open(['action' => 'MotorFlanscheController@store', 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{Form::label('name','Name',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8 text-muted">
                            {{Form::text('name',$motorFlansch->name, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('name_zusatz','Name Zusatz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8 text-muted">
                            {{Form::text('name_zusatz',$motorFlansch->name_zusatz, ['class' => 'form-control', 'placeholder' =>'Bsp.: Standard'])}}
                        </div>
                    </div>
                        <div class="form-group row">
                            <label for="motor_id" class="col-sm-3 col-form-label">Motor</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="motor_id">
                                    <option value="{{ $motorFlansch->motor->id }}">{{ $motorFlansch->motor->name }}</option>
                                    @foreach($motoren as $motor)
                                    <option value="{{ $motor->id }}" {{ old('motor_id') == $motor->id ? 'selected' : '' }}>{{ $motor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <div class="form-group row">
                        {{Form::label('anzahl_schrauben','Anzahl Schrauben',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            <div class="col-3">
                                @if($motorFlansch->anzahl_schrauben == '4')
                                    4 {{Form::radio('anzahl_schrauben','4', true, ['checked' => 'checked'])}}
                                @else
                                    4 {{Form::radio('anzahl_schrauben','4', false, [])}}
                                @endif
                            </div>
                            <div class="col-3">
                                @if($motorFlansch->anzahl_schrauben == '6')
                                    6 {{Form::radio('anzahl_schrauben','6', true, ['checked' => 'checked'])}}
                                @else
                                    6 {{Form::radio('anzahl_schrauben','6', false, [])}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('schraubengroesse','Schraubengröße',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            <div class="col-3">
                                @if($motorFlansch->schraubengroesse == 'M4')
                                    M4 {{Form::radio('schraubengroesse','M4', true, ['checked' => 'checked'])}}
                                @else
                                    M4 {{Form::radio('schraubengroesse','M4', false, [])}}
                                @endif
                            </div>
                            <div class="col-3">
                                @if($motorFlansch->schraubengroesse == 'M5')
                                    M5 {{Form::radio('schraubengroesse','M5', true, ['checked' => 'checked'])}}
                                @else
                                    M5 {{Form::radio('schraubengroesse','M5', false, [])}}
                                @endif
                            </div>
                            <div class="col-3">
                                @if($motorFlansch->schraubengroesse == 'M6')
                                    M6 {{Form::radio('schraubengroesse','M6', true, ['checked' => 'checked'])}}
                                @else
                                    M6 {{Form::radio('schraubengroesse','M6', false, [])}}
                                @endif
                            </div>
                            <div class="col-3">
                                @if($motorFlansch->schraubengroesse == 'M8')
                                    M8 {{Form::radio('schraubengroesse','M8', true, ['checked' => 'checked'])}}
                                @else
                                    M8 {{Form::radio('schraubengroesse','M8', false, [])}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('mitnehmerzapfen_durchmesser','Mitnehmerzapfer [mm]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('mitnehmerzapfen_durchmesser',$motorFlansch->mitnehmerzapfen_durchmesser, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '16', 'placeholder' =>'Bsp.: 13'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('teilkreis_durchmesser','TK [mm]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('teilkreis_durchmesser',$motorFlansch->teilkreis_durchmesser, ['class' => 'form-control','step' => '0.1','min' => '30', 'max' => '200', 'placeholder' =>'Bsp.: 101.6'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('zentrier_durchmesser','Zentrierung [mm]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('zentrier_durchmesser',$motorFlansch->zentrier_durchmesser, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '47', 'placeholder' =>'Bsp.: 47'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('zentrier_hoehe','Höhe Zentrierung [mm]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('zentrier_hoehe',$motorFlansch->zentrier_hoehe, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '10', 'placeholder' =>'Bsp.: 5'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="andruckplatten_id" class="col-sm-3 col-form-label">Andruckplatte</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="andruckplatten_id">
                                <option value="{{ $motorFlansch->artikel07AP->id }}">{{ $motorFlansch->artikel07AP->name }}</option>
                                @foreach($andruckplatten as $andruckplatte)
                                <option value="{{ $andruckplatte->id }}" {{ old('andruckplatten_id') == $andruckplatte->id ? 'selected' : '' }}>{{ $andruckplatte->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('bemerkung_flansch','Bemerkung Flansch',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('bemerkung_flansch',$motorFlansch->bemerkung_flansch, ['class' => 'form-control','rows' => 3, 'placeholder' =>'500 Zeichen für Infos'])}}
                        </div>
                    </div>
                    {{Form::submit('neu abspeichern', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>    
</div>
@endsection