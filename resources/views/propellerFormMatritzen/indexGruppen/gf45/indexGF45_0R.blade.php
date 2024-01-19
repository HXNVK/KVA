@extends('layouts.app')

@section('content')
    <h1>HELIX Propeller Formen Matrix nach Geometrieklasse GF45-0 R</h1>
    <a href="/propellerFormMatritzen" class="btn btn-success">
        <span class="oi" data-glyph="home" title="Übersicht" aria-hidden="true"></span>
    </a>
    <br>
    <br>
    <a href="{{action('PropellerFormMatritzenController@formenMatrixPDF_GF45_0_R')}}" class="btn btn-warning">PDF
        <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
    </a>
    <br>
    <div class="row">
        <div class="float-sm-right">
            <table class="table table-striped table-bordered table-hover"> <!--TABELLE FÜR RECHTSDREHENDEN PROPELLER-->
                
                <th style="color: red" colspan="30">GF45-0 R K45-1</th>
                @include ('propellerFormMatritzen/tabellenkoepfe/gf45/index_tabellenkopf_gf45_0_rechts_K45-1')
                @include ('propellerFormMatritzen/indexGruppen/gf45/index_gf45_0_rechts_K45-1') 

            </table>
        </div>
    </div>

@endsection