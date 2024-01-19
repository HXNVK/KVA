@extends('layouts.app')

@section('content')
    <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF50-0 R</h1>
    <a href="/propellerFormMatritzen" class="btn btn-success">
        <span class="oi" data-glyph="home" title="Übersicht" aria-hidden="true"></span>
    </a>
    <br>
    <br>
    <a href="{{action('PropellerFormMatritzenController@formenMatrixPDF_GF50_0_R')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br>
    <div class="row">
        <div class="float-sm-right">
            <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR RECHTSDREHENDEN PROPELLER-->
                
                <th style="color: red" colspan="30">GF50-0 R K50-1</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-1')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-1') 
               
                <th style="color: red" colspan="30">GF50-0 R K50-2</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-2')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-2') 

                <th style="color: red" colspan="30">GF50-0 R K50-3</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-3')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-3')

                <th style="color: red" colspan="30">GF50-0 R K50-4</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf50/index_tabellenkopf_gf50_0_rechts_K50-4')
                @include ('propellerFormMatritzen/indexGruppen/gf50/index_gf50_0_rechts_K50-4') 

            </table>
        </div>
    </div>

@endsection