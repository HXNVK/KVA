@extends('layouts.app')

@section('content')

    <div class="col-12">
        <a href="/kunden/{{$auftrag->kundeID}}" class="btn btn-success">
            <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"> zurück zu Kunde</span>
        </a>
        {{-- Bestellaufträge --}}
        @if($auftrag->auftrag_typ_id == 1)
            <div class="row">
                <div class="col-5">
                    <h1>Auftrag {{ $auftrag->id }}</h1><br>

                </div>
                <div class="col-3">
                    @if($auftrag->auftrag_status_id != 13)
                            <a href="/auftraege/{{$auftrag->id}}/edit" class="btn btn-warning btn-sm mb-2">
                                <span class="oi" data-glyph="pencil" title="zum Auftrag" aria-hidden="true"> bearbeiten </span>
                            </a>
                    @endif
                </div>
                <div class="col-3">
                    @if($auftrag->auftrag_bezahltstatus != NULL)
                        <a href="/auftraege/{{$auftrag->id}}/?auftragbezahlt=1" class="btn btn-success mr-4 mb-4">
                            <span class="oi" data-glyph="euro" title="ist bereits markiert als bezahlt" aria-hidden="true"> Auftrag bezahlt </span>
                        </a>
                    @else
                        <a href="/auftraege/{{$auftrag->id}}/?auftragbezahlt=1" class="btn btn-danger mr-4 mb-4">
                            <span class="oi" data-glyph="euro" title="drücken um als bezahlt zu markieren" aria-hidden="true"> Auftrag noch nicht bezahlt </span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <h2>Vorgang: {{ $auftrag->auftragTyp->name }}</h2>
                    <h2>Status: {{ $auftrag->auftragstatus->name }}</h2>
                    <h5>geändert am: {{ $auftrag->updated_at }} durch {{ $auftrag->user->name }}</h5>
                </div>
                <div class="col-4">
                    @if($auftrag->testpropeller == 1)
                        <b style="font-size: 20pt; font-weight: 900; color: rgb(255, 174, 0)">Testpropeller</b><br>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-9">
                    <div class="card">
                        {{-- Aufträge Details --}}
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
                                    @if($auftrag->createdAt_user_id != Null)
                                        {{ $auftrag->createdAtUser->name }}
                                    @else
                                        {{ $auftrag->user->name }}
                                    @endif
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
                                    <b>{{ $auftrag->anzahl }}</b>
                                </div>
                                <div class="col-4" style="min-height: 50px">
                                    <b>{{ $auftrag->propeller }}</b>
                                </div>
                                <div class="col-1" style="min-height: 50px">
                                    {{ $auftrag->farbe }}
                                </div>
                                <div class="col-2" style="min-height: 50px">
                                    {{ $auftrag->ausfuehrung }}
                                </div>
                                <div class="col-1" style="min-height: 50px">
                                    {{ $auftrag->form1 }}
                                </div>
                                <div class="col-1" style="min-height: 50px">
                                    {{ $auftrag->teilauftrag }}
                                </div>
                                <div class="col-2" style="min-height: 50px">
                                    {{ $auftrag->lexwareAB }}
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
                                    {{ $auftrag->motorFlansch }}
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    @if($auftrag->dringlichkeit != NULL)
                                        {{ $auftrag->dringlichkeit }}
                                    @else
                                        keine
                                    @endif
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
                                    <sup><small>Kantenschutzband</small></sup>
                                </div>
                                <div class="col-3" style="background-color: lightgray">
                                    <sup><small>ETS</small></sup>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2" style="min-height: 50px">
                                    {{ $auftrag->anordnung }}
                                </div>
                                <div class="col-2" style="min-height: 50px">
                                    {{ $auftrag->aufkleber }}
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                   {{ $auftrag->typenaufkleber }}
                                </div>
                                <div class="col-2" style="min-height: 50px">
                                    {{ $auftrag->kantenschutzband }}
                                 </div>
                                <div class="col-3" style="min-height: 50px">
                                    @if($auftrag->ets != NULL)
                                        {{ $auftrag->ets }}
                                    @elseif($auftrag->ets_alt != NULL)
                                        Altinfo: {{ $auftrag->ets_alt }}
                                    @else
                                        keine
                                    @endif
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
                                    <b>{{ $auftrag->distanzscheibe }}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    <b>{{ $auftrag->asgp }}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    <b>{{ $auftrag->spgp }}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    <b>{{ $auftrag->spkp }}</b>
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
                                    <b>{{ $auftrag->buchsen }}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    <b>{{ $auftrag->ap }}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    <b>{{ $auftrag->schutzhüllen }}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="background-color: lightgray">
                                    <sup><small>Notiz</small></sup>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="min-height: 50px">
                                    <b>{{ $auftrag->notiz }}</b>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @if($auftrag->auftrag_status_id != 13)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=19" class="btn btn-outline-primary mr-4 mb-4">Teillieferung / neuer Status ungeprüft</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=2" class="btn btn-dark mr-4 mb-4">Fertigung</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=9" class="btn btn-secondary mr-4 mb-4">Lamination</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=3" class="btn btn-purple mr-4 mb-4">Fertigung EXT HX</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=18" class="btn btn-info mr-4 mb-4">Fertigung EXT KJ</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=20" class="btn btn-light active mr-4 mb-4">Fertigung EXT HD / ZUL</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=17" class="btn btn-outline-secondary mr-4 mb-4">Entgratung</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=22" class="btn btn-check mr-4 mb-4">Lagereingang Prüfung</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=10" class="btn btn-danger mr-4 mb-4">Lager</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=15" class="btn btn-outline-danger mr-4 mb-4">Eingangslager</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=16" class="btn btn-outline-danger mr-4 mb-4"><span class="oi" data-glyph="pie-chart" title="zum Auftrag" aria-hidden="true"> Teillieferung</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=4" class="btn btn-warning mr-4 mb-4">Endfertigung</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=21" class="btn btn-warning mr-4 mb-4"><span class="oi" data-glyph="external-link" title="zum Auftrag" aria-hidden="true"> Endf. Werkstatt</span></a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=30" class="btn btn-hold mr-4 mb-4"><span class="oi" title="zum Auftrag" aria-hidden="true"> Endf. Auftrag wartend</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=14" class="btn btn btn-outline-success mr-4">Versandlager</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=8" class="btn btn-success mr-4">Versendet</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=13" class="btn btn-light">Stornieren</a>
                                        </div>
                                    </div>
                                @elseif(Auth::user()->id == 1 || Auth::user()->id == 5 || Auth::user()->id == 6)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=1" class="btn btn-primary mr-4 mb-4">Auftragsannahme / Status ungeprüft</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=10" class="btn btn-danger mr-4 mb-4">Lager</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=2" class="btn btn-dark mr-4 mb-4">Fertigung</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=9" class="btn btn-outline-secondary mr-4 mb-4">Lamination</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=3" class="btn btn-purple mr-4 mb-4">Fertigung EXT HX</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=18" class="btn btn-purple mr-4 mb-4">Fertigung EXT KJ</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=17" class="btn btn-secondary mr-4 mb-4">Entgratung</a>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=15" class="btn btn-outline-danger mr-4 mb-4">Eingangslager</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=4" class="btn btn-warning mr-4 mb-4">Endfertigung</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=14" class="btn btn btn-outline-success mr-4">Versandlager</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=8" class="btn btn-success mr-4">Versendet</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=13" class="btn btn-light">Stornieren</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-4">
                                        @switch($auftrag->auftrag_status_id)
                                            @case(13)
                                                <h1><b>Auftrag wurde storniert !!!</b></h1>
                                                @break
                                            @case(8)
                                                <h1><b>Auftrag wurde bereits versendet.</b></h1>
                                                @break
                                        @endswitch
                                    </div>
                                @endif
                            </div>                
                        </div>

                    </div>    
                </div>
                <div class="col-3">
                    <div class="card">
                        {{-- Aufträge Verlauf --}}
                        <?php
                            if($auftrag->log != NULL){
                                $anzahl = count(json_decode($auftrag->log));
                                $log = json_decode($auftrag->log);
                            }else{
                                $anzahl = 0;
                            }
                        ?>
                        <div class="card-body">
                            @if($anzahl != 0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Datum</th>
                                        <th scope="col">Kürzel</th>
                                        <th scope="col">Aktion</th>
                                    </tr>
                                    </thead>
                                    {{-- {{ $anzahl }}x Einträge:<br> --}}
                                        @for ($i = 0; $i < $anzahl; $i++)
                                            <?php 
                                            $a = $i +1; 
                                            ?>
                                            <tbody>
                                            <tr>
                                                <th scope="row">{{$a}}</th>
                                                <td>{{$log[$i][0]}}</td>
                                                <td>{{$log[$i][1]}}</td>
                                                <td>{{$log[$i][2]}}</td>
                                            </tr>
                                            </tbody>
                                        @endfor   

                                </table>
                            @else
                                Keine Logdaten vorhanden.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- Aufträge Retoure / Reparatur / Reklamation --}}
        @if($auftrag->auftrag_typ_id == 2 ||
            $auftrag->auftrag_typ_id == 3 ||
            $auftrag->auftrag_typ_id == 4)
        
            <div class="row">
                <div class="col-5">
                    <h1>Auftrag {{ $auftrag->id }}</h1><br>
                    <h2>Vorgang: {{ $auftrag->auftragTyp->name }}</h2>
                    <h2>Status: {{ $auftrag->auftragstatus->name }}</h2>
                    <h5>geändert am: {{ $auftrag->updated_at }} durch {{ $auftrag->user->name }}</h5>
                </div>
                <div class="col-4">
                    <a href="/auftraege/{{$auftrag->id}}/edit" class="btn btn-warning btn-sm mb-2">
                        <span class="oi" data-glyph="pencil" title="zum Auftrag" aria-hidden="true"> bearbeiten </span>
                    </a>
                </div>
                <div class="col-3">
                    @if($auftrag->auftrag_bezahltstatus != NULL)
                        <a href="/auftraege/{{$auftrag->id}}/?auftragbezahlt=1" class="btn btn-success mr-4 mb-4">
                            <span class="oi" data-glyph="euro" title="zum Auftrag" aria-hidden="true"> Auftrag bezahlt </span>
                        </a>
                    @else
                        <a href="/auftraege/{{$auftrag->id}}/?auftragbezahlt=1" class="btn btn-danger mr-4 mb-4">
                            <span class="oi" data-glyph="euro" title="zum Auftrag" aria-hidden="true"> Auftrag noch nicht bezahlt </span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-9">
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
                                    @if($auftrag->createdAt_user_id != Null)
                                        {{ $auftrag->createdAtUser->name }}
                                    @else
                                        {{ $auftrag->user->name }}
                                    @endif
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
                                    <b>{{ $auftrag->anzahl }}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    <b>{{ $auftrag->propeller}}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">    
                                    @if($auftrag->dringlichkeit != NULL)
                                        {{ $auftrag->dringlichkeit }}
                                    @else
                                        keine
                                    @endif
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    {{ $auftrag->lexwareAB }}
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
                            <div class="row">
                                <div class="col-12" style="background-color: lightgray">
                                    <sup><small>Retoure Propeller einsortiert und ausgetragen von</small></sup>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="min-height: 50px">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        {{-- Aufträge Verlauf --}}
                        <?php
                            if($auftrag->log != NULL){
                                $anzahl = count(json_decode($auftrag->log));
                                $log = json_decode($auftrag->log);
                            }else{
                                $anzahl = 0;
                            }
                        ?>
                        <div class="card-body">
                            @if($anzahl != 0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Datum</th>
                                        <th scope="col">Kürzel</th>
                                        <th scope="col">Aktion</th>
                                    </tr>
                                    </thead>
                                    {{-- {{ $anzahl }}x Einträge:<br> --}}
                                        @for ($i = 0; $i < $anzahl; $i++)
                                            <?php $a = $i +1; ?>
                                            <tbody>
                                            <tr>
                                                <th scope="row">{{$a}}</th>
                                                <td>{{$log[$i][0]}}</td>
                                                <td>{{$log[$i][1]}}</td>
                                                <td>{{$log[$i][2]}}</td>
                                            </tr>
                                            </tbody>
                                        @endfor   

                                </table>
                            @else
                                Keine Logdaten vorhanden.
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            @if($auftrag->auftrag_status_id != 13
                                && $auftrag->auftrag_status_id != 8)
                                <div class="row">
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=10" class="btn btn-danger mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Lager</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=15" class="btn btn-outline-danger mr-4 mb-4">Eingangslager</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=2" class="btn btn-dark mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Fertigung</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=4" class="btn btn-warning mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Endfertigung</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=21" class="btn btn-warning mr-4 mb-4"><span class="oi" data-glyph="external-link" title="zum Auftrag" aria-hidden="true"> Endf. Werkstatt</span></a>
                                    </div>
                                    <div class="col-lg-2">
                                            <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=30" class="btn btn-hold mr-4 mb-4"><span class="oi" title="zum Auftrag" aria-hidden="true"> Endf. Auftrag wartend</span></a>
                                        </div>
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=20" class="btn btn-light active mr-4 mb-4">Fertigung EXT HD / ZUL</a>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=14" class="btn btn-outline-success mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Versandlager</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=8" class="btn btn-success mr-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Versendet / Retourniert</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=13" class="btn btn-light mr-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Stornieren</a>
                                    </div>
                                    <div class="col-lg">
                                        
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-4">
                                    @switch($auftrag->auftrag_status_id)
                                        @case(13)
                                            <h1><b>Auftrag wurde storniert !!!</b></h1>
                                            @break
                                        @case(8)
                                            <h1><b>Auftrag wurde bereits versendet.</b></h1>
                                            @break
                                    @endswitch
                                </div>
                            @endif
                        </div>     
                    </div>
                </div>
            </div>
        @endif
        {{-- Zubehör --}}
        @if($auftrag->auftrag_typ_id == 5 || $auftrag->auftrag_typ_id == 6)
            <div class="row">
                <div class="col-5">
                    <h1>Auftrag {{ $auftrag->id }}</h1><br>
                    <h2>Vorgang: {{ $auftrag->auftragTyp->name }}</h2>
                    <h2>Status: {{ $auftrag->auftragstatus->name }}</h2>
                    <h5>geändert am: {{ $auftrag->updated_at }} durch {{ $auftrag->user->name }}</h5>
                </div>
                <div class="col-4">
                    <a href="/auftraege/{{$auftrag->id}}/edit" class="btn btn-warning btn-sm mb-2">
                        <span class="oi" data-glyph="pencil" title="zum Auftrag" aria-hidden="true"> bearbeiten </span>
                    </a>
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
                                    {{ $auftrag->lexwareAB }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2" style="background-color: lightgray">
                                    <sup><small>Anzahl</small></sup>
                                </div>
                                <div class="col-7" style="background-color: lightgray">
                                    <sup><small>Zubehör</small></sup>
                                </div>
                                <div class="col-2" style="background-color: lightgray">
                                    <sup><small>Teilauftrag</small></sup>
                                </div>
                                <div class="col-1" style="background-color: lightgray">
                                    <sup><small>Dringlichkeit</small></sup>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2" style="min-height: 50px">
                                    <b>{{ $auftrag->anzahl }}</b>
                                </div>
                                <div class="col-7" style="min-height: 50px">
                                    @if($auftrag->distanzscheibe != NULL)
                                        <b>{{ $auftrag->distanzscheibe}} </b>
                                    @endif
                                    @if($auftrag->asgp != NULL)
                                        <b>{{ $auftrag->asgp}} </b>
                                    @endif
                                    @if($auftrag->spgp != NULL)
                                        <b>{{ $auftrag->spgp}} </b>
                                    @endif
                                    @if($auftrag->spkp != NULL)
                                        <b>{{ $auftrag->spkp}} </b>
                                    @endif
                                    @if($auftrag->ap != NULL)
                                        <b>{{ $auftrag->ap}} </b>
                                    @endif
                                    @if($auftrag->adapterscheibe != NULL)
                                        <b>{{ $auftrag->adapterscheibe}} </b>
                                    @endif
                                    @if($auftrag->buchsen != NULL)
                                        <b>{{ $auftrag->buchsen}} </b>
                                    @endif
                                    @if($auftrag->schrauben != NULL)
                                        <b>{{ $auftrag->schrauben}} </b>
                                    @endif
                                    @if($auftrag->schraubenFlansch != NULL)
                                        <b>{{ $auftrag->schraubenFlansch}} </b>
                                    @endif
                                    @if($auftrag->schutzhuellen != NULL)
                                        <b>{{ $auftrag->schutzhuellen}} </b>
                                    @endif
                                    @if($auftrag->zubehoer != NULL)
                                        <b>{{ $auftrag->zubehoer}} </b>
                                    @endif
                                </div>
                                <div class="col-2" style="min-height: 50px">
                                    {{ $auftrag->teilauftrag}}
                                </div>
                                <div class="col-1" style="min-height: 50px">
                                    @if($auftrag->dringlichkeit != NULL)
                                        {{ $auftrag->dringlichkeit }}
                                    @else
                                        keine
                                    @endif
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

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if($auftrag->auftrag_status_id != 13
                            && $auftrag->auftrag_status_id != 8)
                            <div class="row">
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=10" class="btn btn-danger mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Lager</a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=2" class="btn btn-dark mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Fertigung</a>
                                </div>
                                <div class="col-lg-2">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=20" class="btn btn-light active mr-4 mb-4">Fertigung EXT HD / ZUL</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=4" class="btn btn-warning mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Endfertigung</a>
                                </div>
                                <div class="col-lg-2">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=21" class="btn btn-warning mr-4 mb-4"><span class="oi" data-glyph="external-link" title="zum Auftrag" aria-hidden="true"> Endf. Werkstatt</span></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=14" class="btn btn-outline-success mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Versandbereit</a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=8" class="btn btn-success mr-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Versendet</a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=13" class="btn btn-default mr-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Stornieren</a>
                                </div>
                                <div class="col-lg">
                                    
                                </div>
                            </div>
                        @else
                            <div class="col-lg-4">
                                @switch($auftrag->auftrag_status_id)
                                    @case(13)
                                        <h1><b>Auftrag wurde storniert !!!</b></h1>
                                        @break
                                    @case(8)
                                        <h1><b>Auftrag wurde bereits versendet.</b></h1>
                                        @break
                                @endswitch
                            </div>
                        @endif
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
                <div class="col-4">
                    <a href="/auftraege/{{$auftrag->id}}/edit" class="btn btn-warning btn-sm mb-2">
                        <span class="oi" data-glyph="pencil" title="zum Auftrag" aria-hidden="true"> bearbeiten </span>
                    </a>
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
                                    <b>{{ $auftrag->anzahl }}</b>
                                </div>
                                <div class="col-6" style="min-height: 50px">
                                    <b>{{ $auftrag->propeller }}</b>
                                </div>
                                <div class="col-3" style="min-height: 50px">
                                    @if($auftrag->dringlichkeit != NULL)
                                        {{ $auftrag->dringlichkeit }}
                                    @else
                                        keine
                                    @endif
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

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if($auftrag->auftrag_status_id != 13
                            && $auftrag->auftrag_status_id != 8)
                            {{-- <div class="row">
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=2" class="btn btn-dark mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">In Fertigung</a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=14" class="btn btn-outline-success mr-4 mb-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Versandbereit</a>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=8" class="btn btn-success mr-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Fertig</a>
                                </div>
                                <div class="col-lg-3">
                                    <a href="/auftraege/{{$auftrag->id}}/?auftragsstatus=13" class="btn btn-default mr-4"><span class="oi" data-glyph="wrench" aria-hidden="true">Stornieren</a>
                                </div>
                                <div class="col-lg">
                                    
                                </div>
                            </div>
                        @else
                            <div class="col-lg-4">
                                @switch($auftrag->auftrag_status_id)
                                    @case(13)
                                        <h1><b>Auftrag wurde storniert !!!</b></h1>
                                        @break
                                    @case(8)
                                        <h1><b>Form bereits gefertigt und geliefert.</b></h1>
                                        @break
                                @endswitch
                            </div>
                        @endif
                    </div>     
                </div>
            </div>
        @endif
    </div>

@endsection