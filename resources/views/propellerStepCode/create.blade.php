@extends('layouts.app')

@section('content')
<a href="/propellerStepCode" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<br><br>
    {!! Form::open(['action' => 'PropellerStepCodeController@store', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-6">
            <h1>StepCode - Generator</h1>
        </div>
        <div class="col-4">
            {{Form::submit('INPUTs StepCode abspeichern', ['class'=>'btn btn-primary'])}}
        </div>
    </div>
    
    <!-- Auswahl Sektionen -->
    <div>
        <h2>Auswahl Sektionen</h2>
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
            {{Form::label('name','StepCode Name',['class' => 'col-2 col-form-label'])}}
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
    
    <!-- Auswahl Blatt & Block -->
    <div class="row mb mt-5">
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

    <!-- Auswahl Wurzel GF "F" und Auswahl Wurzel GF "AV" -->
    <div class="row mb mt-5">
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

    <!-- freie Eingabe Fläche -->
    <div class="mb mt-5">
        <h2>freie Eingabe Fläche</h2>
        <div class="row">
            {{Form::label('splineOrdnung_u','Spline Ordnung u (Punktfolge oben --> unten)',['class' => 'col-2 col-form-label'])}}
            <div class="col-2">
                {{Form::number('splineOrdnung_uFF','', ['class' => 'form-control', 'min' => 0, 'max' => 10, 'step' => 1])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('splineOrdnung_v','Spline Ordnung v (Punktfolge links --> rechts)',['class' => 'col-2 col-form-label'])}}
            <div class="col-2">
                {{Form::number('splineOrdnung_vFF','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehungwinkel_xFF','Verdrehung Fläche [°] (um x-Achse)',['class' => 'col-2 col-form-label'])}}
            <div class="col-2">
                {{Form::number('verdrehungwinkel_xFF','', ['class' => 'form-control'])}}
            </div>
        </div>
       
        <div class="row">
            {{Form::label('verdrehung_yFF','Verdrehung bei y = [mm]',['class' => 'col-2 col-form-label'])}}
            <div class="col-2">
                {{Form::number('verdrehung_yFF','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehungwinkel_yFF','Verdrehung Fläche [°] (um y-Achse)',['class' => 'col-2 col-form-label'])}}
            <div class="col-2">
                {{Form::number('verdrehungwinkel_yFF','', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            {{Form::label('verdrehung_xFF','Verdrehung bei x =  [mm]',['class' => 'col-2 col-form-label'])}}
            <div class="col-2">
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

    <!-- freie Eingabe Kurve -->
    <div class="mb mt-5">
        <h2>freie Eingabe Kurve</h2>
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