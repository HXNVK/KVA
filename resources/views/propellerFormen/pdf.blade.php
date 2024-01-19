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
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($propellerFormenObjects) > 0)

                {{-- Drehrichtung LINKS --}}
                @foreach($propellerFormenObjects as $propellerFormenObject)
                    @if($propellerFormenObject->propellerDrehrichtungID == "1")
                        <tr>
                            <td style="min-width: 320px; color: blue" align="left">{{ $propellerFormenObject->propellerFormName }}</td>
                            <td style="min-width: 150px; font-size: 10pt; font-weight: 500"></td>
                        </tr>
                    @endif
                @endforeach
                @foreach($propellerFormenObjects as $propellerFormenObject)
                    @if($propellerFormenObject->propellerDrehrichtungID == "1")
                        <tr>
                            <td style="min-width: 320px; color: blue" align="left">{{ $propellerFormenObject->propellerFormName }}</td>
                            <td style="min-width: 150px; font-size: 10pt; font-weight: 500"></td>
                        </tr>
                    @endif
                @endforeach

                {{-- Drehrichtung RECHTS --}}
                @foreach($propellerFormenObjects as $propellerFormenObject)
                    @if($propellerFormenObject->propellerDrehrichtungID == "2")        
                        <tr>
                            <td style="min-width: 320px; color: red" align="left">{{ $propellerFormenObject->propellerFormName }}</td>
                            <td style="min-width: 150px; font-size: 10pt; font-weight: 500"></td>
                        </tr>
                    @endif
                @endforeach
                @foreach($propellerFormenObjects as $propellerFormenObject)
                    @if($propellerFormenObject->propellerDrehrichtungID == "2")        
                        <tr>
                            <td style="min-width: 320px; color: red" align="left">{{ $propellerFormenObject->propellerFormName}}</td>
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
</html>