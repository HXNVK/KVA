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
                min-width: 30px;
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
                <th scope="col">DR</th>
                <th scope="col">Hälfte</th>
                <th scope="col">BL [mm]</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($propellerModellWurzeln) > 0)

                {{-- Drehrichtung LINKS --}}
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                    @if($propellerModellWurzel->propellerDrehrichtung->name == "L")
                        <tr>
                            <td style="min-width: 320px; color: blue" align="left">{{ $propellerModellWurzel->name }}</td>
                            <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                            <td  style="color: blue"  align="center">{{ $propellerModellWurzel->propellerDrehrichtung->name }}</td>
                            <td style="color: blue"  align="center">OBEN</td>
                            <td style="color: blue"  align="center">{{ $propellerModellWurzel->bereichslaenge}}</td>
                            <td style="min-width: 150px; font-size: 10pt; font-weight: 500"></td>
                        </tr>
                    @endif
                @endforeach
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                    @if($propellerModellWurzel->propellerDrehrichtung->name == "L")
                        <tr>
                            <td style="min-width: 320px; color: blue" align="left">{{ $propellerModellWurzel->name }}</td>
                            <td  style="min-width: 80px; color: blue"  align="center">{{ $propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                            <td  style="color: blue"  align="center">{{ $propellerModellWurzel->propellerDrehrichtung->name }}</td>
                            <td style="color: blue"  align="center">UNTEN</td>
                            <td style="color: blue"  align="center">{{ $propellerModellWurzel->bereichslaenge}}</td>
                            <td style="min-width: 150px; font-size: 10pt; font-weight: 500"></td>
                        </tr>
                    @endif
                @endforeach

                {{-- Drehrichtung RECHTS --}}
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                    @if($propellerModellWurzel->propellerDrehrichtung->name == "R")        
                        <tr>
                            <td style="min-width: 320px; color: red" align="left">{{ $propellerModellWurzel->name }}</td>
                            <td  style="min-width: 80px; color: red"  align="center">{{ $propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                            <td  style="color: red"  align="center">{{ $propellerModellWurzel->propellerDrehrichtung->name }}</td>
                            <td style="color: red"  align="center">OBEN</td>
                            <td style="color: red"  align="center">{{ $propellerModellWurzel->bereichslaenge}}</td>
                            <td style="min-width: 150px; font-size: 10pt; font-weight: 500"></td>
                        </tr>
                    @endif
                @endforeach
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                    @if($propellerModellWurzel->propellerDrehrichtung->name == "R")        
                        <tr>
                            <td style="min-width: 320px; color: red" align="left">{{ $propellerModellWurzel->name }}</td>
                            <td  style="min-width: 80px; color: red"  align="center">{{ $propellerModellWurzel->propellerModellKompatibilitaet->name}}</td>               
                            <td  style="color: red"  align="center">{{ $propellerModellWurzel->propellerDrehrichtung->name }}</td>
                            <td style="color: red"  align="center">UNTEN</td>
                            <td style="color: red"  align="center">{{ $propellerModellWurzel->bereichslaenge}}</td>
                            <td style="min-width: 150px; font-size: 10pt; font-weight: 500"></td>
                        </tr>
                    @endif
                @endforeach
                
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
        </tbody>
        </table>
    </body>       
    {{-- <body>
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">GK</th>
                    <th scope="col">DR</th>
                    <th scope="col">Winkel</th>
                    <th scope="col">BL [mm]</th>
                    <th scope="col">Kommentar</th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerModellWurzeln) > 0)
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                    @if($propellerModellWurzel->propellerDrehrichtung->name == "L")
                        <tr>
                            <td style="min-width: 300px; color: blue" align="left">{{ $propellerModellWurzel->name }}</td>
                            <td style="color: blue" align="center">{{ $propellerModellWurzel->propellerKlasseGeometrie->name }}</td>
                            <td style="color: blue" align="center">{{ $propellerModellWurzel->propellerDrehrichtung->name }}</td>
                            <td style="color: blue" align="center">{{ $propellerModellWurzel->winkel }}</td>
                            <td style="color: blue" align="center">{{ $propellerModellWurzel->bereichslaenge }}</td>
                            <td style="min-width:200px; font-size: 10pt; font-weight: 500" align="center">{{ $propellerModellWurzel->kommentar }}</td>
                        </tr>
                    @endif
                @endforeach
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                    @if($propellerModellWurzel->propellerDrehrichtung->name == "R")
                        <tr>
                            <td style="min-width:300px; color: red" align="left">{{ $propellerModellWurzel->name }}</td>
                            <td style="color: red" align="center">{{ $propellerModellWurzel->propellerKlasseGeometrie->name }}</td>
                            <td style="color: red" align="center">{{ $propellerModellWurzel->propellerDrehrichtung->name }}</td>
                            <td style="color: red" align="center">{{ $propellerModellWurzel->winkel }}</td>
                            <td style="color: red" align="center">{{ $propellerModellWurzel->bereichslaenge }}</td>
                            <td style="min-width:200px; font-size: 10pt; font-weight: 500" align="center">{{ $propellerModellWurzel->kommentar }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
        </table>
    </body> --}}
</html>