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
            }
            th { font-size: 14pt; }
            td { font-size: 12pt; }

            thead { display: table-header-group }
            tfoot { display: table-row-group }
            tr { page-break-inside: avoid }
        </style>
    </head>       
    <body>
        <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF25-0 R</h1>
        <div class="row">    
            <div class="float-sm-right" style = "display:block; clear:both; page-break-after:auto;">
                <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR RECHTSDREHENDEN PROPELLER-->

                    <th style="color: red" colspan="30">GF25 R K25-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/gf25/index_tabellenkopf_gf25_0_rechts_K25-1')
                    @include ('propellerFormMatritzen/indexGruppen/gf25/index_gf25_0_rechts_K25-1') 

                </table>
            </div>
        </div>
    </body>
</html>