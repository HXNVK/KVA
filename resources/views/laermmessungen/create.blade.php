@extends('layouts.app')

@section('content')
<div class="row">
    @include('internals.messages')
</div>
<a href="/laermmessungen" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
{!! Form::open(['action' => 'LaermmessungenController@store', 'method' => 'POST']) !!}
    <div class="row">
        <!-- start card Lärmmessdaten -->
        <div class="col-xl-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title mb-4">Stammdaten der neuen Lärmmessung</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kunde_id" class="col-sm-4 col-form-label">Kunde</label>
                        @if(isset($kunde_id))
                            <div class="col-sm-8">
                                {{Form::text('kunde_id',$kunde_id, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        @else
                            <div class="col-sm-8">
                                <select class="form-control" name="kunde_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($kunden as $kunde)
                                    <option value="{{ $kunde->id }}" {{ old('kunde_id') == $kunde->id ? 'selected' : '' }}>{{ $kunde->matchcode }} / {{ $kunde->name1 }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('kunde_id'))
                                <span class="text-danger">Kunde eintragen</span>
                            @endif
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('messdatum','Messdatum',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::date('messdatum','')}}
                            @if ($errors->has('messdatum'))
                                <span class="text-danger">Messdatum eintragen</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('messort','Messort',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messort','', ['class' => 'form-control', 'placeholder' =>'Bsp.: EDKA'])}}
                            @if ($errors->has('messort'))
                                <span class="text-danger">Messort eintragen</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('messortHoehe','Höhe Messtelle über NN [m]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messortHoehe','', ['class' => 'form-control', 'placeholder' =>'Bsp.: EDKA'])}}
                            @if ($errors->has('messortHoehe'))
                                <span class="text-danger">Höhe Messtelle über NN [m] eintragen</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('fluggeraetGruppe','Lärmgrenzwert - Gruppe ',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::radio('fluggeraetGruppe', 'Kap10-G1')}} Kap10 - Gruppe 1<br>
                            {{Form::radio('fluggeraetGruppe', 'Kap10-G2')}} Kap10 - Gruppe 2<br>
                            {{Form::radio('fluggeraetGruppe', 'Kap10-UL')}} Kap10 - Gruppe UL 472,5kg - 600kg<br>
                            {{Form::radio('fluggeraetGruppe', 'LVL')}} LVL 2004 Gruppe UL <= 472,5kg<br>
                            {{Form::radio('fluggeraetGruppe', 'Kap11-UL')}} Kap11 - Gruppe UL Hubschrauber bis 600kg<br>
                            <div>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#fluggeraetGruppe">
                                    <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                        @if ($errors->has('fluggeraetGruppe'))
                            <span class="text-danger">Gruppe wählen</span>
                        @endif

                    </div>
                    <div class="form-group row">
                        {{Form::label('fluggeraet_id','Fluggerät',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            <select class="form-control" name="fluggeraet_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($fluggeraete as $fluggeraet)
                                <option value="{{ $fluggeraet->id }}" {{ old('fluggeraet_id') == $fluggeraet->id ? 'selected' : '' }}>{{ $fluggeraet->name }} / {{ $fluggeraet->kunde->matchcode }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('fluggeraet_id'))
                                <span class="text-danger">Fluggerät wählen</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('werknummer','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('werknummer','', ['class' => 'form-control', 'placeholder' =>'Bsp.: 123'])}}
                        </div>
                        @if ($errors->has('werknummer'))
                            <span class="text-danger">Werknummer eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('baujahr','Baujahr',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('baujahr','', ['class' => 'form-control','step' => '1','min' => '1900', 'max' => '2100', 'placeholder' =>'Bsp.: 2020'])}}
                        </div>
                        @if ($errors->has('baujahr'))
                            <span class="text-danger">Baujahr eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('kennung','Kennung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kennung','', ['class' => 'form-control', 'placeholder' =>'Bsp.: D-MISI'])}}
                        </div>
                        @if ($errors->has('kennung'))
                            <span class="text-danger">Kennung eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('mtow','MTOW [kg]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('mtow','', ['class' => 'form-control','step' => '0.5','min' => '472.5', 'max' => '8618', 'placeholder' =>'Bsp.: 600'])}}
                        </div>
                        @if ($errors->has('mtow'))
                            <span class="text-danger">MTOW [kg] eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('spannweite','Spannweite [m]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            Spannweite wird anhand des Datensatzes Fluggerät gezogen.
                            {{-- {{Form::number('spannweite','', ['class' => 'form-control','step' => '0.01','min' => '7', 'max' => '15', 'placeholder' =>'Bsp.: 9.2'])}} --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz','', ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <!-- start card Motordaten -->
        <div class="col-xl-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="col-sm-12">
                        <h4 class="card-title mb-4">Flugleistungen lt. Handbuch</h4>
                    </div>
                    <div class="form-group row">
                        {{Form::label('D15','Startstrecke D15 [m]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('D15','', ['class' => 'form-control','step' => '1','min' => '100', 'max' => '1000', 'placeholder' =>'Bsp.: 430'])}}
                        </div>
                        @if ($errors->has('D15'))
                            <span class="text-danger">Startstrecke D15 [m] eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('RC','R/C [m/s]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('RC','', ['class' => 'form-control','step' => '0.01','min' => '1', 'max' => '8', 'placeholder' =>'Bsp.: 3.5'])}}
                        </div>
                        @if ($errors->has('RC'))
                            <span class="text-danger">R/C [m/s] eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('Vy','Vy [m/s]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('Vy','', ['class' => 'form-control','step' => '0.1','min' => '1', 'max' => '50', 'placeholder' =>'Bsp.: 35'])}}
                        </div>
                        @if ($errors->has('Vy'))
                            <span class="text-danger">Vy [m/s] eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('delta_CASIAS','Delta CAS / IAS [m/s]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('delta_CASIAS','', ['class' => 'form-control','step' => '0.01','min' => '0', 'max' => '5', 'placeholder' =>'Bsp.: 1.60'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('drehzahlRC','Motordrehzahl im besten Steigen [U/min]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('drehzahlRC','', ['class' => 'form-control','min' => '0','placeholder' =>'Bsp.: 5150'])}}
                        </div>
                        @if ($errors->has('drehzahlRC'))
                            <span class="text-danger">Motordrehzahl im besten Steigen [U/min] eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('ladedruckRC','Ladedruck im Steigflug [inHG]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('ladedruckRC','', ['class' => 'form-control','min' => '0', 'max' => '50', 'step' => '0.1'])}}
                        </div>
                        @if ($errors->has('ladedruckRC'))
                            <span class="text-danger">Ladedruck im Steigflug [inHG] eintragen</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title mb-4">Motordaten zur neuen Lärmmessung</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('motor_id','Motor',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($motoren as $motor)
                                <option value="{{ $motor->id }}" {{ old('motor_id') == $motor->id ? 'selected' : '' }}>{{ $motor->name }} / {{ $motor->kunde->matchcode }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('motor_id'))
                            <span class="text-danger">Motor wählen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('untersetzung','Untersetzung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('untersetzung','', ['class' => 'form-control','min' => '1', 'max' => '4', 'step' => '0.01'])}}
                        </div>
                        @if ($errors->has('untersetzung'))
                            <span class="text-danger">Untersetzung eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('motorWerknummer','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('motorWerknummer','', ['class' => 'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group row">
                        {{Form::label('anzahlAbgasrohre','Anzahl Abgasrohre',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('anzahlAbgasrohre','', ['class' => 'form-control','min' => '1', 'max' => '10'])}}
                        </div>
                        @if ($errors->has('anzahlAbgasrohre'))
                            <span class="text-danger">Anzahl Abgasrohre eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('schalldaempfer','Schalldämpfer',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('schalldaempfer','Standard', ['class' => 'form-control', 'placeholder' =>'Bsp.: Standard oder CKT-Remos'])}}
                        </div>
                        @if ($errors->has('schalldaempfer'))
                            <span class="text-danger">Schalldämpfer eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('kuehlklappen','Kühlklappenstellung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kuehlklappen','ohne', ['class' => 'form-control', 'placeholder' =>'Bsp.: offen'])}}
                        </div>
                        @if ($errors->has('kuehlklappen'))
                            <span class="text-danger">Kühlklappenstellung eintragen</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- start card Propellerdaten -->
        <div class="col-xl-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title mb-4">Propellerdaten zur neuen Lärmmessung</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('herstellerProp','Hersteller',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('herstellerProp','', ['class' => 'form-control', 'placeholder' =>'Bsp.: Helix'])}}
                        </div>
                        @if ($errors->has('untersetzung'))
                            <span class="text-danger">Hersteller eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('modellProp','Modell',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('modellProp','', ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F'])}}
                        </div>
                        @if ($errors->has('modellProp'))
                            <span class="text-danger">Modell eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('werknummerProp','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('werknummerProp','', ['class' => 'form-control', 'placeholder' =>'Bsp.: 0001-0002-0003'])}}
                        </div>
                        @if ($errors->has('werknummerProp'))
                            <span class="text-danger">Werknummer des Propellers eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('bauartProp','Bauart',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::radio('bauartProp', 'F')}} Festwinkel<br>
                            {{Form::radio('bauartProp', 'V')}} am Boden einstellbar<br>
                            {{Form::radio('bauartProp', 'A')}} im Flug verstellbar<br>
                        </div>
                        @if ($errors->has('bauartProp'))
                            <span class="text-danger">Bauart wählen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('durchmesserNominell','Durchmesser nominell [m]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('durchmesserNominell','', ['class' => 'form-control','min' => '0.1', 'max' => '10', 'step' => '0.01'])}}
                        </div>
                        @if ($errors->has('durchmesserNominell'))
                            <span class="text-danger">Durchmesser nominell [m] eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('durchmesserGemessen','Durchmesser gemessen [m]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('durchmesserGemessen','', ['class' => 'form-control','min' => '0.1', 'max' => '10', 'step' => '0.01'])}}
                        </div>
                        @if ($errors->has('durchmesserGemessen'))
                            <span class="text-danger">Durchmesser gemessen [m] eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('blattanzahl','Anzahl Propellerblätter',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('blattanzahl','', ['class' => 'form-control','min' => '1', 'max' => '7', 'step' => '1'])}}
                        </div>
                        @if ($errors->has('blattanzahl'))
                            <span class="text-danger">Anzahl Propellerblätter eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('blattspitzenform','Blattspitzenform',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('blattspitzenform','', ['class' => 'form-control', 'placeholder' =>'Bsp.: -SSI-'])}}
                        </div>
                        @if ($errors->has('blattspitzenform'))
                            <span class="text-danger">Blattspitzenform eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('drehrichtungProp','Drehrichtung Propeller in Flugrichtung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::radio('drehrichtungProp', 'L')}} linksdrehend<br>
                            {{Form::radio('drehrichtungProp', 'R')}} rechtsdrehend
                        </div>
                        @if ($errors->has('drehrichtungProp'))
                            <span class="text-danger">Drehrichtung wählen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('nabenbezeichnung','Nabenbezeichnung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('nabenbezeichnung','', ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F'])}}
                        </div>
                        @if ($errors->has('nabenbezeichnung'))
                            <span class="text-danger">Nabenbezeichung eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('typenbezeichnung','Typenbezeichnung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('typenbezeichnung','', ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F 1.75m R-SSI-18-3'])}}
                        </div>
                        @if ($errors->has('typenbezeichnung'))
                            <span class="text-danger">Typenbezeichnung eintragen</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- start card Messpersonal -->
        <div class="col-xl-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title mb-4">Messpersonal der Lärmmessung</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('leiter','Verantwortliche Leiter',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('leiter','', ['class' => 'form-control'])}}
                        </div>
                        @if ($errors->has('leiter'))
                            <span class="text-danger">Verantwortlichen Leiter eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('messstelleBoden1','Messstelle Boden 1',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messstelleBoden1','', ['class' => 'form-control'])}}
                        </div>
                        @if ($errors->has('messstelleBoden1'))
                            <span class="text-danger">Messstelle Boden 1 eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('messstelleBoden2','Messstelle Boden 2',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messstelleBoden2','', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('pilot','Pilot',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('pilot','', ['class' => 'form-control'])}}
                        </div>
                        @if ($errors->has('pilot'))
                            <span class="text-danger">Pilot eintragen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('beobachterFlugzeug','Beobachter im Flugzeug',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('beobachterFlugzeug','', ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
@endsection

@include('laermmessungen.modalFluggeraetGruppe')