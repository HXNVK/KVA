<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
        <style>
            table, th, td {
                border-collapse: collapse;
                /* border: px solid grey; */
                min-width: 50px;
                table-layout:fixed;
                
            }
            th { font-size: 12pt; font-weight: 900; text-align: left; height: 50px}
            td { font-size: 12pt; font-weight: 350; text-align: center; height: 50px}

            thead { display: table-header-group }
            tfoot { display: table-row-group }
            
        </style>
    </head>       
    <body>
        {{-- 1.Seite --}}
        <div>
            {{-- Header --}}
            <div>
                <table>
                    <td style="width: 650px;"></td>
                    <td style="text-align: right; width: 300px;"><img src = "/home/www/kva/public/images/logo_fhaachen.jpg" class="img-rounded" style="width: 12%"></td>
                </table>                    
            </div>

            <div>
                <table>
                    <tr>
                        <td style="height: 100px;"></td>
                    </tr>
                    @if($laermmessung->fluggeraetGruppe == 'LVL')
                        <tr>
                            <td style="text-align: left; font-size: 20pt; font-weight: 900; width: 900px;">Lärmmessbericht nach LVL vom August 2004</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 900px;"> Die Lärmvorschrift für Luftfahrzeuge legt die technischen Forderungen fest für Ultraleichtflugzeuge / Tragschrauber / Ultraleichthubschrauber</td> 
                        </tr>
                    @elseif($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                        <tr>
                            <td style="text-align: left; font-size: 20pt; font-weight: 900; width: 900px;">Lärmmessbericht nach Kapitel 11</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 900px;"> Die Lärmvorschrift für Luftfahrzeuge legt die technischen Forderungen fest für Ultraleichthubschrauber</td> 
                        </tr>
                    @else
                        <tr>
                            <td style="text-align: left; font-size: 20pt; font-weight: 900; width: 900px;">Lärmmessbericht Kapitel 10</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 900px;"> Lärmmessung an Propellerflugzeugen bis 8618 kg höchstzulässiger Startmasse und Motorseglern, gemäß ICAO Anhang 16, Kapitel 10 (Startflugmessung) </td>
                        </tr>
                    @endif
                    <tr>
                        <td style="height: 50px;"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="text-align: left; width: 300px;">Das vorgeführte Luftfahrzeug</td>
                        <td style="text-align: left; width: 400px;">{{$laermmessung->muster}} {{$laermmessung->baureihe}} / {{$laermmessung->kennung}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; width: 300px;">mit Motor</td>
                        <td style="text-align: left; width: 400px;">{{$laermmessung->motor}}</td>
                    </tr>
                    @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                        <tr>
                            <td style="text-align: left; width: 300px;">mit Rotor</td>
                            <td style="text-align: left; width: 400px;">{{$laermmessung->herstellerProp}} / {{$laermmessung->modellProp}}</td>
                        </tr>
                    @else
                        <tr>
                            <td style="text-align: left; width: 300px;">mit Propeller</td>
                            <td style="text-align: left; width: 400px;">{{$laermmessung->herstellerProp}} / {{$laermmessung->modellProp}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="text-align: left; width: 300px;">und Schalldämpfer</td>
                        <td style="text-align: left; width: 400px;">{{$laermmessung->schalldaempfer}}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="text-align: left; width: 900px;"> hat am {{date("d.m.Y",strtotime($laermmessung->messdatum))}}, die im Protokoll festgehaltenen Werte aufgewiesen.</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="text-align: left; width: 300px;">ermittelter Pegelwert</td>
                        <td style="text-align: left; width: 300px;">{{round($pegelwert_durschnitt,2)}} dB(A)</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; width: 300px;">Lärmgrenzwert</td>
                        <td style="text-align: left; width: 300px;">{{round($laermmessung->laermgrenzwert,2)}} dB(A)</td>
                    </tr>
                </table>
                <table>
                    @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                        <tr>
                            <td style="text-align: left; width: 900px;"> 
                                Die Werte wurden gemäß ICAO Anhang 16, Kapitel 11 ermittelt.<br> 
                                Für die vom Luftfahrt-Bundesamt anzuerkennenden Messungen werden die Ergebnisse<br>
                                exklusiv vom Luftfahrt-Bundesamt veröffentlicht (NFL). Eine Verbreitung der Messwerte ist vor <br>
                                Anerkennung des Luftfahrt-Bundesamtes in solchen Fällen nicht zulässig.
                            </td>
                        </tr>
                    @elseif($laermmessung->fluggeraetGruppe == 'LVL')
                        <tr>
                            <td style="text-align: left; width: 900px;"> 
                                Die Werte wurden gemäß LVL - UL vom August 2004 ermittelt.<br> 
                                Für die vom Luftfahrt-Bundesamt anzuerkennenden Messungen werden die Ergebnisse<br>
                                exklusiv vom Luftfahrt-Bundesamt veröffentlicht (NFL). Eine Verbreitung der Messwerte ist vor <br>
                                Anerkennung des Luftfahrt-Bundesamtes in solchen Fällen nicht zulässig.
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td style="text-align: left; width: 900px;"> 
                                Die Werte wurden gemäß ICAO Anhang 16, Kapitel 10 ermittelt.<br> 
                                Für die vom Luftfahrt-Bundesamt anzuerkennenden Messungen werden die Ergebnisse<br>
                                exklusiv vom Luftfahrt-Bundesamt veröffentlicht (NFL). Eine Verbreitung der Messwerte ist vor <br>
                                Anerkennung des Luftfahrt-Bundesamtes in solchen Fällen nicht zulässig.
                            </td>
                        </tr>
                    @endif
                </table>
                <table>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                    <td style="text-align: left; width: 300px;">Aachen, den {{date('d.m.Y',strtotime($laermmessung->protokolldatum))}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; width: 300px;">Verantwortlicher Leiter</td>
                        <td style="text-align: left; width: 300px;">{{$laermmessung->leiter}}</td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Footer --}}
            <div>
                <table>
                    <td style="text-align: center; width: 900px;"><img src = "/home/www/kva/public/images/logos_footer_lfa.jpg" class="img-rounded" style="width: 100%"></td>
                </table>                    
            </div>
        </div>
        
        {{-- 2.Seite --}}
        <div>
            {{-- Header --}}
            <div>
                <table>
                    <td style="width: 650px; page-break-before: always"></td>
                    <td style="text-align: right; width: 300px;"><img src = "/home/www/kva/public/images/logo_fhaachen.jpg" class="img-rounded" style="width: 12%"></td>
                </table>                    
            </div>

            <div>
                <table>
                    {{-- Auftraggeber --}}
                    <tr>
                        <th style="text-align: left; width: 300px;">Auftraggeber</th>
                        <td style="text-align: left; width: 300px;">
                            {{$laermmessung->kunde->name1}}<br>
                            {{$kundeStrasse}}<br>
                            {{$kundePlz}} {{$kundeStadt}}<br>
                            {{$kundeLand}}
                        </td>
                    </tr>
                    {{-- Zelle --}}
                    <div>
                        <tr>
                            <th style="text-align: left; width: 300px; height: 10px">1.Zelle</th>
                            <td style="text-align: left; width: 300px;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Hersteller</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->herstellerFluggeraet}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Kennblatt Nr.</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->kennblatt}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Muster</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->muster}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Baureihe</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->baureihe}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Werknummer</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->werknummer}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Baujahr</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->baujahr}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Kennung</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->kennung}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Maximale Abflugmasse</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->mtow}} [kg]</td>
                        </tr>
                        @if($laermmessung->fluggeraetGruppe != 'Kap11-UL')
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Fahrwerk</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->fahrwerk}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Spannweite</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->spannweite}} [m]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Höchstzulässige Geschwindigkeit</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->v_max}} [km/h]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Mindest Geschwindigkeit</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->v_min}} [km/h]</td>
                            </tr>
                        @else
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Höchstzulässige Geschwindigkeit</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->v_max}}[km/h]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Geschwindigkeit m. max. Dauerleistung V<sub>H</sub></td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->v_h}} [km/h]</td>
                            </tr>
                            <tr>
                                <td>{{-- Leerfeld --}}</td>
                            </tr>
                            <tr>
                                <td>{{-- Leerfeld --}}</td>
                            </tr>
                        @endif
                    </div>
                    {{-- Motor --}}
                    <div>
                        <tr>
                            <th style="text-align: left; width: 300px; height: 10px">2.Motor</th>
                            <td style="text-align: left; width: 300px;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Hersteller & Typ</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->motor}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Werknummer</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->motorWerknummer}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Zylinderzahl</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->motorZylinder}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Arbeitsweise</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->motorArbeitsweise}}, {{$laermmessung->kraftstoffZufuhr}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Nennleistung</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->nennleistung}} [kW]</td>
                        </tr>
                        @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Rotordrehzahl bei PDauer,max</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->drehzahlRC}} [U/min]</td>
                            </tr>
                        @else
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Motordrehzahl im besten Steigen</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->drehzahlRC}} [U/min]</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Ladedruck im Steigflug</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->ladedruckRC}} [inHg]</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Kühlklappen</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->kuehlklappen}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Abgasrohr Anzahl</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->anzahlAbgasrohre}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; width: 300px; height: 10px">Schalldämpfer</td>
                            <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->schalldaempfer}}</td>
                        </tr>
                    </div>
                    {{-- Propeller --}}
                    <div>
                        @if($laermmessung->fluggeraetGruppe != 'Kap11-UL')
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">3.Propeller</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Hersteller</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->herstellerProp}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Modell</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->modellProp}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Werknummer</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->werknummerProp}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Bauart</td>
                                <td style="text-align: left; width: 300px; height: 10px">
                                    @if($laermmessung->bauartProp == 'F')
                                        Festwinkel
                                    @endif
                                    @if($laermmessung->bauartProp == 'V')
                                        am Boden einstellbar
                                    @endif
                                    @if($laermmessung->bauartProp == 'A')
                                        im Flug verstellbar
                                    @endif    
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Durchmesser nominell</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->durchmesserNominell}} [m]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Durchmesser Toleranz</td>
                                <td style="text-align: left; width: 300px; height: 10px">+ - 5 [mm]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Durchmesser gemessen</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->durchmesserGemessen}} [m]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Blattanzahl</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->blattanzahl}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Blattspitzenform</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->blattspitzenform}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Drehrichtung</td>
                                <td style="text-align: left; width: 300px; height: 10px">
                                    @if($laermmessung->drehrichtungProp == 'L')
                                        linksdrehend
                                    @endif
                                    @if($laermmessung->drehrichtungProp == 'R')
                                        rechtsdrehend
                                    @endif    
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Nabenbezeichnung</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->nabenbezeichnung}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Typenbezeichnung</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->typenbezeichnung}}</td>
                            </tr>
                        @else
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">3.Hauptrotor</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Hersteller</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->herstellerProp}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Modell</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->modellProp}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Werknummer</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->werknummerProp}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Durchmesser gemessen</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->durchmesserGemessen}} [m]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Durchmesser Toleranz</td>
                                <td style="text-align: left; width: 300px; height: 10px">+ - 5 [mm]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Blattanzahl</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->blattanzahl}}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">4.Heckrotor</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Hersteller</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->herstellerProp2}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Modell</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->modellProp2}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Werknummer</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->werknummerProp2}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Durchmesser gemessen</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->durchmesserGemessen2}} [m]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Durchmesser Toleranz</td>
                                <td style="text-align: left; width: 300px; height: 10px">+ - 5 [mm]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Blattanzahl</td>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->blattanzahl2}}</td>
                            </tr>
                        @endif
                    </div>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Footer --}}
            <div>
                <table>
                    <td style="text-align: center; width: 900px;"><img src = "/home/www/kva/public/images/logos_footer_lfa.jpg" class="img-rounded" style="width: 100%"></td>
                </table>                    
            </div>
        </div>

        {{-- 3.Seite --}}
        <div>
            {{-- Header --}}
            <div>
                <table>
                    <td style="width: 650px; page-break-before: always"></td>
                    <td style="text-align: right; width: 300px;"><img src = "/home/www/kva/public/images/logo_fhaachen.jpg" class="img-rounded" style="width: 12%"></td>
                </table>                    
            </div>

            <div>
                <table>
                    {{-- Flugleistungen --}}
                    <div>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">4.Flugleistungen</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                        </table>
                        @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
                            <table>
                                <tr>
                                    <td style="text-align: left; width: 900px;"> 
                                        Daten wurden aus dem Flughandbuch übernommen bzw. im Vorfeld erflogen.<br>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="text-align: left; width: 150px; ">V<sub>Max</sub>:</td>
                                    <td style="text-align: left; width: 300px; ">{{$laermmessung->v_max}} [km/h] = {{round($laermmessung->v_max * 0.5399568,0)}} [kt]</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; ">V<sub>H</sub>:</td>
                                    <td style="text-align: left; width: 300px; ">{{$laermmessung->v_h}} [km/h] = {{round($laermmessung->v_h * 0.5399568,0)}} [kt]</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        @else
                            <table>
                                <tr>
                                    <td style="text-align: left; width: 900px;"> 
                                        Daten wurden aus dem Flughandbuch übernommen bzw. im Vorfeld erflogen.<br>
                                        Die Werte beziehen sich auf das Kurzstartverfahren bei 15 °C, kein Wind, Meereshöhe, <br>
                                        fester Rollbahn und zulässiger Höchstmasse.
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="text-align: left; width: 450px; ">Strecke zur Überwindung des 15m Hindernisses (D15)</td>
                                    <td style="text-align: left; width: 300px; ">{{$laermmessung->D15}} [m]</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 450px; ">Steigrate des besten Steigens (R/C)</td>
                                    <td style="text-align: left; width: 300px; ">{{$laermmessung->RC * 200}} [ft/min] = {{$laermmessung->RC}} [m/s]</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 450px; ">Geschwindigkeit während des besten Steigen (Vy) (bei D15 und R/C)</td>
                                    <td style="text-align: left; width: 350px; ">{{round($laermmessung->Vy * 1.94384,0)}} [kt] = {{round($laermmessung->Vy * 3.6,0)}} [km/h] = {{round($laermmessung->Vy,1)}} [m/s]</td>
                                </tr>
                            </table>
                        @endif
                    </div>

                    {{-- Allgemeine Angaben --}}
                    <div>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">5.Allgemeine Angaben</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                        </table>
                        <table>
                            <tr>
                                <td style="text-align: left; width: 900px;"> 
                                    Das Lärmmessverfahren wird mit höchstzulässiger Startmasse durchgeführt da das Gewicht großen <br>
                                    Einfluss auf die Messergebnisse hat.<br>
                                    Nach jeder Flugstunde wird die höchstzulässige Startmasse durch nachtanken wiederhergestellt.<br>
                                    Die Angaben des Auftraggebers wurden, soweit nachprüfbar, vor der Lärmmessung überprüft und <br>
                                    für korrekt befunden.
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Messgeräte --}}
                    <div>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">6.Messgeräte</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                        </table>
                        <table>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Schallpegelmesser</td>
                                <td style="text-align: left; width: 500px; height: 10px">Brüel & Kjær, PULSE Multi-analyzer System / 2250-L</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Messmikrofon</td>
                                <td style="text-align: left; width: 500px; height: 10px">Brüel & Kjær, Typ 4189 / 4950</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Kalibrator</td>
                                <td style="text-align: left; width: 500px; height: 10px">Brüel & Kjær, Typ 4231</td>
                            </tr>
                            <tr>
                                <td>
                                    {{-- Leerfeld --}}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Digitalkamera mit Festbrennweite</td>
                                <td style="text-align: left; width: 500px; height: 10px">Nikon D7000 mit Nikkor 50mm</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Ablageprüfung</td>
                                <td style="text-align: left; width: 500px; height: 10px">kalibrierte Höhenauswertung</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Meterologische Daten</td>
                                <td style="text-align: left; width: 500px; height: 10px">Hobo Weather Station Logger</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Windgeschwindigkeit</td>
                                <td style="text-align: left; width: 500px; height: 10px">PCE-A420</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Thermo- und Hygrometer</td>
                                <td style="text-align: left; width: 500px; height: 10px">PCE-HVAC3</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Barometer</td>
                                <td style="text-align: left; width: 500px; height: 10px">Fischer</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Drehzahlmesser</td>
                                <td style="text-align: left; width: 500px; height: 10px">Tach 200 PCE-155</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Dokumentation --}}
                    <div>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">7.Dokumentation</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                        </table>
                        <table>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Pegelaufzeichnung</td>
                                <td style="text-align: left; width: 500px; height: 10px">Brüel & Kjær, Pulse Labshop / BZ5503</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Videoaufzeichnung im Flugzeug</td>
                                <td style="text-align: left; width: 500px; height: 10px">GoPro Hero10 Black</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Umgebungsparameter --}}
                    <div>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">8.Umgebungsparameter</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                        </table>
                        <table>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Flugplatz</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->messort}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Höhe Messstelle über NN</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->messortHoehe}} [m]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px"></td>
                                <td style="text-align: left; width: 300px; height: 10px">vor Messbeginn</td>
                                <td style="text-align: left; width: 300px; height: 10px">nach Messende</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Luftdruck</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_beginn->QNH}} [hPa]</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_ende->QNH}} [hPa]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Luftfeuchtigkeit</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_beginn->luftfeuchte_rel}} [%]</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_ende->luftfeuchte_rel}} [%]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Temperatur am Boden</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_beginn->temperatur_boden}} [°C]</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_ende->temperatur_boden}} [°C]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Temperatur in Flughöhe</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_beginn->temperatur_flugh}} [°C]</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_ende->temperatur_flugh}} [°C]</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Umgebungslärmpegel</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_beginn->messpegel_umgeb}} [dB(A)]</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessDatei_ende->messpegel_umgeb}} [dB(A)]</td>
                            </tr>
                        </table>
                    </div>
                </table>
            </div>

            {{-- Footer --}}
            <div>
                <table>
                    <td style="text-align: center; width: 900px;"><img src = "/home/www/kva/public/images/logos_footer_lfa.jpg" class="img-rounded" style="width: 100%"></td>
                </table>                    
            </div>
        </div>

        {{-- 4.Seite --}}
        <div>
            {{-- Header --}}
            <div>
                <table>
                    <td style="width: 650px; page-break-before: always"></td>
                    <td style="text-align: right; width: 300px;"><img src = "/home/www/kva/public/images/logo_fhaachen.jpg" class="img-rounded" style="width: 12%"></td>
                </table>                    
            </div>

            <div>
                <table>
                    {{-- Flugleistungen --}}
                    <div>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">9.Messpersonal</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>   
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Verantwortlicher Leiter</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->leiter}}</td>
                            </tr> 
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Messstelle Boden 1</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->messstelleBoden1}}</td>
                            </tr> 
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Messstelle Boden 2</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->messstelleBoden2}}</td>
                            </tr> 
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Pilot</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->pilot}}</td>
                            </tr> 
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Beobachtung im Flugzeug</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->beobachterFlugzeug}}</td>
                            </tr> 
                        </table>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">10.Messübersicht</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                        </table>
                        <table>
                            <tr>
                                <td style="text-align: left; width: 900px;"> 
                                    Eine zusammenfassende Übersicht der aufgezeichneten und errechneten Werte der als gültig<br>
                                    bewerteten Überflüge ist als Anhang erstellt.<br>
                                    Diese Übersicht ist Teil des Protokolls.
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">11.Ergebnis</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Eingruppierung</td>
                                <td style="text-align: left; width: 500px; height: 10px">
                                    @if($laermmessung->fluggeraetGruppe == 'Kap10-G1')
                                        Kapitel 10 (Gruppe 1)
                                    @endif
                                    @if($laermmessung->fluggeraetGruppe == 'Kap10-G2')
                                        Kapitel 10 (Gruppe 2)
                                    @endif
                                    @if($laermmessung->fluggeraetGruppe == 'Kap10-UL')
                                        Kapitel 10 (Gruppe Ultraleichtflugzeuge) 
                                    @endif
                                    @if($laermmessung->fluggeraetGruppe == 'LVL')
                                        LVL 2004 
                                    @endif
                                    @if($laermmessung->fluggeraetGruppe == 'Kap11-Heli')
                                        Kapitel 11 (Gruppe Hubschrauber)
                                    @endif
                                </td>
                            </tr> 
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Lärmgrenzwert</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{round($laermmessung->laermgrenzwert,2)}} [dB(A)]</td>
                            </tr>
                            @if($laermmessung->fluggeraetGruppe == 'Kap10-UL')
                                <tr>
                                    <td style="text-align: left; width: 300px; height: 10px">Lärmgrenzwert für erhöhten Lärmschutz m. Bj. ab 01.01.2000</td>
                                    <td style="text-align: left; width: 500px; height: 10px">{{round(61+0.017*($laermmessung->mtow-500),2)}} [dB(A)]</td>
                                </tr>
                            @endif
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Pegel im Mittel</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{round($pegelwert_durschnitt,2)}} [dB(A)]</td>
                            </tr> 
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">Referenzhöhe</td>
                                <td style="text-align: left; width: 500px; height: 10px">{{$laermmessung->Href}} [m]</td>
                            </tr> 
                        </table>
                        <table>
                            <tr>
                                <th style="text-align: left; width: 300px; height: 10px">12.Bestätigung</th>
                                <td style="text-align: left; width: 300px;"></td>
                            </tr>    
                        </table>
                        <table>
                            <tr>
                                <td style="text-align: left; width: 900px;"> 
                                    Die Richtigkeit dieses Protokolls bestätigt der verantwortliche Leiter.
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>
                                    {{-- Leerfeld --}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{-- Leerfeld --}}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; width: 300px; height: 10px">{{$laermmessung->leiter}}</td>
                            </tr>    
                        </table>
                    </div>
                </table>
                <table>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{-- Leerfeld --}}
                        </td>
                    </tr>
                </table>
                {{-- Footer --}}
                <div>
                    <table>
                        <td style="text-align: center; width: 900px;"><img src = "/home/www/kva/public/images/logos_footer_lfa.jpg" class="img-rounded" style="width: 100%"></td>
                    </table>                    
                </div>
            </div>
        </div>

        {{-- 5.Seite --}}
        @if($laermmessung->fluggeraetGruppe == 'Kap11-UL')
            <div>
                {{-- Header --}}
                <div>
                    <table>
                        <td style="width: 650px; page-break-before: always"></td>
                        {{-- <td style="text-align: right; width: 300px;"><img src = "/home/www/kva/public/images/logo_fhaachen.jpg" class="img-rounded" style="width: 12%"></td> --}}
                    </table>                    
                </div>
                {{-- Anlage Protokoll --}}
                <div>
                    <table>
                        <tr>
                            <td style="text-align: center; font-weight:900; width: 900px; height: 10px"> 
                                Überflug - Messung nach Kap. 11 für {{$laermmessung->fluggeraet}} / {{$laermmessung->kennung}}
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Messdatum:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{date('d.m.Y',strtotime($laermmessung->messdatum))}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Ausstelldatum:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{date('d.m.Y',strtotime($laermmessung->protokolldatum))}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">durch:</td>
                            <td style="font-size: 10pt; text-align: left; width: 220px; height: 10px">{{$laermmessung->leiter}}</td>
                        </tr> 
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Messort:</td>
                            <td style="font-size: 10pt; text-align: left; width: 220px; height: 10px">{{($laermmessung->messort)}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Luftfahrzeug:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->fluggeraet}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Hersteller:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->herstellerFluggeraet}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Pegel/Umgeb.:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{round($pegelwertUmgeb_durschnitt,1)}} [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Motor:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->motor}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Höhen-Korr.:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">+ - 20%</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">MTOW:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->mtow}} [kg]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                        </tr> 
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Luftdruck:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">Beginn / Ende</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessDatei_beginn->QNH}} / {{$laermmessDatei_ende->QNH}} [hPa]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">max.Dauer RPM :</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->drehzahlRC}} [U/min]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Rotordurchmesser:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->durchmesserGemessen}} [m]</td>
                        </tr>
                    </table>
                    <table style="border: 1px solid grey;">
                        <tr>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Flug Nr.</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Zeit</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Wind-geschw. [kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Wind-richtg. [°]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Quer-windkomp. [kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Flug-bahn [°]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">IAS [m/s]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Temp. Boden [°C]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Temp. Flugh. [°C]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">rel. Luft-feuchte [%]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">QNH [hPa]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Rot. Drehz. [U/min]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Lade-druck [inHg]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Höhe ü. Micro [m]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">seitl. Abw. [°]</td>
                        </tr>
                        @foreach($laermmessDaten as $laermmessDatei)
                            <tr>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messdatenNr_id}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{date('H:i',strtotime($laermmessDatei->messzeit))}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->windgeschwindigkeit}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->windrichtung}}</td>
                                @php
                                    $richtungQuerwind = abs($laermmessDatei->flugbahn - $laermmessDatei->windrichtung);  

                                    $QuerwindGeschwindkeit = round(sin(deg2rad($richtungQuerwind))*$laermmessDatei->windgeschwindigkeit,1);

                                @endphp
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$QuerwindGeschwindkeit}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->flugbahn}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->IAS}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->temperatur_boden}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->temperatur_flugh}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->luftfeuchte_rel}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->QNH}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->drehzahl}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->ladedruck}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->hoehe_ueb_micro}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->seitl_abweichung}}</td>
                            </tr>
                            @endforeach
                    </table>
                    <table>
                        <tr>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Flug Nr.</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Mess-pegel [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Mess-pegel Umgeb. [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Ref. Geschw. [kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Ref. Geschw. Min.[kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Ref. Geschw. Max.[kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">IAS [kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">delta 1 [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">delta 2 [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">korr. Pegel [dB(A)]</td>
                        </tr>
                        @foreach($laermmessDaten as $laermmessDatei)
                            <tr>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messdatenNr_id}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messpegel}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messpegel_umgeb}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{round($laermmessDatei->v_r_ziel,1)}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{round($laermmessDatei->v_r_ziel - 3,0)}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{round($laermmessDatei->v_r_ziel + 3,0)}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{round($laermmessDatei->IAS/0.514444,0)}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->delta_1}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->delta_2}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messpegel_korr}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <table>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Lärmgrenzwert:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{round($laermmessung->laermgrenzwert,1)}} [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Endgültiger Pegelwert L<sub>A,max,korr</sub></td>
                            <td style="font-size: 15pt; text-align: left; width: 150px; height: 10px">{{round($pegelwert_durschnitt,1)}} [dB(A)]</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">Summe korr. Pegelw.:</td>
                            <td style="font-size: 10pt; text-align: left; width: 250px; height: 10px">{{round($pegelwert_summe,2)}} [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 400px; height: 10px">Summe quadr. korr. Pegelw.: {{round($pegelwert_korr_summe,2)}} [dB(A)^2]</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">90% Vertrauensbereich:</td>
                            <td style="font-size: 10pt; text-align: left; width: 250px; height: 10px">{{round($vertrauensgrenze,2)}} [dB(A)] < +/- 1,5 [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 400px; height: 10px">mit Standardabw.: {{round($standardabweichung,2)}} [dB(A)] und t={{$faktor_t}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">Referenzhöhe: </td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">{{round($laermmessung->Href,1)}} [m]</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">Messfenster:</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">max: {{round($laermmessung->Href + 15,1)}} [m]</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">min: {{round($laermmessung->Href - 15,1)}} [m]</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                        </tr>
                </div>
                {{-- Footer --}}
                <div>
                    <table>
                        <td style="text-align: center; width: 900px;"><img src = "/home/www/kva/public/images/logos_footer_lfa.jpg" class="img-rounded" style="width: 100%"></td>
                    </table>                    
                </div>
            </div>
        @else
            <div>
                {{-- Header --}}
                <div>
                    <table>
                        <td style="width: 650px; page-break-before: always"></td>
                        {{-- <td style="text-align: right; width: 300px;"><img src = "/home/www/kva/public/images/logo_fhaachen.jpg" class="img-rounded" style="width: 12%"></td> --}}
                    </table>                    
                </div>
                {{-- Anlage Protokoll --}}
                <div>
                    <table>
                        <tr>
                            <td style="text-align: center; font-weight:900; width: 900px; height: 10px"> 
                                Startflug - Messung nach LVL / Kap. 10 für {{$laermmessung->fluggeraet}} / {{$laermmessung->kennung}}
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Messdatum:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{date('d.m.Y',strtotime($laermmessung->messdatum))}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Ausstelldatum:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{date('d.m.Y',strtotime($laermmessung->protokolldatum))}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">durch:</td>
                            <td style="font-size: 10pt; text-align: left; width: 220px; height: 10px">{{$laermmessung->leiter}}</td>
                        </tr> 
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Messort:</td>
                            <td style="font-size: 10pt; text-align: left; width: 220px; height: 10px">{{($laermmessung->messort)}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Fluggerät:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->fluggeraet}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Hersteller:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->herstellerFluggeraet}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Pegel/Umgeb.:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{round($pegelwertUmgeb_durschnitt,1)}} [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Motor:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->motor}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">R/C:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->RC}} [m/s]</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Höhen-Korr.:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">+ - 20%</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">MTOW:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->mtow}} [kg]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Vy:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->Vy}} [m/s]</td>
                        </tr> 
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Luftdruck:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">Beginn / Ende</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Propeller:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->typenbezeichnung}}</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">D15:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->D15}} [m]</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px"></td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessDatei_beginn->QNH}} / {{$laermmessDatei_ende->QNH}} [hPa]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">max.RPM bei Vy lt. Herst.:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->drehzahlRC}} [U/min]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Spannweite:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{$laermmessung->spannweite}} [m]</td>
                        </tr>
                    </table>
                    <table style="border: 1px solid grey;">
                        <tr>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Flug Nr.</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Zeit</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Wind-geschw. [kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Wind-richtg. [°]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Quer-windkomp. [kt]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Flug-bahn [°]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">IAS [m/s]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Temp. Boden [°C]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Temp. Flugh. [°C]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">rel. Luft-feuchte [%]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">QNH [hPa]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Prop. Drehz. [U/min]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Lade-druck [inHg]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Höhe ü. Micro [m]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">seitl. Abw. [°]</td>
                        </tr>
                        @foreach($laermmessDaten as $laermmessDatei)
                            <tr>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messdatenNr_id}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{date('H:i',strtotime($laermmessDatei->messzeit))}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->windgeschwindigkeit}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->windrichtung}}</td>
                                @php
                                    $richtungQuerwind = abs($laermmessDatei->flugbahn - $laermmessDatei->windrichtung);  

                                    $QuerwindGeschwindkeit = round(sin(deg2rad($richtungQuerwind))*$laermmessDatei->windgeschwindigkeit,1);

                                @endphp
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$QuerwindGeschwindkeit}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->flugbahn}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->IAS}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->temperatur_boden}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->temperatur_flugh}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->luftfeuchte_rel}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->QNH}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->drehzahl}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->ladedruck}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->hoehe_ueb_micro}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->seitl_abweichung}}</td>
                            </tr>
                            @endforeach
                    </table>
                    <table>
                        <tr>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Flug Nr.</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Mess-pegel [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Mess-pegel Umgeb. [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Helic. Blattspitzen-Geschw. [m/s]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Schall-Geschw. [m/s]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Spitzen Machz. <br>[-]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">Mr - Mt <br>[-]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">delta 1 [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">delta 2 [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">delta 3 [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">delta 4 [dB(A)]</td>
                            <td style="font-size: 10pt; border: 1px solid grey; width: 65px; height: 40px">korr. Pegel [dB(A)]</td>
                        </tr>
                        @foreach($laermmessDaten as $laermmessDatei)
                            <tr>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messdatenNr_id}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messpegel}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messpegel_umgeb}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->blattspitzengeschw}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->schallgeschw}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->spitzen_machzahl}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->Mr_minus_Mt}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->delta_1}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->delta_2}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->delta_3}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->delta_4}}</td>
                                <td style="font-size: 10pt; border: 1px solid grey; height: 40px">{{$laermmessDatei->messpegel_korr}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <table>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Lärmgrenzwert:</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px">{{round($laermmessung->laermgrenzwert,1)}} [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">Endgültiger Pegelwert L<sub>A,max,korr</sub></td>
                            <td style="font-size: 15pt; text-align: left; width: 150px; height: 10px">{{round($pegelwert_durschnitt,2)}} [dB(A)]</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">Summe korr. Pegelw.:</td>
                            <td style="font-size: 10pt; text-align: left; width: 250px; height: 10px">{{round($pegelwert_summe,2)}} [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 400px; height: 10px">Summe quadr. korr. Pegelw.: {{round($pegelwert_korr_summe,2)}} [dB(A)^2]</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">90% Vertrauensbereich:</td>
                            <td style="font-size: 10pt; text-align: left; width: 250px; height: 10px">{{round($vertrauensgrenze,2)}} [dB(A)] < +/- 1,5 [dB(A)]</td>
                            <td style="font-size: 10pt; text-align: left; width: 400px; height: 10px">mit Standardabw.: {{round($standardabweichung,2)}} [dB(A)] und t={{$faktor_t}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">Referenzhöhe: </td>
                            <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">{{round($laermmessung->Href,1)}} [m] QFE</td>
                            <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                        </tr>
                        @if($laermmessung->fluggeraetGruppe == 'LVL')
                            <tr>
                                <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">Messfenster:</td>
                                <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">max: 150 [m] QFE</td>
                                <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px"></td>
                                <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">min: 75 [m] QFE</td>
                                <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                            </tr>
                        @else
                            <tr>
                                <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px">Messfenster:</td>
                                <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">max: {{round($laermmessung->Href + 0.2 * $laermmessung->Href,1)}} [m] QFE</td>
                                <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                            </tr>
                            <tr>
                                <td style="font-size: 10pt; text-align: left; width: 200px; height: 10px"></td>
                                <td style="font-size: 10pt; text-align: left; width: 100px; height: 10px">min: {{round($laermmessung->Href - 0.2 * $laermmessung->Href,1)}} [m] QFE</td>
                                <td style="font-size: 10pt; text-align: left; width: 120px; height: 10px"></td>
                            </tr>
                        @endif
                </div>
                {{-- Footer --}}
                <div>
                    <table>
                        <td style="text-align: center; width: 900px;"><img src = "/home/www/kva/public/images/logos_footer_lfa.jpg" class="img-rounded" style="width: 100%"></td>
                    </table>                    
                </div>
            </div>
        @endif

    </body>
</html>