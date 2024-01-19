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
                min-width: 100px;
            }
            thead { display: table-header-group }
            tfoot { display: table-row-group }
            tr { page-break-inside: avoid }
        </style>
    </head>       
    <body>
        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Typen</th>
                    <th scope="col">Typen (ALT)</th>
                    <th scope="col">RPS</th>
                    <th scope="col">block_ay</th>
                    <th scope="col">block_fy</th>
                    <th scope="col">kommentar</th>
                </tr>
            </thead>
            <tbody>
            @if(count($propellerModellKompatibilitaeten) > 0)
                @foreach($propellerModellKompatibilitaeten as $propellerModellKompatibilitaet)
                <tr>
                    <td style=min-width:100px align="left">{{ $propellerModellKompatibilitaet->name }}</td>
                    <td style=min-width:200px align="center">{{ $propellerModellKompatibilitaet->typen }}</td>
                    <td style=min-width:200px align="center">{{ $propellerModellKompatibilitaet->typen_alt }}</td>
                    <td align="center">{{ $propellerModellKompatibilitaet->rps }}</td>
                    <td align="center">{{ $propellerModellKompatibilitaet->block_ay }}</td>
                    <td align="center">{{ $propellerModellKompatibilitaet->block_fy }}</td>
                    <td style=min-width:150px align="center">{{ $propellerModellKompatibilitaet->kommentar }}</td>
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
        </table>
    </body>
</html>
