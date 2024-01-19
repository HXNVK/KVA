@extends('layouts.app')

@section('content')
    <h1>Wurzeldaten F {{$psc_WurzelF->name}} dublizieren für StepCode</h1>
    <a href="/propellerStepCodeWurzelnF/" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="back" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => 'PropellerStepCodeWurzelnFController@store', 'method' => 'POST']) !!}
            <h1>Input Wurzel F, K, S</h1>
            <div>
                <div class="row">
                    {{Form::label('propeller_modell_wurzel','Wurzelmodell',['class' => 'col-2 col-form-label'])}}
                    <select class="form-control col-2" name="propeller_modell_wurzel_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($propellerModellWurzeln as $propellerModellWurzel)
                        <option value="{{ $propellerModellWurzel->id }}" {{ old('propeller_modell_blatt_id') == $propellerModellWurzel->id ? 'selected' : '' }}>{{ $propellerModellWurzel->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    {{Form::label('z_E1','z-Ebene 1 [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('z_E1',$inputWurzelF[0], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                        {{Form::label('z_E2','z-Ebene 2 [mm]',['class' => 'col-2 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('z_E2',$inputWurzelF[1], ['class' => 'form-control'])}}
                        </div>
                </div>
                <div class="row">
                    {{Form::label('z_E3','z-Ebene 3 [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('z_E3',$inputWurzelF[2], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('R_F','Flanschradius (Breite bei Typ K, S) [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('R_F',$inputWurzelF[3], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('L_F','Flanschlänge (nur bei Typ K, S) [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('L_F',$inputWurzelF[14], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('S_p','Spaltmaß [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('S_p',$inputWurzelF[4], ['class' => 'form-control',  'step' => 0.01, 'min' => -1, 'max' => 10])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('p_w','y-Verschiebung Flansch [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('p_w',$inputWurzelF[5], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    <?php
                        $AOE = $inputWurzelF[6]/pi()*180;
                    ?>
                    {{Form::label('AOE','Einstellwinkel [°]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('AOE',$AOE, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    <?php
                        $CA = $inputWurzelF[7]/pi()*180;
                    ?>
                    {{Form::label('CA','Konuswinkel [°]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('CA',$CA, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    <?php
                        $RAB = $inputWurzelF[8]/pi()*180;
                    ?>
                    {{Form::label('RAB','Verdrehwinkel in die Blockebene [°]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('RAB',$RAB, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('WT','Abstand Tangentenausrichtung [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('WT',$inputWurzelF[9], ['class' => 'form-control'])}}
                    </div>
                </div>  
                
                <div class="row">
                    {{Form::label('AT','Abstand Tangentenausrichtung zu x-RPS [mm]',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('AT',$inputWurzelF[10], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                        {{Form::label('x_RPS','x-Wert Trennstelle RPS [mm]',['class' => 'col-2 col-form-label'])}}
                        <div class="col-2">
                            {{Form::number('x_RPS',$inputWurzelF[11], ['class' => 'form-control'])}}
                        </div>
                </div>              
                <div class="row">
                    {{Form::label('Komp','Kompatibilität',['class' => 'col-2 col-form-label'])}}
                    <div class="col-2">
                        <select class="form-control" name="Komp">
                            <option value="{{$inputWurzelF[12]}}">{{$inputWurzelF[12]}}</option>
                            @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
                            <option value="{{ $propellerModellKompatibilitaet->name }}" {{ old('Kom') == $propellerModellKompatibilitaet->id ? 'selected' : '' }}>{{ $propellerModellKompatibilitaet->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 
                <table>
                    <tr>
                        <td style="font-size: 10pt;">y-Verschiebung Verrundung [mm]</td>
                        <td>{{Form::text('vy1',$inputWurzelF[15][0], ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('vy2',$inputWurzelF[15][1], ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('vy3',$inputWurzelF[15][2], ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('vy4',$inputWurzelF[15][3], ['class' => 'form-control'])}}</td>
                </tr>
                    <tr>
                        <td style="font-size: 10pt;">z-Verschiebung Verrundung [mm]</td>
                        <td>{{Form::text('vz1',$inputWurzelF[16][0], ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('vz2',$inputWurzelF[16][1], ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('vz3',$inputWurzelF[16][2], ['class' => 'form-control'])}}</td>
                        <td>{{Form::text('vz4',$inputWurzelF[16][3], ['class' => 'form-control'])}}</td>
                    
                    </tr>
                </table>

                <div class="row">
                    {{Form::label('newKomp','neue Kompatibilität  (Format siehe "Design-Rulebook)',['class' => 'col-2 col-form-label'])}}
                    <div class="col-3">
                        {{Form::textarea('newKomp',$inputWurzelF[13], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('beschreibung','Beschreibung',['class' => 'col-2 col-form-label'])}}
                    <div class="col-6">
                        {{Form::textarea('beschreibung',$psc_WurzelF->beschreibung, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection