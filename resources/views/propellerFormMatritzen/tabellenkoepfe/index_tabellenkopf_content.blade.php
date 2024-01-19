<tr>
    <th style=min-width:70px>GK</th>
    <th style=min-width:50px>&Oslash;</th>
    <th style=min-width:50px>DR</th>
    <th style=min-width:70px>Typ</th>
    <th style=min-width:70px>Typ (Alt)</th>
    <th style=min-width:50px>NC</th>
    <th style=min-width:50px>Konus-Winkel</th>
    <th style=min-width:30px>Winkel Blatt</th>
    <th style colspan="22">Winkel Wurzel</th>
</tr>
@if(count($propellerModellWurzeln) > 0)
    @foreach($propellerModellWurzeln as $propellerModellWurzel)
        <tr>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td style="background-color: lightgray" align="center"></td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-9.0")
                                    {{ "-9°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-8.0")
                                    {{ "-8°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-7.0")
                                    {{ "-7°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-6.0")
                                    {{ "-6°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-5.0")
                                    {{ "-5°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-4.0")
                                    {{ "-4°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-3.0")
                                    {{ "-3°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-2.0")
                                    {{ "-2°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach</td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "-1.0")
                                    {{ "-1°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>    
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                        @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                            @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                                @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                    @if($propellerModellWurzel->propellerModellWurzel_winkel == "0.0")
                                        {{ "0°" }}
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "1.0")
                                    {{ "1°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "2.0")
                                    {{ "2°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "3.0")
                                    {{ "3°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "4.0")
                                    {{ "4°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "5.0")
                                    {{ "5°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "6.0")
                                    {{ "6°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "7.0")
                                    {{ "7°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "8.0")
                                    {{ "8°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "9.0")
                                    {{ "9°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "10.0")
                                    {{ "10°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "11.0")
                                    {{ "11°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
            <td style="background-color: lightgray" align="center">
            @foreach($propellerModellWurzeln as $propellerModellWurzel)
                @if($propellerModellWurzel->kompatibilitaet_name == $kompatibilitaet)
                    @if(substr($propellerModellWurzel->geometrieklasse,1,1) == $propellerModellWurzel_typ)
                        @if($propellerModellWurzel->drehrichtung == $drehrichtung)
                            @if($propellerModellWurzel->geometrieklasse == $geometrieklasse)
                                @if($propellerModellWurzel->propellerModellWurzel_winkel == "12.0")
                                    {{ "12°" }}
                                @endif
                            @endif
                        @endif
                    @endif
                @endif
            @endforeach
            </td>
        </tr> 
        @break
    @endforeach
@else
<p>Keine Daten von propellerModellWurzelnn vorhanden!</p>
@endif