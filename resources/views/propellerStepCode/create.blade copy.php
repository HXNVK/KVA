@extends('layouts.app')

@section('content')
<a href="/propellerStepCode" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<br><br>
    {!! Form::open(['action' => 'PropellerStepCodeController@Main_Step_Code', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-6">
            <h1>StepCode - Generator</h1>
        </div>
        <div class="col-4">
            {{Form::submit('StepCode generieren', ['class'=>'btn btn-primary'])}}
        </div>
    </div>
    
    <h2>Auswahl Sektionen</h2>
    <div>
        <div class="row">
            <div class="col-8">
                <table>
                    <tr>
                        <td>{{Form::label('include_blatt','Blatt',['class' => '<col-3></col-3> col-form-label'])}}</td>
                        <td>{{Form::label('include_wurzel','Wurzel',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('include_verlaengerung','Verlängerung',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('include_freieF','freie Fläche',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('include_freieFK','freie Kurve',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('include_Block','Block',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('include_CAM','CAM-Hilfen',['class' => 'col-2 col-form-label'])}}</td>
                        <td>{{Form::label('include_javaprop','Java-Prop Input',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('include_NC','NC_Kante',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('VK_HK_switch','VK-HK tauschen',['class' => 'col-3 col-form-label'])}}</td>
                        <td>{{Form::label('show_Splines','Kurven anzeigen',['class' => 'col-3 col-form-label'])}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center">{{Form::checkbox('include_blatt', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_wurzel', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_verlaengerung', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_freieF', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_freieFK', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_Block', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_CAM', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_javaprop', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('include_NC', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('VK_HK_switch', 'ja',false)}}</td>
                        <td style="text-align: center">{{Form::checkbox('show_Splines', 'ja',false)}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            {{Form::label('name','Name',['class' => 'col-2 col-form-label'])}}
            <div class="col-sm-3">
                {{Form::text('name','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('drehrichtung','Drehrichtung',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                <select class="form-control" name="drehrichtung">
                    <option value="" disabled>Bitte wählen</option>
                    <option value="rechts" >rechts</option>
                    <option value="links" >links</option>
                </select> 
            </div>
        </div>
        <div class="row">
            {{Form::label('formhaelfte','Formhälfte',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                <select class="form-control" name="formhaelfte">
                    <option value="" disabled>Bitte wählen</option>
                    <option value="oben" >oben</option>
                    <option value="unten" >unten</option>
                </select> 
            </div>
        </div>
        <div class="row">
            {{Form::label('wurzeltyp','Wurzeltyp',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                <select class="form-control" name="wurzeltyp">
                    <option value="" disabled>Bitte wählen</option>
                    <option value="F" >F</option>
                    <option value="V" >V</option>
                    <option value="S" >S</option>
                    <option value="W" >W</option>
                    <option value="K" >K</option>
                </select> 
            </div>
        </div>
        <div class="row">
            {{Form::label('DFB','Durchmesser Fräser Blockrand [mm]',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('DFB','', ['class' => 'form-control', 'step' => 1, 'min' => 1, 'max' => 70])}}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-3">
            <h2>Auswahl Blatt</h2>
            <select class="form-control col-12" name="psc_blatt_id">
                <option value="" disabled>Bitte wählen</option>
                @foreach($psc_blaetter as $psc_blatt)
                <option value="{{ $psc_blatt->id }}" {{ old('psc_blatt_id') == $psc_blatt->id ? 'selected' : '' }}>{{ $psc_blatt->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-3">
            <h2>Auswahl Block</h2>
            <select class="form-control col-12" name="psc_blattBlock_id">
                <option value="" disabled>Bitte wählen</option>
                @foreach($psc_blattBloecke as $psc_blattBlock)
                <option value="{{ $psc_blattBlock->id }}" {{ old('psc_blattBlock_id') == $psc_blattBlock->id ? 'selected' : '' }}>{{ $psc_blattBlock->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <h2>Auswahl Wurzel GF "F"</h2>
            <select class="form-control col-12" name="psc_wurzel_F_id">
                <option value="" disabled>Bitte wählen</option>
                @foreach($psc_wurzeln_F as $psc_wurzel_F)
                <option value="{{ $psc_wurzel_F->id }}" {{ old('psc_wurzel_F_id') == $psc_wurzel_F->id ? 'selected' : '' }}>{{ $psc_wurzel_F->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <h2>Auswahl Wurzel GF "AV"</h2>
            <select class="form-control col-12" name="psc_wurzel_AV_id">
                <option value="" disabled>Bitte wählen</option>
                @foreach($psc_wurzeln_AV as $psc_wurzel_AV)
                <option value="{{ $psc_wurzel_AV->id }}" {{ old('psc_wurzel_AV_id') == $psc_wurzel_AV->id ? 'selected' : '' }}>{{ $psc_wurzel_AV->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-3">
            <h2>Auswahl Block Wurzel</h2>
            <select class="form-control col-12" name="psc_wurzelBlock_id">
                <option value="" disabled>Bitte wählen</option>
                @foreach($psc_wurzelBloecke as $psc_wurzelBlock)
                <option value="{{ $psc_wurzelBlock->id }}" {{ old('psc_wurzelBlock_id') == $psc_wurzelBlock->id ? 'selected' : '' }}>{{ $psc_wurzelBlock->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Ausgeblendeter ALTCODE --}}
    <div>
            {{-- <h1>Input Blatt</h1>
        <div>
            <div class="row">
                {{Form::label('propeller_modell_blatt','Propeller Blattmodell',['class' => 'col-2 col-form-label'])}}
                <select class="form-control col-2" name="propeller_modell_blatt_id">
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
                            <td>{{Form::text('radiusstationNr1','1', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr2','2', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr3','3', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr4','4', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr5','5', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstationNr15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Radiusstation x-Wert [mm]</td>
                            <td>{{Form::text('radiusstation_x1','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x2','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x3','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x4','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x5','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('radiusstation_x15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Profiltiefe l [mm]</td>
                            <td>{{Form::text('profiltiefe_l1','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l2','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l3','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l4','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l5','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profiltiefe_l15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Profildicke Skalierung [-]</td>
                            <td>{{Form::text('profildicke_s1','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s2','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s3','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s4','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s5','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profildicke_s15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Profilrücklage [mm]</td>
                            <td>{{Form::text('profilruecklage_1','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_2','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_3','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_4','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_5','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilruecklage_15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Profil V-Lage [mm]</td>
                            <td>{{Form::text('profilvlage_1','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_2','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_3','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_4','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_5','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('profilvlage_15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Dicke HK [mm]</td>
                            <td>{{Form::text('dickeHK_1','1', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_2','1', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_3','1', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_4','1', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_5','1', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('dickeHK_15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Steigung [mm]</td>
                            <td>{{Form::text('steigung_1','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_2','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_3','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_4','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_5','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('steigung_15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Verdrehwinkel um y-Achse [°]</td>
                            <td>{{Form::text('verdrehwinkel_y_1','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_2','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_3','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_4','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_5','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_y_15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Verdrehwinkel z-Achse [°]</td>
                            <td>{{Form::text('verdrehwinkel_z_1','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_2','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_3','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_4','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_5','0', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('verdrehwinkel_z_15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Referenzlinie [-]</td>
                            <td>{{Form::text('referenzlinie_1','0.33', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_2','0.33', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_3','0.33', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_4','0.33', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_5','0.33', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_6','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_7','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_8','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_9','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_10','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_11','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_12','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_13','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_14','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('referenzlinie_15','', ['class' => 'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">Profil Nr. [-]</td>
                            <td>
                                <select class="form-control" name="profil_1">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value = "{{ $propellerProfil->name }}" {{ old('profil_1') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>    
                            </td>
                            <td>
                                <select class="form-control" name="profil_2">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_2') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>  
                            </td>
                            <td>
                                <select class="form-control" name="profil_3">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}"{{ old('profil_3') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>      
                            </td>
                            <td>
                                <select class="form-control" name="profil_4">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_4') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>      
                            </td>
                            <td>
                                <select class="form-control" name="profil_5">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}"{{ old('profil_5') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>      
                            </td>
                            <td>
                                <select class="form-control" name="profil_6">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_6') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>  
                            </td>
                            <td>
                                <select class="form-control" name="profil_7">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_7') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>      
                            </td>
                            <td>
                                <select class="form-control" name="profil_8">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_8') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>      
                            </td>
                            <td>
                                <select class="form-control" name="profil_9">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_9') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>      
                            </td>
                            <td>
                                <select class="form-control" name="profil_10">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_10') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>     
                            </td>
                            <td>
                                <select class="form-control" name="profil_11">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_11') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select> 
                            </td>
                            <td>
                                <select class="form-control" name="profil_12">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_12') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>     
                            </td>
                            <td>
                                <select class="form-control" name="profil_13">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_13') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select> 
                            </td>
                            <td>
                                <select class="form-control" name="profil_14">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_14') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>     
                            </td>
                            <td>
                                <select class="form-control" name="profil_15">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerProfile as $propellerProfil)
                                    <option value="{{ $propellerProfil->name }}" {{ old('profil_15') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }}</option>
                                    @endforeach
                                </select>     
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> --}}

        {{-- <h1>Input Blatt Block</h1>
        <div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <table>
                            <tr>
                                <td>{{Form::label('include_tip_tangent','Tangentenrand Spitze Kontur folgen',['class' => 'col-2 col-form-label'])}}</td>
                                
                            </tr>
                            <tr>
                                <td style="text-align: center">{{Form::checkbox('include_tip_tangent', 'ja',false)}}</td>
    
                            </tr>
                        </table>
                    </div>
                </div>

                <table>
                    <tr>
                        <td style="font-size: 10pt;">z-Verschiebung Tangentenrand [mm]</td>
                        <td>{{Form::text('zKW1','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW2','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW3','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW4','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW5','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW6','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW7','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW8','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW9','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW10','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW11','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW12','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW13','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW14','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('zKW15','', ['class' => 'form-control'])}}</td>
                    </tr>
                </table>
                <div class="row">
                    {{Form::label('bTR','Breite Tangentenrand [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('bTR','', ['class' => 'form-control'])}}
                    </div>
                </div>
                    <div class="row">
                        {{Form::label('bB','Breite Blockrand [mm]',['class' => 'col-2 col-form-label'])}}
                        <div class="col-1">
                            {{Form::number('bB','', ['class' => 'form-control', 'step' => 1])}}
                        </div>
                </div>
                <table>
                <tr>
                    <td style="font-size: 10pt;">Blockabmaße [mm]</td>
                    <td>{{Form::text('Blockx','', ['class' => 'form-control', 'placeholder' => "x-Wert"])}}</td>
                    <td>{{Form::text('Blocky','', ['class' => 'form-control', 'placeholder' => "y-Wert"])}}</td>
                    <td>{{Form::text('Blockz','', ['class' => 'form-control', 'placeholder' => "z-Wert"])}}</td>
                </tr>
                <tr>
                    <td style="font-size: 10pt;">Blocknullpunkt [mm]</td>
                    <td>{{Form::text('Blockx0','', ['class' => 'form-control', 'placeholder' => "x-Wert"])}}</td>
                    <td>{{Form::text('Blocky0','', ['class' => 'form-control', 'placeholder' => "y-Wert"])}}</td>
                    <td>{{Form::text('Blockz0','', ['class' => 'form-control', 'placeholder' => "z-Wert"])}}</td>
                </tr>
                <tr>
                    <td style="font-size: 10pt;">Lage Zentrierkonus [mm]</td>
                    <td>{{Form::text('Konusx','', ['class' => 'form-control', 'placeholder' => "x-Wert"])}}</td>
                    <td>{{Form::text('Konusy','', ['class' => 'form-control', 'placeholder' => "y-Wert"])}}</td>
                    <td>{{Form::text('Konusz','', ['class' => 'form-control', 'placeholder' => "z-Wert"])}}</td>
                </tr>
            </table>
        </div> --}}

        {{--     
        
            <div class="row">
                <div class="col-4">
                    <h1>Input Wurzel F, K, S</h1>
                        <div class="row">
                            <select class="form-control col-sm-2" name="propeller_modell_wurzel_id">
                                <option value="" disabled>Bitte wählen</option>
                                @foreach($propellerModellWurzel as $propellerModellWurz)
                                <option value="{{ $propellerModellWurz->id }}" {{ old('propeller_modell_blatt_id') == $propellerModellWurz->id ? 'selected' : '' }}>{{ $propellerModellWurz->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            {{Form::label('z_E1','z-Ebene 1 [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('z_E1','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                                {{Form::label('z_E2','z-Ebene 2 [mm]',['class' => 'col-4 col-form-label'])}}
                                <div class="col-3">
                                    {{Form::number('z_E2','', ['class' => 'form-control'])}}
                                </div>
                        </div>
                        <div class="row">
                            {{Form::label('z_E3','z-Ebene 3 [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('z_E3','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('R_F','Flanschradius (Breite bei Typ K, S) [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('R_F','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('L_F','Flanschlänge (nur bei Typ K, S) [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('L_F','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('S_p','Spaltmaß [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('S_p','', ['class' => 'form-control',  'step' => 0.01, 'min' => -1, 'max' => 10])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('p_w','y-Verschiebung Flansch [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('p_w','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('AOE','Einstellwinkel [°]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('AOE','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('CA','Konuswinkel [°]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('CA','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('RAB','Verdrehwinkel in die Blockebene [°]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('RAB','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            {{Form::label('WT','Abstand Tangentenausrichtung [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('WT','', ['class' => 'form-control'])}}
                            </div>
                        </div>  
                        
                        <div class="row">
                            {{Form::label('AT','Abstand Tangentenausrichtung zu x-RPS [mm]',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                {{Form::number('AT','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                                {{Form::label('x_RPS','x-Wert Trennstelle RPS [mm]',['class' => 'col-4 col-form-label'])}}
                                <div class="col-3">
                                    {{Form::number('x_RPS','', ['class' => 'form-control'])}}
                                </div>
                        </div>              
                        <div class="row">
                            {{Form::label('Kom','Kompatibilität',['class' => 'col-4 col-form-label'])}}
                            <div class="col-3">
                                <select class="form-control" name="Kom">
                                    <option value="" disabled>Bitte wählen</option>
                                    @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
                                    <option value="{{ $propellerModellKompatibilitaet->name }}" {{ old('Kom') == $propellerModellKompatibilitaet->id ? 'selected' : '' }}>{{ $propellerModellKompatibilitaet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <table>
                            <tr>
                                <td style="font-size: 10pt;">y-Verschiebung Verrundung [mm]</td>
                                <td>{{Form::text('vy1','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::text('vy2','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::text('vy3','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::text('vy4','', ['class' => 'form-control'])}}</td>
                        </tr>
                            <tr>
                                <td style="font-size: 10pt;">z-Verschiebung Verrundung [mm]</td>
                                <td>{{Form::text('vz1','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::text('vz2','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::text('vz3','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::text('vz4','', ['class' => 'form-control'])}}</td>
                            
                            </tr>
                        </table>

                        <div class="row">
                            {{Form::label('newKomp','neue Kompatibilität  (Format siehe "Design-Rulebook)',['class' => 'col-2 col-form-label'])}}
                            <div class="col-12">
                                {{Form::textarea('newKomp','', ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                <div class="col-8">  
                    <h1>Input Wurzel A/V</h1>
                    <div>
                        <div class="col-12">
                            <table>
                                <tr>
                                    <td style="font-size: 10pt;">Kreisebene</td>
                                    <td>{{Form::text('Kreisebene1','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene2','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene3','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene4','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene5','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene6','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene7','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene8','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene9','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene10','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene11','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene12','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene13','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene14','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreisebene15','', ['class' => 'form-control'])}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10pt;">Kreismittelpunkt x-Wert [mm]</td>
                                    <td>{{Form::text('Kreis_x1','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x2','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x3','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x4','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x5','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x6','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x7','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x8','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x9','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x10','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x11','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x12','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x13','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x14','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_x15','', ['class' => 'form-control'])}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10pt;">Kreismittelpunkt y-Wert [mm]</td>
                                    <td>{{Form::text('Kreis_y1','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y2','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y3','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y4','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y5','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y6','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y7','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y8','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y9','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y10','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y11','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y12','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y13','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y14','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_y15','', ['class' => 'form-control'])}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10pt;">Kreismittelpunkt z-Wert [-]</td>
                                    <td>{{Form::text('Kreis_z1','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z2','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z3','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z4','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z5','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z6','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z7','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z8','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z9','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z10','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z11','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z12','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z13','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z14','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_z15','', ['class' => 'form-control'])}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10pt;">Kreisdurchmesser [mm]</td>
                                    <td>{{Form::text('Kreis_D1','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D2','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D3','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D4','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D5','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D6','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D7','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D8','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D9','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D10','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D11','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D12','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D13','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D14','', ['class' => 'form-control'])}}</td>
                                    <td>{{Form::text('Kreis_D15','', ['class' => 'form-control'])}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        {{Form::label('CAAV','Konuswinkel [°]',['class' => 'col-3 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('CAAV','', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="row">
                        {{Form::label('RABAV','Verdrehwinkel in die Blockebene [°]',['class' => 'col-3 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('RABAV','', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="row">
                        {{Form::label('WTAV','Abstand Tangentenausrichtung [mm]',['class' => 'col-3 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('WTAV','', ['class' => 'form-control'])}}
                        </div>
                    </div>  
                    <div class="row">
                        {{Form::label('ATAV','Abstand Tangentenausrichtung zu x-RPS [mm]',['class' => 'col-3 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('ATAV','', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="row">
                        {{Form::label('x_RPSAV','x-Wert Schnittstelle x-RPS []',['class' => 'col-3 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('x_RPSAV','', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="row">
                        {{Form::label('HTB','Hinterkantenverschiebung [mm]',['class' => 'col-3 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('HTB','', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                        {{Form::label('AT','Achtung Kompatibilität: wird an Blatt angepasst. Richtiges Blatt muss geladen sein!',['class' => 'col-12 col-form-label'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <h1>Input Block Wurzel</h1>
            <div>
                <div class="col-12">
                    <table>
                        <tr>
                            <td style="font-size: 10pt;">z-Verschiebung Tangentenrand [mm]</td>
                            <td>{{Form::text('zKWW1','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('zKWW2','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('zKWW3','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('zKWW4','', ['class' => 'form-control'])}}</td>
                            <td>{{Form::text('zKWW5','', ['class' => 'form-control'])}}</td>
                                        </tr>
                    </table>
                    <div class="row">
                        {{Form::label('bTRW','Breite Tangentenrand [mm]',['class' => 'col-2 col-form-label'])}}
                        <div class="col-1">
                            {{Form::number('bTRW','', ['class' => 'form-control', 'min' => 0, 'max' => 15, 'step' => 1])}}
                        </div>
                    </div>
                        <div class="row">
                            {{Form::label('bBW','Breite Blockrand [mm]',['class' => 'col-2 col-form-label'])}}
                            <div class="col-1">
                                {{Form::number('bBW','', ['class' => 'form-control', 'min' => 0, 'max' => 15, 'step' => 1])}}
                            </div>
                    </div>
                    <table>
                    <tr>
                        <td style="font-size: 10pt;">Blockabmaße [mm]</td>
                        <td>{{Form::text('BlockWx','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('BlockWy','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('BlockWz','', ['class' => 'form-control'])}}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 10pt;">Blocknullpunkt [mm]</td>
                        <td>{{Form::text('BlockWx0','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('BlockWy0','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('BlockWz0','', ['class' => 'form-control'])}}</td>
                    </tr>
                    <tr>
                        <td style="font-size:10pt;">Lage Zentrierkonus [mm]</td>
                        <td>{{Form::text('KonusWx','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('KonusWy','', ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('KonusWz','', ['class' => 'form-control'])}}</td>
                    </tr>
                </table>
            </div> --}}
    </div>


    <h2>Input NC-Kante</h2>
    <div>
        <div class="col-12">
            <table>
                <tr>
                    <td style="font-size: 8pt;">NC-Offset x [mm]</td>
                    <td>{{Form::text('nc_offset_x_1','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_2','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_3','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_4','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_5','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_6','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_7','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_8','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_9','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_10','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_11','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_12','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_13','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_14','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_x_15','', ['class' => 'form-control'])}}</td>
                                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-size: 8pt;">NC-Offset y [mm]</td>
                    <td>{{Form::text('nc_offset_y_1','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_2','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_3','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_4','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_5','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_6','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_7','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_8','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_9','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_10','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_11','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_12','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_13','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_14','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('nc_offset_y_15','', ['class' => 'form-control'])}}</td>
                                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-size: 8pt;">Kantenverdrehung relativ zur Profilsehne [°]</td>
                    <td>{{Form::text('twist-nc_1','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_2','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_3','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_4','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_5','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_6','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_7','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_8','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_9','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_10','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_11','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_12','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_13','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_14','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('twist-nc_15','', ['class' => 'form-control'])}}</td>
                                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-size: 8pt;">z - Offset Fläche 1 [mm]</td>
                    <td>{{Form::text('z_offset_1_1','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_2','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_3','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_4','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_5','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_6','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_7','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_8','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_9','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_10','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_11','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_12','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_13','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_14','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_1_15','', ['class' => 'form-control'])}}</td>
                                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-size: 8pt;">z - Offset Fläche 2 [mm]</td>
                    <td>{{Form::text('z_offset_2_1','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_2','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_3','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_4','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_5','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_6','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_7','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_8','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_9','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_10','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_11','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_12','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_13','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_14','', ['class' => 'form-control'])}}</td>
                    <td>{{Form::text('z_offset_2_15','', ['class' => 'form-control'])}}</td>
                                </tr>
            </table>
            <div class="row">
                {{Form::label('begin_nc_x','Beginn NC Kante bei x= [mm]',['class' => 'col-2 col-form-label'])}}
                <div class="col-1">
                    {{Form::number('begin_nc_x','', ['class' => 'form-control'])}}
                </div>
            </div>
                <div class="row">
                    {{Form::label('nc_thickness_trail','Dicke NC-Kante an Spitze [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('nc_thickness_trail','', ['class' => 'form-control'])}}
                    </div>
            </div>
            <div class="row">
                {{Form::label('nc_thickness_bond','Klebespalt Spitze [mm]',['class' => 'col-2 col-form-label'])}}
                <div class="col-1">
                    {{Form::number('nc_thickness_bond','', ['class' => 'form-control'])}}
                </div>
        </div>   
    </div>    

    <h2>freie Eingabe Fläche</h2>
    <div>
        <div class="row">
            {{Form::label('splineOrdnung_u','Spline Ordnung u (Punktfolge oben --> unten)',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('splineOrdnung_uFF','', ['class' => 'form-control', 'min' => 0, 'max' => 10, 'step' => 1])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('splineOrdnung_v','Spline Ordnung v (Punktfolge links --> rechts)',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('splineOrdnung_vFF','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehungwinkel_xFF','Verdrehung Fläche [°] (um x-Achse)',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehungwinkel_xFF','', ['class' => 'form-control'])}}
            </div>
        </div>
       
        <div class="row">
            {{Form::label('verdrehung_yFF','Verdrehung bei y = [mm]',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehung_yFF','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehungwinkel_yFF','Verdrehung Fläche [°] (um y-Achse)',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehungwinkel_yFF','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehung_xFF','Verdrehung bei x =  [mm]',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehung_xFF','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('freePoints','freie Punkteingabe',['class' => 'col-2 col-form-label'])}}
            <div class="col-6">
                {{Form::textarea('freepoints','', ['class' => 'form-control'])}}
            </div>
        </div>
    </div>

    <h2>freie Eingabe Kurve</h2>
    <div>
        <div class="row">
            {{Form::label('splineOrdnung_u','Spline Ordnung u (Punktfolge links --> rechts)',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('splineOrdnung_uFK','', ['class' => 'form-control', 'min' => 0, 'max' => 7, 'step' => 1])}}
            </div>
        </div>
       
        <div class="row">
            {{Form::label('verdrehungwinkel_xFF','Verdrehung Kurve [°] (um x-Achse)',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehungwinkel_xFK','', ['class' => 'form-control', 'min' => -45, 'max' => 45, 'step' => 1])}}
            </div>
        </div>
       
        <div class="row">
            {{Form::label('verdrehungwinkel_ylattFK','Verdrehung bei y = [mm]',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehung_yFK','', ['class' => 'form-control', 'min' => -45, 'max' => 45, 'step' => 1])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehungwinkel_blatt','Verdrehung Fläche [°] (um y-Achse)',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehungwinkel_yFK','', ['class' => 'form-control', 'min' => -45, 'max' => 45, 'step' => 1])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehungwinkel_blatt','Verdrehung bei x =  [mm]',['class' => 'col-2 col-form-label'])}}
            <div class="col-1">
                {{Form::number('verdrehung_xFK','', ['class' => 'form-control', 'min' => -45, 'max' => 45, 'step' => 1])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('freePointsfK','freie Punkteingabe',['class' => 'col-2 col-form-label'])}}
            <div class="col-6">
                {{Form::textarea('freepointsfK','', ['class' => 'form-control'])}}
            </div>
        </div>
    </div>

    
    {!! Form::close() !!}
@endsection