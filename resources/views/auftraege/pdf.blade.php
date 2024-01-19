<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <style>
            table, th, td {
                border-collapse: collapse;
                border: 1px solid grey;
                min-width: 50px;
                table-layout:fixed;
                
            }
            th { font-size: 6pt; font-weight: 350; text-align: left; height: 15px; background-color: lightgrey}
            td { font-size: 12pt; font-weight: 350; text-align: center; height: 50px}

            thead { display: table-header-group }
            tfoot { display: table-row-group }
            
        </style>
    </head>       
    <body>
        {{-- FB019 Fertigungsauftrag --}}
        @if($auftrag->auftragTyp->id == 1)
            
                {{-- Header --}}
                <div>
                    <table style="border: 0px;">
                        <td style="text-align: left; width: 300px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="width: 40%"></td>
                        @if($auftrag->auftragStatus->name == 'Storniert')
                            <td style="text-align: center; width: 300px; height: 15px;" bgcolor="red">
                                    <b>Auftrag storniert !!!</b>
                            </td>
                        @else
                            <td style="text-align: center; width: 300px; height: 15px;">
                            </td>
                        @endif
                        <td style="text-align: left; width: 300px; height: 15px"><b>FB 019: Fertigungsauftrag</b></td>
                    </table>                    
                </div>
                {{-- Abschnitt 1: Daten für Büro --}}
                <div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="width: 460px">Matchcode</th>
                            <th style="width: 110px">MyFactory</th>
                            <th style="width: 50px">Auftragsauslöser</th>
                            <th style="width: 90px">Datum </th>
                            <th style="width: 100px"></th>
                            <th style="width: 110px">Auftragsnummer</th>
                        </tr>
                        <tr>
                            <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                            <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                            <td>
                                @if($auftrag->createdAt_user_id != Null)
                                    {{ $auftrag->createdAtUser->kuerzel }}
                                @else
                                    {{ $auftrag->user->kuerzel }}
                                @endif    
                            </td>
                            <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                            <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                            <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                        </tr>
                    </table>
                </div>
                {{-- Abschnitt 2: allg Daten Propeller --}}
                <div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="width: 50px">Anzahl</th>
                            <th colspan="5" style="width: 700px">Propeller</th>
                            <th style="width: 150px">Bauweise</th>
                        </tr>
                        <tr>
                            <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->anzahl }}</td>
                            <td colspan="5" style="font-size: 20pt; font-weight: 900; width: 750px">
                                @if($auftrag->notiz != NULL)
                                    <button style="background-color: orange"> ! </button>
                                @endif
                                @if($auftrag->ausfuehrung != 'A25-0'
                                    || $auftrag->ausfuehrung != 'A30-0'
                                    || $auftrag->ausfuehrung != 'A40-0'
                                    || $auftrag->ausfuehrung != 'A45-0'
                                    || $auftrag->ausfuehrung != 'A50-0'
                                    || $auftrag->ausfuehrung != 'A60-0')
                                    @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' || $auftrag->farbe == 'FD')
                                        {{ $auftrag->propeller }} / {{ $auftrag->farbe }} 
                                    @else
                                        {{ $auftrag->propeller }}
                                    @endif
                                @else
                                    @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' || $auftrag->farbe == 'FD' )
                                        {{ $auftrag->propeller }} / {{ $auftrag->farbe }} / {{ $auftrag->ausfuehrung }}
                                    @else
                                        {{ $auftrag->propeller }} / {{ $auftrag->ausfuehrung }}
                                    @endif
                                @endif
                            </td>
                            <td style="width: 100px; font-size: 20pt; font-weight: 900">{{ $auftrag->ausfuehrung }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th colspan="5" style="width: 900px">Propeller-Nr.</th>
                        </tr>
                        <tr>
                            @if($auftrag->anzahl < 5)
                                <td colspan="5" style="height: 30px; font-weight: 900; width: 900px">
                                    @if(!empty($propellernummern[0]))
                                        @for ($i = 0; $i < $auftrag->anzahl; $i++)
                                            {{$i+1}}/{{$auftrag->anzahl}}: {{substr($propellernummern[$i]['produktionsjahr'],-2)}}{{($propellernummern[$i]['id'])}}
                                        @endfor
                                    @else
                                        @if(Str::of($auftrag->propeller)->containsAll(["H50"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H60"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H40A"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H40V"])
                                            )    
                                                kein Datenbankeintrag
                                        @else
                                            nur für H40AV / H50 / H60
                                        @endif
                                    @endif
                                </td>
                            @else
                                <td colspan="5" style="height: 20px; font-weight: 600; width: 900px">
                                    @if(Str::of($auftrag->propeller)->containsAll(["H50"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H60"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H40A"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H40V"])
                                            )    
                                            Bitte folgende Seite(n) einsehen.
                                    @endif
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>
                {{-- Abschnitt 3: Daten für Fertigung --}}
                <div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="width: 180px">Dringlichkeit</th>
                            <th style="width: 180px">ETS</th>
                            <th style="width: 200px">Anzahl noch zu fertigender Blätter:</th>
                            <th style="width: 200px">Nächste freie Serien-Nr.:</th>
                            <!-- <th style="width: 300px">Propeller-Nr.:</th> -->
                            <th style="width: 150px">Teilauftrag</th>
                            
                        </tr>
                        <tr>
                            <td style="width: 200px; text-align:left; height: 40px;">
                                @if($auftrag->dringlichkeit == NULL)
                                    {{Form::checkbox('dringend','dringend', false, [])}} dringend
                                    <br>
                                    {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                                @elseif($auftrag->dringlichkeit == 'dringend')
                                    {{Form::checkbox('dringend','dringend', true, ['checked' => 'checked'])}} dringend
                                    <br>
                                    {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                                @elseif($auftrag->dringlichkeit == 'nochHeute')
                                    {{Form::checkbox('nochHeute','nochHeute', false, [])}} dringend
                                    <br>
                                    {{Form::checkbox('nochHeute','nochHeute', true, ['checked' => 'checked'])}} noch heute
                                @endif
                            </td>
                            <td style="width: 180px; text-align:center; height: 40px;">@if($auftrag->ets != NULL){{ date('d M Y', strtotime($auftrag->ets)) }}@endif</td>
                            <td style="width: 180px; text-align:center; height: 40px;"></td>
                            <td style="width: 180px; text-align:center; height: 40px;"></td>
                            <!-- <td style="width: 300px; text-align:center"></td> -->
                            <td style="width: 150px; text-align:center; font-size: 20pt; height: 40px;">
                                {{ $auftrag->teilauftrag }}

                                @if($auftrag->distanzscheibe != NULL ||
                                    $auftrag->asgp != NULL ||
                                    $auftrag->spgp != NULL ||
                                    $auftrag->spkp != NULL ||
                                    $auftrag->ap != NULL ||
                                    $auftrag->buchsen != NULL ||
                                    $auftrag->schrauben != NULL
                                    )

                                    + Zubehör
                                @endif
                            
                            </td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 100px; height: 30px; font-weight: 900">Serien-Nr.</td>
                            <td style="width: 70px; height: 30px; font-weight: 900">Wer</td>
                            <td style="width: 100px; height: 30px; font-weight: 900">Datum</td>
                            <td style="width: 50px; height: 30px; font-weight: 900">Ofen-Nr.</td>
                            <td style="width: 100px; height: 30px; font-weight: 900">Tempern Start</td>
                            <td style="width: 100px; height: 30px; font-weight: 900">Tempern Ende</td>
                            <td style="width: 250px; height: 30px; font-weight: 900">Bemerkung</td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">1+2</td>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">3+4</td>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">5+6</td>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">7+8</td>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">9+10</td>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">11+12</td>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                        <tr>
                            <td style="width: 100px; height: 30px; font-weight: 900"></td>
                            <td style="width: 250px; height: 30px; font-weight: 900"></td>
                        </tr>
                    </table>
                    @if(Str::of($auftrag->propeller)->containsAll(["H50"]) ||
                        Str::of($auftrag->propeller)->containsAll(["H60"]) ||
                        Str::of($auftrag->propeller)->containsAll(["H40A"]) ||
                        Str::of($auftrag->propeller)->containsAll(["H40V"])
                        )  
                        @if($auftrag->anzahl > 4)
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">13+14</td>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">15+16</td>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">17+18</td>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">19+20</td>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                    <td style="width: 250px; height: 30px; font-weight: 900"></td>
                                </tr>
                            </table>
                        @else
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width: 150px; height: 30px; font-weight: 900">Propeller-Nr.</td>
                                    @if(Str::of($auftrag->propeller)->containsAll(["H50V"]) ||
                                        Str::of($auftrag->propeller)->containsAll(["H60V"]) ||
                                        Str::of($auftrag->propeller)->containsAll(["H60A"]) ||
                                        Str::of($auftrag->propeller)->containsAll(["H40A"]) ||
                                        Str::of($auftrag->propeller)->containsAll(["H40V"])
                                        ) 
                                        <td style="width: 350px; height: 30px; font-weight: 900">Naben-SN. | Blatt-SN.</td>
                                        <td style="width: 400px; height: 30px; font-weight: 900">Bemerkung</td>
                                        <!-- <td style="width: 400px; height: 30px; font-weight: 900">Min / Max Blatt-Steig.Diff. [+-0.3°]</td> -->
                                    @else
                                        <td style="width: 400px; height: 30px; font-weight: 900">Blatt-SN.</td>
                                        <td style="width: 350px; height: 30px; font-weight: 900">Bemerkung</td>
                                    @endif
                                    
                                </tr>
                            </table>
                            @if(!empty($propellernummern[0]))
                                @for ($i = 0; $i < $auftrag->anzahl; $i++)
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="width: 150px; height: 30px; font-weight: 900">{{$i+1}}/{{$auftrag->anzahl}}: {{substr($propellernummern[$i]['produktionsjahr'],-2)}}{{($propellernummern[$i]['id'])}}</td>
                                            @if(Str::of($auftrag->propeller)->containsAll(["H50V"]) ||
                                                Str::of($auftrag->propeller)->containsAll(["H60V"]) ||
                                                Str::of($auftrag->propeller)->containsAll(["H60A"]) ||
                                                Str::of($auftrag->propeller)->containsAll(["H40A"]) ||
                                                Str::of($auftrag->propeller)->containsAll(["H40V"])
                                                )
                                                <td style="width: 350px; height: 50px; font-weight: 900">_______ | _______ / ________ / ________</td>
                                                <td style="width: 200px; height: 30px;">
                                                    {{Form::checkbox('koppelset','koppelset', false, [])}} -10°/+8° (47.0/44)<br>
                                                    {{Form::checkbox('koppelset','koppelset', false, [])}} -10°/+6° (44/44)
                                                </td>
                                                <td style="width: 200px; height: 30px;">
                                                    {{Form::checkbox('koppelset','koppelset', false, [])}} -10°/+10° (47.0/47.0)
                                                </td>
                                            @else
                                                <td style="width: 400px; height: 50px; font-weight: 900">_______ / ________ / ________</td>
                                                <td style="width: 350px; height: 30px;"></td>
                                            @endif
                                        </tr>
                                    </table>
                                @endfor
                            @else
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                                        @if(Str::of($auftrag->propeller)->containsAll(["H50V"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H60V"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H40A"]) ||
                                            Str::of($auftrag->propeller)->containsAll(["H40V"])
                                            )
                                            <td style="width: 400px; height: 50px; font-weight: 900">_______ | _______ / ________ / ________</td>
                                        @else
                                            <td style="width: 400px; height: 50px; font-weight: 900">_______ / ________ / ________</td>
                                        @endif
                                        <td style="width: 350px; height: 30px; font-weight: 900"></td>
                                    </tr>
                                </table>
                            @endif
                        @endif
                    @else
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">13+14</td>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                            <tr>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">15+16</td>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                            <tr>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">17+18</td>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                            <tr>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">19+20</td>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 70px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                            <tr>
                                <td style="width: 100px; height: 30px; font-weight: 900"></td>
                                <td style="width: 250px; height: 30px; font-weight: 900"></td>
                            </tr>
                        </table>
                    @endif
                </div>
                {{-- Abschnitt 4: Daten für Endfertigung --}}
                <div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="width: 800px">Bemerkungen</th>
                            <th style="width: 100px">Zertifikat</th>
                        </tr>
                        <tr>
                            <td style="width: 800px; height: 50px; text-align:left; height: 40px;">{{ $auftrag->notiz }}</td>
                            <td style="width: 100px; font-size: 20pt; height: 40px;">{{ $auftrag->form1 }}</td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="width: 600px;">Projektinfo</th>
                            <th style="width: 300px;">Motor</th>
                        </tr>
                        <tr>
                            <td style="width: 600px; height: 40px;">{{ $auftrag->projekt }}</td>
                            <td style="width: 300px; height: 40px;">{{ $auftrag->motor }} mit {{ $auftrag->untersetzung }}</td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="width: 125px">Propelleranordnung</th>
                            <th style="width: 125px">Logo-Aufkleber</th>
                            <th style="width: 350px">Bohrschema</th>
                            <th style="width: 300px">Typenaufkleber</th>
                            {{-- <th style="width: 125px">Wuchtung geprüft</th>
                            <th style="width: 125px">Spurlauf geprüft</th> --}}
                        </tr>
                        <tr>
                            <td style="width: 125px; font-size: 20pt; height: 30px;">
                                @if($auftrag->anordnung == 'Zug')
                                    Zug
                                @elseif($auftrag->anordnung == 'Druck')
                                    Druck
                                @endif
                            </td>
                            <td style="width: 125px; font-size: 15pt; height: 30px;">
                                @if($auftrag->aufkleber == 'Helix')
                                    Helix
                                @elseif($auftrag->aufkleber == 'ohne')
                                    ohne
                                @elseif($auftrag->aufkleber == 'Kunde')
                                    Kunde
                                @else
                                    {{ $auftrag->aufkleber }}
                                @endif
                            </td>
                            <td style="font-size: 20pt; width: 350px; font-weight: 900; height: 30px;">{{ $auftrag->motorFlansch }}</td>
                            <td style="font-size: 10pt; width: 300px; height: 30px;">
                                @if($auftrag->typenaufkleber != NULL)
                                    {{ $auftrag->typenaufkleber}}
                                @else
                                    @if(Str::of($auftrag->propeller)->containsAll(["H50"]) ||
                                        Str::of($auftrag->propeller)->containsAll(["H60"]))
                                        @if($auftrag->form1 == 'Form1')
                                            @if(Str::of($auftrag->propeller)->containsAll(["H50"]))
                                            Silber Sticker H50F mit Cert.Nr. EASA.P.502<br>
                                                    !! Alte Typenbezeichnung !!
                                            @endif
                                        @else
                                            Silber Sticker H50/H60
                                        @endif
                                    @else
                                        @if($auftrag->ausfuehrung == 'A25-0'
                                            || $auftrag->ausfuehrung == 'A30-0'
                                            || $auftrag->ausfuehrung == 'A40-0'
                                            || $auftrag->ausfuehrung == 'A45-0'
                                            || $auftrag->ausfuehrung == 'A50-0'
                                            || $auftrag->ausfuehrung == 'A60-0')
                                                {{ $auftrag->propeller }}
                                        @else
                                            @switch($auftrag->ausfuehrung)
                                                @case('A25-2')
                                                    {{ $auftrag->propeller }} / A2
                                                    @break
                                                @case('A25-5')
                                                    {{ $auftrag->propeller }} / A5
                                                    @break
                                                @case('A25-6')
                                                    {{ $auftrag->propeller }} / A6
                                                    @break
                                                @case('A25-7')
                                                    {{ $auftrag->propeller }} / A7
                                                    @break
                                                @case('A30-2')
                                                    {{ $auftrag->propeller }} / A2
                                                    @break
                                                @case('A30-5')
                                                    {{ $auftrag->propeller }} / A5
                                                    @break
                                                @case('A30-6')
                                                    {{ $auftrag->propeller }} / A6
                                                    @break
                                                @case('A30-7')
                                                    {{ $auftrag->propeller }} / A7
                                                    @break
                                                @case('A40-3')
                                                    {{ $auftrag->propeller }} / A3
                                                    @break
                                                @case('A50-2')
                                                    {{ $auftrag->propeller }} / A2
                                                    @break
                                                @case('A50-5')
                                                    {{ $auftrag->propeller }} / A5
                                                    @break
                                                @case('A50-6')
                                                    {{ $auftrag->propeller }} / A6
                                                    @break
                                                @case('A50-7')
                                                    {{ $auftrag->propeller }} / A7
                                                    @break
                                                @case('A60-5')
                                                    {{ $auftrag->propeller }} / A5
                                                    @break
                                                @case('A60-6')
                                                    {{ $auftrag->propeller }} / A6
                                                    @break
                                                @case('A60-7')
                                                    {{ $auftrag->propeller }} / A7
                                                    @break
                                                @case('A60-8')
                                                    {{ $auftrag->propeller }} / A8
                                                    @break
                                            @endswitch
                                        @endif
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            @if(Str::of($auftrag->propeller)->containsAll(["H50"]) ||
                Str::of($auftrag->propeller)->containsAll(["H60"]) ||
                Str::of($auftrag->propeller)->containsAll(["H40A"]) ||
                Str::of($auftrag->propeller)->containsAll(["H40V"]) ||
                Str::of($auftrag->propeller)->containsAll(["H40B"])
                )    
                {{-- Abschnitt 5: Daten für Kontrolle / Versand --}}
                <div>
                    <table>
                        <tr>
                            <th style="width: 150px">Kantenschutzband / Steigung</th>
                            <th style="width: 150px">Wuchtung / Spurlauf</th>
                            <th style="width: 160px">Form 1 -> Checkliste AH10</th>
                            <th style="width: 230px">Endfertigung</th>
                            <th style="width: 210px">Prüfung</th>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 4%">{{ $auftrag->kantenschutzband }}</td>
                            <td style="font-size: 12pt; width: 150px; height: 40px; text-align:left">W [gr] <</td>
                            <td style="width: 160px; height: 40px"></td>
                            <td style="width: 230px; height: 40px"></td>
                            <td style="width: 210px; height: 40px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12pt; width: 160px; height: 40px; text-align:left">Stg. [°] =</td>
                            <td style="font-size: 12pt; width: 160px; height: 40px; text-align:left">Spl. [mm] <</td>
                            <td style="font-size: 9pt; width: 160px; height: 25px">Datum / bearbeitet von</td>
                            <td style="font-size: 9pt; width: 210px; height: 25px">Anzahl / Datum / endgefertigt von</td>
                            <td style="font-size: 9pt; width: 210px; height: 25px">Anzahl / Datum / geprüft von</td>
                        </tr>
                    </table>
                </div>

                {{-- FB005 verwendete Materialien --}}
                <div>
                    <table style="border: 0px;">
                        <table style="page-break-before: always">
                            <td style="text-align: left; width: 300px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="width: 40%"></td>
                            <td style="text-align: left; width: 300px; height: 15px"></td>
                            <td style="text-align: left; width: 300px; height: 15px"><b>FB 005: verwendete Materialien</b></td>
                        </table>    
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th style="width: 460px">Matchcode</th>
                            <th style="width: 110px">MyFactory AB</th>
                            <th style="width: 50px">Auftragsauslöser</th>
                            <th style="width: 90px">Datum </th>
                            <th style="width: 100px"></th>
                            <th style="width: 110px">Auftragsnummer</th>
                        </tr>
                        <tr>
                            <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                            <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                            <td>
                                @if($auftrag->createdAt_user_id != Null)
                                    {{ $auftrag->createdAtUser->kuerzel }}
                                @else
                                    {{ $auftrag->user->kuerzel }}
                                @endif    
                            </td>
                            <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                            <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                            <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                        </tr>
                    </table>
                    <div>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th colspan="5" style="width: 900px">Blatt-SN.</th>
                            </tr>
                            <tr>
                                <td colspan="5" style="height: 30px; font-weight: 900; width: 900px">
                                    von: _____________________ / bis: _____________________
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table>
                        <tr>
                            <th style="width: 450px; font-size: 14pt; font-weight: 900; text-align: center">Gewebe, Einlagen</th>
                            <th style="width: 450px; font-size: 14pt; font-weight: 900; text-align: center">Harze, Härter, Farbstoffe, Dickungsmittel, Klebstoffe</th>
                        </tr>
                    </table>
                    <div>
                        <table style="float: left;">
                            <tr>
                                <th style="width: 230px; font-size: 14pt; font-weight: 900; text-align: center">Material</th>
                                <th style="width: 100px; font-size: 14pt; font-weight: 900; text-align: center">Helix Chargen Nr.</th>
                                <th style="width: 100px; font-size: 14pt; font-weight: 900; text-align: center">Namens-Kürzel</th>
                            </tr>
                            @foreach($materialien as $material)
                                @if($material->MaterialGruppeID == 1)
                                    <tr>
                                        <td style="width: 230px; height: 15px; font-size: 14pt; font-weight: 900; text-align: left">{{$material->MaterialName}}</td>
                                        <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                                        <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 230px; height: 15px; font-size: 8pt; font-weight: 500; text-align: left">{{$material->MaterialNameLang}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                        <table style="float: right;">
                            <tr>
                                <th style="width: 230px; font-size: 14pt; font-weight: 900; text-align: center">Material</th>
                                <th style="width: 100px; font-size: 14pt; font-weight: 900; text-align: center">Helix Chargen Nr.</th>
                                <th style="width: 100px; font-size: 14pt; font-weight: 900; text-align: center">Namens-Kürzel</th>
                            </tr>
                            @foreach($materialien as $material)
                                @if($material->MaterialGruppeID == 2)
                                    <tr>
                                        <td style="width: 230px; height: 15px; font-size: 14pt; font-weight: 900; text-align: left">{{$material->MaterialName}}</td>
                                        <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                                        <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 230px; height: 15px; font-size: 8pt; font-weight: 500; text-align: left">{{$material->MaterialNameLang}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <table>
                        <tr>
                            <th style="width: 900px; font-size: 14pt; font-weight: 900; text-align: center">weitere Materialien</th>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width: 230px; height: 15px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                            <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                            <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                        </tr>
                        <tr>
                            <td style="width: 230px; height: 15px; font-size: 8pt; font-weight: 500; text-align: left"></td>
                        </tr>
                    </table>
                </div>

                {{-- FB019 Seite 3 ==> Propellernummern wenn Anzahl größer 4 ist bei H40AV / H40B / H50 / H60--}}
                @if($auftrag->anzahl > 4)
                    {{-- Header --}}
                    <div>
                        <table style="page-break-before: always">
                            <td style="text-align: left; width: 300px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="width: 40%"></td>
                            @if($auftrag->auftragStatus->name == 'Storniert')
                                <td style="text-align: center; width: 300px; height: 15px;" bgcolor="red">
                                        <b>Auftrag storniert !!!</b>
                                </td>
                            @else
                                <td style="text-align: center; width: 300px; height: 15px;">
                                </td>
                            @endif
                            <td style="text-align: left; width: 300px; height: 15px"><b>FB 019: Fertigungsauftrag</b></td>
                        </table>                    
                    </div>
                    {{-- Abschnitt 1: Daten für Büro --}}
                    <div>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 460px">Matchcode</th>
                                <th style="width: 110px">MyFactory</th>
                                <th style="width: 50px">Auftragsauslöser</th>
                                <th style="width: 90px">Datum </th>
                                <th style="width: 100px"></th>
                                <th style="width: 110px">Auftragsnummer</th>
                            </tr>
                            <tr>
                                <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                                <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                                <td>
                                    @if($auftrag->createdAt_user_id != Null)
                                        {{ $auftrag->createdAtUser->kuerzel }}
                                    @else
                                        {{ $auftrag->user->kuerzel }}
                                    @endif    
                                </td>
                                <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                                <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                                <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                            </tr>
                        </table>
                    </div>
                    {{-- Abschnitt 2: allg Daten Propeller --}}
                    <div>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 50px">Anzahl</th>
                                <th colspan="5" style="width: 700px">Propeller</th>
                                <th style="width: 150px">Bauweise</th>
                            </tr>
                            <tr>
                                <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->anzahl }}</td>
                                <td colspan="5" style="font-size: 20pt; font-weight: 900; width: 750px">
                                    @if($auftrag->notiz != NULL)
                                        <button style="background-color: orange"> ! </button>
                                    @endif
                                    @if($auftrag->ausfuehrung != 'A25-0'
                                        || $auftrag->ausfuehrung != 'A30-0'
                                        || $auftrag->ausfuehrung != 'A40-0'
                                        || $auftrag->ausfuehrung != 'A45-0'
                                        || $auftrag->ausfuehrung != 'A50-0'
                                        || $auftrag->ausfuehrung != 'A60-0')
                                        @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' )
                                            {{ $auftrag->propeller }} / {{ $auftrag->farbe }} 
                                        @else
                                            {{ $auftrag->propeller }}
                                        @endif
                                    @else
                                        @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' )
                                            {{ $auftrag->propeller }} / {{ $auftrag->farbe }} / {{ $auftrag->ausfuehrung }}
                                        @else
                                            {{ $auftrag->propeller }} / {{ $auftrag->ausfuehrung }}
                                        @endif
                                    @endif
                                </td>
                                <td style="width: 100px; font-size: 20pt; font-weight: 900">{{ $auftrag->ausfuehrung }}</td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="width: 300px; height: 30px; font-weight: 900">Propeller-Nr.</td>
                                <td style="width: 300px; height: 30px; font-weight: 900">Blatt-Nr.</td>
                                <td style="width: 300px; height: 30px; font-weight: 900">Bemerkung</td>
                            </tr>
                        </table>
                        @if(!empty($propellernummern[0]))
                            @for ($i = 0; $i < $auftrag->anzahl; $i++)
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width: 300px; height: 30px; font-weight: 900">{{$i+1}}/{{$auftrag->anzahl}}: {{substr($propellernummern[$i]['produktionsjahr'],-2)}}{{($propellernummern[$i]['id'])}}</td>
                                        <td style="width: 300px; height: 50px; font-weight: 900">_______ / ________ / ________</td>
                                        <td style="width: 300px; height: 30px; font-weight: 900"></td>
                                    </tr>
                                </table>
                            @endfor
                        @else
                            @for ($i = 0; $i < $auftrag->anzahl; $i++)
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width: 300px; height: 30px; font-weight: 900"></td>
                                        <td style="width: 300px; height: 50px; font-weight: 900">_______ / ________ / ________</td>
                                        <td style="width: 300px; height: 30px; font-weight: 900"></td>
                                    </tr>
                                </table>
                            @endfor
                        @endif
                    </div>
                @endif

                {{-- FB094 Auftrag Spinner --}}
                @if($auftrag->distanzscheibe != NULL ||
                    $auftrag->asgp != NULL ||
                    $auftrag->spgp != NULL ||
                    $auftrag->spkp != NULL ||
                    $auftrag->ap != NULL ||
                    $auftrag->buchsen != NULL ||
                    $auftrag->schrauben != NULL
                    )
                
                    {{-- Header --}}
                    <div>
                        <table style="page-break-before: always">
                            <td style="text-align: left; width: 300px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="width: 40%"></td>
                            <td style="text-align: left; width: 300px; height: 15px"></td>
                            <td style="text-align: left; width: 300px; height: 15px"><b>FB 094: Spinnerauftrag</b></td>
                        </table>                    
                    </div>
                    {{-- Abschnitt 1: Daten für Büro --}}
                    <div>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 460px">Matchcode</th>
                                <th style="width: 110px">MyFactory AB</th>
                                <th style="width: 50px">Auftragsauslöser</th>
                                <th style="width: 90px">Datum </th>
                                <th style="width: 100px"></th>
                                <th style="width: 110px">Auftragsnummer</th>
                            </tr>
                            <tr>
                                <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                                <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                                <td>
                                    @if($auftrag->createdAt_user_id != Null)
                                        {{ $auftrag->createdAtUser->kuerzel }}
                                    @else
                                        {{ $auftrag->user->kuerzel }}
                                    @endif    
                                </td>
                                <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                                <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                                <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                            </tr>
                        </table>
                    </div>
                    {{-- Abschnitt 2: allg Daten Spinner --}}
                    <div>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 50px">Anzahl</th>
                                <th colspan="5" style="width: 600px">Spinner</th>
                                <th style="width: 350px">Propelleranordung</th>
                            </tr>
                            <tr>
                                <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->anzahl }}</td>
                                <td colspan="5" style="font-size: 20pt; font-weight: 900; width: 600px">{{ $auftrag->spkp }}</td>
                                <td style="font-size: 20pt; font-weight: 900; width: 350px">                                
                                    @if($auftrag->anordnung == 'Zug')
                                        Zug
                                    @elseif($auftrag->anordnung == 'Druck')
                                        Druck
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 750px">Propeller</th>
                                <th style="width: 150px"></th>
                            </tr>
                            <tr>
                                <td style="width: 750px; font-size: 20pt">
                                    @if($auftrag->ausfuehrung != 'A25-0'
                                    || $auftrag->ausfuehrung != 'A30-0'
                                    || $auftrag->ausfuehrung != 'A40-0'
                                    || $auftrag->ausfuehrung != 'A45-0'
                                    || $auftrag->ausfuehrung != 'A50-0'
                                    || $auftrag->ausfuehrung != 'A60-0')
                                        @if($auftrag->farbe != 'S')
                                            {{ $auftrag->propeller }} / {{ $auftrag->farbe }} / {{ $auftrag->ausfuehrung }}
                                        @else
                                            {{ $auftrag->propeller }} / {{ $auftrag->ausfuehrung }}
                                        @endif
                                    @else
                                        @if($auftrag->farbe != 'S')
                                            {{ $auftrag->propeller }} / {{ $auftrag->farbe }}
                                        @else
                                            {{ $auftrag->propeller }}
                                        @endif
                                    @endif
                                </td>
                                <td style="width: 150px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 900px">Bemerkungen</th>
                            </tr>
                            <tr>
                                <td style="width: 900px; height: 80px; text-align:left">{{ $auftrag->notiz }}</td>
                            </tr>
                        </table>
                    </div>
                    {{-- Abschnitt 3: Daten für Fertigung --}}
                    <div>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 180px">Dringlichkeit</th>
                                <th style="width: 180px">ETS</th>
                                <th style="width: 180px"></th>
                                <th style="width: 180px"></th>
                                <th style="width: 180px">Teilauftrag</th> 
                            </tr>
                            <tr>
                                <td style="width: 200px; text-align:left">
                                    @if($auftrag->dringlichkeit == NULL)
                                        {{Form::checkbox('dringend','dringend', false, [])}} dringend
                                        <br>
                                        {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                                    @elseif($auftrag->dringlichkeit == 'dringend')
                                        {{Form::checkbox('dringend','dringend', true, ['checked' => 'checked'])}} dringend
                                        <br>
                                        {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                                    @elseif($auftrag->dringlichkeit == 'nochHeute')
                                        {{Form::checkbox('nochHeute','nochHeute', false, [])}} dringend
                                        <br>
                                        {{Form::checkbox('nochHeute','nochHeute', true, ['checked' => 'checked'])}} noch heute
                                    @endif
                                </td>
                                <td style="width: 180px; text-align:center">{{ $auftrag->ets }}</td>
                                <td style="width: 180px; text-align:center"></td>
                                <td style="width: 180px; text-align:center"></td>
                                <td style="width: 700px; text-align:center; font-size: 20pt">
                                    {{ $auftrag->teilauftrag }}
                                    
                                    @if($auftrag->distanzscheibe != NULL ||
                                        $auftrag->asgp != NULL ||
                                        $auftrag->spgp != NULL ||
                                        $auftrag->spkp != NULL ||
                                        $auftrag->ap != NULL ||
                                        $auftrag->buchsen != NULL ||
                                        $auftrag->schrauben != NULL
                                        )

                                        + Zubehör
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">Distanzscheibe</th>
                                <th style="width: 450px">Seriennummer</th>
                            </tr>
                            <tr>
                                <td style="width: 450px; font-size: 20pt">{{ $auftrag->distanzscheibe }}</td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">ASGP</th>
                                <th style="width: 450px">Seriennummer</th>
                            </tr>
                            <tr>
                                <td style="width: 450px; font-size: 20pt">{{ $auftrag->asgp }}</td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">SPGP</th>
                                <th style="width: 450px">Seriennummer</th>
                            </tr>
                            <tr>
                                <td style="width: 450px; font-size: 20pt">{{ $auftrag->spgp }}</td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">SPKP</th>
                                <th style="width: 450px">Seriennummer</th>
                            </tr>
                            <tr>
                                <td style="width: 450px; font-size: 20pt">{{ $auftrag->spkp }}</td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">AP</th>
                                <th style="width: 450px"></th>
                            </tr>
                            <tr>
                                <td style="width: 450px; font-size: 20pt">{{ $auftrag->ap }}</td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">Handbuch</th>
                                <th style="width: 450px"></th>
                            </tr>
                            <tr>
                                <td style="width: 450px"></td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>                    
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">Schrauben</th>
                                <th style="width: 450px"></th>
                            </tr>
                            <tr>
                                <td style="width: 450px; font-size: 20pt">{{ $auftrag->schrauben }}</td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 450px; text-align:left">Buchsen</th>
                                <th style="width: 450px"></th>
                            </tr>
                            <tr>
                                <td style="width: 450px; font-size: 20pt">{{ $auftrag->buchsen }}</td>
                                <td style="width: 450px"></td>
                            </tr>
                        </table>
                    </div>
                    {{-- Abschnitt 5: Daten für Kontrolle / Versand --}}
                    <div>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 300px">Endfertigung</th>
                                <th style="width: 300px">Prüfung</th>
                                <th style="width: 300px"></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width: 300px; height: 30px">Anzahl / Datum / endgefertigt von</td>
                                <td style="width: 300px; height: 30px">Anzahl / Datum / geprüft von</td>
                                <td style="width: 300px; height: 30px"></td>
                            </tr>
                        </table>
                    </div>
                @endif
            @else
                {{-- Abschnitt 5: Daten für Kontrolle / Versand --}}
                <div>
                    <table>
                        <tr>
                            <th style="width: 150px">Kantenschutzband / Steigung</th>
                            <th style="width: 150px">Wuchtung / Spurlauf</th>
                            <th style="width: 300px">Endfertigung</th>
                            <th style="width: 300px">Prüfung</th>
                        </tr>
                        <tr>
                            <td style="width: 150px; height: 40px">{{ $auftrag->kantenschutzband }}</td>
                            <td style="font-size: 12pt; width: 150px; height: 40px; text-align:left">W [gr] <</td>
                            <td style="width: 300px; height: 40px"></td>
                            <td style="width: 300px; height: 40px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12pt; width: 160px; height: 40px; text-align:left">Stg. [°] =</td>
                            <td style="font-size: 12pt; width: 160px; height: 40px; text-align:left">Spl. [mm] <</td>
                            <td style="width: 300px; height: 40px">Anzahl / Datum / endgefertigt von</td>
                            <td style="width: 300px; height: 40px">Anzahl / Datum / geprüft von</td>
                        </tr>
                    </table>
                </div>
            @endif

            @if($propellerZuschnitt_aktuell != NULL)    
            {{-- Abschnitt 6: Zuschnitt AH015 --}}
            <div>
                <table style="page-break-before: always">
                    <tr>
                        <td style="text-align: left; width: 300px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="width: 40%"></td>
                        <td style="text-align: left; width: 300px; height: 15px"></td>
                        <td style="text-align: left; width: 300px; height: 15px"><b>AH 015: Zuschnitt</b></td>                    
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="width: 600px; text-align: left; font-size: 20pt;  font-weight: 900">{{$propellerZuschnitt_aktuell->typen}} / <br>{{$propellerZuschnitt_aktuell->durchmesser_min}}m - {{$propellerZuschnitt_aktuell->durchmesser_max}}m</td>
                        <td style="width: 300px; text-align: left; font-size: 20pt;  font-weight: 900">{{$propellerZuschnitt_aktuell->name}}</td>
                    </tr>
                </table> 
                <table>
                    <tr>
                        <td style="width: 600px; text-align: left; font-size: 20pt;  font-weight: 900">{{ $auftrag->propeller }}</td>
                        <td style="width: 600px; text-align: left;">ab 11.05.2021</td>
                    </tr>
                </table> 
                <table>
                    <tr>
                        <th style="width: 800px; font-size: 14pt; font-weight: 900; text-align: left">Zuschnitt für ein Blatt</th>
                        <th style="width: 100px; font-size: 14pt; font-weight: 900;">Nr.:</th>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="width: 300px; font-size: 14pt; font-weight: 900; text-align: left">Material</th>
                        <th style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left">Chargen-Nr.</th>
                        <th style="width: 100px; font-size: 14pt; font-weight: 900;">Anzahl</th>
                        <th style="width: 300px; font-size: 14pt; font-weight: 900; text-align: left">Schablone / Zuschnitt-Maße</th>
                        <th style="width: 100px; font-size: 14pt; font-weight: 900;"></th>
                    </tr>
                </table>
                <table>
                    @foreach($propellerZuschnittLagen as $propellerZuschnittLage)
                            <tr>
                                <td style="width: 300px; height: 15px; font-size: 14pt; font-weight: 900; text-align: left">{{$propellerZuschnittLage->material->name}}</td>
                                <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900; text-align: left"></td>
                                <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900;">{{ $propellerZuschnittLage->anzahl }}</td>
                                <td style="width: 300px; font-size: 14pt; font-weight: 900; text-align: left">{{ $propellerZuschnittLage->propellerZuschnittSchablone->name }}</td>
                                <td rowspan="2" style="width: 100px; font-size: 14pt; font-weight: 900;">{{ $propellerZuschnittLage->reihenfolge }}</td>
                            </tr>
                            <tr>
                                <td style="width: 300px; height: 15px; font-size: 8pt; font-weight: 500; text-align: left">{{$propellerZuschnittLage->material->name_lang}}</td>
                                <td style="width: 300px; height: 15px; font-size: 8pt; font-weight: 500; text-align: left">{{$propellerZuschnittLage->bemerkung}}</td>
                            </tr>
                    @endforeach
                </table>
                <table>
                    <tr>
                        <th style="width: 280px">Prüfung</th>
                        <th style="width: 620px">Freigabe</th>
                    </tr>
                    <tr>
                        <td style="width: 280px; height: 50px"></td>
                        <td style="width: 620px; height: 50px"></td>
                    </tr>
                    <tr>
                        <td style="width: 280px; height: 25px; text-align: left">Datum / zugeschnitten von</td>
                        <td style="width: 620px; height: 25px; text-align: left">Datum / Kürzel / SN von-bis</td>
                    </tr>
                </table>
            </div>
            @endif
        @endif

        {{-- FB009 Begutachtung und Auftrag --}}
        @if($auftrag->auftrag_typ_id == 2 ||
            $auftrag->auftrag_typ_id == 3 ||
            $auftrag->auftrag_typ_id == 4)
            
            {{-- Abschnitt 1: Daten für Büro --}}
            <div>
                <table style="border: 0px;">
                    <td style="text-align: left; width: 500px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="max-width: 40%"></td>
                    <td style="text-align: left; width: 400px; height: 15px"><b>FB 009: Begutachtung und Auftrag</b></td>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 460px">Matchcode</th>
                        <th style="width: 110px">MyFactory</th>
                        <th style="width: 50px">Auftragsauslöser</th>
                        <th style="width: 90px">Datum </th>
                        <th style="width: 100px"></th>
                        <th style="width: 110px">Auftragsnummer</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                        <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                        <td>{{ $auftrag->createdAtUser->kuerzel }}</td>
                        <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                        <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                        <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="width: 700px">Vorgang</th>
                        <th style="width: 200px">Teilauftrag</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px">{{ $auftrag->auftragTyp->name }}</td>
                        <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->teilauftrag }}</td>  
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 2: allg Daten Propeller --}}
            <div>
                <table>
                    <tr>
                        <th style="width: 50px">Anzahl</th>
                        <th style="width: 850px">Propeller</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->anzahl }}</td>
                        <td style="font-size: 20pt; width: 850px; font-weight: 900">{{ $auftrag->propeller }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="width: 900px">Bemerkungen</th>
                    </tr>
                    <tr>
                        <td style="width: 900px; height: 80px; text-align:left">{{ $auftrag->notiz }}</td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 3: Daten für Retoure --}}
            <div>
                <table>
                    <tr>
                        <th style="width: 900px">Retoure Propeller einsortiert und ausgetragen von:</th>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 300px; height: 30px">Datum / bearbeitet von</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="width: 900px">Propeller geprüft und versendet von:</th>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 300px; height: 30px">Datum / bearbeitet von</td>
                    </tr>
                </table>
            </div>
        @endif

        {{-- FB094 Auftrag Spinner --}}
        @if($auftrag->auftrag_typ_id == 5)
        
            {{-- Header --}}
            <div>
                <table style="page-break-before: always">
                    <td style="text-align: left; width: 300px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="width: 40%"></td>
                    <td style="text-align: left; width: 300px; height: 15px"></td>
                    <td style="text-align: left; width: 300px; height: 15px"><b>FB 094: Spinnerauftrag</b></td>
                </table>                    
            </div>
            {{-- Abschnitt 1: Daten für Büro --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 460px">Matchcode</th>
                        <th style="width: 110px">MyFactory</th>
                        <th style="width: 50px">Auftragsauslöser</th>
                        <th style="width: 90px">Datum </th>
                        <th style="width: 100px"></th>
                        <th style="width: 110px">Auftragsnummer</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                        <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                        <td>
                            @if($auftrag->createdAt_user_id != Null)
                                {{ $auftrag->createdAtUser->kuerzel }}
                            @else
                                {{ $auftrag->user->kuerzel }}
                            @endif    
                        </td>
                        <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                        <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                        <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 2: allg Daten Spinner --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 50px">Anzahl</th>
                        <th colspan="5" style="width: 600px">Spinner</th>
                        <th style="width: 350px">Propelleranordung</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->anzahl }}</td>
                        <td colspan="5" style="font-size: 20pt; font-weight: 900; width: 600px">{{ $auftrag->spkp }}</td>
                        <td style="font-size: 20pt; font-weight: 900; width: 350px">                                
                            @if($auftrag->anordnung == 'Zug')
                                Zug
                            @elseif($auftrag->anordnung == 'Druck')
                                Druck
                            @endif
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 750px">Details</th>
                        <th style="width: 150px"></th>
                    </tr>
                    <tr>
                        <td style="width: 750px; font-size: 20pt">
                            {{ $auftrag->propeller }}
                        </td>
                        <td style="width: 150px"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 900px">Bemerkungen</th>
                    </tr>
                    <tr>
                        <td style="width: 900px; height: 80px; text-align:left">{{ $auftrag->notiz }}</td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 3: Daten für Fertigung --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 180px">Dringlichkeit</th>
                        <th style="width: 180px">ETS</th>
                        <th style="width: 180px"></th>
                        <th style="width: 180px"></th>
                        <th style="width: 180px">Teilauftrag</th> 
                    </tr>
                    <tr>
                        <td style="width: 200px; text-align:left">
                            @if($auftrag->dringlichkeit == NULL)
                                {{Form::checkbox('dringend','dringend', false, [])}} dringend
                                <br>
                                {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                            @elseif($auftrag->dringlichkeit == 'dringend')
                                {{Form::checkbox('dringend','dringend', true, ['checked' => 'checked'])}} dringend
                                <br>
                                {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                            @elseif($auftrag->dringlichkeit == 'nochHeute')
                                {{Form::checkbox('nochHeute','nochHeute', false, [])}} dringend
                                <br>
                                {{Form::checkbox('nochHeute','nochHeute', true, ['checked' => 'checked'])}} noch heute
                            @endif
                        </td>
                        <td style="width: 180px; text-align:center">{{ $auftrag->ets }}</td>
                        <td style="width: 180px; text-align:center"></td>
                        <td style="width: 180px; text-align:center"></td>
                        <td style="width: 700px; text-align:center; font-size: 20pt">
                            {{ $auftrag->teilauftrag }}
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">Distanzscheibe</th>
                        <th style="width: 450px">Seriennummer</th>
                    </tr>
                    <tr>
                        <td style="width: 450px; font-size: 20pt">{{ $auftrag->distanzscheibe }}</td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">ASGP</th>
                        <th style="width: 450px">Seriennummer</th>
                    </tr>
                    <tr>
                        <td style="width: 450px; font-size: 20pt">{{ $auftrag->asgp }}</td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">SPGP</th>
                        <th style="width: 450px">Seriennummer</th>
                    </tr>
                    <tr>
                        <td style="width: 450px; font-size: 20pt">{{ $auftrag->spgp }}</td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">SPKP</th>
                        <th style="width: 450px">Seriennummer</th>
                    </tr>
                    <tr>
                        <td style="width: 450px; font-size: 20pt">{{ $auftrag->spkp }}</td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">AP</th>
                        <th style="width: 450px"></th>
                    </tr>
                    <tr>
                        <td style="width: 450px; font-size: 20pt">{{ $auftrag->ap }}</td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">Handbuch</th>
                        <th style="width: 450px"></th>
                    </tr>
                    <tr>
                        <td style="width: 450px"></td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>                    
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">Schrauben</th>
                        <th style="width: 450px"></th>
                    </tr>
                    <tr>
                        <td style="width: 450px"></td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 450px; text-align:left">Buchsen</th>
                        <th style="width: 450px"></th>
                    </tr>
                    <tr>
                        <td style="width: 450px; font-size: 20pt">{{ $auftrag->buchsen }}</td>
                        <td style="width: 450px"></td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 5: Daten für Kontrolle / Versand --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 300px">Endfertigung</th>
                        <th style="width: 300px">Prüfung</th>
                        <th style="width: 300px"></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 300px; height: 30px">Anzahl / Datum / endgefertigt von</td>
                        <td style="width: 300px; height: 30px">Anzahl / Datum / geprüft von</td>
                        <td style="width: 300px; height: 30px"></td>
                    </tr>
                </table>
            </div>
        @endif
        
        {{-- FB00x Zubehör --}}
        @if($auftrag->auftrag_typ_id == 6)
            
            {{-- Abschnitt 1: Daten für Büro --}}
            <div>
                <table style="border: 0px;">
                    <td style="text-align: left; width: 500px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="max-width: 40%"></td>
                    <td style="text-align: left; width: 400px; height: 15px"><b>FB 00x: Zubehör</b></td>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 460px">Matchcode</th>
                        <th style="width: 110px">MyFactory</th>
                        <th style="width: 50px">Auftragsauslöser</th>
                        <th style="width: 90px">Datum </th>
                        <th style="width: 100px"></th>
                        <th style="width: 110px">Auftragsnummer</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                        <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                        <td>
                            @if($auftrag->createdAt_user_id != Null)
                                {{ $auftrag->createdAtUser->kuerzel }}
                            @else
                                {{ $auftrag->user->kuerzel }}
                            @endif    
                        </td>
                        <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                        <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                        <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="width: 700px">Vorgang</th>
                        <th style="width: 200px">Teilauftrag</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px">{{ $auftrag->auftragTyp->name }}</td>  
                        <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->teilauftrag }}</td>  
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 2: allg Daten Propeller --}}
            <div>
                <table>
                    <tr>
                        <th style="width: 50px">Anzahl</th>
                        <th style="width: 850px">Zubehör</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->anzahl }}</td>
                        <td style="font-size: 20pt; width: 850px; font-weight: 900">
                            @if($auftrag->distanzscheibe != NULL)
                            <b>{{ $auftrag->distanzscheibe}} / </b>
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
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th style="width: 900px">Bemerkungen</th>
                    </tr>
                    <tr>
                        <td style="width: 900px; height: 80px; text-align:left">{{ $auftrag->notiz }}</td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 3: Daten für Fertigung --}}
            @if(Str::of($auftrag->spgp)->containsAll(["CFK"]))
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 180px">Dringlichkeit</th>
                        <th style="width: 180px">ETS</th>
                        <th style="width: 180px">Anzahl noch zu fertigender Blätter:</th>
                        <th style="width: 180px">Nächste freie Serien-Nr.:</th>
                        <th style="width: 180px">Teilauftrag</th>
                        
                    </tr>
                    <tr>
                        <td style="width: 200px; text-align:left">
                            @if($auftrag->dringlichkeit == NULL)
                                {{Form::checkbox('dringend','dringend', false, [])}} dringend
                                <br>
                                {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                            @elseif($auftrag->dringlichkeit == 'dringend')
                                {{Form::checkbox('dringend','dringend', true, ['checked' => 'checked'])}} dringend
                                <br>
                                {{Form::checkbox('dringend','dringend', false, [])}} noch heute
                            @elseif($auftrag->dringlichkeit == 'nochHeute')
                                {{Form::checkbox('nochHeute','nochHeute', false, [])}} dringend
                                <br>
                                {{Form::checkbox('nochHeute','nochHeute', true, ['checked' => 'checked'])}} noch heute
                            @endif
                        </td>
                        <td style="width: 180px; text-align:center">@if($auftrag->ets != NULL){{ date('d M Y', strtotime($auftrag->ets)) }}@endif</td>
                        <td style="width: 180px; text-align:center"></td>
                        <td style="width: 180px; text-align:center"></td>
                        <td style="width: 700px; text-align:center; font-size: 20pt">
                            {{ $auftrag->teilauftrag }}

                            @if($auftrag->distanzscheibe != NULL ||
                                $auftrag->asgp != NULL ||
                                $auftrag->spgp != NULL ||
                                $auftrag->spkp != NULL ||
                                $auftrag->ap != NULL ||
                                $auftrag->buchsen != NULL ||
                                $auftrag->schrauben != NULL
                                )

                                + Zubehör
                            @endif
                        
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 150px; height: 30px; font-weight: 900">Serien-Nr.</td>
                        <td style="width: 50px; height: 30px; font-weight: 900">Wer</td>
                        <td style="width: 100px; height: 30px; font-weight: 900">Datum</td>
                        <td style="width: 100px; height: 30px; font-weight: 900">Uhrzeit</td>
                        <td style="width: 385px; height: 30px; font-weight: 900">Bemerkung</td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">1+2</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">3+4</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">5+6</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">7+8</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">9+10</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">11+12</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">13+14</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">15+16</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">17+18</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900">19+20</td>
                        <td style="width: 150px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 50px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td rowspan="2" style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                    <tr>
                        <td style="width: 100px; height: 30px; font-weight: 900"></td>
                        <td style="width: 385px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
            </div>
            @endif
            {{-- Abschnitt 5: Daten für Kontrolle / Versand --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 300px">Endfertigung</th>
                        <th style="width: 300px">Prüfung</th>
                        <th style="width: 300px"></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 300px; height: 30px">Anzahl / Datum / endgefertigt von</td>
                        <td style="width: 300px; height: 30px">Anzahl / Datum / geprüft von</td>
                        <td style="width: 300px; height: 30px"></td>
                    </tr>
                </table>
            </div>
        @endif

        {{-- FB018 Fertigungsauftrag Formenbau--}}
        @if($auftrag->auftrag_typ_id == 7)
        
            {{-- Header --}}
            <div>
                <table style="border: 0px;">
                    <td style="text-align: left; width: 300px; height: 15px"><img src = "/home/www/kva/public/images/logo_helix_header.png" class="img-rounded" style="width: 40%"></td>
                        <td style="text-align: center; width: 200px; height: 15px;">
                        </td>
                    <td style="text-align: left; width: 400px; height: 15px"><b>FB 018: Fertigungsauftrag Formenbau</b></td>
                </table>                    
            </div>
            {{-- Abschnitt 1: Daten für Büro --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 460px">Matchcode</th>
                        <th style="width: 110px">MyFactory</th>
                        <th style="width: 50px">Auftragsauslöser</th>
                        <th style="width: 90px">Datum </th>
                        <th style="width: 100px"></th>
                        <th style="width: 110px">Auftragsnummer</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; font-weight: 900">{{ $auftrag->kundeMatchcode }}</td>
                        <td>D{{$auftrag->myFactoryID}}<br><br>AB{{ $auftrag->lexwareAB }}</td>
                        <td>
                            @if($auftrag->createdAt_user_id != Null)
                                {{ $auftrag->createdAtUser->kuerzel }}
                            @else
                                {{ $auftrag->user->kuerzel }}
                            @endif    
                        </td>
                        <td>{{ date('d M Y', strtotime($auftrag->created_at)) }}</td>
                        <td> <img src="data:image/png;base64,{{DNS2D::getBarcodePNG( $myFactoryQR, 'QRCODE',4,4)}}" alt="barcode" /></td>
                        <td style="font-size: 20pt;"><b>{{ $auftrag->id }}</b></td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 2: allg Daten Propeller --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 50px">Anzahl</th>
                        <th colspan="6" style="width: 850px">Formentyp</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px; font-weight: 900">{{ $auftrag->anzahl }}</td>
                        <td colspan="6" style="font-size: 20pt; font-weight: 900; width: 850px">{{ $auftrag->propeller }}</td>
                    </tr>
                    <tr>
                        <th style="width: 50px"></th>
                        <th colspan="6" style="width: 850px">Formhälfte</th>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px; font-weight: 900"></td>
                        <td colspan="4" style="font-size: 15pt; font-weight: 600; width: 425px">
                            @if($auftrag->propellerForm_haelfte == 'oben')
                                {{ $auftrag->propellerForm_haelfte }}
                            @endif
                            @if($auftrag->propellerFormBlatt_neu == '1')
                                NEUES Blattmodell
                            @endif
                        </td>
                        <td colspan="4" style="font-size: 15pt; font-weight: 600; width: 425px">
                            @if($auftrag->propellerForm_haelfte == 'unten')
                                {{ $auftrag->propellerForm_haelfte }}
                            @endif
                            @if($auftrag->propellerFormWurzel_neu == '1')
                                NEUES Wurzelmodell
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 20pt; width: 50px; font-weight: 900"></td>
                        <td colspan="4" style="font-size: 20pt; font-weight: 900; width: 425px">{{ $propellerForm->propellerModellBlatt->name }}</td>
                        <td colspan="4" style="font-size: 20pt; font-weight: 900; width: 425px">{{ $propellerForm->propellerModellWurzel->name }}</td>
                    </tr>


                </table>

                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 900px">Bemerkungen</th>
                    </tr>
                    <tr>
                        <td style="width: 900px; height: 80px; text-align:left">{{ $auftrag->notiz }}</td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 3: Daten für Fertigung --}}
            <div>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th style="width: 200px">Dringlichkeit</th>
                        <th style="width: 180px">ETA</th>
                        <th style="width: 180px">Anzahl noch zu fertigenden Formen:</th>
                        <th style="width: 180px">Nächste freie Serien-Nr.:</th>
                        <th style="width: 500px"></th>
                        
                    </tr>
                    <tr>
                        <td style="width: 200px; text-align:left">{{ $auftrag->dringlichkeit }}</td>
                        <td style="width: 180px; text-align:center">{{ $auftrag->ets }}</td>
                        <td style="width: 180px; text-align:center"></td>
                        <td style="width: 180px; text-align:center"></td>
                        <td style="width: 500px; text-align:center; font-size: 20pt"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">Form</td>
                        <td style="width: 180px; height: 30px; font-weight: 900">Wer</td>
                        <td style="width: 180px; height: 30px; font-weight: 900">Datum</td>
                        <td style="width: 180px; height: 30px; font-weight: 900">Uhrzeit</td>
                        <td style="width: 500px; height: 30px; font-weight: 900">Bemerkung</td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">1</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">2</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">3</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">4</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">Abzug</td>
                        <td style="width: 180px; height: 30px; font-weight: 900">Wer</td>
                        <td style="width: 180px; height: 30px; font-weight: 900">Datum</td>
                        <td style="width: 180px; height: 30px; font-weight: 900">Uhrzeit</td>
                        <td style="width: 500px; height: 30px; font-weight: 900">Bemerkung</td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">1</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">2</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">3</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">4</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">5</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 200px; height: 30px; font-weight: 900">6</td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 180px; height: 30px; font-weight: 900"></td>
                        <td style="width: 500px; height: 30px; font-weight: 900"></td>
                    </tr>
                </table>
            </div>
            {{-- Abschnitt 5: Daten für Kontrolle / Versand --}}
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th style="width: 900px">Freigabe</th>
                </tr>
                <tr>
                    <td style="font-size: 15pt; width: 50px; font-weight: 900">Für die Propellerfertigung freigegeben: Kürzel__________ / Datum__________</td>
                </tr>
            </table>

            {{-- Abschnitt 6: Aufkleber Alumodelle --}}
            <table style="page-break-before: always">
                @if($propellerForm->propellerModellBlatt->propellerDrehrichtung->name == "L")
                    <tr>
                        <td  style="min-width: 320px; color: blue" align="left">{{ $propellerForm->propellerModellBlatt->name }}</td>
                        <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                        <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerDrehrichtung->name }}</td>
                        <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->winkel }}</td>
                        @if($propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                            <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                        @else
                            <td  style="color: blue"  align="center">-</td>
                        @endif
                        <td style="color: blue"  align="center">UNTEN</td>
                        <td style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->bereichslaenge}}</td>
                        
                    </tr> 
                    <tr>
                        <td style="min-width: 320px; color: blue" align="left">{{ $propellerForm->propellerModellWurzel->name }}</td>
                        <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerForm->propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellWurzel->propellerDrehrichtung->name }}</td>
                        <td style="color: blue"  align="center">UNTEN</td>
                        <td style="color: blue"  align="center">{{ $propellerForm->propellerModellWurzel->bereichslaenge}}</td>
                        
                    </tr>       
                    <tr>
                        <td style="min-width: 320px; color: blue" align="left">{{ $propellerForm->propellerModellBlatt->name }}</td>
                        <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                        <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerDrehrichtung->name }}</td>
                        <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->winkel }}</td>
                        @if($propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                            <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                        @else
                            <td  style="color: blue"  align="center">-</td>
                        @endif
                        <td style="color: blue"  align="center">OBEN</td>
                        <td style="color: blue"  align="center">{{ $propellerForm->propellerModellBlatt->bereichslaenge}}</td>
                        
                    </tr> 
                    <tr>
                        <td style="min-width: 320px; color: blue" align="left">{{ $propellerForm->propellerModellWurzel->name }}</td>
                        <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerForm->propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="color: blue"  align="center">{{ $propellerForm->propellerModellWurzel->propellerDrehrichtung->name }}</td>
                        <td style="color: blue"  align="center">OBEN</td>
                        <td style="color: blue"  align="center">{{ $propellerForm->propellerModellWurzel->bereichslaenge}}</td>
                        
                    </tr>   
                @endif
                @if($propellerForm->propellerModellBlatt->propellerDrehrichtung->name == "R")
                    <tr>
                        <td style="min-width: 320px; color: red" align="left">{{ $propellerForm->propellerModellBlatt->name }}</td>
                        <td  style="min-width: 80px; color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="min-width: 80px; color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                        <td  style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerDrehrichtung->name }}</td>
                        <td  style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->winkel }}</td>
                        @if($propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                            <td  style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                        @else
                            <td  style="color: red"  align="center">-</td>
                        @endif
                        <td style="color: red"  align="center">UNTEN</td>
                        <td style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->bereichslaenge}}</td>
                        
                    </tr> 
                    <tr>
                        <td style="min-width: 320px; color: red" align="left">{{ $propellerForm->propellerModellWurzel->name }}</td>
                        <td  style="min-width: 80px; color: red"  align="center">{{ $propellerForm->propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="color: red"  align="center">{{ $propellerForm->propellerModellWurzel->propellerDrehrichtung->name }}</td>
                        <td style="color: red"  align="center">UNTEN</td>
                        <td style="color: red"  align="center">{{ $propellerForm->propellerModellWurzel->bereichslaenge}}</td>
                        
                    </tr>       
                    <tr>
                        <td style="min-width: 320px; color: red" align="left">{{ $propellerForm->propellerModellBlatt->name }}</td>
                        <td  style="min-width: 80px; color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="min-width: 80px; color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                        <td  style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerDrehrichtung->name }}</td>
                        <td  style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->winkel }}</td>
                        @if($propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                            <td  style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                        @else
                            <td  style="color: red"  align="center">-</td>
                        @endif
                        <td style="color: red"  align="center">OBEN</td>
                        <td style="color: red"  align="center">{{ $propellerForm->propellerModellBlatt->bereichslaenge}}</td>
                        
                    </tr> 
                    <tr>
                        <td style="min-width: 320px; color: red" align="left">{{ $propellerForm->propellerModellWurzel->name }}</td>
                        <td  style="min-width: 80px; color: red"  align="center">{{ $propellerForm->propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                        <td  style="color: red"  align="center">{{ $propellerForm->propellerModellWurzel->propellerDrehrichtung->name }}</td>
                        <td style="color: red"  align="center">OBEN</td>
                        <td style="color: red"  align="center">{{ $propellerForm->propellerModellWurzel->bereichslaenge}}</td>
                        
                    </tr>   
                @endif
            </table>

            <table>
                @if($propellerForm->propellerModellBlatt->propellerDrehrichtung->name == "L")
                    @for($i = 0;$i < $auftrag->anzahl; $i++)
                        <tr>
                            <td style="font-size: 20pt; font-weight: 900; width: 400px; color: blue" align="left">{{ $auftrag->propeller }}</td>
                        </tr>
                    @endfor
                @endif
            </table>

            <table>
                @if($propellerForm->propellerModellBlatt->propellerDrehrichtung->name == "R")
                    @for($i = 0;$i < $auftrag->anzahl; $i++)
                        <tr>
                            <td style="font-size: 20pt; font-weight: 900; width: 400px; color: red" align="left">{{ $auftrag->propeller }}</td>
                        </tr>
                    @endfor
                @endif
            </table>

            
        @endif

    </body>
</html>