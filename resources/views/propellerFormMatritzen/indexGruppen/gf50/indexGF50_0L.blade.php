@extends('layouts.app')

@section('content')
    <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF50-0 L</h1>
    <a href="/propellerFormMatritzen" class="btn btn-success">
        <span class="oi" data-glyph="home" title="Übersicht" aria-hidden="true"></span>
    </a>
    <br>
    <br>
    <a href="{{action('PropellerFormMatritzenController@formenMatrixPDF_GF50_0_L')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br>
    <div class="row">
        <div class="float-sm-left">
            <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR LINKSDREHENDE PROPELLER-->

                <th style="color: blue" colspan="30">GF50-0 L K50-1</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_links_K50-1')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_links_K50-1')                
                
                <th style="color: blue" colspan="30">GF50-0 L K50-2</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_links_K50-2')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_links_K50-2') 

                <th style="color: blue" colspan="30">GF50-0 L K50-3</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_links_K50-3')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_links_K50-3') 

                <th style="color: blue" colspan="30">GF50-0 L K50-4</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_links_K50-4')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_links_K50-4') 

            </table>
        </div>
    </div>

@endsection