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
        <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF31-0 L</h1>
        <div class="row">
            <div class="float-sm-left" style = "display:block; clear:both; page-break-after:auto;">
                <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR LINKSDREHENDE PROPELLER-->
                    
                    <th style="color: blue" colspan="30">GF31-0 L K30-2</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/gf31/index_tabellenkopf_gf31_0_links_K30-2')
                    @include ('propellerFormMatritzen/indexGruppen/gf31/index_gf31_0_links_K30-2')       

                </table>
            </div>
        </div>
    </body>
</html>