@extends('layouts.app')

@section('content')
<a href="/laermmessungen" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<div class="row">
    <div class="col-4">

    </div>
    <div class="col-4 mb-4">
        <a href="/laermmessBerichtPDF/{{$laermmessung->id}}" class="btn btn-warning btn-sm">
            BERICHT ERSTELLEN & DOWNLOAD <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
        </a>    
    </div>
</div>
<div class="row">
    <div class="col-2">

    </div>
    <div class="col-8">
        <h1><b>{{$laermmessung->herstellerFluggeraet}} / {{$laermmessung->fluggeraet}} / {{$laermmessung->typenbezeichnung}}</b></h1>
    </div>
</div>
<div class="row">
    {{-- Basisdaten Lärmmessung --}}
    <div class="col-xl-3">
        {!! Form::open(['action' => ['LaermmessungenController@update', $laermmessung->id], 'method' => 'POST']) !!}
            <!-- start card Daten Lärmmessdaten-->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <h4 class="card-title mb-4">Lärmmessung Basisdaten</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            {{Form::label('berichtGesperrt','LFA Bericht: ',['class' => 'col-sm-8 col-form-label'])}}
                        </div>
                        <div class="col-sm-5">
                            @if($laermmessung->berichtGesperrt == '1')
                                gesperrt {{Form::radio('berichtGesperrt', '1', 'checked')}}<br>
                                nicht gesperrt {{Form::radio('berichtGesperrt', '0')}}
                            @else
                                gesperrt {{Form::radio('berichtGesperrt', '1')}}<br>
                                nicht gesperrt {{Form::radio('berichtGesperrt', '0', 'checked')}}
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kunde_id','Kunden ID',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kunde_id',$laermmessung->kunde_id, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kunde','Kunde',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kunde',$laermmessung->kunde->matchcode, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('messdatum','Messdatum',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::date('messdatum',$laermmessung->messdatum)}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('protokolldatum','Protokolldatum',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::date('protokolldatum',$laermmessung->protokolldatum)}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('messort','Messort',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messort',$laermmessung->messort, ['class' => 'form-control', 'placeholder' =>'Bsp.: EDKA'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('messortHoehe','Höhe Messtelle über NN [m]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messortHoehe',$laermmessung->messortHoehe, ['class' => 'form-control', 'placeholder' =>'Bsp.: 193'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('fluggeraetGruppe','Lärmgrenzwert - Gruppe',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            @if($laermmessung->fluggeraetGruppe == 'Kap10-G1')
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G1', 'checked')}} Kap10 - Gruppe 1<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G2')}} Kap10 - Gruppe 2<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-UL')}} Kap10 - Gruppe UL<br>
                                {{Form::radio('fluggeraetGruppe', 'LVL')}} LVL 2004 Gruppe UL <= 472,5kg<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap11-UL')}} Kap11 - Gruppe UL Hubschrauber bis 600kg<br>
                            @endif
                            @if($laermmessung->fluggeraetGruppe == 'Kap10-G2')
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G1')}} Kap10 - Gruppe 1<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G2', 'checked')}} Kap10 - Gruppe 2<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-UL')}} Kap10 - Gruppe UL<br>
                                {{Form::radio('fluggeraetGruppe', 'LVL')}} LVL 2004 Gruppe UL <= 472,5kg<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap11-UL')}} Kap11 - Gruppe UL Hubschrauber bis 600kg<br>
                            @endif
                            @if($laermmessung->fluggeraetGruppe == 'Kap10-UL')
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G1')}} Kap10 - Gruppe 1<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G2')}} Kap10 - Gruppe 2<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-UL', 'checked')}} Kap10 - Gruppe UL<br>
                                {{Form::radio('fluggeraetGruppe', 'LVL')}} LVL 2004 Gruppe UL <= 472,5kg<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap11-UL')}} Kap11 - Gruppe UL Hubschrauber bis 600kg<br>
                            @endif
                            @if($laermmessung->fluggeraetGruppe == 'LVL')
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G1')}} Kap10 - Gruppe 1<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G2')}} Kap10 - Gruppe 2<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-UL')}} Kap10 - Gruppe UL<br>
                                {{Form::radio('fluggeraetGruppe', 'LVL', 'checked')}} LVL 2004 Gruppe UL <= 472,5kg<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap11-UL')}} Kap11 - Gruppe UL Hubschrauber bis 600kg<br>
                            @endif
                            @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G1')}} Kap10 - Gruppe 1<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-G2')}} Kap10 - Gruppe 2<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap10-UL')}} Kap10 - Gruppe UL<br>
                                {{Form::radio('fluggeraetGruppe', 'LVL')}} LVL 2004 Gruppe UL <= 472,5kg<br>
                                {{Form::radio('fluggeraetGruppe', 'Kap11-UL', 'checked')}} Kap11 - Gruppe UL Hubschrauber bis 600kg<br>
                            @endif
                            <div>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#fluggeraetGruppe">
                                    <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('fluggeraetHersteller','Hersteller Fluggerät',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('fluggeraetHersteller',$laermmessung->herstellerFluggeraet, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('fluggeraet','Fluggerät',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('fluggeraet',$laermmessung->fluggeraet, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('muster','Muster',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('muster',$laermmessung->muster, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('baureihe','Baureihe',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('baureihe',$laermmessung->baureihe, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kennung','Kennung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kennung',$laermmessung->kennung, ['class' => 'form-control', 'placeholder' =>'Bsp.: D-MISI'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('spannweite','Spannweite [m]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('spannweite',$laermmessung->spannweite, ['class' => 'form-control','step' => '0.01','min' => '4', 'max' => '15', 'placeholder' =>'Bsp.: 7.85'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('werknummer','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('werknummer',$laermmessung->werknummer, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('baujahr','Baujahr',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('baujahr',$laermmessung->baujahr, ['class' => 'form-control','step' => '1','min' => '1900', 'max' => '2100', 'placeholder' =>'Bsp.: 2020'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('fahrwerk','Fahrwerk',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            @if($laermmessung->fahrwerk == 'fest')
                                {{Form::radio('fahrwerk', 'fest', true)}} fest <br>
                                {{Form::radio('fahrwerk', 'einziehbar', false)}} einziehbar
                            @else
                                {{Form::radio('fahrwerk', 'fest', false)}} fest <br>
                                {{Form::radio('fahrwerk', 'einziehbar', true)}} einziehbar
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kennblattNr','Kennblatt Nr.',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kennblattNr',$laermmessung->kennblatt, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('mtow','MTOW [kg]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('mtow',$laermmessung->mtow, ['class' => 'form-control','step' => '0.5','min' => '450', 'max' => '8618', 'placeholder' =>'Bsp.: 600'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz',$laermmessung->notiz, ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <h4 class="card-title mb-4">Flugleistungen lt. Handbuch</h4>
                        </div>
                    </div>
                    @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                        <div class="form-group row">
                            {{Form::label('Vmax','Vmax [km/h]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('Vmax',$laermmessung->v_max, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '400', 'placeholder' =>'Bsp.: 160'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('Vh','Vh [km/h]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('Vh',$laermmessung->v_h, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '400', 'placeholder' =>'Bsp.: 145'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('drehzahlRC','Rotordrehzahl bei PDauer,max [U/min]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('drehzahlRC',$laermmessung->drehzahlRC, ['class' => 'form-control','min' => '0','placeholder' =>'Bsp.: 570'])}}
                            </div>
                        </div>
                    @else
                        <div class="form-group row">
                            {{Form::label('Vmax','Vmax [km/h]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('Vmax',$laermmessung->v_max, ['class' => 'form-control','step' => '1','min' => '45', 'max' => '400', 'placeholder' =>'Bsp.: 249'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('Vmin','Vmin [km/h]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('Vmin',$laermmessung->v_min, ['class' => 'form-control','step' => '1','min' => '45', 'max' => '300', 'placeholder' =>'Bsp.: 62'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('D15','Startstrecke D15 [m]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('D15',$laermmessung->D15, ['class' => 'form-control','step' => '1','min' => '100', 'max' => '1000', 'placeholder' =>'Bsp.: 430'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('RC','R/C [m/s]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('RC',$laermmessung->RC, ['class' => 'form-control','step' => '0.01','min' => '1', 'max' => '10', 'placeholder' =>'Bsp.: 3.5'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('Vy','Vy [m/s]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('Vy',$laermmessung->Vy, ['class' => 'form-control','step' => '0.1','min' => '1', 'max' => '50', 'placeholder' =>'Bsp.: 35'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('delta_CASIAS','Delta CAS / IAS [m/s]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('delta_CASIAS',$laermmessung->delta_CAS_IAS, ['class' => 'form-control','step' => '0.01','min' => '0', 'max' => '5', 'placeholder' =>'Bsp.: 1.60'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('drehzahlRC','Motordrehzahl im besten Steigen [U/min]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('drehzahlRC',$laermmessung->drehzahlRC, ['class' => 'form-control','min' => '0','placeholder' =>'Bsp.: 2111'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('ladedruckRC','Ladedruck im Steigflug [inHG]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('ladedruckRC',$laermmessung->ladedruckRC, ['class' => 'form-control','min' => '0', 'max' => '50', 'step' => '0.1'])}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- start card Motordaten -->
            <button id = "motordaten" type="button" class="btn btn-primary mb-2"><span class="oi" data-glyph="eye"></span> Motordaten</button>
            <div class="card mb-4 motordaten">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title mb-4">Motordaten zur neuen Lärmmessung</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('motor','Motor',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('motor',$laermmessung->motor, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('untersetzung','Untersetzung',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('untersetzung',$laermmessung->untersetzung, ['class' => 'form-control','min' => '1', 'max' => '4', 'step' => '0.01'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('motorWerknummer','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('motorWerknummer',$laermmessung->motorWerknummer, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('motorZylinder','Zylinderanzahl',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('motorZylinder',$laermmessung->motorZylinder, ['class' => 'form-control','min' => '1', 'max' => '12', 'step' => '1'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('motorArbeitsweise','Arbeitsweise',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('motorArbeitsweise',$laermmessung->motorArbeitsweise, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kraftstoffZufuhr','Kraftstoffzufuhr',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kraftstoffZufuhr',$laermmessung->kraftstoffZufuhr, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('nennleistung','Nennleistung [kW]',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('nennleistung',$laermmessung->nennleistung, ['class' => 'form-control', 'step' => '0.1'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('anzahlAbgasrohre','Anzahl Abgasrohre',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('anzahlAbgasrohre',$laermmessung->anzahlAbgasrohre, ['class' => 'form-control','min' => '1', 'max' => '10'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('schalldaempfer','Schalldämpfer',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('schalldaempfer',$laermmessung->schalldaempfer, ['class' => 'form-control', 'placeholder' =>'Bsp.: Wellerdämpder WD-01'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('kuehlklappen','Kühlklappen',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('kuehlklappen',$laermmessung->kuehlklappen, ['class' => 'form-control', 'placeholder' =>'Bsp.: offen'])}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- start card Propellerdaten -->
            <button id = "propellerdaten" type="button" class="btn btn-primary mb-2"><span class="oi" data-glyph="eye"></span> Propellerdaten</button>
            <div class="card mb-4 propellerdaten">
                <div class="card-body">
                    @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title mb-4">Rotordaten zur neuen Lärmmessung</h4>
                            </div>
                        </div>
                        Hauptrotor
                        <div class="form-group row">
                            {{Form::label('herstellerProp','Hersteller',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('herstellerProp',$laermmessung->herstellerProp, ['class' => 'form-control', 'placeholder' =>'Bsp.: Helix-Carbon GmbH'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('modellProp','Modell',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('modellProp',$laermmessung->modellProp, ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('werknummerProp','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('werknummerProp',$laermmessung->werknummerProp, ['class' => 'form-control', 'placeholder' =>'Bsp.: 0001-0002-0003'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('durchmesserNominell','Durchmesser nominell [m]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('durchmesserNominell',$laermmessung->durchmesserNominell, ['class' => 'form-control','min' => '0.1', 'max' => '8', 'step' => '0.01'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('durchmesserGemessen','Durchmesser gemessen [m]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('durchmesserGemessen',$laermmessung->durchmesserGemessen, ['class' => 'form-control','min' => '0.1', 'max' => '8', 'step' => '0.01'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('blattanzahl','Anzahl Rotorblätter',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('blattanzahl',$laermmessung->blattanzahl, ['class' => 'form-control','min' => '1', 'max' => '7', 'step' => '1'])}}
                            </div>
                        </div>
                        Heckrotor
                        <div class="form-group row">
                            {{Form::label('herstellerProp2','Hersteller',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('herstellerProp2',$laermmessung->herstellerProp2, ['class' => 'form-control', 'placeholder' =>'Bsp.: Helix-Carbon GmbH'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('modellProp2','Modell',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('modellProp2',$laermmessung->modellProp2, ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('werknummerProp2','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('werknummerProp2',$laermmessung->werknummerProp2, ['class' => 'form-control', 'placeholder' =>'Bsp.: 0001-0002-0003'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('durchmesserNominell2','Durchmesser nominell [m]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('durchmesserNominell2',$laermmessung->durchmesserNominell2, ['class' => 'form-control','min' => '0.1', 'max' => '8', 'step' => '0.01'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('durchmesserGemessen2','Durchmesser gemessen [m]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('durchmesserGemessen2',$laermmessung->durchmesserGemessen2, ['class' => 'form-control','min' => '0.1', 'max' => '8', 'step' => '0.01'])}}
                            </div>
                        </div>
                        Heckrotor
                        <div class="form-group row">
                            {{Form::label('blattanzahl2','Anzahl Rotorblätter',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('blattanzahl2',$laermmessung->blattanzahl2, ['class' => 'form-control','min' => '1', 'max' => '7', 'step' => '1'])}}
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title mb-4">Propellerdaten zur neuen Lärmmessung</h4>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('herstellerProp','Hersteller',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('herstellerProp',$laermmessung->herstellerProp, ['class' => 'form-control', 'placeholder' =>'Bsp.: Helix-Carbon GmbH'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('modellProp','Modell',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('modellProp',$laermmessung->modellProp, ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('werknummerProp','Werknummer',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('werknummerProp',$laermmessung->werknummerProp, ['class' => 'form-control', 'placeholder' =>'Bsp.: 0001-0002-0003'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('bauartProp','Bauart',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                @if($laermmessung->bauartProp == 'F')
                                    {{Form::radio('bauartProp', 'F', 'checked')}} Festwinkel<br>
                                    {{Form::radio('bauartProp', 'V')}} am Boden einstellbar<br>
                                    {{Form::radio('bauartProp', 'A')}} im Flug verstellbar<br>
                                @endif
                                @if($laermmessung->bauartProp == 'V')
                                    {{Form::radio('bauartProp', 'F')}} Festwinkel<br>
                                    {{Form::radio('bauartProp', 'V', 'checked')}} am Boden einstellbar<br>
                                    {{Form::radio('bauartProp', 'A')}} im Flug verstellbar<br>
                                @endif
                                @if($laermmessung->bauartProp == 'A')
                                    {{Form::radio('bauartProp', 'F')}} Festwinkel<br>
                                    {{Form::radio('bauartProp', 'V')}} am Boden einstellbar<br>
                                    {{Form::radio('bauartProp', 'A', 'checked')}} im Flug verstellbar<br>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('durchmesserNominell','Durchmesser nominell [m]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('durchmesserNominell',$laermmessung->durchmesserNominell, ['class' => 'form-control','min' => '0.1', 'max' => '3', 'step' => '0.01'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('durchmesserGemessen','Durchmesser gemessen [m]',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('durchmesserGemessen',$laermmessung->durchmesserGemessen, ['class' => 'form-control','min' => '0.1', 'max' => '3', 'step' => '0.01'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('blattanzahl','Anzahl Propellerblätter',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::number('blattanzahl',$laermmessung->blattanzahl, ['class' => 'form-control','min' => '1', 'max' => '7', 'step' => '1'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('blattspitzenform','Blattspitzenform',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('blattspitzenform',$laermmessung->blattspitzenform, ['class' => 'form-control', 'placeholder' =>'Bsp.: -SSI-'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('drehrichtungProp','Drehrichtung Propeller in Flugrichtung',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                @if($laermmessung->drehrichtungProp == 'L')
                                    {{Form::radio('drehrichtungProp', 'L', 'checked')}} linksdrehend<br>
                                    {{Form::radio('drehrichtungProp', 'R')}} rechtsdrehend
                                @endif
                                @if($laermmessung->drehrichtungProp == 'R')
                                    {{Form::radio('drehrichtungProp', 'L')}} linksdrehend<br>
                                    {{Form::radio('drehrichtungProp', 'R', 'checked')}} rechtsdrehend
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('nabenbezeichnung','Naben-bezeichnung',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('nabenbezeichnung',$laermmessung->nabenbezeichnung, ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('typenbezeichnung','Typen-bezeichnung',['class' => 'col-sm-4 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('typenbezeichnung',$laermmessung->typenbezeichnung, ['class' => 'form-control', 'placeholder' =>'Bsp.: H50F 1.75m R-SSI-18-3'])}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- start card Messpersonal -->
            <button id = "personaldaten" type="button" class="btn btn-primary mb-2"><span class="oi" data-glyph="eye"></span> Messpersonal</button>
            <div class="card mb-4 personaldaten">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title mb-4">Messpersonal der Lärmmessung</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('leiter','Verantwortliche Leiter',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('leiter',$laermmessung->leiter, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('messstelleBoden1','Messstelle Boden 1',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messstelleBoden1',$laermmessung->messstelleBoden1, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('messstelleBoden2','Messstelle Boden 2',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('messstelleBoden2',$laermmessung->messstelleBoden2, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('pilot','Pilot',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('pilot',$laermmessung->pilot, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('beobachterFlugzeug','Beobachter im Flugzeug',['class' => 'col-sm-4 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('beobachterFlugzeug',$laermmessung->beobachterFlugzeug, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
            </div>
        {{Form::hidden('_method','PUT')}}
        {!! Form::close() !!}
    </div> 
    
    {{-- Messdaten Überflüge --}}
    <div class="col-xl-9">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <h4 class="card-title mb-4">Messdaten Überflüge</h4>
                    </div>
                    <div class="col-sm-1">

                    </div>
                    <div class="col-sm-2">
                        <h4><b>Lärmgrenzwert:</b> <br>{{round($laermmessung->laermgrenzwert,2)}} [dB(A)]</h4>
                    </div>
                    @if($laermmessung->fluggeraetGruppe != 'LVL' && $laermmessung->fluggeraetGruppe != 'Kap11-UL')
                        <div class="col-sm-2">
                            <h4><b>erhöhter Lärmschutz m. Bj. ab 01.01.2000:</b> <br>{{round(61+0.017*($laermmessung->mtow-500),2)}} [dB(A)]</h4>
                        </div>
                    @endif
                    <div class="col-sm-2">
                        <h4><b>Href:</b> <br>{{round($laermmessung->Href,0)}} [m]</h4>
                    </div>
                    @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                        <div class="col-sm-1">
                            <h4><b>Hmin QFE:</b> <br>{{round($laermmessung->Href-15,0)}} [m]</h4>
                        </div>
                        <div class="col-sm-1">
                            <h4><b>Hmax QFE:</b> <br>{{round($laermmessung->Href+15,0)}} [m]</h4>
                        </div>
                    @endif
                    @if($laermmessung->fluggeraetGruppe == 'LVL')
                        <div class="col-sm-1">
                            <h4><b>Hmin QFE:</b> <br>75 [m]</h4>
                        </div>
                        <div class="col-sm-1">
                            <h4><b>Hmax QFE:</b> <br>150 [m]</h4>
                        </div>
                    @else
                        <div class="col-sm-1">
                            <h4><b>Hmin QFE:</b> <br>{{round($laermmessung->Href-0.2*$laermmessung->Href,0)}} [m]</h4>
                        </div>
                        <div class="col-sm-1">
                            <h4><b>Hmax QFE:</b> <br>{{round($laermmessung->Href+0.2*$laermmessung->Href,0)}} [m]</h4>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-1">
                        
                    </div>
                    <div class="col-sm-2">
                        <h4><b>Mittelwert Messpegel korrigiert:</b> <br>{{round($pegelwert_durschnitt,2)}} [dB(A)]</h4>
                    </div>
                    <div class="col-sm-2">
                        <h4><b>Summe korr. Pegelw.:</b> <br>{{round($pegelwert_summe,2)}} [dB(A)]</h4>
                    </div>
                    <div class="col-sm-2">
                        <h4><b>Summe quadr. korr. Pegelw.:</b> <br>{{round($pegelwert_korr_summe,2)}} [dB(A)]^2</h4>
                    </div>
                    <div class="col-sm-2">

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <a href="/laermmessungDaten/create/?laermmessungID={{$laermmessung->id}}" class="btn btn-success">
                            <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="col-sm-1">
                        
                    </div>
                    <div class="col-sm-2">
                        <h4><b>Gewertete Messflüge:</b> <br>{{$anzahlMessfluege}}</h4>
                    </div>
                    <div class="col-sm-2">
                        <h4><b>Standardabweichung:</b> <br>{{round($standardabweichung,2)}} [dB(A)]</h4>
                    </div>
                    <div class="col-sm-2">
                        <h4><b>Studienfaktor t:</b> <br>{{$faktor_t}} [-]</h4>
                    </div>
                    <div class="col-sm-2">
                        <h4><b>Vertrauensgrenze:</b> <br>{{round($vertrauensgrenze,2)}} [dB(A)]</h4>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-striped" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">Überflug Nr.</th>
                                <th scope="col">Messung Uhrzeit</th>
                                <th scope="col">Windgeschw. [kt]</th>
                                <th scope="col">WindRich. [°]</th>
                                <th scope="col">Querwindkomp. [kt]</th>
                                <th scope="col">Flugbahn [°]</th>
                                <th scope="col">IAS [m/s]</th>
                                <th scope="col">Temp. Boden [°C]</th>
                                <th scope="col">Temp. Flughöhe [°C]</th>
                                <th scope="col">rel. Luftfeuchte [%]</th>
                                <th scope="col">QNH [hPa]</th>
                                @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                                    <th scope="col">Rotor Drehzahl [U/min]</th>
                                @else
                                    <th scope="col">Propeller Drehzahl [U/min]</th>
                                @endif
                                <th scope="col">Ladedruck [inchHG]</th>
                                <th scope="col">Höhe ü. Micro [m]</th>
                                <th scope="col">Seitl. Abweichung [°]</th>
                                <th scope="col">Messung OK?</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($laermmessungDateien) > 0)
                            @foreach($laermmessungDateien as $laermmessungDatei)
                            <tr>
                                <td style=min-width:50px>{{$laermmessungDatei->messdatenNr_id}}</td>
                                <td style=min-width:50px>{{date('H:i',strtotime($laermmessungDatei->messzeit))}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->windgeschwindigkeit}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->windrichtung}}</td>
                                @php
                                    $richtungQuerwind = abs($laermmessungDatei->flugbahn - $laermmessungDatei->windrichtung);  

                                    $QuerwindGeschwindkeit = round(sin(deg2rad($richtungQuerwind))*$laermmessungDatei->windgeschwindigkeit,1);

                                @endphp
                                <td style=min-width:50px>{{$QuerwindGeschwindkeit}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->flugbahn}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->IAS}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->temperatur_boden}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->temperatur_flugh}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->luftfeuchte_rel}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->QNH}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->drehzahl}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->ladedruck}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->hoehe_ueb_micro}}</td>
                                <td style=min-width:50px>{{$laermmessungDatei->seitl_abweichung}}</td>
                                <td style=min-width:50px>
                                    @if($laermmessungDatei->checked != 1)
                                        nicht OK
                                    @else
                                        OK
                                    @endif
                                </td>
                                <td style=min-width:50px>
                                    @if($laermmessungDatei->updated_at > $laermmessungDatei->created_at) 
                                        geändert: {{ $laermmessungDatei->updated_at }} / {{ $laermmessungDatei->user->name }}
                                    @else
                                        erstellt: {{ $laermmessungDatei->created_at }} / {{ $laermmessungDatei->user->name }}
                                    @endif
                                </td>
                                <td style=min-width:50px>
                                    @if($laermmessung->berichtGesperrt != '1')
                                        <a href="/laermmessungDaten/{{$laermmessungDatei->id}}/edit" class="btn btn-warning">
                                            <span class="oi" data-glyph="pencil" title="Lärmmessungdatensatz bearbeiten" aria-hidden="true"></span>
                                        </a></td>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <p>Keine Daten vorhanden!!!</p>
                        @endif
                        </tbody>
                    </table>
                    @if($laermmessung->fluggeraetGruppe != 'Kap11-UL')
                        <table class="table table-striped" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Überflug Nr.</th>
                                    <th scope="col">Messpegel [dB(A)]</th>
                                    <th scope="col">Messpegel Umgeb. [dB(A)]</th>
                                    <th scope="col">Helicale Blattspitzen-Geschw. [m/s]</th>
                                    <th scope="col">Schall-Geschw. in Flugh. [m/s]</th>
                                    <th scope="col">Spitzen Machz. [-]</th>
                                    <th scope="col">Mr - Mt [-]</th>
                                    <th scope="col">delta 1 [dB(A)]</th>
                                    <th scope="col">delta 2 [dB(A)]</th>
                                    <th scope="col">delta 3 [dB(A)]</th>
                                    <th scope="col">delta 4 [dB(A)]</th>
                                    <th scope="col">korr. Pegel [dB(A)]</th>
                                    <th scope="col">Notiz</th>
                                    <th scope="col">Verwendet?</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>

                                </tr>
                            </thead>
                            <tbody>
                            @if(count($laermmessungDateien) > 0)
                                @foreach($laermmessungDateien as $laermmessungDatei)
                                <tr>
                                    <td style=min-width:50px>{{$laermmessungDatei->messdatenNr_id}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->messpegel}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->messpegel_umgeb}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->blattspitzengeschw}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->schallgeschw}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->spitzen_machzahl}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->Mr_minus_Mt}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->delta_1,3)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->delta_2,3)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->delta_3,3)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->delta_4,3)}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->messpegel_korr}}</td>
                                    <td style=min-width:50px>{{ Str::limit($laermmessungDatei->notiz,10,'...') }}</td>
                                    <td style=min-width:50px>
                                        @if($laermmessungDatei->verwendet != 1)
                                            X
                                        @else
                                            OK
                                        @endif
                                    </td>
                                    <td style=min-width:50px>
                                        @if($laermmessungDatei->updated_at > $laermmessungDatei->created_at) 
                                            geändert: {{ $laermmessungDatei->updated_at }} / {{ $laermmessungDatei->user->name }}
                                        @else
                                            erstellt: {{ $laermmessungDatei->created_at }} / {{ $laermmessungDatei->user->name }}
                                        @endif
                                    </td>
                                    <td style=min-width:50px>
                                        @if($laermmessung->berichtGesperrt != '1')
                                            <a href="/laermmessungDaten/{{$laermmessungDatei->id}}/edit" class="btn btn-warning">
                                                <span class="oi" data-glyph="pencil" title="Lärmmessungdatensatz bearbeiten" aria-hidden="true"></span>
                                            </a></td>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <p>Keine Daten vorhanden!!!</p>
                            @endif
                            </tbody>
                        </table>
                    @else
                        <table class="table table-striped" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Überflug Nr.</th>
                                    <th scope="col">Messpegel [dB(A)]</th>
                                    <th scope="col">Messpegel Umgeb. [dB(A)]</th>
                                    <th scope="col">Ref. Geschw. [kt]</th>
                                    <th scope="col">Ref. Geschw. Min [kt]</th>
                                    <th scope="col">Ref. Geschw. Max [kt]</th>
                                    <th scope="col">IAS [kt]</th>
                                    <th scope="col">delta 1 [dB(A)]</th>
                                    <th scope="col">delta 2 [dB(A)]</th>
                                    <th scope="col">korr. Pegel [dB(A)]</th>
                                    <th scope="col">Notiz</th>
                                    <th scope="col">Verwendet?</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>

                                </tr>
                            </thead>
                            <tbody>
                            @if(count($laermmessungDateien) > 0)
                                @foreach($laermmessungDateien as $laermmessungDatei)
                                <tr>
                                    <td style=min-width:50px>{{$laermmessungDatei->messdatenNr_id}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->messpegel}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->messpegel_umgeb}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->v_r_ziel,1)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->v_r_ziel - 3,0)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->v_r_ziel + 3,0)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->IAS/0.514444,0)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->delta_1,3)}}</td>
                                    <td style=min-width:50px>{{round($laermmessungDatei->delta_2,3)}}</td>
                                    <td style=min-width:50px>{{$laermmessungDatei->messpegel_korr}}</td>
                                    <td style=min-width:50px>{{ Str::limit($laermmessungDatei->notiz,10,'...') }}</td>
                                    <td style=min-width:50px>
                                        @if($laermmessungDatei->verwendet != 1)
                                            X
                                        @else
                                            OK
                                        @endif
                                    </td>
                                    <td style=min-width:50px>
                                        @if($laermmessungDatei->updated_at > $laermmessungDatei->created_at) 
                                            geändert: {{ $laermmessungDatei->updated_at }} / {{ $laermmessungDatei->user->name }}
                                        @else
                                            erstellt: {{ $laermmessungDatei->created_at }} / {{ $laermmessungDatei->user->name }}
                                        @endif
                                    </td>
                                    <td style=min-width:50px>
                                        <a href="/laermmessungDaten/{{$laermmessungDatei->id}}/edit" class="btn btn-warning">
                                            <span class="oi" data-glyph="pencil" title="Lärmmessungdatensatz bearbeiten" aria-hidden="true"></span>
                                        </a></td>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <p>Keine Daten vorhanden!!!</p>
                            @endif
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>   
</div>



<script>
    $(document).ready(function() {
        $("#motordaten").ready(function(){
            $(".motordaten").toggle();
        });
        $("#motordaten").click(function(){
            $(".motordaten").toggle();
        });

        $("#propellerdaten").ready(function(){
            $(".propellerdaten").toggle();
        });
        $("#propellerdaten").click(function(){
          $(".propellerdaten").toggle();
        });
        $("#personaldaten").ready(function(){
            $(".personaldaten").toggle();
        });
        $("#personaldaten").click(function(){
          $(".personaldaten").toggle();
        });
    });
</script>

@endsection

@include('laermmessungen.modalFluggeraetGruppe')