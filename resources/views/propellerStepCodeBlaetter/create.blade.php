@extends('layouts.app')

@section('content')
    <h1>Neue Blattebenendaten für StepCode</h1>
    <a href="/propellerStepCodeBlaetter/" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => 'PropellerStepCodeBlaetterController@store', 'method' => 'POST']) !!}
            <h1>Input Blatt</h1>
            <div>
                <div class="row">
                    {{Form::label('propeller_modell_blatt','Blattmodell',['class' => 'col-2 col-form-label'])}}
                    <select class="form-control col-3" name="propeller_modell_blatt_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerModellBlaetter as $propellerModellBlatt)
                        <option value="{{ $propellerModellBlatt->id }}" {{ old('propeller_modell_blatt_id') == $propellerModellBlatt->id ? 'selected' : '' }}>{{ $propellerModellBlatt->name }}</option>
                        @endforeach
                    </select>
                </div>
        
            
                <div class="row">
                    {{Form::label('splineOrdnung_u','Spline Ordnung u (x-Richtung)',['class' => 'col-2 col-form-label'])}} 
                    <div class="col-1">
                        {{Form::number('splineOrdnung_u','', ['class' => 'form-control', 'min' => 2, 'max' => 10, 'step' => 1])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('splineOrdnung_v','Spline Ordnung u (y-Richtung)',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('splineOrdnung_v','', ['class' => 'form-control', 'min' => 2, 'max' => 10, 'step' => 1])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('verdrehungwinkel_blattx','Verdrehung Blatt [°] (um x-Achse)',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('verdrehungwinkel_blattx','', ['class' => 'form-control', 'min' => -180, 'max' => 180, 'step' => 1])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('verdrehungwinkel_blatty','Verdrehung Blatt [°] (um y-Achse)',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('verdrehungwinkel_blatty','', ['class' => 'form-control', 'min' => -45, 'max' => 45, 'step' => 1])}}
                    </div>
                </div>
                <div>
                    <div class="col-12">
                        <table>
                            <tr>
                                <td style="font-size: 10pt;">lfd. Nr.</td>
                                <td>{{Form::number('radiusstationNr1','1', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr2','2', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr3','3', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr4','4', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr5','5', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr6','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr7','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr8','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr9','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr10','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr11','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr12','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr13','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr14','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr15','', ['class' => 'form-control'])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Radiusstation x-Wert [mm]</td>
                                <td>{{Form::number('radiusstation_x1','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x2','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x3','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x4','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x5','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('radiusstation_x15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profiltiefe l [mm]</td>
                                <td>{{Form::number('profiltiefe_l1','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l2','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l3','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l4','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l5','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profiltiefe_l15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profildicke Skalierung [-]</td>
                                <td>{{Form::number('profildicke_s1','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s2','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s3','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s4','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s5','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profildicke_s15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profilrücklage [mm]</td>
                                <td>{{Form::number('profilruecklage_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilruecklage_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profil V-Lage [mm]</td>
                                <td>{{Form::number('profilvlage_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('profilvlage_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Dicke HK [mm]</td>
                                <td>{{Form::number('dickeHK_1','1', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_2','1', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_3','1', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_4','1', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_5','1', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('dickeHK_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Steigung [mm]</td>
                                <td>{{Form::number('steigung_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('steigung_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Verdrehwinkel um y-Achse [°]</td>
                                <td>{{Form::number('verdrehwinkel_y_1','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_2','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_3','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_4','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_5','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_y_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Verdrehwinkel z-Achse [°]</td>
                                <td>{{Form::number('verdrehwinkel_z_1','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_2','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_3','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_4','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_5','0', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('verdrehwinkel_z_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Referenzlinie [-]</td>
                                <td>{{Form::number('referenzlinie_1','0.33', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_2','0.33', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_3','0.33', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_4','0.33', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_5','0.33', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                                <td>{{Form::number('referenzlinie_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profil Nr. [-]</td>
                                <td>
                                    <select class="form-control" name="profil_1">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value = "{{$propellerProfil->id}}" {{ old('profil_1') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>    
                                </td>
                                <td>
                                    <select class="form-control" name="profil_2">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_2') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>  
                                </td>
                                <td>
                                    <select class="form-control" name="profil_3">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}"{{ old('profil_3') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_4">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_4') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_5">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}"{{ old('profil_5') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_6">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_6') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>  
                                </td>
                                <td>
                                    <select class="form-control" name="profil_7">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_7') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_8">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_8') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_9">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_9') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_10">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_10') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                                <td>
                                    <select class="form-control" name="profil_11">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_11') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select> 
                                </td>
                                <td>
                                    <select class="form-control" name="profil_12">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_12') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                                <td>
                                    <select class="form-control" name="profil_13">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_13') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select> 
                                </td>
                                <td>
                                    <select class="form-control" name="profil_14">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_14') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                                <td>
                                    <select class="form-control" name="profil_15">
                                        <option value="" >Bitte wählen</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_15') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    {{Form::label('beschreibung','Beschreibung',['class' => 'col-2 col-form-label'])}}
                    <div class="col-4">
                        {{Form::textarea('beschreibung','', ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                    </div>
                </div>
            </div>

                <!-- Input NC-Kante -->
            <div>
                <h2>Input NC-Kante</h2>
                <div class="col-12">
                    <table>
                        <tr>
                            <td style="font-size: 8pt;">NC-Offset x [mm]</td>
                            <td>{{Form::number('nc_offset_x_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_x_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">NC-Offset y [mm]</td>
                            <td>{{Form::number('nc_offset_y_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('nc_offset_y_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Kantenverdrehung relativ zur Profilsehne [°]</td>
                            <td>{{Form::number('twist-nc_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('twist-nc_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">z - Offset Fläche 1 [mm]</td>
                            <td>{{Form::number('z_offset_1_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_1_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">z - Offset Fläche 2 [mm]</td>
                            <td>{{Form::number('z_offset_2_1','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_2','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_3','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_4','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_5','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_6','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_7','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_8','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_9','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_10','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_11','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_12','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_13','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_14','', ['class' => 'form-control','step' => 0.01])}}</td>
                            <td>{{Form::number('z_offset_2_15','', ['class' => 'form-control','step' => 0.01])}}</td>
                        </tr>
                    </table>
                    <div class="row">
                        {{Form::label('begin_nc_x','Beginn NC Kante bei x= [mm]',['class' => 'col-2 col-form-label'])}}
                        <div class="col-1">
                            {{Form::number('begin_nc_x','', ['class' => 'form-control','step' => 0.01])}}
                        </div>
                    </div>
                        <div class="row">
                            {{Form::label('nc_thickness_trail','Dicke NC-Kante an Spitze [mm]',['class' => 'col-2 col-form-label'])}}
                            <div class="col-1">
                                {{Form::number('nc_thickness_trail','', ['class' => 'form-control','step' => 0.01])}}
                            </div>
                    </div>
                    <div class="row">
                        {{Form::label('nc_thickness_bond','Klebespalt Spitze [mm]',['class' => 'col-2 col-form-label'])}}
                        <div class="col-1">
                            {{Form::number('nc_thickness_bond','', ['class' => 'form-control','step' => 0.01])}}
                        </div>
                </div>   
            </div>   

            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection