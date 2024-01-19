@extends('layouts.app')

@section('content')
<a href="/projekte/{{$projekt->id}}/edit" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
{!! Form::open(['action' => ['ProjektPropellerController@update', $projektPropeller->id], 'method' => 'POST']) !!}  
@if($projektPropeller->propeller_gek != 0)
    <h2>Testdaten des Propellers {{ $projektPropeller->propeller->name }} / {{ $projektPropeller->artikel03Farbe->text }} / {{ $projektPropeller->artikel03Ausfuehrung->name }} / gek. {{ $projektPropeller->propellerDurchmesser->name }} {{Form::submit('überarbeiten', ['class'=>'btn btn-primary'])}}</h2> 
@else
    <h2>Testdaten des Propellers {{ $projektPropeller->propeller->name }} / {{ $projektPropeller->artikel03Farbe->text }} / {{ $projektPropeller->artikel03Ausfuehrung->name }} {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}</h2> 
@endif
    <!-- Testdaten für UL -->
    @if($projekt->projektGeraeteklasse->name == '3-ACHS' 
        || $projekt->projektGeraeteklasse->name == 'GYRO'
        || $projekt->projektGeraeteklasse->name == 'SONDER' 
        || $projekt->projektGeraeteklasse->name == 'UL-TRIKE')

        <div class="row">
            <!-- start card Projektdaten -->
            <div class="col-xl-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title mb-4">Fluggerät und Umgebungsdaten</h4>
                        </div>
                        {{-- <div class="form-group row">
                            {{Form::label('id','Projekt ID',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('id', $projekt->id, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            {{Form::label('projektname','Projektname',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::hidden('projekt_id',$projekt->id)}}
                                {{Form::text('projektname', $projekt->name, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        </div>     
                        <div class="form-group row">
                            {{Form::label('beschreibung','Beschreibung',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('beschreibung', $projektPropeller->beschreibung, ['class' => 'form-control', 'placeholder' =>'Bsp.: Reisepropeller oder Standard...'])}}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <label for="motorGetriebe_id" class="col-sm-4 col-form-label">Untersetzung</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="motorGetriebe_id">
                                    <option value="{{ $projektPropeller->motorGetriebe->id }}">{{ $projektPropeller->motorGetriebe->name }}</option>
                                    @foreach($getriebeObjects as $getriebe)
                                    <option value="{{ $getriebe->id }}" {{ old('motorGetriebe_id') == $getriebe->id ? 'selected' : '' }}>{{ $getriebe->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propeller_id" class="col-sm-4 col-form-label">Propeller</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="propeller_id">
                                    <option value="{{ $projektPropeller->propeller->id }}">{{ $projektPropeller->propeller->name }}</option>
                                    @foreach($propellerObjects as $propeller)
                                    <option value="{{ $propeller->id }}" {{ old('propeller_id') == $propeller->id ? 'selected' : '' }}>{{ $propeller->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="ausfuehrung_id">
                                    <option value="{{ $projektPropeller->artikel03Ausfuehrung->id }}">{{ $projektPropeller->artikel03Ausfuehrung->name }}</option>
                                    @foreach($ausfuehrungen as $ausfuehrung)
                                    <option value="{{ $ausfuehrung->id }}" {{ old('ausfuehrung_id') == $ausfuehrung->id ? 'selected' : '' }}>{{ $ausfuehrung->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="farbe_id">
                                    <option value="{{ $projektPropeller->artikel03Farbe->id }}">{{ $projektPropeller->artikel03Farbe->text }}</option>
                                    @foreach($farben as $farbe)
                                    <option value="{{ $farbe->id }}" {{ old('farbe_id') == $farbe->id ? 'selected' : '' }}>{{ $farbe->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propellerDurchmesserNeu_id" class="col-sm-4 col-form-label">Propeller eingekürzt auf</label>
                            <div class="col-sm-4">                                
                                @if($projektPropeller->propeller_gek != 0)
                                    <select class="form-control" name="propellerDurchmesserNeu_id">
                                        <option value="{{ $projektPropeller->propellerDurchmesser->id }}">{{ $projektPropeller->propellerDurchmesser->name }}</option>
                                        @foreach($propellerDurchmesserNeu as $propellerDurchmesser)
                                        <option value="{{ $propellerDurchmesser->id }}" {{ old('propellerDurchmesserNeu_id') == $propellerDurchmesser->id ? 'selected' : '' }}>{{ $propellerDurchmesser->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="form-control" name="propellerDurchmesserNeu_id">
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                        @foreach($propellerDurchmesserNeu as $propellerDurchmesser)
                                        <option value="{{ $propellerDurchmesser->id }}" {{ old('propellerDurchmesserNeu_id') == $propellerDurchmesser->id ? 'selected' : '' }}>{{ $propellerDurchmesser->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kantenschutz_id" class="col-sm-4 col-form-label">PU-Kantenschutzband</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="kantenschutz_id">
                                    @if($projektPropeller != null)
                                        @if($projektPropeller->artikel_03Kantenschutz_id != NULL)
                                            <option value="{{ $projektPropeller->artikel03Kantenschutz->id }}">{{ $projektPropeller->artikel03Kantenschutz->text }}</option>
                                        @else
                                            <option value="" disabled>Bitte wählen</option>
                                            <option value="">----</option>
                                        @endif
                                    @else
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                    @endif
                                    @foreach($kantenschuetze as $kantenschutz)
                                    <option value="{{ $kantenschutz->id }}" {{ old('kantenschutz_id') == $kantenschutz->id ? 'selected' : '' }}>{{ $kantenschutz->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('typenaufkleber','Typenaufkleber',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::text('typenaufkleber',$projektPropeller->typenaufkleber , ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: H160Funbi'])}}
                            </div>
                        </div>
                        @if($kunde->kundeAufkleber->id == 1)
                            <div class="form-group row">
                                <label for="propellerAufkleber_id" class="col-sm-4 col-form-label">Logo Aufkleber</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="propellerAufkleber_id">
                                        @if($projektPropeller != null)
                                            @if($projektPropeller->propeller_aufkleber_id != NULL)
                                                <option value="{{ $projektPropeller->propellerAufkleber->id }}">{{ $projektPropeller->propellerAufkleber->text }}</option>
                                            @else
                                                <option value="" disabled>Bitte wählen</option>
                                                <option value="">----</option>
                                            @endif
                                        @else
                                            <option value="" disabled>Bitte wählen</option>
                                            <option value="">----</option>
                                        @endif
                                        @foreach($propellerAufkleberObjects as $propellerAufkleber)
                                        <option value="{{ $propellerAufkleber->id }}" {{ old('propellerAufkleber_id') == $propellerAufkleber->id ? 'selected' : '' }}>{{ $propellerAufkleber->text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            {{Form::label('notizProduktion','Notiz für Produktion',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::textarea('notizProduktion',$projektPropeller->notizProduktion , ['class' => 'form-control','rows' => 3, 'placeholder' =>'Infos für die Produktion...'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('gewicht','Abflugmasse [kg]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('gewicht',$projektPropeller->gewicht , ['class' => 'form-control','step' => '1','min' => '30', 'max' => '1000', 'placeholder' =>'Bsp.: 533'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('klappen_set','Klappen gesetzt',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                <div class="col-3">
                                    @if($projektPropeller->klappen_set == '1')
                                        JA {{Form::radio('klappen_set','1', true, ['checked' => 'checked'])}}
                                    @else
                                        JA {{Form::radio('klappen_set','1', false, [])}}
                                    @endif
                                </div>
                                <div class="col-3">
                                    @if($projektPropeller->klappen_set == '0')
                                        NEIN {{Form::radio('klappen_set','0', true, ['checked' => 'checked'])}}
                                    @else
                                        NEIN {{Form::radio('klappen_set','0', false, [])}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('startzeit','Startzeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('startzeit',$projektPropeller->startzeit, ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1211'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('landezeit','Landezeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('landezeit',$projektPropeller->landezeit, ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1245'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('luftdruck','QNH [hPa]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('luftdruck',$projektPropeller->luftdruck_qnh, ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 1013'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('temperatur','Außentemperatur Boden [°C]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('temperatur',$projektPropeller->temperatur_gnd, ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 15'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('metar','Wetter',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('metar',$projektPropeller->metar, ['class' => 'form-control', 'placeholder' =>'Bsp.: 020/4 CAVOK 14/01 1020'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::textarea('notiz',$projektPropeller->notiz, ['class' => 'form-control','rows' => 6, 'placeholder' =>'500 Zeichen für Infos'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('ergebnis_bewertung','Bewertung Ergebnis',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                <div class="col-12">
                                    @if($projektPropeller->ergebnis_bewertung == '1')
                                        Referenz-Info {{Form::checkbox('ergebnis_bewertung','1', true, ['checked' => 'checked'])}}
                                    @else
                                        Referenz-Info {{Form::checkbox('ergebnis_bewertung','1', false, [])}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start card Testdaten -->
            <div class="col-xl-6">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title mb-4">Flugdaten</h4>
                        </div>
                        <div class="form-group row">
                            <!-- Testdaten Steig- Horizontalflug -->
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th style="min-width:50px">Steig- & Horizontalflug</th>
                                    <th></th>
                                    <th></th>
                                    <th colspan="2">Messhöhe [ft]: {{Form::number('mp_hoehe','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000'])}}</th>
                                    <th colspan="2">Temp. in Höhe [°C]: {{Form::number('mp_hoehe','', ['class' => 'form-control','step' => '1','min' => '-10', 'max' => '20'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Leistung</th>
                                    <th style="background-color: lightgray">Start Vo</th>
                                    <th style="background-color: lightgray">Steigen Vx</th>
                                    <th style="background-color: lightgray">Vollgas Vmax</th>
                                    <th style="background-color: lightgray">Zwischenwert 1</th>
                                    <th style="background-color: lightgray">Zwischenwert 2</th>
                                    <th style="background-color: lightgray">Zwischenwert 3</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Drehzahl [U/min]</th>
                                    <th>{{Form::number('mp_Vo_drehzahl',$projektPropeller->mp_Vo_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</th>
                                    <th>{{Form::number('mp_Vx_drehzahl',$projektPropeller->mp_Vx_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</th>
                                    <th>{{Form::number('mp_Vmax_drehzahl',$projektPropeller->mp_Vmax_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</th>
                                    <th>{{Form::number('mp1_drehzahl',$projektPropeller->mp1_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</th>
                                    <th>{{Form::number('mp2_drehzahl',$projektPropeller->mp2_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</th>
                                    <th>{{Form::number('mp3_drehzahl',$projektPropeller->mp3_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Steigrate & Verbrauch [ft/min & l/h]</th>
                                    <th>X</th>
                                    <th>{{Form::number('mp_Vx_steigrate',$projektPropeller->mp_Vx_steigrate, ['class' => 'form-control','step' => '1','min' => '500', 'max' => '5000'])}}</th>
                                    <th>{{Form::number('mp_Vmax_verbrauch',$projektPropeller->mp_Vmax_verbrauch, ['class' => 'form-control','step' => '0.1'])}}</th>
                                    <th>{{Form::number('mp1_verbrauch',$projektPropeller->mp1_verbrauch, ['class' => 'form-control','step' => '0.1'])}}</th>
                                    <th>{{Form::number('mp2_verbrauch',$projektPropeller->mp2_verbrauch, ['class' => 'form-control','step' => '0.1'])}}</th>
                                    <th>{{Form::number('mp3_verbrauch',$projektPropeller->mp3_verbrauch, ['class' => 'form-control','step' => '0.1'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Ladedruck [inchHg]</th>
                                    <th>{{Form::number('mp_Vo_ladedruck',$projektPropeller->mp_Vo_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</th></th>
                                    <th>{{Form::number('mp_Vx_ladedruck',$projektPropeller->mp_Vx_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</th>
                                    <th>{{Form::number('mp_Vmax_ladedruck',$projektPropeller->mp_Vmax_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</th></th>
                                    <th>{{Form::number('mp1_ladedruck',$projektPropeller->mp1_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</th>
                                    <th>{{Form::number('mp2_ladedruck',$projektPropeller->mp2_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</th>
                                    <th>{{Form::number('mp3_ladedruck',$projektPropeller->mp3_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">IAS [km/h]</th>
                                    <th>X</th>
                                    <th>{{Form::number('mp_Vx_IAS',$projektPropeller->mp_Vx_IAS, ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400'])}}</th>
                                    <th>{{Form::number('mp_Vmax_IAS',$projektPropeller->mp_Vmax_IAS, ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400'])}}</th>
                                    <th>{{Form::number('mp1_IAS',$projektPropeller->mp1_IAS, ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400' ])}}</th>
                                    <th>{{Form::number('mp2_IAS',$projektPropeller->mp2_IAS, ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400'])}}</th>
                                    <th>{{Form::number('mp3_IAS',$projektPropeller->mp3_IAS, ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400'])}}</th>
                                </tr>
                            </table>
                        </div>
                            <!-- Testdaten Steigflug Detail -->
                        <div class="form-group row">
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th>Steigflug mit max. Leistung</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray"></th>
                                    <th style="background-color: lightgray">Höhe [ft]</th>
                                    <th style="background-color: lightgray" colspan="2">Temperatur [°C]</th>
                                    <th style="background-color: lightgray">Drehzahl [U/min]</th>
                                    <th style="background-color: lightgray">Ladedruck [inchHG]</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray"></th>
                                    <th style="background-color: lightgray"></th>
                                    <th style="background-color: lightgray">Öl</th>
                                    <th style="background-color: lightgray">Luft</th>
                                    <th style="background-color: lightgray"></th>
                                    <th style="background-color: lightgray"></th>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">Beginn</td>
                                    <td>1000</td>
                                    <td>{{Form::number('mp_beginn_Vx_temp_oel',$projektPropeller->mp_beginn_Vx_temp_oel, ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120'])}}</td></td>
                                    <td>{{Form::number('mp_beginn_Vx_temp_luft',$projektPropeller->mp_beginn_Vx_temp_luft, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30'])}}</td></td>
                                    <td>{{Form::number('mp_beginn_Vx_drehzahl',$projektPropeller->mp_beginn_Vx_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</td>
                                    <td>{{Form::number('mp_beginn_Vx_ladedruck',$projektPropeller->mp_beginn_Vx_ladedruck, ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 28,8'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 30sec</td>
                                    <td>{{Form::number('mp_nach30s_Vx_hoehe',$projektPropeller->mp_nach30s_Vx_hoehe, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000'])}}</td>
                                    <td>{{Form::number('mp_nach30s_Vx_temp_oel',$projektPropeller->mp_nach30s_Vx_temp_oel, ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120'])}}</td></td>
                                    <td>{{Form::number('mp_nach30s_Vx_temp_luft',$projektPropeller->mp_nach30s_Vx_temp_luft, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30'])}}</td></td>
                                    <td>{{Form::number('mp_nach30s_Vx_drehzahl',$projektPropeller->mp_nach30s_Vx_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</td>
                                    <td>{{Form::number('mp_nach30s_Vx_ladedruck',$projektPropeller->mp_nach30s_Vx_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 60sec</td>
                                    <td>{{Form::number('mp_nach60s_Vx_hoehe',$projektPropeller->mp_nach60s_Vx_hoehe, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000'])}}</td>
                                    <td>{{Form::number('mp_nach60s_Vx_temp_oel',$projektPropeller->mp_nach60s_Vx_temp_oel, ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120'])}}</td></td>
                                    <td>{{Form::number('mp_nach60s_Vx_temp_luft',$projektPropeller->mp_nach60s_Vx_temp_luft, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30'])}}</td></td>
                                    <td>{{Form::number('mp_nach60s_Vx_drehzahl',$projektPropeller->mp_nach60s_Vx_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</td>
                                    <td>{{Form::number('mp_nach60s_Vx_ladedruck',$projektPropeller->mp_nach60s_Vx_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 90sec</td>
                                    <td>{{Form::number('mp_nach90s_Vx_hoehe',$projektPropeller->mp_nach90s_Vx_hoehe, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000'])}}</td>
                                    <td>{{Form::number('mp_nach90s_Vx_temp_oel',$projektPropeller->mp_nach90s_Vx_temp_oel, ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120'])}}</td></td>
                                    <td>{{Form::number('mp_nach90s_Vx_temp_luft',$projektPropeller->mp_nach90s_Vx_temp_luft, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30'])}}</td></td>
                                    <td>{{Form::number('mp_nach90s_Vx_drehzahl',$projektPropeller->mp_nach90s_Vx_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</td>
                                    <td>{{Form::number('mp_nach90s_Vx_ladedruck',$projektPropeller->mp_nach90s_Vx_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 120sec</td>
                                    <td>{{Form::number('mp_nach120s_Vx_hoehe',$projektPropeller->mp_nach120s_Vx_hoehe, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000'])}}</td>
                                    <td>{{Form::number('mp_nach120s_Vx_temp_oel',$projektPropeller->mp_nach120s_Vx_temp_oel, ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120'])}}</td></td>
                                    <td>{{Form::number('mp_nach120s_Vx_temp_luft',$projektPropeller->mp_nach120s_Vx_temp_luft, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30'])}}</td></td>
                                    <td>{{Form::number('mp_nach120s_Vx_drehzahl',$projektPropeller->mp_nach120s_Vx_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</td>
                                    <td>{{Form::number('mp_nach120s_Vx_ladedruck',$projektPropeller->mp_nach120s_Vx_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 150sec</td>
                                    <td>{{Form::number('mp_nach150s_Vx_hoehe',$projektPropeller->mp_nach150s_Vx_hoehe, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000'])}}</td>
                                    <td>{{Form::number('mp_nach150s_Vx_temp_oel',$projektPropeller->mp_nach150s_Vx_temp_oel, ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120'])}}</td></td>
                                    <td>{{Form::number('mp_nach150s_Vx_temp_luft',$projektPropeller->mp_nach150s_Vx_temp_luft, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30'])}}</td></td>
                                    <td>{{Form::number('mp_nach150s_Vx_drehzahl',$projektPropeller->mp_nach150s_Vx_drehzahl, ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000'])}}</td>
                                    <td>{{Form::number('mp_nach150s_Vx_ladedruck',$projektPropeller->mp_nach150s_Vx_ladedruck, ['class' => 'form-control','step' => '0.1'])}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Testdaten für PPG u.ä. -->
    @else
        <div class="row">
            <!-- start card Projektdaten -->
            <div class="col-xl-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title mb-4">Fluggerät und Umgebungsdaten</h4>
                        </div>
                        {{-- <div class="form-group row">
                            {{Form::label('id','Projekt ID',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('id', $projekt->id, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            {{Form::label('projektname','Projektname',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::hidden('projekt_id',$projekt->id)}}
                                {{Form::text('projektname', $projekt->name, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        </div>     
                        <div class="form-group row">
                            {{Form::label('beschreibung','Beschreibung',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('beschreibung', $projektPropeller->beschreibung, ['class' => 'form-control', 'placeholder' =>'Bsp.: Reisepropeller oder Standard...'])}}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <label for="motorGetriebe_id" class="col-sm-4 col-form-label">Untersetzung</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="motorGetriebe_id">
                                    <option value="{{ $projektPropeller->motorGetriebe->id }}">{{ $projektPropeller->motorGetriebe->name }}</option>
                                    @foreach($getriebeObjects as $getriebe)
                                    <option value="{{ $getriebe->id }}" {{ old('motorGetriebe_id') == $getriebe->id ? 'selected' : '' }}>{{ $getriebe->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propeller_id" class="col-sm-4 col-form-label">Typ</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="propeller_id">
                                    <option value="{{ $projektPropeller->propeller->id }}">{{ $projektPropeller->propeller->name }}</option>
                                    @foreach($propellerObjects as $propeller)
                                    <option value="{{ $propeller->id }}" {{ old('propeller_id') == $propeller->id ? 'selected' : '' }}>{{ $propeller->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="ausfuehrung_id">
                                    <option value="{{ $projektPropeller->artikel03Ausfuehrung->id }}">{{ $projektPropeller->artikel03Ausfuehrung->name }}</option>
                                    @foreach($ausfuehrungen as $ausfuehrung)
                                    <option value="{{ $ausfuehrung->id }}" {{ old('ausfuehrung_id') == $ausfuehrung->id ? 'selected' : '' }}>{{ $ausfuehrung->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="farbe_id">
                                    <option value="{{ $projektPropeller->artikel03Farbe->id }}">{{ $projektPropeller->artikel03Farbe->text }}</option>
                                    @foreach($farben as $farbe)
                                    <option value="{{ $farbe->id }}" {{ old('farbe_id') == $farbe->id ? 'selected' : '' }}>{{ $farbe->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propellerDurchmesserNeu_id" class="col-sm-4 col-form-label">Propeller eingekürzt auf</label>
                            <div class="col-sm-4">                                
                                @if($projektPropeller->propeller_gek != 0)
                                    <select class="form-control" name="propellerDurchmesserNeu_id">
                                        <option value="{{ $projektPropeller->propellerDurchmesser->id }}">{{ $projektPropeller->propellerDurchmesser->name }}</option>
                                        @foreach($propellerDurchmesserNeu as $propellerDurchmesser)
                                        <option value="{{ $propellerDurchmesser->id }}" {{ old('propellerDurchmesserNeu_id') == $propellerDurchmesser->id ? 'selected' : '' }}>{{ $propellerDurchmesser->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="form-control" name="propellerDurchmesserNeu_id">
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                        @foreach($propellerDurchmesserNeu as $propellerDurchmesser)
                                        <option value="{{ $propellerDurchmesser->id }}" {{ old('propellerDurchmesserNeu_id') == $propellerDurchmesser->id ? 'selected' : '' }}>{{ $propellerDurchmesser->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('typenaufkleber','Typenaufkleber',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('typenaufkleber',$projektPropeller->typenaufkleber , ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: H160Funbi'])}}
                            </div>
                        </div>
                        @if($kunde->kundeAufkleber->id == 1)
                            <div class="form-group row">
                                <label for="propellerAufkleber_id" class="col-sm-4 col-form-label">Größe Helix-Aufkleber</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="propellerAufkleber_id">
                                        @if($projektPropeller != null)
                                            @if($projektPropeller->propeller_aufkleber_id != NULL)
                                                <option value="{{ $projektPropeller->propellerAufkleber->id }}">{{ $projektPropeller->propellerAufkleber->text }}</option>
                                            @else
                                                <option value="" disabled>Bitte wählen</option>
                                                <option value="">----</option>
                                            @endif
                                        @else
                                            <option value="" disabled>Bitte wählen</option>
                                            <option value="">----</option>
                                        @endif
                                        @foreach($propellerAufkleberObjects as $propellerAufkleber)
                                        <option value="{{ $propellerAufkleber->id }}" {{ old('propellerAufkleber_id') == $propellerAufkleber->id ? 'selected' : '' }}>{{ $propellerAufkleber->text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        @if($kunde->kundeAufkleber->id == 2)
                            <input type="hidden" value="6" name="propellerAufkleber_id">
                        @endif
                        @if($kunde->kundeAufkleber->id == 3)
                            <input type="hidden" value="5" name="propellerAufkleber_id">
                        @endif
                        <div class="form-group row">
                            {{Form::label('notizProduktion','Notiz für Produktion',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::textarea('notizProduktion',$projektPropeller->notizProduktion , ['class' => 'form-control','rows' => 3, 'placeholder' =>'Infos für die Produktion...'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('gewicht','Abflugmasse [kg]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('gewicht',$projektPropeller->gewicht , ['class' => 'form-control','step' => '1','min' => '30', 'max' => '1000', 'placeholder' =>'Bsp.: 533'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('startzeit','Startzeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('startzeit',$projektPropeller->startzeit, ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1211'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('landezeit','Landezeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('landezeit',$projektPropeller->landezeit, ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1245'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('luftdruck','QNH [hPa]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('luftdruck',$projektPropeller->luftdruck_qnh, ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 1013'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('temperatur','Außentemperatur Boden [°C]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('temperatur',$projektPropeller->temperatur_gnd, ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 15'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('metar','Wetter',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('metar',$projektPropeller->metar, ['class' => 'form-control', 'placeholder' =>'Bsp.: 020/4 CAVOK 14/01 1020'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::textarea('notiz',$projektPropeller->notiz, ['class' => 'form-control','rows' => 6, 'placeholder' =>'500 Zeichen für Infos'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('ergebnis_bewertung','Bewertung Ergebnis',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                <div class="col-12">
                                    @if($projektPropeller->ergebnis_bewertung == '1')
                                        Referenz-Info {{Form::checkbox('ergebnis_bewertung','1', true, ['checked' => 'checked'])}}
                                    @else
                                        Referenz-Info {{Form::checkbox('ergebnis_bewertung','1', false, [])}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start card Testdaten -->
            <div class="col-xl-6">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title mb-4">Flugdaten</h4>
                        </div>
                        <div class="form-group row">
                            <!-- Testdaten Steig- Horizontalflug -->
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th style="background-color: lightgray"></th>
                                    <th style="background-color: lightgray">Start Vo</th>
                                </tr>

                                <tr>
                                    <th style="background-color: lightgray">Propellerdrehzahl [U/min]</th>
                                    <th>{{Form::number('mp_Vo_drehzahl', $projektPropeller->mp_Vo_drehzahl, ['class' => 'form-control','step' => '1','min' => '500', 'max' => '8000'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Standschub [kp]</th>
                                    <th>{{Form::number('mp_Vo_schub', $projektPropeller->mp_Vo_schub, ['class' => 'form-control','step' => '1','min' => '1', 'max' => '500'])}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{Form::hidden('_method','PUT')}}
{!! Form::close() !!}
@endsection