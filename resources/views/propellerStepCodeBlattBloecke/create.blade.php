@extends('layouts.app')

@section('content')
    <h1>Neue Blockdaten für Blatt</h1>
    <a href="/propellerStepCodeBlattBloecke" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="zurück" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => 'PropellerStepCodeBlattBloeckeController@store', 'method' => 'POST']) !!}
            <h1>Input Blatt Block</h1>
            <div class="row">
                {{Form::label('propeller_modell_blatt','Propeller Blattmodell',['class' => 'col-2 col-form-label'])}}
                <select class="form-control col-3" name="propeller_modell_blatt_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($propellerModellBlaetter as $propellerModellBlatt)
                    <option value="{{ $propellerModellBlatt->id }}" {{ old('propeller_modell_blatt_id') == $propellerModellBlatt->id ? 'selected' : '' }}>{{ $propellerModellBlatt->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <div class="col-12">
                    <div class="row">
                        <table>
                            <tr>
                                <td>{{Form::label('include_tip_tangent','Tangentenrand Spitze Kontur folgen',['class' => 'col-2 col-form-label'])}}</td>
                                <td style="text-align: center">{{Form::checkbox('include_tip_tangent', 'ja',false)}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table>
                            <tr>
                                <td>Lfd. Nr.</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                                <td>13</td>
                                <td>14</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td style="font-size: 10pt;">z-Verschiebung Tangentenrand [mm]</td>
                                <td>{{Form::number('zKW1','0', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW2','0', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW3','0', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW4','0', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW5','0', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW6','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW7','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW8','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW9','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW10','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW11','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW12','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW13','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW14','', ['class' => 'form-control'])}}</td>
                                <td>{{Form::number('zKW15','', ['class' => 'form-control'])}}</td>
                            </tr>
                        </table>
                    </div>
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
            </div>
            <div class="row">
                {{Form::label('beschreibung','Beschreibung',['class' => 'col-2 col-form-label'])}}
                <div class="col-4">
                    {{Form::textarea('beschreibung','', ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                </div>
            </div>

            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection