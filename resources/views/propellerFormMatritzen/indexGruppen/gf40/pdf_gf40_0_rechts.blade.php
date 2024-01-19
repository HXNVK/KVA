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
                min-width: 35px;
            }
            thead { display: table-header-group }
            tfoot { display: table-row-group }
            tr { page-break-inside: avoid }
        </style>
    </head>       
    <body>
        <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF40-0 R</h1>
        <div class="row">

            <div class="float-sm-right" style = "display:block; clear:both; page-break-after:auto;">
                <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR RECHTSDREHENDEN PROPELLER-->

                    <th style="color: red" colspan="30">GF40-0 R K30-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/gf40/index_tabellenkopf_gf40_0_rechts_K30-1')
                    @include ('propellerFormMatritzen/indexGruppen/gf40/index_gf40_0_rechts_K30-1') 

                </table>
            </div>
        </div>
    </body>
</html>