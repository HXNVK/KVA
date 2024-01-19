@extends('layouts.app')

@section('content')
<div class="row">
    @include('internals.messages')
</div>
<a href="/projekte/{{$projekt->id}}/edit" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
{!! Form::open(['action' => ['ProjektPropellerController@store', $projekt->id], 'method' => 'POST']) !!}
<h1>Neue Testdaten eines Propellers {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}</h1>
    <!-- Testdaten für UL -->
    @if($projekt->projektGeraeteklasse->name == '3-ACHS' 
        || $projekt->projektGeraeteklasse->name == 'GYRO' 
        || $projekt->projektGeraeteklasse->name == 'SONDER' 
        || $projekt->projektGeraeteklasse->name == 'UL-Trike')

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
                                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' =>'Bsp.: Reisepropeller (max. 20 Zeichen)'])}}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <label for="motorGetriebe_id" class="col-sm-4 col-form-label">Untersetzung</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="motorGetriebe_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($getriebeObjects as $getriebe)
                                    <option value="{{ $getriebe->id }}" {{ old('motorGetriebe_id') == $getriebe->id ? 'selected' : '' }}>{{ $getriebe->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propeller_id" class="col-sm-4 col-form-label">Propeller / Ausführung / Farbe</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="propeller_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($propellerObjects as $propeller)
                                    <option value="{{ $propeller->id }}" {{ old('propeller_id') == $propeller->id ? 'selected' : '' }}>{{ $propeller->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="ausfuehrung_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($ausfuehrungen as $ausfuehrung)
                                    <option value="{{ $ausfuehrung->id }}" {{ old('ausfuehrung_id') == $ausfuehrung->id ? 'selected' : '' }}>{{ $ausfuehrung->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="farbe_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($farben as $farbe)
                                    <option value="{{ $farbe->id }}" {{ old('farbe_id') == $farbe->id ? 'selected' : '' }}>{{ $farbe->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ausfuehrung"> 
                                    <span class="oi" data-glyph="info" title="Ausfuehrung Bausweise" aria-hidden="true"></span>Ausführung Def.
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propellerDurchmesserNeu_id" class="col-sm-4 col-form-label">Propeller eingekürzt auf</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="propellerDurchmesserNeu_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($propellerDurchmesserNeu as $propellerDurchmesser)
                                    <option value="{{ $propellerDurchmesser->id }}" {{ old('propellerDurchmesserNeu_id') == $propellerDurchmesser->id ? 'selected' : '' }}>{{ $propellerDurchmesser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kantenschutz_id" class="col-sm-4 col-form-label">PU-Kantenschutzband</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="kantenschutz_id">
                                    @if($projektPropellerObjects != null)
                                        @if($projektPropellerObjects->artikel_03Kantenschutz_id != NULL)
                                            <option value="{{ $projektPropellerObjects->artikel_03Kantenschutz->id }}">{{ $projektPropellerObjects->artikel_03Kantenschutz->text }}</option>
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
                                {{Form::text('typenaufkleber','', ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: H160Funbi'])}}
                            </div>
                        </div>
                        @if($kunde->kundeAufkleber->id == 1)
                            <div class="form-group row">
                                <label for="propellerAufkleber_id" class="col-sm-4 col-form-label">Logo Aufkleber</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="propellerAufkleber_id">
                                        @if($projektPropellerObjects != null)
                                            @if($projektPropellerObjects->propeller_aufkleber_id != NULL)
                                                <option value="{{ $projektPropellerObjects->propellerAufkleber->id }}">{{ $projektPropellerObjects->propellerAufkleber->text }}</option>
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
                                {{Form::textarea('notizProduktion','', ['class' => 'form-control','rows' => 3, 'placeholder' =>'Infos für die Produktion...'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-3">
                                <a href="/propeller/create" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> neuer Propeller</span>
                                </a>    
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#typenbezeichnung"> 
                                    <span class="oi" data-glyph="info" title="Typenbezeichnung ALT-NEU" aria-hidden="true"></span>Typenbez. NEU
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('gewicht','Abflugmasse [kg]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('gewicht','', ['class' => 'form-control','step' => '1','min' => '30', 'max' => '1000', 'placeholder' =>'Bsp.: 533'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('klappen_set','Klappen gesetzt',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                <div class="col-3">
                                        JA {{Form::radio('klappen_set','1', false, [])}}
                                </div>
                                <div class="col-3">
                                        NEIN {{Form::radio('klappen_set','0', false, [])}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('startzeit','Startzeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('startzeit','', ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1211'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('landezeit','Landezeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('landezeit','', ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1245'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('luftdruck','QNH [hPa]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('luftdruck','', ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 1013'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('temperatur','Außentemperatur Boden [°C]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('temperatur','', ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 15'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('metar','Wetter',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('metar','', ['class' => 'form-control', 'placeholder' =>'Bsp.: 020/4 CAVOK 14/01 1020'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::textarea('notiz','', ['class' => 'form-control','rows' => 4, 'placeholder' =>'Infos zum getesteten Propeller...'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('ergebnis_bewertung','Bewertung Ergebnis',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                <div class="col-12">
                                    Referenz-Info {{Form::checkbox('ergebnis_bewertung','1', false, [])}}  
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
                                    <th colspan="2">Messhöhe [ft]: {{Form::number('mp_hoehe','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000', 'placeholder' =>'Bsp.: 2000'])}}</th>
                                    <th colspan="2">Temp. in Höhe [°C]: {{Form::number('mp_hoehe','', ['class' => 'form-control','step' => '1','min' => '-10', 'max' => '20', 'placeholder' =>'Bsp.: 12'])}}</th>
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
                                    <th>{{Form::number('mp_Vo_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5200'])}}</th>
                                    <th>{{Form::number('mp_Vx_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5050'])}}</th>
                                    <th>{{Form::number('mp_Vmax_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5450'])}}</th>
                                    <th>{{Form::number('mp1_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5000'])}}</th>
                                    <th>{{Form::number('mp2_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 4800'])}}</th>
                                    <th>{{Form::number('mp3_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 4300'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Steigrate & Verbrauch [ft/min & l/h]</th>
                                    <th>X</th>
                                    <th>{{Form::number('mp_Vx_steigrate','', ['class' => 'form-control','step' => '1','min' => '500', 'max' => '5000', 'placeholder' =>'Bsp.: 1020'])}}</th>
                                    <th>{{Form::number('mp_Vmax_verbrauch','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 27,9'])}}</th>
                                    <th>{{Form::number('mp1_verbrauch','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 24,9'])}}</th>
                                    <th>{{Form::number('mp2_verbrauch','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 25,1'])}}</th>
                                    <th>{{Form::number('mp3_verbrauch','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 22,8'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Ladedruck [inchHg]</th>
                                    <th>{{Form::number('mp_Vo_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 29,8'])}}</th></th>
                                    <th>{{Form::number('mp_Vx_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 29,2'])}}</th>
                                    <th>{{Form::number('mp_Vmax_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 27,9'])}}</th></th>
                                    <th>{{Form::number('mp1_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 24,9'])}}</th>
                                    <th>{{Form::number('mp2_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 25,0'])}}</th>
                                    <th>{{Form::number('mp3_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 22,8'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">IAS [km/h]</th>
                                    <th>X</th>
                                    <th>{{Form::number('mp_Vx_IAS','', ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400', 'placeholder' =>'Bsp.: 120'])}}</th>
                                    <th>{{Form::number('mp_Vmax_IAS','', ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400', 'placeholder' =>'Bsp.: 220'])}}</th>
                                    <th>{{Form::number('mp1_IAS','', ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400', 'placeholder' =>'Bsp.: 210'])}}</th>
                                    <th>{{Form::number('mp2_IAS','', ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400', 'placeholder' =>'Bsp.: 180'])}}</th>
                                    <th>{{Form::number('mp3_IAS','', ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400', 'placeholder' =>'Bsp.: 155'])}}</th>
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
                                    <td>{{Form::number('mp_beginn_Vx_temp_oel','', ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 76'])}}</td></td>
                                    <td>{{Form::number('mp_beginn_Vx_temp_luft','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 8'])}}</td></td>
                                    <td>{{Form::number('mp_beginn_Vx_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5070'])}}</td>
                                    <td>{{Form::number('mp_beginn_Vx_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 28,8'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 30sec</td>
                                    <td>{{Form::number('mp_nach30s_Vx_hoehe','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000', 'placeholder' =>'Bsp.: 1520'])}}</td>
                                    <td>{{Form::number('mp_nach30s_Vx_temp_oel','', ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 72'])}}</td></td>
                                    <td>{{Form::number('mp_nach30s_Vx_temp_luft','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 8'])}}</td></td>
                                    <td>{{Form::number('mp_nach30s_Vx_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5030'])}}</td>
                                    <td>{{Form::number('mp_nach30s_Vx_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 28,4'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 60sec</td>
                                    <td>{{Form::number('mp_nach60s_Vx_hoehe','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000', 'placeholder' =>'Bsp.: 1960'])}}</td>
                                    <td>{{Form::number('mp_nach60s_Vx_temp_oel','', ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 77'])}}</td></td>
                                    <td>{{Form::number('mp_nach60s_Vx_temp_luft','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 8'])}}</td></td>
                                    <td>{{Form::number('mp_nach60s_Vx_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5020'])}}</td>
                                    <td>{{Form::number('mp_nach60s_Vx_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 28,0'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 90sec</td>
                                    <td>{{Form::number('mp_nach90s_Vx_hoehe','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000', 'placeholder' =>'Bsp.: 2360'])}}</td>
                                    <td>{{Form::number('mp_nach90s_Vx_temp_oel','', ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 84'])}}</td></td>
                                    <td>{{Form::number('mp_nach90s_Vx_temp_luft','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 8'])}}</td></td>
                                    <td>{{Form::number('mp_nach90s_Vx_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5020'])}}</td>
                                    <td>{{Form::number('mp_nach90s_Vx_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 27,6'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 120sec</td>
                                    <td>{{Form::number('mp_nach120s_Vx_hoehe','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000', 'placeholder' =>'Bsp.: 2750'])}}</td>
                                    <td>{{Form::number('mp_nach120s_Vx_temp_oel','', ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 90'])}}</td></td>
                                    <td>{{Form::number('mp_nach120s_Vx_temp_luft','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 7'])}}</td></td>
                                    <td>{{Form::number('mp_nach120s_Vx_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5010'])}}</td>
                                    <td>{{Form::number('mp_nach120s_Vx_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 27,2'])}}</td>
                                </tr>
                                <tr>
                                    <td style="background-color: lightgray">nach 150sec</td>
                                    <td>{{Form::number('mp_nach150s_Vx_hoehe','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '10000', 'placeholder' =>'Bsp.: 3200'])}}</td>
                                    <td>{{Form::number('mp_nach150s_Vx_temp_oel','', ['class' => 'form-control','step' => '1','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 96'])}}</td></td>
                                    <td>{{Form::number('mp_nach150s_Vx_temp_luft','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 8'])}}</td></td>
                                    <td>{{Form::number('mp_nach150s_Vx_drehzahl','', ['class' => 'form-control','step' => '1','min' => '1000', 'max' => '8000', 'placeholder' =>'Bsp.: 5000'])}}</td>
                                    <td>{{Form::number('mp_nach150s_Vx_ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 26,9'])}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Testdaten für MS u.ä. -->
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
                                {{Form::text('beschreibung', '', ['class' => 'form-control', 'placeholder' =>'Bsp.: Reisepropeller (max. 20 Zeichen)'])}}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <label for="motorGetriebe_id" class="col-sm-4 col-form-label">Untersetzung</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="motorGetriebe_id">
                                    @if($projektPropellerObjects != null)
                                        <option value="{{ $projektPropellerObjects->motorGetriebe->id }}">{{ $projektPropellerObjects->motorGetriebe->name }}</option>
                                    @else
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                    @endif
                                    @foreach($getriebeObjects as $getriebe)
                                    <option value="{{ $getriebe->id }}" {{ old('motorGetriebe_id') == $getriebe->id ? 'selected' : '' }}>{{ $getriebe->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propeller_id" class="col-sm-4 col-form-label">Propeller / Ausführung / Farbe</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="propeller_id">
                                    @if($projektPropellerObjects != null)
                                        <option value="{{ $projektPropellerObjects->propeller->id }}">{{ $projektPropellerObjects->propeller->name }}</option>
                                    @else
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                    @endif
                                    @foreach($propellerObjects as $propeller)
                                    <option value="{{ $propeller->id }}" {{ old('propeller_id') == $propeller->id ? 'selected' : '' }}>{{ $propeller->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="ausfuehrung_id">
                                    @if($projektPropellerObjects != null)
                                        <option value="{{ $projektPropellerObjects->artikel03Ausfuehrung->id }}">{{ $projektPropellerObjects->artikel03Ausfuehrung->name }}</option>
                                    @else
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                    @endif
                                    @foreach($ausfuehrungen as $ausfuehrung)
                                    <option value="{{ $ausfuehrung->id }}" {{ old('ausfuehrung_id') == $ausfuehrung->id ? 'selected' : '' }}>{{ $ausfuehrung->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="farbe_id">
                                    @if($projektPropellerObjects != null)
                                        <option value="{{ $projektPropellerObjects->artikel03Farbe->id }}">{{ $projektPropellerObjects->artikel03Farbe->text }}</option>
                                    @else
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                    @endif
                                    @foreach($farben as $farbe)
                                    <option value="{{ $farbe->id }}" {{ old('farbe_id') == $farbe->id ? 'selected' : '' }}>{{ $farbe->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ausfuehrung"> 
                                    <span class="oi" data-glyph="info" title="Ausfuehrung Bausweise" aria-hidden="true"></span>Ausführung Def.
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="propellerDurchmesserNeu_id" class="col-sm-4 col-form-label">Propeller eingekürzt auf</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="propellerDurchmesserNeu_id">
                                    @if($projektPropellerObjects != null)
                                        @if($projektPropellerObjects->propeller_gek != 0)
                                            <option value="{{ $projektPropellerObjects->propellerDurchmesser->id }}">{{ $projektPropellerObjects->propellerDurchmesser->name }}</option>
                                        @else
                                            <option value="" disabled>Bitte wählen</option>
                                            <option value="">----</option>
                                        @endif
                                    @else
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                    @endif
                                    @foreach($propellerDurchmesserNeu as $propellerDurchmesser)
                                    <option value="{{ $propellerDurchmesser->id }}" {{ old('propellerDurchmesserNeu_id') == $propellerDurchmesser->id ? 'selected' : '' }}>{{ $propellerDurchmesser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('typenaufkleber','Typenaufkleber',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('typenaufkleber','', ['class' => 'form-control', 'placeholder' =>'Bsp.: H160Funbi'])}}
                            </div>
                        </div>
                        @if($kunde->kundeAufkleber->id == 1)
                            <div class="form-group row">
                                <label for="propellerAufkleber_id" class="col-sm-4 col-form-label">Größe Helix-Aufkleber</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="propellerAufkleber_id">

                                            <option value="" disabled>Bitte wählen</option>
                                            <option value="">----</option>

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
                                {{Form::textarea('notizProduktion','', ['class' => 'form-control','rows' => 3, 'placeholder' =>'Infos für die Produktion...'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-3">
                                <a href="/propeller/create" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> neuer Propeller</span>
                                </a>    
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#typenbezeichnung"> 
                                    <span class="oi" data-glyph="info" title="Typenbezeichnung ALT-NEU" aria-hidden="true"></span>Typenbez. NEU
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('gewicht','Abflugmasse [kg]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('gewicht','', ['class' => 'form-control','step' => '1','min' => '30', 'max' => '1000', 'placeholder' =>'Bsp.: 100'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('startzeit','Startzeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('startzeit','', ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1211'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('landezeit','Landezeit [UTC]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('landezeit','', ['class' => 'form-control','step' => '1','min' => '0000', 'max' => '2359', 'placeholder' =>'Bsp.: 1245'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('luftdruck','QNH [hPa]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('luftdruck','', ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 1013'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('temperatur','Außentemperatur Boden [°C]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-4">
                                {{Form::number('temperatur','', ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 15'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('metar','Wetter',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::text('metar','', ['class' => 'form-control','step' => '1', 'placeholder' =>'Bsp.: 020/4 CAVOK 14/01 1020'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::textarea('notiz','', ['class' => 'form-control','rows' => 4, 'placeholder' =>'500 Zeichen für Infos'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('ergebnis_bewertung','Bewertung Ergebnis',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                <div class="col-12">
                                    Referenz-Info {{Form::checkbox('ergebnis_bewertung','1', false, [])}}  
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
                                    <th>{{Form::number('mp_Vo_drehzahl','', ['class' => 'form-control','step' => '1','min' => '500', 'max' => '8000'])}}</th>
                                </tr>
                                <tr>
                                    <th style="background-color: lightgray">Standschub [kp]</th>
                                    <th>{{Form::number('mp_Vo_schub','', ['class' => 'form-control','step' => '1','min' => '1', 'max' => '500'])}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif        
{!! Form::close() !!}
@endsection

@include('projektPropeller.modalTypenbezeichnung')
@include('projektPropeller.modalAusfuehrung')