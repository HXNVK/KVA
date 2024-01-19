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
                font-weight: 600;
            }
            th { font-size: 10pt; }
            td { font-size: 14pt; }
            
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
                    <th scope="col">Kommentar</th>
                </tr>
            </thead>
            <tbody>
            @if(count($materialien) > 0)
                @foreach($materialien as $material)
                    <tr>
                        <td style="min-width: 320px; " align="left">{{ $material->name }}</td>
                        <td style="min-width: 200px; font-size: 10pt; font-weight: 500">{{ $material->kommentar}}</td>
                    </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
        </table>
    </body>
</html>
