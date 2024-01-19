@extends('layouts.app')

@section('content')
    <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GK30 R</h1>
    <a href="/propellerFormMatritzen" class="btn btn-success">
        <span class="oi" data-glyph="home" title="Übersicht" aria-hidden="true"></span>
    </a>
    <br>
    <br>
    <a href="{{action('PropellerFormMatritzenController@formenMatrixPDF_GK30_0_R')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br>
    <div class="row">
        <div class="float-sm-right">
            <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR RECHTSDREHENDEN PROPELLER-->

                <th style="color: red" colspan="30">GK30-0 R K30-1</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gk30/index_tabellenkopf_gk30_0_rechts_K30-1')
                @include ('propellerFormMatritzen/indexGruppen/gk30/index_gk30_0_rechts_K30-1') 

            </table>
        </div>
    </div>

@endsection