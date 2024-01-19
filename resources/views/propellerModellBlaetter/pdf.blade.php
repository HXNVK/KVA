<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <img src = "/home/www/kva/public/img/logo_helix_header.png" class="img-rounded" style="max-width: 20%">    
        <style>
            table, th, td {
                border-collapse: collapse;
                border: 1px solid lightgrey;
                height: 50px;
                min-width: 50px;
                font-weight: 900;
            }
            th { font-size: 10pt; }
            td { font-size: 16pt; }
            
            thead { display: table-header-group }
            tfoot { display: table-row-group }
            tr { page-break-inside: avoid }
        </style>
    </head>       
        <body>
            <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Komp</th>
                    <th scope="col">Typ (alt)</th>
                    <th scope="col">DR</th>
                    <th scope="col">Winkel</th>
                    <th scope="col">VKT</th>
                    <th scope="col">Hälfte</th>
                    <th scope="col">BL [mm]</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if(count($propellerModellBlaetter) > 0)

                    {{-- Drehrichtung LINKS --}}
                    @foreach($propellerModellBlaetter as $propellerModellBlatt)
                        @if($propellerModellBlatt->propellerDrehrichtung->name == "L")
                            <tr>
                                <td style="min-width: 370px; color: blue" align="left">{{ $propellerModellBlatt->name }}</td>
                                <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                                <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                                <td  style="color: blue"  align="center">{{ $propellerModellBlatt->propellerDrehrichtung->name }}</td>
                                <td  style="color: blue"  align="center">{{ $propellerModellBlatt->winkel }}</td>
                                @if($propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                                    <td  style="color: blue"  align="center">{{ $propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                                @else
                                    <td  style="color: blue"  align="center">-</td>
                                @endif
                                <td style="color: blue"  align="center">OBEN</td>
                                <td style="color: blue"  align="center">{{ $propellerModellBlatt->bereichslaenge}}</td>
                                <td style="min-width: 100px; font-size: 10pt; font-weight: 500"></td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach($propellerModellBlaetter as $propellerModellBlatt)
                        @if($propellerModellBlatt->propellerDrehrichtung->name == "L")
                            <tr>
                                <td style="min-width: 370px; color: blue" align="left">{{ $propellerModellBlatt->name }}</td>
                                <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                                <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                                <td  style="color: blue"  align="center">{{ $propellerModellBlatt->propellerDrehrichtung->name }}</td>
                                <td  style="color: blue"  align="center">{{ $propellerModellBlatt->winkel }}</td>
                                @if($propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                                    <td  style="color: blue"  align="center">{{ $propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                                @else
                                    <td  style="color: blue"  align="center">-</td>
                                @endif
                                <td style="color: blue"  align="center">UNTEN</td>
                                <td style="color: blue"  align="center">{{ $propellerModellBlatt->bereichslaenge}}</td>
                                <td style="min-width: 100px; font-size: 10pt; font-weight: 500"></td>
                            </tr>
                        @endif
                    @endforeach

                    {{-- Drehrichtung RECHTS --}}
                    @foreach($propellerModellBlaetter as $propellerModellBlatt)
                        @if($propellerModellBlatt->propellerDrehrichtung->name == "R")        
                            <tr>
                                <td style="min-width: 370px; color: red" align="left">{{ $propellerModellBlatt->name }}</td>
                                <td  style="min-width: 80px; color: red"  align="center">{{ $propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                                <td  style="min-width: 80px; color: red"  align="center">{{ $propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                                <td  style="color: red"  align="center">{{ $propellerModellBlatt->propellerDrehrichtung->name }}</td>
                                <td  style="color: red"  align="center">{{ $propellerModellBlatt->winkel }}</td>
                                @if($propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                                    <td  style="color: red"  align="center">{{ $propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                                @else
                                    <td  style="color: red"  align="center">-</td>
                                @endif
                                <td style="color: red"  align="center">OBEN</td>
                                <td style="color: red"  align="center">{{ $propellerModellBlatt->bereichslaenge}}</td>
                                <td style="min-width: 100px; font-size: 10pt; font-weight: 500"></td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach($propellerModellBlaetter as $propellerModellBlatt)
                        @if($propellerModellBlatt->propellerDrehrichtung->name == "R")        
                            <tr>
                                <td style="min-width: 370px; color: red" align="left">{{ $propellerModellBlatt->name }}</td>
                                <td  style="min-width: 80px; color: red"  align="center">{{ $propellerModellBlatt->propellerModellKompatibilitaet->name}}</td>               
                                <td  style="min-width: 80px; color: red"  align="center">{{ $propellerModellBlatt->propellerModellBlattTyp->name_alt }}</td>
                                <td  style="color: red"  align="center">{{ $propellerModellBlatt->propellerDrehrichtung->name }}</td>
                                <td  style="color: red"  align="center">{{ $propellerModellBlatt->winkel }}</td>
                                @if($propellerModellBlatt->propellerVorderkantenTyp->text != "n.a.")
                                    <td  style="color: red"  align="center">{{ $propellerModellBlatt->propellerVorderkantenTyp->text }}</td>    
                                @else
                                    <td  style="color: red"  align="center">-</td>
                                @endif
                                <td style="color: red"  align="center">UNTEN</td>
                                <td style="color: red"  align="center">{{ $propellerModellBlatt->bereichslaenge}}</td>
                                <td style="min-width: 100px; font-size: 10pt; font-weight: 500"></td>
                            </tr>
                        @endif
                    @endforeach
                    
                @else
                    <p>Keine Daten vorhanden!!!</p>
                @endif
            </tbody>
            </table>
        </body>
</html>
