@if(count($propellerFormen) > 0)
    @foreach($propellerModellBlaetter as $propellerModellBlatt)	
        @if($propellerModellBlatt->kompatibilitaet_name == $kompatibilitaet)
            @if($propellerModellBlatt->drehrichtung == $drehrichtung)
                @foreach($propellerFormen as $propellerForm)
                    @if($propellerModellBlatt->propellerModellBlatt_name == $propellerForm->propellerModellBlatt_name)
                        @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                            <tr>
                                <td align="center">{{ $geometrieklasse }}</td>
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            {{ number_format(2* ($propellerForm->propellerModellBlatt_bereichslaenge + $propellerForm->propellerModellWurzel_bereichslaenge)/1000,2,'.','') ."m"}}
                                            @break
                                        @endif
                                    @endif
                                @endforeach
                                </td><!--Durchmesser-->
                                <td align="center">{{ $propellerModellBlatt->drehrichtung }}</td><!--Drehrichtung-->
                                <td align="center">{{ $propellerModellBlatt->propellerModellBlatt_typ }}</td><!--typ-->
                                <td align="center">({{ $propellerModellBlatt->propellerModellBlatt_typalt }})</td><!--typalt-->
                                <td align="center">
                                    @if($propellerForm->vorderkantentypID != 1)
                                        {{ $propellerForm->vorderkantentyp }}
                                    @endif    
                                </td><!--Vorderkantentyp-->
                                <td align="center">
                                    @if($propellerForm->propellerForm_konuswinkel != NULL || $propellerForm->propellerForm_konuswinkel != "0.0")
                                        {{ $propellerForm->propellerForm_konuswinkel }}
                                    @endif     
                                </td><!--Konuswinkel-->
                                <td style="background-color: lightgray" align="center">{{ $propellerModellBlatt->propellerModellBlatt_winkel }}°</td><!--Blatt-Winkel-->
                                <td align="center">
                                    @foreach($propellerFormen as $propellerForm)
                                        @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                            @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                                @if($propellerForm->propellerModellWurzel_winkel == "-9")
                                                    {{ $propellerForm->propellerForm_winkel }} 
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                </td><!-- -9° -->
                                <td align="center">
                                    @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-8")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- -8° -->
                                <td align="center">            
                                    @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-7")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- -7° -->
                                <td align="center">
                                    @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-6")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- -6° -->
                                <td align="center">            
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-5")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- -5° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-4")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- -4° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-3")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- -3° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-2")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- -2° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "-1")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif    
                                @endforeach
                                </td><!-- -1° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if(Str::of($propellerForm->propellerModellWurzel_name)->containsAll(["$geometrieklasse"]))
                                                @if($propellerForm->propellerModellWurzel_winkel == "0")
                                                    {{ $propellerForm->propellerForm_winkel }} 
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 0° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "1")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 1° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "2")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 2° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "3")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 3° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "4")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 4° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "5")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 5° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "6")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 6° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "7")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 7° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "8")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 8° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "9")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 9° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "10")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 10° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "11")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 11° -->
                                <td align="center">
                                @foreach($propellerFormen as $propellerForm)
                                    @if(Str::of($propellerForm->propellerForm_name)->containsAll(["$geometrieklasse"]))
                                        @if($propellerForm->propellerModellBlatt_name == $propellerModellBlatt->propellerModellBlatt_name)
                                            @if($propellerForm->propellerModellWurzel_winkel == "12")
                                                {{ $propellerForm->propellerForm_winkel }} 
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                </td><!-- 12° -->
                            </tr>
                            @break
                        @endif 
                    @endif
                @endforeach
            @endif 
        @endif
    @endforeach
@else
<p>Keine Daten vorhanden!</p>
@endif