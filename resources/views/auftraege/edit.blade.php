@extends('layouts.app')

@section('content')


    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="home" aria-hidden="true"></span>
    </a>
    {!! Form::open(['action' => ['AuftraegeController@update', $auftrag->id], 'method' => 'POST']) !!}
    {{-- Bestellaufträge --}}
    @if($auftrag->auftrag_typ_id == 1)
        <div class="row">
            <div class="col-4">
                <h1>Auftrag {{ $auftrag->id }} bearbeiten</h1>
            </div>
        </div>
        {{-- Aufträge Details --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Kunde</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Projektinfo</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Auftragsauslöser</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Datum</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Auftrag</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <b>{{ $auftrag->kundeMatchcode }}</b>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <b>{{ $auftrag->projekt }}</b>
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                {{ $auftrag->user->name }}
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                {{ $auftrag->created_at }}
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                {{ $auftrag->id }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1" style="background-color: lightgray">
                                <sup><small>Menge</small></sup>
                            </div>
                            <div class="col-4" style="background-color: lightgray">
                                <sup><small>Propeller</small></sup>
                            </div>
                            <div class="col-1" style="background-color: lightgray">
                                <sup><small>Farbe</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Ausführung</small></sup>
                            </div>
                            <div class="col-1" style="background-color: lightgray">
                                <sup><small>Zertifzierung</small></sup>
                            </div>
                            <div class="col-1" style="background-color: lightgray">
                                <sup><small>Teilauftrag</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>MyFactory-AB</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1" style="min-height: 50px">
                                {{Form::number('anzahl',$auftrag->anzahl, ['class' => 'form-control','step' => '1','min' => '1', 'max' => '500'])}}
                            </div>
                            <div class="col-4" style="min-height: 50px">
                                <select class="form-control" name="propeller">
                                    <option value="{{ $auftrag->propeller }}">{{ $auftrag->propeller }}</option>
                                    @foreach($propeller as $key => $propellername)
                                    <option value="{{ $propellername }}" {{ old('propeller') == $propellername ? 'selected' : '' }}>{{ $propellername }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1" style="min-height: 50px">
                                <select class="form-control" name="propellerFarbe">
                                    <option value="{{ $auftrag->farbe }}">{{ $auftrag->farbe }}</option>
                                    @foreach($farben as $key => $farbe)
                                    <option value="{{ $farbe }}" {{ old('propellerFarbe') == $farbe ? 'selected' : '' }}>{{ $farbe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                <select class="form-control" name="propellerAusfuehrung">
                                    <option value="{{ $auftrag->ausfuehrung }}">{{ $auftrag->ausfuehrung }}</option>
                                    @foreach($ausfuehrungen as $key => $ausfuehrung)
                                    <option value="{{ $ausfuehrung }}" {{ old('propellerAusfuehrung') == $ausfuehrung ? 'selected' : '' }}>{{ $ausfuehrung }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1" style="min-height: 50px">
                                {{ $auftrag->form1 }}
                            </div>
                            <div class="col-1" style="min-height: 50px">
                                {{ $auftrag->teilauftrag }}
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                {{Form::number('lexwareAB',$auftrag->lexwareAB, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Motor</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Untersetzung</small></sup>
                            </div>
                            <div class="col-4" style="background-color: lightgray">
                                <sup><small>Motorflansch</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Dringlichkeit</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <b>{{ $auftrag->motor }}</b>
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                <b>{{ $auftrag->untersetzung }}</b>
                            </div>
                            <div class="col-4" style="min-height: 50px">
                                {{Form::text('motorFlansch',$auftrag->motorFlansch, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="dringlichkeit">
                                    <option value="{{ $auftrag->dringlichkeit }}">{{ $auftrag->dringlichkeit }}</option>
                                    <option value="dringend">dringend</option>
                                    <option value="nochHeute">noch Heute</option>
                                    <option value="">keine</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Propelleranordnung</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Aufkleber</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Typenaufkleber</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Kantenschutz</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>ETS</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2" style="min-height: 50px">
                                <select class="form-control" name="propellerAnordung">
                                    <option value="{{ $auftrag->anordnung }}">{{ $auftrag->anordnung }}</option>
                                    <option value="Zug">Zug</option>
                                    <option value="Druck">Druck</option>
                                </select>
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                <select class="form-control" name="aufkleber">
                                    <option value="{{ $auftrag->aufkleber }}">{{ $auftrag->aufkleber }}</option>
                                    <option value="Helix gross">Helix gross</option>
                                    <option value="Helix mittel">Helix mittel</option>
                                    <option value="Helix klein">Helix klein</option>
                                    <option value="Helix mini">Helix mini</option>
                                    <option value="Kunde">Kunde</option>
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{Form::text('typenaufkleber',$auftrag->typenaufkleber, ['class' => 'form-control'])}}
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                <select class="form-control" name="kantenschutz">
                                    <option value="{{ $auftrag->kantenschutzband }}">{{ $auftrag->kantenschutzband }}</option>
                                    @foreach($kantenschuetze as $key => $kantenschutz)
                                    <option value="{{ $kantenschutz }}" {{ old('kantenschutz') == $kantenschutz ? 'selected' : '' }}>{{ $kantenschutz }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{Form::date('ets',$auftrag->ets)}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="background-color: lightgray">
                                <sup><small>Anabauteile</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>Distanzscheibe</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>ASGP</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>SPGP</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>SPKP</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="distanzscheibe">
                                    <option value="{{ $auftrag->distanzscheibe }}">{{ $auftrag->distanzscheibe }}</option>
                                    @foreach($distanzscheiben as $key => $distanzscheibe)
                                    <option value="{{ $distanzscheibe }}" {{ old('distanzscheibe') == $distanzscheibe ? 'selected' : '' }}>{{ $distanzscheibe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                    <select class="form-control" name="asgp">
                                    <option value="{{ $auftrag->asgp }}">{{ $auftrag->asgp }}</option>
                                    @foreach($asgpObj as $key => $asgp)
                                    <option value="{{ $asgp }}" {{ old('asgp') == $asgp ? 'selected' : '' }}>{{ $asgp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="spgp">
                                    <option value="{{ $auftrag->spgp }}">{{ $auftrag->spgp }}</option>
                                    @foreach($spgpObj as $key => $spgp)
                                    <option value="{{ $spgp }}" {{ old('spgp') == $spgp ? 'selected' : '' }}>{{ $spgp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="spkp">
                                    <option value="{{ $auftrag->spkp }}">{{ $auftrag->spkp }}</option>
                                    @foreach($spkpObj as $key => $spkp)
                                    <option value="{{ $spkp }}" {{ old('spkp') == $spkp ? 'selected' : '' }}>{{ $spkp }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>Buchsen</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>Andruckplatte</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>Schutzhüllen</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="buchsen">
                                    <option value="{{ $auftrag->buchsen }}">{{ $auftrag->buchsen }}</option>
                                    @foreach($buchsenObj as $key => $buchsen)
                                    <option value="{{ $buchsen }}" {{ old('buchsen') == $buchsen ? 'selected' : '' }}>{{ $buchsen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="andruckplatte">
                                    <option value="{{ $auftrag->ap }}">{{ $auftrag->ap }}</option>
                                    @foreach($apObj as $key => $andruckplatten)
                                    <option value="{{ $andruckplatten }}" {{ old('andruckplatte') == $andruckplatten ? 'selected' : '' }}>{{ $andruckplatten }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <b>{{ $auftrag->Schutzhüllen }}</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="background-color: lightgray">
                                <sup><small>Notiz</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="min-height: 50px">
                                {{Form::textarea('notiz',$auftrag->notiz, ['class' => 'form-control', 'rows' => 3])}}
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    @endif

    {{-- Bestellaufträge Zubehör--}}
    @if($auftrag->auftrag_typ_id == 5 || $auftrag->auftrag_typ_id == 6)
        <div class="row">
            <div class="col-4">
                <h1>Auftrag {{ $auftrag->id }} bearbeiten</h1>
            </div>
        </div>
        {{-- Aufträge Details --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Kunde</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Auftragsauslöser</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Datum</small></sup>
                            </div>
                            <div class="col-1" style="background-color: lightgray">
                                <sup><small>Auftrag</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>MyFactory-AB</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <b>{{ $auftrag->kundeMatchcode }}</b>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{ $auftrag->user->name }}
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{ $auftrag->created_at }}
                            </div>
                            <div class="col-1" style="min-height: 50px">
                                {{ $auftrag->id }}
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                {{Form::number('lexwareAB',$auftrag->lexwareAB, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Menge</small></sup>
                            </div>
                            <div class="col-4" style="background-color: lightgray">
                                <sup><small>Zubehör</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>Dringlichkeit</small></sup>
                            </div>
                            <div class="col-1" style="background-color: lightgray">
                                
                            </div>
                            <div class="col-1" style="background-color: lightgray">
                                
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2" style="min-height: 50px">
                                {{Form::number('anzahl',$auftrag->anzahl, ['class' => 'form-control','step' => '1','min' => '1', 'max' => '5000'])}}
                            </div>
                            <div class="col-4" style="min-height: 50px">
                                <input type="hidden" value="Zubehoer" id="propeller" name="propeller">
                                {{ $auftrag->propeller }}
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                <select class="form-control" name="dringlichkeit">
                                    <option value="{{ $auftrag->dringlichkeit }}">{{ $auftrag->dringlichkeit }}</option>
                                    <option value="dringend">dringend</option>
                                    <option value="nochHeute">noch Heute</option>
                                    <option value="">keine</option>
                                </select>
                            </div>
                            <div class="col-1" style="min-height: 50px">
        
                            </div>
                            <div class="col-1" style="min-height: 50px">

                            </div>
                            <div class="col-3" style="min-height: 50px">
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12" style="background-color: lightgray">
                                <sup><small>Anbauteile</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>Distanzscheibe</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>ASGP</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>SPGP</small></sup>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <sup><small>SPKP</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="distanzscheibe">
                                    <option value="{{ $auftrag->distanzscheibe }}">{{ $auftrag->distanzscheibe }}</option>
                                    @foreach($distanzscheiben as $key => $distanzscheibe)
                                    <option value="{{ $distanzscheibe }}" {{ old('distanzscheibe') == $distanzscheibe ? 'selected' : '' }}>{{ $distanzscheibe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                    <select class="form-control" name="asgp">
                                    <option value="{{ $auftrag->asgp }}">{{ $auftrag->asgp }}</option>
                                    @foreach($asgpObj as $key => $asgp)
                                    <option value="{{ $asgp }}" {{ old('asgp') == $asgp ? 'selected' : '' }}>{{ $asgp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="spgp">
                                    <option value="{{ $auftrag->spgp }}">{{ $auftrag->spgp }}</option>
                                    @foreach($spgpObj as $key => $spgp)
                                    <option value="{{ $spgp }}" {{ old('spgp') == $spgp ? 'selected' : '' }}>{{ $spgp }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="spkp">
                                    <option value="{{ $auftrag->spkp }}">{{ $auftrag->spkp }}</option>
                                    @foreach($spkpObj as $key => $spkp)
                                    <option value="{{ $spkp }}" {{ old('spkp') == $spkp ? 'selected' : '' }}>{{ $spkp }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12" style="background-color: lightgray">
                                <sup><small>Notiz</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="min-height: 50px">
                                {{Form::textarea('notiz',$auftrag->notiz, ['class' => 'form-control', 'rows' => 3])}}
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    @endif

    {{-- Aufträge Reparatur / Reklamation --}}
    @if($auftrag->auftrag_typ_id == 2 || $auftrag->auftrag_typ_id == 3 || $auftrag->auftrag_typ_id == 4)
        <div class="row">
            <div class="col-4">
                <h1>Auftrag {{ $auftrag->id }} bearbeiten</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Kunde</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Auftragsauslöser</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Datum</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Auftrag</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <b>{{ $auftrag->kundeMatchcode }}</b>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{ $auftrag->user->name }}
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{ $auftrag->created_at }}
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{ $auftrag->id }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Anzahl</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Propeller</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Dringlichkeit</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>MyFactory-AB</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                {{Form::number('anzahl',$auftrag->anzahl, ['class' => 'form-control','step' => '1','min' => '1', 'max' => '99'])}}
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="propeller">
                                    <option value="{{ $auftrag->propeller }}">{{ $auftrag->propeller }}</option>
                                    @foreach($propeller as $key => $propellername)
                                    <option value="{{ $propellername }}" {{ old('propeller') == $propellername ? 'selected' : '' }}>{{ $propellername }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="dringlichkeit">
                                    <option value="{{ $auftrag->dringlichkeit }}">{{ $auftrag->dringlichkeit }}</option>
                                    <option value="nochHeute">noch heute</option>
                                    <option value="dringend">dringend</option>
                                    <option value="">keine</option>
                                </select>
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                {{Form::number('lexwareAB',$auftrag->lexwareAB, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="background-color: lightgray">
                                <sup><small>Bemerkungen</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="min-height: 50px">
                                {{Form::textarea('notiz',$auftrag->notiz, ['class' => 'form-control','rows' => 4,'placeholder' =>'500 Zeichen für Infos'])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    @endif

    {{-- Formenbau --}}
    @if($auftrag->auftrag_typ_id == 7)
        <div class="row">
            <div class="col-5">
                <h1>Auftrag {{ $auftrag->id }}</h1><br>
                <h2>Vorgang: {{ $auftrag->auftragTyp->name }}</h2>
                <h2>Status: {{ $auftrag->auftragstatus->name }}</h2>
                <h5>geändert am: {{ $auftrag->updated_at }} durch {{ $auftrag->user->name }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Kunde</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Auftragsauslöser</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Datum</small></sup>
                            </div>
                            <div class="col-1" style="background-color: lightgray">
                                <sup><small>Auftrag</small></sup>
                            </div>
                            <div class="col-2" style="background-color: lightgray">
                                <sup><small>LexwareAB</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                <b>{{ $auftrag->kundeMatchcode }}</b>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{ $auftrag->user->name }}
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                {{ $auftrag->created_at }}
                            </div>
                            <div class="col-1" style="min-height: 50px">
                                {{ $auftrag->id }}
                            </div>
                            <div class="col-2" style="min-height: 50px">
                                {{ $auftrag->lexwareAB }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Anzahl</small></sup>
                            </div>
                            <div class="col-6" style="background-color: lightgray">
                                <sup><small>Form</small></sup>
                            </div>
                            <div class="col-3" style="background-color: lightgray">
                                <sup><small>Dringlichkeit</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="min-height: 50px">
                                {{Form::number('anzahl',$auftrag->anzahl, ['class' => 'form-control','step' => '1','min' => '1', 'max' => '99'])}}
                            </div>
                            <div class="col-6" style="min-height: 50px">
                                <select class="form-control" name="propellerForm">
                                    <option value="{{ $auftrag->propeller }}">{{ $auftrag->propeller }}</option>
                                    @foreach($propellerFormen as $key => $propellerForm)
                                    <option value="{{ $propellerForm }}" {{ old('propellerForm') == $propellerForm ? 'selected' : '' }}>{{ $propellerForm }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="min-height: 50px">
                                <select class="form-control" name="dringlichkeit">
                                    <option value="{{ $auftrag->dringlichkeit }}">{{ $auftrag->dringlichkeit }}</option>
                                    <option value="dringend">dringend</option>
                                    <option value="nochHeute">noch Heute</option>
                                    <option value="">keine</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="background-color: lightgray">
                                <sup><small>Bemerkungen</small></sup>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" style="min-height: 50px">
                                {{ $auftrag->notiz}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    @endif
    {{Form::hidden('_method','PUT')}}
    {{Form::submit('ändern', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}


@endsection