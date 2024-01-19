@extends('layouts.app')

@section('content')
    <h1>Wurzeldaten AV {{$psc_WurzelAV->name}} dublizieren für StepCode</h1>
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
                            @for($x = 0;$x < count($inputWurzelAV[6]);$x++)
                                <?php $i = $x + 1;?>
                                <td>{{Form::text("Kreisebene$i",$inputWurzelAV[6][$x], ['class' => 'form-control'])}}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td style="font-size: 10pt;">Kreismittelpunkt x-Wert [mm]</td>
                            @for($x = 0;$x < count($inputWurzelAV[6]);$x++)
                                <?php $i = $x + 1;?>
                                <td>{{Form::text("Kreis_x$i",$inputWurzelAV[7][$x], ['class' => 'form-control'])}}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td style="font-size: 10pt;">Kreismittelpunkt y-Wert [mm]</td>
                            @for($x = 0;$x < count($inputWurzelAV[6]);$x++)
                                <?php $i = $x + 1;?>
                                <td>{{Form::text("Kreis_y$i",$inputWurzelAV[8][$x], ['class' => 'form-control'])}}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td style="font-size: 10pt;">Kreismittelpunkt z-Wert [-]</td>
                            @for($x = 0;$x < count($inputWurzelAV[6]);$x++)
                                <?php $i = $x + 1;?>
                                <td>{{Form::text("Kreis_z$i",$inputWurzelAV[9][$x], ['class' => 'form-control'])}}</td>
                            @endfor
                        </tr>
                        <tr>
                            <td style="font-size: 10pt;">Kreisdurchmesser [mm]</td>
                            @for($x = 0;$x < count($inputWurzelAV[6]);$x++)
                                <?php $i = $x + 1;?>
                                <td>{{Form::text("Kreis_D$i",$inputWurzelAV[10][$x], ['class' => 'form-control'])}}</td>
                            @endfor
                        </tr>
                    </table>
                </div>

                <div class="row">
                    {{Form::label('CAAV','Konuswinkel [°]',['class' => 'col-3 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('CAAV',$inputWurzelAV[0][0], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('RABAV','Verdrehwinkel in die Blockebene [°]',['class' => 'col-3 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('RABAV',$inputWurzelAV[1][0], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('WTAV','Abstand Tangentenausrichtung [mm]',['class' => 'col-3 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('WTAV',$inputWurzelAV[2][0], ['class' => 'form-control'])}}
                    </div>
                </div>  
                <div class="row">
                    {{Form::label('ATAV','Abstand Tangentenausrichtung zu x-RPS [mm]',['class' => 'col-3 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('ATAV',$inputWurzelAV[3][0], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('x_RPSAV','x-Wert Schnittstelle x-RPS []',['class' => 'col-3 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('x_RPSAV',$inputWurzelAV[4][0], ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="row">
                    {{Form::label('HTB','Hinterkantenverschiebung [mm]',['class' => 'col-3 col-form-label'])}}
                    <div class="col-2">
                        {{Form::number('HTB',$inputWurzelAV[5][0], ['class' => 'form-control'])}}
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
                        {{Form::textarea('beschreibung',$psc_WurzelAV->beschreibung, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection