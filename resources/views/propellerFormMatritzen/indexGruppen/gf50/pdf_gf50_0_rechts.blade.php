<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <img src = "/home/www/helixmatrix/public/img/logo_helix_header.png" class="img-rounded" style="max-width: 20%">    
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
        <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF50-0 R</h1>
            <div class="float-sm-right" style = "display:block; clear:both; page-break-after:avoid;">
                <table class="table table-striped table-bordered table-hover">
                    <th style="color: red" colspan="30">GF50-0 R K50-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-1')
                    @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-1') 
                </table>
            </div>
            <div class="float-sm-right" style = "display:block; clear:both; page-break-after:avoid;">
                <table class="table table-striped table-bordered table-hover">
                    <th style="color: red" colspan="30">GF50-0 R K50-2</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-2')
                    @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-2') 
                </table>
            </div>
            <div class="float-sm-right" style = "display:block; clear:both; page-break-after:always;">
                <table class="table table-striped table-bordered table-hover">
                    <th style="color: red" colspan="30">GF50-0 R K50-3</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-3')
                    @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-3')
                </table>
            </div>
            <div class="float-sm-right" style = "display:block; clear:both; page-break-after:avoid;">
                <table class="table table-striped table-bordered table-hover">
                    <th style="color: red" colspan="30">GF50-0 R K50-4</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-4')
                    @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-4') 
                </table>
            </div>
    </body>
</html>