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
        <h1>HELIX Propeller Formen Matrix</h1>
        <div class="row">
            <div class="float-sm-left" style = "display:block; clear:both; page-break-after:always;">
                <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR LINKSDREHENDE PROPELLER-->
                    
                    <th style="color: blue" colspan="30">H25F L K25-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h25/index_tabellenkopf_h25_f_links_K25-1')
                    @include ('propellerFormMatritzen/indexGruppen/h25/index_h25_f_links_K25-1')   
                    <th style="color: blue" colspan="30">H26F L K25-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h26/index_tabellenkopf_h26_f_links_K25-1')
                    @include ('propellerFormMatritzen/indexGruppen/h26/index_h26_f_links_K25-1')   

                    <th style="color: blue" colspan="30">H30F L K30-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h30/index_tabellenkopf_h30_f_links_K30-1')
                    @include ('propellerFormMatritzen/indexGruppen/h30/index_h30_f_links_K30-1')
                    <th style="color: blue" colspan="30">H30F L K30-2</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h30/index_tabellenkopf_h30_f_links_K30-2')
                    @include ('propellerFormMatritzen/indexGruppen/h30/index_h30_f_links_K30-2')   

                    <th style="color: blue" colspan="30">H40F L K30-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h40/index_tabellenkopf_h40_f_links_K30-1')
                    @include ('propellerFormMatritzen/indexGruppen/h40/index_h40_f_links_K30-1') 

                    <th style="color: blue" colspan="30">H45F L K45-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h45/index_tabellenkopf_h45_f_links_K45-1')
                    @include ('propellerFormMatritzen/indexGruppen/h45/index_h45_f_links_K45-1') 

                    <th style="color: blue" colspan="30">H50F L K50-2</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_links_K50-2')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_links_K50-2') 
                    
                    <th style="color: blue" colspan="30">H50F L K50-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_links_K50-1')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_links_K50-1') 

                    <th style="color: blue" colspan="30">H50F L K50-4</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_links_K50-4')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_links_K50-4') 

                    <th style="color: blue" colspan="30">H50F L K50-3</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_links_K50-3')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_links_K50-3') 

                </table>
            </div>
            <div class="float-sm-right" style = "display:block; clear:both; page-break-after:always;">
                <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR RECHTSDREHENDEN PROPELLER-->

                    <th style="color: red" colspan="30">H25F R K25-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h25/index_tabellenkopf_h25_f_rechts_K25-1')
                    @include ('propellerFormMatritzen/indexGruppen/h25/index_h25_f_rechts_K25-1') 

                    <th style="color: red" colspan="30">H30F R K30-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h30/index_tabellenkopf_h30_f_rechts_K30-1')
                    @include ('propellerFormMatritzen/indexGruppen/h30/index_h30_f_rechts_K30-1')  

                    <th style="color: red" colspan="30">H40F R K30-2</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h40/index_tabellenkopf_h40_f_rechts_K30-1')
                    @include ('propellerFormMatritzen/indexGruppen/h40/index_h40_f_rechts_K30-1') 

                    <th style="color: red" colspan="30">H45F R K45-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h45/index_tabellenkopf_h45_f_rechts_K45-1')
                    @include ('propellerFormMatritzen/indexGruppen/h45/index_h45_f_rechts_K45-1') 

                    <th style="color: red" colspan="30">H50F R K50-2</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_rechts_K50-2')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_rechts_K50-2') 

                    <th style="color: red" colspan="30">H50F R K50-1</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_rechts_K50-1')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_rechts_K50-1') 

                    <th style="color: red" colspan="30">H50F R K50-4</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_rechts_K50-4')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_rechts_K50-4') 

                    <th style="color: red" colspan="30">H50F R K50-3</th>
                    @include ('propellerFormMatritzen/tabellenkoepfe/h50/index_tabellenkopf_h50_f_rechts_K50-3')
                    @include ('propellerFormMatritzen/indexGruppen/h50/index_h50_f_rechts_K50-3') 

                </table>
            </div>
        </div>
    </body>
</html>