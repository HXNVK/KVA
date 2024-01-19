<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <img src = "/home/www/kva/public/img/logo_helix_header.png" class="img-rounded" style="max-width: 20%">
        <style>
            table, th, td {
                border-collapse: collapse;
                border: 1px solid grey;
                height: 50px;
                min-width: 70px;
                font-weight: 500;
            }
            th { font-size: 10pt; }
            td { font-size: 14pt; }

            thead { display: table-header-group }
            tfoot { display: table-row-group }
            tr { page-break-inside: avoid }
        </style>
    </head>       
    <body>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Typ</th>
                    <th scope="col">Typ (1/3) Umrissform</th>
                    <th scope="col">Typ (2/3) Profilform</th>
                    <th scope="col">Typ (3/3) Profill&auml;nge</th>
                    <th scope="col">Typ (Alt)</th>
                    <th scope="col">Komp.</th>
                    <th scope="col">Designklasse-Klasse</th>
                    <th scope="col">Excl.</th>
                    <th scope="col">Kunde</th>
                    <th scope="col">Kommentar</th>

                </tr>
            </thead>
            <tbody>
            @if(count($propellerModellBlattTypen) > 0)
                @foreach($propellerModellBlattTypen as $propellerModellBlattTyp)
                <tr>
                    <td style="min-width: 150px; align="left">{{ $propellerModellBlattTyp->name }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->umrissform }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->profilform }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->profillaenge }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->name_alt }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->propellerModellKompatibilitaet->name }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->propellerKlasseDesign->name }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->exclusiv }}</td>
                    <td align="center">{{ $propellerModellBlattTyp->kunde }}</td>
                    <td style=min-width:180px></td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
        </table>
    </body>
</html>