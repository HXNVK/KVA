@extends('layouts.app')

@section('content')
    <h1>Block Daten {{$psc_wurzelBlock->name}} dublizieren</h1>
    <a href="/propellerStepCodeWurzelBloecke/" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="back" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => 'PropellerStepCodeWurzelBloeckeController@store', 'method' => 'POST']) !!}
            <div>
                <h1>Input Block Wurzel</h1>
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
                                <td style="font-size: 10pt;">z-Verschiebung Tangentenrand [mm]</td>
                                @for($x = 0;$x < count($inputWurzelBlock[0]);$x++)
                                    <?php $i = $x + 1;?>
                                    <td>{{Form::number("zKWW$i",$inputWurzelBlock[0][$x], ['class' => 'form-control','min' => -15, 'max' => 15, 'step' => 0.1])}}</td>
                                @endfor
                            </tr>
                        </table>
                        <div class="row">
                            {{Form::label('bTRW','Breite Tangentenrand [mm]',['class' => 'col-2 col-form-label'])}}
                            <div class="col-1">
                                {{Form::number('bTRW',$inputWurzelBlock[1][0], ['class' => 'form-control', 'min' => 0, 'max' => 15, 'step' => 1])}}
                            </div>
                        </div>
                            <div class="row">
                                {{Form::label('bBW','Breite Blockrand [mm]',['class' => 'col-2 col-form-label'])}}
                                <div class="col-1">
                                    {{Form::number('bBW',$inputWurzelBlock[2][0], ['class' => 'form-control', 'min' => 0, 'max' => 15, 'step' => 1])}}
                                </div>
                        </div>
                        <table>
                        <tr>
                            <td style="font-size: 10pt;">Blockabmaße [mm]</td>
                            <td>{{Form::number('BlockWx',$inputWurzelBlock[3][0], ['class' => 'form-control','step' => 0.5])}}</td>
                            <td>{{Form::number('BlockWy',$inputWurzelBlock[3][1], ['class' => 'form-control','step' => 0.5])}}</td>
                            <td>{{Form::number('BlockWz',$inputWurzelBlock[3][2], ['class' => 'form-control','step' => 0.5])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt;">Blocknullpunkt [mm]</td>
                            <td>{{Form::number('BlockWx0',$inputWurzelBlock[4][0], ['class' => 'form-control','step' => 0.5])}}</td>
                            <td>{{Form::number('BlockWy0',$inputWurzelBlock[4][1], ['class' => 'form-control','step' => 0.5])}}</td>
                            <td>{{Form::number('BlockWz0',$inputWurzelBlock[4][2], ['class' => 'form-control','step' => 0.5])}}</td>
                        </tr>
                        <tr>
                            <td style="font-size:10pt;">Lage Zentrierkonus [mm]</td>
                            <td>{{Form::number('KonusWx',$inputWurzelBlock[5][0], ['class' => 'form-control','step' => 0.5])}}</td>
                            <td>{{Form::number('KonusWy',$inputWurzelBlock[5][1], ['class' => 'form-control','step' => 0.5])}}</td>
                            <td>{{Form::number('KonusWz',$inputWurzelBlock[5][2], ['class' => 'form-control','step' => 0.5])}}</td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    {{Form::label('beschreibung','Beschreibung',['class' => 'col-2 col-form-label'])}}
                    <div class="col-4">
                        {{Form::textarea('beschreibung',$psc_wurzelBlock->beschreibung, ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                    </div>
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection