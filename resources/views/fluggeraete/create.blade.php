@extends('layouts.app')

@section('content')
<a href="/fluggeraete" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
{!! Form::open(['action' => 'FluggeraeteController@store', 'method' => 'POST']) !!}
<h1>Neuen Stammsatz eines Fluggerätes {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}</h1>
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
                            {{Form::text('name','', ['class' => 'form-control','placeholder' =>'Bsp.: FK9 MK VI...max. 20 Zeichen'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('muster','Muster',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('muster','', ['class' => 'form-control','placeholder' =>'Bsp.: FK9'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('baureihe','Baureihe',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('baureihe','', ['class' => 'form-control','placeholder' =>'Bsp.: MK VI'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hersteller_id" class="col-sm-3 col-form-label">Hersteller (Kunde)</label>
                        @if(isset($kunde_id))
                            <div class="col-sm-8">
                                {{Form::hidden('hersteller_id',$kunde_id)}}
                                {{Form::text('hersteller',$kunde->matchcode, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        @else
                            <div class="col-sm-8">
                                <select class="form-control" name="hersteller_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($kunden as $kunde)
                                    <option value="{{ $kunde->id }}" {{ old('hersteller_id') == $kunde->id ? 'selected' : '' }}>{{ $kunde->matchcode }} / {{ $kunde->name1 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="motor_ausrichtung_id" class="col-sm-3 col-form-label">Ausrichtung Motor- bzw. Getriebeflansch</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_ausrichtung_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($motorAusrichtungen as $motorAusrichtung)
                                <option value="{{ $motorAusrichtung->id }}" {{ old('motor_ausrichtung_id') == $motorAusrichtung->id ? 'selected' : '' }}>{{ $motorAusrichtung->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="projekt_zertifizierung_id" class="col-sm-3 col-form-label">Zertifizierung</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="projekt_zertifizierung_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($projektZertifizierungen as $projektZertifizierung)
                                <option value="{{ $projektZertifizierung->id }}" {{ old('projekt_zertifizierung_id') == $projektZertifizierung->id ? 'selected' : '' }}>{{ $projektZertifizierung->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('spannweite','Spannweite [m]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('spannweite','', ['class' => 'form-control','step' => '0.01','min' => '1', 'max' => '25', 'placeholder' =>'Bsp.: 9.5'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('v_max','Vmax [km/h]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('v_max','', ['class' => 'form-control','step' => '1','min' => '30', 'max' => '400', 'placeholder' =>'Bsp.: 245'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('v_reise','Vreise [km/h]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('v_reise','', ['class' => 'form-control','step' => '1','min' => '30', 'max' => '400', 'placeholder' =>'Bsp.: 180'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('v_min','Vmin [km/h]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('v_min','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '400', 'placeholder' =>'Bsp.: 60'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('leermasse','Leermasse [kg]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('mtow','', ['class' => 'form-control','step' => '1','min' => '1', 'max' => '10000', 'placeholder' =>'Bsp.: 320'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('mtow','MTOW [kg]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('mtow','', ['class' => 'form-control','step' => '0.5','min' => '1', 'max' => '10000', 'placeholder' =>'Bsp.: 600'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('fahrwerk','Fahrwerk',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::radio('fahrwerk', 'fest')}} fest<br>
                            {{Form::radio('fahrwerk', 'einziehbar')}} einziehbar
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kennblattnummer','Kennblatt-Nr.',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kennblattnummer','', ['class' => 'form-control','placeholder' =>'Bsp.: 61141.6'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz','', ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
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
                        <div class="col-sm-8">
                            {{Form::number('flanschposition','', ['class' => 'form-control','step' => '1','min' => '-100', 'max' => '100', 'placeholder' =>'Bsp.: +20mm'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ds_id" class="col-sm-3 col-form-label">Distanzscheibe</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="ds_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
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
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
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
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
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
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($spinnerSPKP_Obj as $spinnerSPKP)
                                <option value="{{ $spinnerSPKP->id }}" {{ old('spkp_id') == $spinnerSPKP->id ? 'selected' : '' }}>{{ $spinnerSPKP->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="schraubeM8FL" class="col-sm-3 col-form-label">Schraubenset Flansch (für Einsatz mit Helix-Buchsen) 6x:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="schraubeM8FL">
                                <option value="" disabled>Bitte wählen</option>
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
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($schraubenM8_Obj as $schraubenM8)
                                <option value="{{ $schraubenM8->name }}" {{ old('schraubeM8P') == $schraubenM8->id ? 'selected' : '' }}>{{ $schraubenM8->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}    

<script type="text/javascript">

    $(document).ready(function() {
        $('select[name="motor"]').on('change', function() {
            var motorID = $(this).val();
            if(motorID) {
                $.ajax({
                    url: '/projekte/create/json-motorGetriebe/'+motorID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="motorGetriebe"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="motorGetriebe"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="motorGetriebe"]').empty();
            }
        });

        $('select[name="motor"]').on('change', function() {
            var motorID = $(this).val();
            if(motorID) {
                $.ajax({
                    url: '/projekte/create/json-motorFlansch/'+motorID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="motorFlansch"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="motorFlansch"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="motorFlansch"]').empty();
            }
        });
    });

</script>
@endsection