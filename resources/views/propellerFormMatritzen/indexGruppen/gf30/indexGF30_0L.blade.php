@extends('layouts.app')

@section('content')
    <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF30-0 L</h1>
    <a href="/propellerFormMatritzen" class="btn btn-success">
        <span class="oi" data-glyph="home" title="Übersicht" aria-hidden="true"></span>
    </a>
    <br>
    <br>
    <a href="{{action('PropellerFormMatritzenController@formenMatrixPDF_GF30_0_L')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br>
    <div class="row">
        <div class="float-sm-left">
            <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR LINKSDREHENDE PROPELLER-->

                <th style="color: blue" colspan="30">GF30-0 L K30-1</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf30/index_tabellenkopf_gf30_0_links_K30-1')
                @include ('propellerFormMatritzen/indexGruppen/gf30/index_gf30_0_links_K30-1')
                <th style="color: blue" colspan="30">GF30-0 L K30-2</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf30/index_tabellenkopf_gf30_0_links_K30-2')
                @include ('propellerFormMatritzen/indexGruppen/gf30/index_gf30_0_links_K30-2')   

            </table>
        </div>
    </div>

@endsection