@extends('layouts.app')

@section('content')
<a href="/kunden/{{$kunde->id}}" class="btn btn-success">
    <span class="oi" data-glyph="home" title="Dashboard Kunde" aria-hidden="true"></span>
</a>
{!! Form::open(['action' => ['ProjekteController@update', $projekt->id], 'method' => 'POST']) !!}
<h1>Projekt {{ $projekt->name }} {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}</h1>
    <button id = "projektdaten" type="button" class="btn btn-primary mb-2"><span class="oi" data-glyph="eye"></span> Projektdaten</button>
    <div class="row projektdaten">
        <!-- start card Projektdaten -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h4 class="card-title mb-4">Projektdaten</h4>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('kunde_id','Kunden ID',['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('kunde_id',$kunde->id, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('beschreibung','Beschreibung',['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::text('beschreibung',$projekt->beschreibung, ['class' => 'form-control', 'placeholder' =>'Bsp.: Prototyp'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="projekt_geraeteklasse_id" class="col-sm-3 col-form-label">Geräteklasse</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="projekt_geraeteklasse_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="{{ $projekt->projektGeraeteklasse->id }}">{{ $projekt->projektGeraeteklasse->name }}</option>
                                    @foreach($projektGeraeteklassen as $projektGeraeteklasse)
                                    <option value="{{ $projektGeraeteklasse->id }}" {{ old('projekt_geraete_klasse_id') == $projektGeraeteklasse->id ? 'selected' : '' }}>{{ $projektGeraeteklasse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('fluggeraet_id','Fluggerät',['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-8">
                                @if($projekt->fluggeraet_id != NULL)
                                    {{Form::hidden('fluggeraet_id',$projekt->fluggeraet->id)}}
                                    {{Form::text('fluggeraet_name',$projekt->fluggeraet->name, ['class' => 'form-control','readonly' => 'true'])}}
                                @else
                                    <select class="form-control" name="fluggeraet_id">
                                        <option value="" disabled>Bitte wählen</option>
                                        <option value="">----</option>
                                        @foreach($fluggeraete as $fluggeraet)
                                        <option value="{{ $fluggeraet->id }}" {{ old('fluggeraet_id') == $fluggeraet->id ? 'selected' : '' }}>{{ $fluggeraet->kunde->matchcode }} / {{ $fluggeraet->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="projekt_kategorie_id" class="col-sm-3 col-form-label">Kategorie</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="projekt_kategorie_id">
                                    <option value="{{ $projekt->projektKategorie->id }}">{{ $projekt->projektKategorie->name }}</option>
                                    @foreach($projektKategorien as $projektKategorie)
                                    <option value="{{ $projektKategorie->id }}" {{ old('projekt_kategorie_id') == $projektKategorie->id ? 'selected' : '' }}>{{ $projektKategorie->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="projekt_typ_id" class="col-sm-3 col-form-label">Typ</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="projekt_typ_id">
                                    <option value="{{ $projekt->projektTyp->id }}">{{ $projekt->projektTyp->name }}</option>
                                    @foreach($projektTypen as $projektTyp)
                                    <option value="{{ $projektTyp->id }}" {{ old('projekt_typ_id') == $projektTyp->id ? 'selected' : '' }}>{{ $projektTyp->name }} ({{ $projektTyp->beziehung }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="projekt_status_id" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="projekt_status_id">
                                    <option value="{{ $projekt->projektStatus->id }}">{{ $projekt->projektStatus->name }}</option>
                                    @foreach($projektStatusObjects as $projektStatus)
                                    <option value="{{ $projektStatus->id }}" {{ old('projekt_status_id') == $projektStatus->id ? 'selected' : '' }}>{{ $projektStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
                            <div class="col-sm-8">
                                {{Form::textarea('notiz',$projekt->notiz, ['class' => 'form-control','rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start card Motordaten im Projekt -->
            <div class="col-lg-3">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title mb-4">Motor</h4>
                            </div>
                        </div>   
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select name="motor" id="motor" class="form-control">
                                    @if($projekt->motor_id != null)
                                        <option value="{{ $projekt->motor->id }}">{{ $projekt->motor->kunde->matchcode }} / {{ $projekt->motor->name }}</option>
                                        @foreach($motoren as $motor)
                                        <option value="{{ $motor->id }}" {{ old('motor_id') == $motor->id ? 'selected' : '' }}>{{ $motor->kunde }} / {{$motor->name}}</option>
                                        @endforeach
                                    @else
                                        @foreach($motoren as $motor)
                                        <option value="{{ $motor->id }}" {{ old('motor_id') == $motor->id ? 'selected' : '' }}>{{ $motor->kunde }} / {{$motor->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div>
                            <a href="/motoren/create" class="btn btn-success">
                                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> neuer Motor</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title mb-4">Flanschmaße</h4>
                            </div>
                            </div>   
                        <div class="form-group row">
                            <div class="col-sm-12">
                                @if($projekt->motor_flansch_id != null)
                                    <select name="motorFlansch" id="motorFlansch" class="form-control">
                                        <option value="{{ $projekt->motorFlansch->id }}">{{ $projekt->motorFlansch->name }}</option>
                                    </select>
                                @else
                                    @foreach($motorFlansche as $motorFlansch)
                                    <select name="motorFlansch" id="motorFlansch" class="form-control">
                                        <option value="{{ $motorFlansch->id }}" {{ old('motorFlansch') == $motorFlansch->id ? 'selected' : '' }}>{{$motorFlansch->name}}</option>
                                    </select>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div>
                            <a href="/motorFlansche/create" class="btn btn-success">
                                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> neues Flanschmaß</span>
                            </a>    
                        </div>
                    </div>
    
                </div>
            </div>
    </div>
{{Form::hidden('_method','PUT')}}
{!! Form::close() !!}
<div class="row">
    <!-- start card Propeller im Projekt -->
    <div class="col-lg-9">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <h4 class="card-title mb-4">Propellerdaten</h4>
                    </div>
                    <div class="col-sm-2">
                        <a href="/projektPropeller/create/?projektId={{$projekt->id}}" class="btn btn-success">
                            <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div>
                        <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-warning btn-sm mr-2">
                            <span class="oi" data-glyph="eye"> Reset</span>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <h5>Untersetzungen</h5>
                    </div>
                    <div class="col-sm-4">
                        @foreach($motorGetriebeObjects as $motorGetriebe)
                        <a href="/projekte/{{$projekt->id}}/edit?motorGetriebeID={{$motorGetriebe->id}}" class="btn btn-primary btn-sm mr-2">
                            <span class="oi" data-glyph="eye"> {{ number_format($motorGetriebe->untersetzungszahl,2) }}</span>
                        </a>
                        @endforeach

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <h5>Durchmesser</h5>
                    </div>
                    <div class="col-sm-6">
                        @foreach($propellerDurchmesserObjects as $propellerDurchmesser)
                            @foreach($projektPropellerObjects as $projektPropeller)
                                @if($projektPropeller->propellerDurchmesserID == $propellerDurchmesser->id)
                                    <a href="/projekte/{{$projekt->id}}/edit?propellerDurchmesserID={{$propellerDurchmesser->id}}" class="btn btn-primary btn-sm mr-2 mb-2">
                                        <span class="oi" data-glyph="eye">{{$propellerDurchmesser->name}}</span>
                                    </a>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
                <!-- Projektklasse MS oder MS-Trike -->
                @if($projekt->projektGeraeteklasse->id == 1 ||
                    $projekt->projektGeraeteklasse->id == 2 )
                    <div class="row col-sm-12">
                        <table class="table table-striped" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Untersetzung</th>
                                    <th>Ausführung</th>
                                    <th>max. Standdrehzahl [U/min]</th>
                                    <th>Standschub [kp]</th>
                                    <th>Drehzahl soll [U/min]</th>
                                    <th>Beschreibung / Einsatz</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($projektPropellerObjects) > 0)
                                @foreach($projektPropellerObjects as $projektPropeller)
                                    <tr>
                                        <td style=width:280px>
                                            @if($projektPropeller->propellerGek == 0)
                                                <a href="/projektPropeller/{{$projektPropeller->projektPropellerID}}/edit" class="btn btn-primary btn-sm">
                                                    <span class="oi" data-glyph="eye" title="Testdaten Details" aria-hidden="true"> {{ $projektPropeller->propellername }}</span>
                                                </a>
                                            @else
                                                <a href="/projektPropeller/{{$projektPropeller->projektPropellerID}}/edit" class="btn btn-primary btn-sm">
                                                <span class="oi" data-glyph="eye" title="Testdaten Details" aria-hidden="true"> {{ $projektPropeller->propellername }} gek. {{ $projektPropeller->propellerDurchmesser }}m</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td style=min-width:50px>{{ number_format($projektPropeller->untersetzung,2) }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->ausfuehrung }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp_Vo_drehzahl }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp_Vo_schub }}</td>
                                        <td style=min-width:50px>
                                            @if($projektPropeller->motorNenndrehzahl == NULL || $projektPropeller->motorNenndrehzahl == '-')
                                                k.A. Nenndrehzahl !
                                            @else
                                                {{ number_format($projektPropeller->motorNenndrehzahl / $projektPropeller->untersetzung,0) }}
                                            @endif
                                        </td>
                                        <td style=min-width:50px>{{ $projektPropeller->beschreibung }}</td>
                                        <td>
                                        {!! Form::open(['action' => ['ProjektPropellerController@destroy', $projektPropeller->projektPropellerID, 'name' => 'remove'], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method','DELETE')}}
                                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Propellers ".$projektPropeller->propellername." aus $projektPropeller->projektname .&quot;)"])}}
                                        {!! Form::close() !!}
                                        </td>
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            {{ csrf_field() }}
                                            <?php 
                                                if($projektPropeller->propellerGek == 0){
                                                    $propellername = $projektPropeller->propellername;
                                                }
                                                else{
                                                    $propellername = "$projektPropeller->propellername gek. ".$projektPropeller->propellerDurchmesser."m" ;
                                                }
                                                
                                                $projektPropellerPreis = $projektPropeller->artikel_01PropellerPreis + ($projektPropeller->blattanzahl * ($projektPropeller->ausfuehrungPreis + $projektPropeller->farbePreis))

                                            ?>
                                            <input type="hidden" value="{{ $kunde->id }}" id="customerID" name="customerID">
                                            <input type="hidden" value="{{ $projektPropeller->projektPropellerID }}" id="id" name="id">
                                            <input type="hidden" value="{{ $projektPropeller->propellerFormID }}" id="propellerFormID" name="propellerFormID">
                                            <input type="hidden" value="{{ $propellername }}" id="name" name="name">
                                            <input type="hidden" value="{{ $projektPropellerPreis }}" id="price" name="price">
                                            <input type="hidden" value="{{ $projektPropeller->blattanzahl }}" id="numOfBlades" name="numOfBlades">
                                            <input type="hidden" value="{{ $projektPropeller->projektID }}" id="projectID" name="projectID">
                                            <input type="hidden" value="{{ $projektPropeller->projektname }}" id="projectname" name="projectname">
                                            <input type="hidden" value="{{ $projektPropeller->geraeteklasse }}" id="projectclass" name="projectclass">
                                            <input type="hidden" value="{{ $projektPropeller->ausfuehrung }}" id="option" name="option">
                                            <input type="hidden" value="{{ $projektPropeller->bohrschema }}" id="drilling" name="drilling">
                                            <input type="hidden" value="{{ $projektPropeller->typenaufkleber }}" id="typesticker" name="typesticker">
                                            <input type="hidden" value="{{ $projektPropeller->kantenschutzband }}" id="protectionTape" name="protectionTape">
                                            <input type="hidden" value="0" id="testpropeller" name="testpropeller">
                                            {{-- <input type="hidden" value="{{ $projektPropeller->ds }}" id="ds" name="ds">
                                            <input type="hidden" value="{{ $projektPropeller->asgp }}" id="asgp" name="asgp">
                                            <input type="hidden" value="{{ $projektPropeller->spgp }}" id="spgp" name="spgp">
                                            <input type="hidden" value="{{ $projektPropeller->spkp }}" id="spkp" name="spkp">
                                            <input type="hidden" value="{{ $projektPropeller->ap }}" id="ap" name="ap"> --}}
                                            <input type="hidden" value="1" id="type" name="type">
                                            
                                            @if($projektPropeller->ausrichtung != NULL)
                                                <input type="hidden" value="{{ $projektPropeller->ausrichtung }}" id="assembly" name="assembly">
                                            @else
                                                @if($projektPropeller->geraeteklasse == 'UL-Trike' ||
                                                    $projektPropeller->geraeteklasse == 'MS-Trike' ||
                                                    $projektPropeller->geraeteklasse == 'MS' ||
                                                    $projektPropeller->geraeteklasse == 'GYRO')
                                                    <input type="hidden" value="Druck" id="assembly" name="assembly">
                                                @else
                                                    <input type="hidden" value="Zug" id="assembly" name="assembly">
                                                @endif
                                            @endif

                                            <input type="hidden" value="{{ $projektPropeller->propellerAufkleber }}" id="sticker" name="sticker">

                                            @if($projektPropeller->farbe == 'keine')
                                                <input type="hidden" value="S" id="color" name="color">
                                            @endif
                                            @if($projektPropeller->farbe == 'ZF')
                                                <input type="hidden" value="SW" id="color" name="color">
                                            @endif
                                            @if($projektPropeller->farbe == 'WTD')
                                                <input type="hidden" value="WTD" id="color" name="color">
                                            @endif

                                            <input type="hidden" value="" id="urgency" name="urgency">
                                            <input type="hidden" value="" id="certification" name="certification">
                                            <input type="hidden" value="{{ $projektPropeller->produktionsNotiz }}" id="comment" name="comment">
                                            <input type="hidden" value="1" id="quantity" name="quantity">

                                            <td>
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span>
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Kein Propellereintrag vorhanden.</p>
                            @endif
                            </tbody>
                        </table>
                    </div>
                <!-- restl. Projektklassen -->
                @else 
                    <div class="row col-sm-12">
                        <table class="table table-striped" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Untersetzung</th>
                                    <th>Ausführung</th>
                                    <th>Farbe</th>
                                    <th>Standdrehzahl [U/min]</th>
                                    <th>DZ [U/min] / Steigen [ft/min]</th>
                                    <th>DZ Vmax [U/min] / Geschw. [km/h]</th>
                                    <th>DZ b. Wert 1 [U/min] / Geschw. [km/h]</th>
                                    <th>DZ b. Wert 2 [U/min] / Geschw. [km/h]</th>
                                    <th>DZ b. Wert 3 [U/min] / Geschw. [km/h]</th>
                                    <th>Beschreibung / Einsatz</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($projektPropellerObjects) > 0)
                                @foreach($projektPropellerObjects as $projektPropeller)
                                    <tr>
                                        <td style=width:280px>
                                            @if($projektPropeller->propellerGek == 0)
                                                <a href="/projektPropeller/{{$projektPropeller->projektPropellerID}}/edit" class="btn btn-primary btn-sm">
                                                    <span class="oi" data-glyph="eye" title="Testdaten Details" aria-hidden="true"> {{ $projektPropeller->propellername }}</span>
                                                </a>
                                            @else
                                                <a href="/projektPropeller/{{$projektPropeller->projektPropellerID}}/edit" class="btn btn-primary btn-sm">
                                                <span class="oi" data-glyph="eye" title="Testdaten Details" aria-hidden="true"> {{ $projektPropeller->propellername }} gek. {{ $projektPropeller->propellerDurchmesser }}m</span>
                                                </a>
                                            @endif
                                        </td>
                                        <td style=min-width:50px>{{ number_format($projektPropeller->untersetzung,2) }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->ausfuehrung }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->farbe }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp_Vo_drehzahl }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp_Vx_drehzahl }} / {{ $projektPropeller->mp_Vx_steigrate }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp_Vmax_drehzahl }} / {{ $projektPropeller->mp_Vmax_IAS}}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp1_drehzahl }} / {{ $projektPropeller->mp1_IAS}}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp2_drehzahl }} / {{ $projektPropeller->mp2_IAS}}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->mp3_drehzahl }} / {{ $projektPropeller->mp3_IAS}}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->beschreibung }}</td>
                                        <td>
                                        {!! Form::open(['action' => ['ProjektPropellerController@destroy', $projektPropeller->projektPropellerID, 'name' => 'remove'], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method','DELETE')}}
                                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Propellers ".$projektPropeller->propellername." aus $projektPropeller->projektname .&quot;)"])}}
                                        {!! Form::close() !!}
                                        </td>
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            {{ csrf_field() }}
                                            <?php 
                                                if($projektPropeller->propellerGek == 0){
                                                    $propellername = $projektPropeller->propellername;
                                                }
                                                else{
                                                    $propellername = "$projektPropeller->propellername gek. ".$projektPropeller->propellerDurchmesser."m" ;
                                                }
                                                
                                                $projektPropellerPreis = $projektPropeller->artikel_01PropellerPreis + ($projektPropeller->blattanzahl * ($projektPropeller->ausfuehrungPreis + $projektPropeller->farbePreis))

                                            ?>
                                            <input type="hidden" value="{{ $kunde->id }}" id="customerID" name="customerID">
                                            <input type="hidden" value="{{ $projektPropeller->projektPropellerID }}" id="id" name="id">
                                            <input type="hidden" value="{{ $projektPropeller->propellerFormID }}" id="propellerFormID" name="propellerFormID">
                                            <input type="hidden" value="{{ $propellername }}" id="name" name="name">
                                            <input type="hidden" value="{{ $projektPropellerPreis }}" id="price" name="price">
                                            <input type="hidden" value="{{ $projektPropeller->blattanzahl }}" id="numOfBlades" name="numOfBlades">
                                            <input type="hidden" value="{{ $projektPropeller->projektID }}" id="projectID" name="projectID">
                                            <input type="hidden" value="{{ $projektPropeller->projektname }}" id="projectname" name="projectname">
                                            <input type="hidden" value="{{ $projektPropeller->geraeteklasse }}" id="projectclass" name="projectclass">
                                            <input type="hidden" value="{{ $projektPropeller->ausfuehrung }}" id="option" name="option">
                                            <input type="hidden" value="{{ $projektPropeller->farbe }}" id="color" name="color">
                                            <input type="hidden" value="{{ $projektPropeller->bohrschema }}" id="drilling" name="drilling">
                                            <input type="hidden" value="{{ $projektPropeller->typenaufkleber }}" id="typesticker" name="typesticker">
                                            <input type="hidden" value="{{ $projektPropeller->kantenschutzband }}" id="protectionTape" name="protectionTape">
                                            <input type="hidden" value="0" id="testpropeller" name="testpropeller">
                                            {{-- <input type="hidden" value="{{ $projektPropeller->ds }}" id="ds" name="ds">
                                            <input type="hidden" value="{{ $projektPropeller->asgp }}" id="asgp" name="asgp">
                                            <input type="hidden" value="{{ $projektPropeller->spgp }}" id="spgp" name="spgp">
                                            <input type="hidden" value="{{ $projektPropeller->spkp }}" id="spkp" name="spkp">
                                            <input type="hidden" value="{{ $projektPropeller->ap }}" id="ap" name="ap"> --}}
                                            <input type="hidden" value="1" id="type" name="type">
                                            
                                            @if($projektPropeller->ausrichtung != NULL)
                                                <input type="hidden" value="{{ $projektPropeller->ausrichtung }}" id="assembly" name="assembly">
                                            @else
                                                @if($projektPropeller->geraeteklasse == 'UL-Trike' ||
                                                    $projektPropeller->geraeteklasse == 'MS-Trike' ||
                                                    $projektPropeller->geraeteklasse == 'MS' ||
                                                    $projektPropeller->geraeteklasse == 'GYRO')
                                                    <input type="hidden" value="Druck" id="assembly" name="assembly">
                                                @else
                                                    <input type="hidden" value="Zug" id="assembly" name="assembly">
                                                @endif
                                            @endif

                                            <input type="hidden" value="{{ $projektPropeller->propellerAufkleber }}" id="sticker" name="sticker">

                                            {{-- @if($projektPropeller->farbe == 'keine')
                                                <input type="hidden" value="S" id="color" name="color">
                                            @endif
                                            @if($projektPropeller->farbe == 'ZF')
                                                <input type="hidden" value="SW" id="color" name="color">
                                            @endif
                                            @if($projektPropeller->farbe == 'WTD')
                                                <input type="hidden" value="WTD" id="color" name="color">
                                            @endif --}}

                                            <input type="hidden" value="" id="urgency" name="urgency">
                                            <input type="hidden" value="" id="certification" name="certification">
                                            <input type="hidden" value="{{ $projektPropeller->produktionsNotiz }}" id="comment" name="comment">
                                            <input type="hidden" value="1" id="quantity" name="quantity">

                                            <td>
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span>
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Kein Propellereintrag vorhanden.</p>
                            @endif
                            </tbody>
                        </table>
                    </div>
                @endif


            </div>
        </div>
    </div>

    <!-- start card Referenzpropeller -->
    <div class="col-lg-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="card-title mb-4">Referenzpropeller</h4>
                    </div>
                    @if(count($RefProjektPropellerObjects) > 0)
                        @foreach($RefProjektPropellerObjects as $ReferenzPropeller)
                            @if($ReferenzPropeller->propellerGek == 0)
                                <a href="/projektPropeller/create/?projektId={{$projekt->id}}&projektPropellerID={{$ReferenzPropeller->projektPropellerID}}" class="btn btn-success btn-sm mb-2">
                                    <span class="oi" data-glyph="plus" title="Propeller hinzufügen" aria-hidden="true"> {{ $ReferenzPropeller->propellername }} <br>({{$ReferenzPropeller->projektname}})</span>
                                </a>
                            @else
                                <a href="/projektPropeller/create/?projektId={{$projekt->id}}&projektPropellerID={{$ReferenzPropeller->projektPropellerID}}" class="btn btn-success btn-sm mb-2">
                                <span class="oi" data-glyph="plus" title="Propeller hinzufügen" aria-hidden="true"> {{ $ReferenzPropeller->propellername }} gek. {{ $ReferenzPropeller->propellerDurchmesser }}m <br>({{$ReferenzPropeller->projektname}})</span>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Kein Referenzpropeller vorhanden.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function() {
        // $('select[name="motor"]').on('change', function() {
        //     var motorID = $(this).val();
        //     if(motorID) {
        //         $.ajax({
        //             url: '/projekte/create/json-motorGetriebe/'+motorID,
        //             type: "GET",
        //             dataType: "json",
        //             success:function(data) {
        //                 $('select[name="motorGetriebe"]').empty();
        //                 $.each(data, function(key, value) {
        //                     $('select[name="motorGetriebe"]').append('<option value="'+ key +'">'+ value +'</option>');
        //                 });
        //             }
        //         });
        //     }else{
        //         $('select[name="motorGetriebe"]').empty();
        //     }
        // });
        $('select[name="motor"]').on('change', function() {
            var motorID = $(this).val();
            if(motorID) {
                $.ajax({
                    url: '/projekte/create/json-motorFlansch/'+motorID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="motorFlansch"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="motorFlansch"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="motorFlansch"]').empty();
            }
        });

        $("#projektdaten").ready(function(){
            $(".projektdaten").toggle();
        });
        $("#projektdaten").click(function(){
            $(".projektdaten").toggle();
        });
    });

</script>
@endsection