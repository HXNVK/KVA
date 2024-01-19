@extends('layouts.app')

@section('content')
    <h1>Blattebenendaten für StepCode ändern</h1>
    <a href="/propellerStepCodeBlaetter" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="back" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => ['PropellerStepCodeBlaetterController@update', $propellerStepCodeBlatt->id], 'method' => 'POST']) !!}
            <div>
                <div class="row">
                    {{Form::label('propeller_modell_blatt','Propeller Blattmodell',['class' => 'col-2 col-form-label'])}}
                    <div class="col-4">
                        {{Form::text('name',$propellerStepCodeBlatt->name, ['class' => 'form-control', 'readonly' => 'true'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('splineOrdnung_u','Spline Ordnung u (x-Richtung)',['class' => 'col-2 col-form-label'])}} 
                    <div class="col-1">
                        {{Form::number('splineOrdnung_u',$inputBlatt[0][0], ['class' => 'form-control', 'min' => 2, 'max' => 10, 'step' => 1])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('splineOrdnung_v','Spline Ordnung u (y-Richtung)',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('splineOrdnung_v',$inputBlatt[1][0], ['class' => 'form-control', 'min' => 2, 'max' => 10, 'step' => 1])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('verdrehungwinkel_blattx','Verdrehung Blatt [°] (um x-Achse)',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('verdrehungwinkel_blattx',$inputBlatt[2][0], ['class' => 'form-control', 'min' => -180, 'max' => 180, 'step' => 1])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('verdrehungwinkel_blatty','Verdrehung Blatt [°] (um y-Achse)',['class' => 'col-2 col-form-label'])}}
                    <div class="col-1">
                        {{Form::number('verdrehungwinkel_blatty',$inputBlatt[3][0], ['class' => 'form-control', 'min' => -45, 'max' => 45, 'step' => 1])}}
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
                                <td>{{Form::number('radiusstationNr6','6', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr7','7', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr8','8', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr9','9', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr10','10', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr11','11', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr12','12', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr13','13', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr14','14', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('radiusstationNr15','15', ['class' => 'form-control'])}}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Radiusstation x-Wert [mm]</td>
                                @for($x = 0;$x < count($inputBlatt[4]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("radiusstation_x$i",$inputBlatt[4][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profiltiefe l [mm]</td>
                                @for($x = 0;$x < count($inputBlatt[5]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("profiltiefe_l$i",$inputBlatt[5][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profildicke Skalierung [-]</td>
                                @for($x = 0;$x < count($inputBlatt[6]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("profildicke_s$i",$inputBlatt[6][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profilrücklage [mm]</td>
                                @for($x = 0;$x < count($inputBlatt[7]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("profilruecklage_$i",$inputBlatt[7][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profil V-Lage [mm]</td>
                                @for($x = 0;$x < count($inputBlatt[8]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("profilvlage_$i",$inputBlatt[8][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Dicke HK [mm]</td>
                                @for($x = 0;$x < count($inputBlatt[9]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("dickeHK_$i",$inputBlatt[9][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Steigung [mm]</td>
                                @for($x = 0;$x < count($inputBlatt[10]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("steigung_$i",$inputBlatt[10][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Verdrehwinkel um y-Achse [°]</td>
                                @for($x = 0;$x < count($inputBlatt[11]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("verdrehwinkel_y_$i",$inputBlatt[11][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Verdrehwinkel z-Achse [°]</td>
                                @for($x = 0;$x < count($inputBlatt[12]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("verdrehwinkel_z_$i",$inputBlatt[12][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Referenzlinie [-]</td>
                                @for($x = 0;$x < count($inputBlatt[13]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("referenzlinie_$i",$inputBlatt[13][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td style="font-size: 8pt;">Profil Nr. [-]</td>
                                <td>
                                    <select class="form-control" name="profil_1">
                                        <option value="{{$inputBlatt[14][0]}}">{{$inputBlatt[14][0]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value = "{{$propellerProfil->id}}" {{ old('profil_1') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>    
                                </td>
                                <td>
                                    <select class="form-control" name="profil_2">
                                        <option value="{{$inputBlatt[14][1]}}">{{$inputBlatt[14][1]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_2') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>  
                                </td>
                                <td>
                                    <select class="form-control" name="profil_3">
                                        <option value="{{$inputBlatt[14][2]}}">{{$inputBlatt[14][2]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}"{{ old('profil_3') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_4">
                                        <option value="{{$inputBlatt[14][3]}}">{{$inputBlatt[14][3]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_4') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_5">
                                        <option value="{{$inputBlatt[14][4]}}">{{$inputBlatt[14][4]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}"{{ old('profil_5') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_6">
                                        <option value="{{$inputBlatt[14][5]}}">{{$inputBlatt[14][5]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_6') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>  
                                </td>
                                <td>
                                    <select class="form-control" name="profil_7">
                                        <option value="{{$inputBlatt[14][6]}}">{{$inputBlatt[14][6]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_7') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_8">
                                        <option value="{{$inputBlatt[14][7]}}">{{$inputBlatt[14][7]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_8') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_9">
                                        <option value="{{$inputBlatt[14][8]}}">{{$inputBlatt[14][8]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_9') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>      
                                </td>
                                <td>
                                    <select class="form-control" name="profil_10">
                                        <option value="{{$inputBlatt[14][9]}}">{{$inputBlatt[14][9]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_10') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                                <td>
                                    <select class="form-control" name="profil_11">
                                        <option value="{{$inputBlatt[14][10]}}">{{$inputBlatt[14][10]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_11') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select> 
                                </td>
                                <td>
                                    <select class="form-control" name="profil_12">
                                        <option value="{{$inputBlatt[14][11]}}">{{$inputBlatt[14][11]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_12') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                                <td>
                                    <select class="form-control" name="profil_13">
                                        <option value="{{$inputBlatt[14][12]}}">{{$inputBlatt[14][12]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_13') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select> 
                                </td>
                                <td>
                                    <select class="form-control" name="profil_14">
                                        <option value="{{$inputBlatt[14][13]}}">{{$inputBlatt[14][13]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_14') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                                <td>
                                    <select class="form-control" name="profil_15">
                                        <option value="{{$inputBlatt[14][14]}}">{{$inputBlatt[14][14]}}</option>
                                        @foreach($propellerProfile as $propellerProfil)
                                        <option value="{{ $propellerProfil->id }}" {{ old('profil_15') == $propellerProfil->id ? 'selected' : '' }}>{{ $propellerProfil->name }} / ID: {{$propellerProfil->id}} / ID: {{$propellerProfil->id}}</option>
                                        @endforeach
                                    </select>     
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <h2>Input NC-Kante</h2>
                        <div class="col-12">
                            <table>
                                <tr>
                                    <td style="font-size: 8pt;">NC-Offset x [mm]</td>
                                    @for($x = 0;$x < count($inputBlatt[15]);$x++)
                                        <?php $i = $x + 1;?>
                                        <td>{{Form::number("nc_offset_x_$i",$inputBlatt[15][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td style="font-size: 8pt;">NC-Offset y [mm]</td>
                                    @for($x = 0;$x < count($inputBlatt[16]);$x++)
                                        <?php $i = $x + 1;?>
                                        <td>{{Form::number("nc_offset_y_$i",$inputBlatt[16][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td style="font-size: 8pt;">Kantenverdrehung relativ zur Profilsehne [°]</td>
                                    @for($x = 0;$x < count($inputBlatt[17]);$x++)
                                        <?php $i = $x + 1;?>
                                        <td>{{Form::number("twist-nc_$i",$inputBlatt[17][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td style="font-size: 8pt;">z - Offset Fläche 1 [mm]</td>
                                    @for($x = 0;$x < count($inputBlatt[18]);$x++)
                                        <?php $i = $x + 1;?>
                                        <td>{{Form::number("z_offset_1_$i",$inputBlatt[18][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td style="font-size: 8pt;">z - Offset Fläche 2 [mm]</td>
                                    @for($x = 0;$x < count($inputBlatt[19]);$x++)
                                        <?php $i = $x + 1;?>
                                        <td>{{Form::number("z_offset_2_$i",$inputBlatt[19][$x], ['class' => 'form-control','step' => 0.01])}}</td>
                                    @endfor
                                </tr>
                            </table>
                            <div class="row">
                                {{Form::label('begin_nc_x','Beginn NC Kante bei x= [mm]',['class' => 'col-2 col-form-label'])}}
                                <div class="col-1">
                                    {{Form::number('begin_nc_x',$inputBlatt[20][0], ['class' => 'form-control','step' => 0.01])}}
                                </div>
                            </div>
                            <div class="row">
                                {{Form::label('nc_thickness_trail','Dicke NC-Kante an Spitze [mm]',['class' => 'col-2 col-form-label'])}}
                                <div class="col-1">
                                    {{Form::number('nc_thickness_trail',$inputBlatt[21][0], ['class' => 'form-control','step' => 0.01])}}
                                </div>
                            </div>
                            <div class="row">
                                {{Form::label('nc_thickness_bond','Klebespalt Spitze [mm]',['class' => 'col-2 col-form-label'])}}
                                <div class="col-1">
                                    {{Form::number('nc_thickness_bond',$inputBlatt[22][0], ['class' => 'form-control','step' => 0.01])}}
                                </div>
                            </div>
                        </div>   
                    </div> 
                </div>
                <div class="row">
                    {{Form::label('beschreibung','Beschreibung',['class' => 'col-2 col-form-label'])}}
                    <div class="col-4">
                        {{Form::textarea('beschreibung',$propellerStepCodeBlatt->beschreibung, ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                    </div>
                </div>
            </div>

            {{Form::hidden('_method','PUT')}}
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
   
@endsection