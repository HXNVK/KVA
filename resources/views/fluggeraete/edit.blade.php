@extends('layouts.app')

@section('content')
<div class="row">
    @include('internals.messages')
</div>
<a href="/fluggeraete" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
{!! Form::open(['action' => ['FluggeraeteController@update', $fluggeraet->id], 'method' => 'POST']) !!}
<h1>Stammsatz des Fluggerätes {{ $fluggeraet->name }}{{Form::submit('ändern', ['class'=>'btn btn-primary'])}}</h1>
    <div class="row">
        <!-- start card Projektdaten -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4 class="card-title mb-4">Projektdaten</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('name','Name',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('name',$fluggeraet->name, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('muster','Muster',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('muster',$fluggeraet->muster, ['class' => 'form-control','placeholder' =>'Bsp.: FK9'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('baureihe','Baureihe',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('baureihe',$fluggeraet->baureihe, ['class' => 'form-control','placeholder' =>'Bsp.: MK VI'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hersteller" class="col-sm-3 col-form-label">Hersteller</label>
                        <div class="col-sm-8">
                            {{Form::hidden('hersteller_id',$fluggeraet->kunde->id)}}
                            {{Form::text('hersteller',$fluggeraet->kunde->matchcode, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="motor_ausrichtung_id" class="col-sm-3 col-form-label">Ausrichtung Motor- bzw. Getriebeflansch</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_ausrichtung_id">
                                <option value="{{ $fluggeraet->motorAusrichtung->id }}">{{ $fluggeraet->motorAusrichtung->name }}</option>
                                @foreach($motorAusrichtungen as $motorAusrichtung)
                                <option value="{{ $motorAusrichtung->id }}" {{ old('motorAusrichtung') == $motorAusrichtung->id ? 'selected' : '' }}>{{ $motorAusrichtung->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="projekt_zertifizierung_id" class="col-sm-3 col-form-label">Zertifizierung</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="projekt_zertifizierung_id">
                                <option value="{{ $fluggeraet->projektZertifizierung->id }}">{{ $fluggeraet->projektZertifizierung->name }}</option>
                                @foreach($projektZertifizierungen as $projektZertifizierung)
                                <option value="{{ $projektZertifizierung->id }}" {{ old('projekt_zertifizierung_id') == $projektZertifizierung->id ? 'selected' : '' }}>{{ $projektZertifizierung->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('spannweite','Spannweite [m]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('spannweite',$fluggeraet->spannweite, ['class' => 'form-control','step' => '0.01','min' => '1', 'max' => '25', 'placeholder' =>'Bsp.: 9.5'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('v_max','Vmax [km/h]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('v_max',$fluggeraet->v_max, ['class' => 'form-control','step' => '1','min' => '30', 'max' => '400', 'placeholder' =>'Bsp.: 245'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('v_reise','Vreise [km/h]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('v_reise',$fluggeraet->v_reise, ['class' => 'form-control','step' => '1','min' => '30', 'max' => '400', 'placeholder' =>'Bsp.: 180'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('v_min','Vmin [km/h]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('v_min',$fluggeraet->v_min, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '400', 'placeholder' =>'Bsp.: 60'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('leermasse','Leermasse [kg]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('leermasse',$fluggeraet->leermasse, ['class' => 'form-control','step' => '1','min' => '1', 'max' => '8000', 'placeholder' =>'Bsp.: 320'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('mtow','MTOW [kg]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('mtow',$fluggeraet->mtow, ['class' => 'form-control','step' => '0.5','min' => '1', 'max' => '10000', 'placeholder' =>'Bsp.: 600'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('fahrwerk','Fahrwerk',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-3">
                            @if($fluggeraet->fahrwerk == 'fest')
                                {{Form::radio('fahrwerk', 'fest', true)}} fest <br>
                                {{Form::radio('fahrwerk', 'einziehbar', false)}} einziehbar
                            @else
                                {{Form::radio('fahrwerk', 'fest', false)}} fest <br>
                                {{Form::radio('fahrwerk', 'einziehbar', true)}} einziehbar
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kennblattnummer','Kennblatt-Nr.',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kennblattnummer',$fluggeraet->kennblattnummer, ['class' => 'form-control','placeholder' =>'Bsp.: 61141.6'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz',$fluggeraet->notiz, ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4 class="card-title mb-4">Zubehörteile</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('flanschposition','Position Motorflansch zur Cowling [mm]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-4">
                            {{Form::number('flanschposition',$fluggeraet->flanschposition, ['class' => 'form-control','step' => '1','min' => '-100', 'max' => '100', 'placeholder' =>'Bsp.: +20mm'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ds_id" class="col-sm-3 col-form-label">Distanzscheibe</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="ds_id">
                                <option value="{{ $fluggeraet->artikel05Distanzscheibe->id }}">{{ $fluggeraet->artikel05Distanzscheibe->name }}</option>
                                @foreach($distanzscheiben as $distanzscheibe)
                                <option value="{{ $distanzscheibe->id }}" {{ old('ds_id') == $distanzscheibe->id ? 'selected' : '' }}>{{ $distanzscheibe->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="asgp_id" class="col-sm-3 col-form-label">ASGP</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="asgp_id">
                                <option value="{{ $fluggeraet->artikel06ASGP->id }}">{{ $fluggeraet->artikel06ASGP->name }}</option>
                                @foreach($spinnerASGP_Obj as $spinnerASGP)
                                <option value="{{ $spinnerASGP->id }}" {{ old('asgp_id') == $spinnerASGP->id ? 'selected' : '' }}>{{ $spinnerASGP->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="spgp_id" class="col-sm-3 col-form-label">SPGP</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="spgp_id">
                                <option value="{{ $fluggeraet->artikel06SPGP->id }}">{{ $fluggeraet->artikel06SPGP->name }}</option>
                                @foreach($spinnerSPGP_Obj as $spinnerSPGP)
                                <option value="{{ $spinnerSPGP->id }}" {{ old('spgp_id') == $spinnerSPGP->id ? 'selected' : '' }}>{{ $spinnerSPGP->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="spkp_id" class="col-sm-3 col-form-label">SPKP</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="spkp_id">
                                <option value="{{ $fluggeraet->artikel06SPKP->id }}">{{ $fluggeraet->artikel06SPKP->name }}</option>
                                @foreach($spinnerSPKP_Obj as $spinnerSPKP)
                                <option value="{{ $spinnerSPKP->id }}" {{ old('spkp_id') == $spinnerSPKP->id ? 'selected' : '' }}>{{ $spinnerSPKP->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="schraubeM8FL" class="col-sm-3 col-form-label">Schraubenset Flansch 6x:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="schraubeM8FL">
                                <option value="{{ $fluggeraet->artikel_07SB_FL }}">{{ $fluggeraet->artikel_07SB_FL }}</option>
                                <option value="">----</option>
                                @foreach($schraubenM8_Obj as $schraubenM8)
                                <option value="{{ $schraubenM8->name }}" {{ old('schraubeM8FL') == $schraubenM8->id ? 'selected' : '' }}>{{ $schraubenM8->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="schraubeM8P" class="col-sm-3 col-form-label">Schraubenset Propeller 6x:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="schraubeM8P">
                                <option value="{{ $fluggeraet->artikel_07SB_P }}">{{ $fluggeraet->artikel_07SB_P }}</option>
                                <option value="">----</option>
                                @foreach($schraubenM8_Obj as $schraubenM8)
                                <option value="{{ $schraubenM8->name }}" {{ old('schraubeM8P') == $schraubenM8->id ? 'selected' : '' }}>{{ $schraubenM8->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    Die Schraubenlängen sind ausgelegt für die Montage mit Helix-Buchsen. 
                </div>
            </div>
        </div>
    </div>
{{Form::hidden('_method','PUT')}}
{!! Form::close() !!}    
@endsection