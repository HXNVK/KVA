@extends('layouts.app')

@section('content')
    <h1>Neue Wurzeldaten "AV" für StepCode</h1>
    <a href="/propellerStepCodeWurzelnAV/" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="back" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => 'PropellerStepCodeWurzelnAVController@store', 'method' => 'POST']) !!}
            <h1>Input Wurzel A/V</h1>
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
            <div class="row">
                {{Form::label('beschreibung','Beschreibung',['class' => 'col-2 col-form-label'])}}
                <div class="col-6">
                    {{Form::textarea('beschreibung','', ['class' => 'form-control'])}}
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection