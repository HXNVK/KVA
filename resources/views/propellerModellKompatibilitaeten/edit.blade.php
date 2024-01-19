@extends('layouts.app')

@section('content')
<a href="/propellerModellKompatibilitaeten" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Kompatibilitaet {{ $propellerModellKompatibilitaet->name }} ändern</h1>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => ['PropellerModellKompatibilitaetenController@update', $propellerModellKompatibilitaet->id], 'method' => 'POST']) !!}
        <div class="form-group row">
            {{Form::label('name','Name',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('name',$propellerModellKompatibilitaet->name, ['class' => 'form-control','placeholder' =>'K30-1'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('typen','Typen',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('typen',$propellerModellKompatibilitaet->typen, ['class' => 'form-control','placeholder' =>'-GMZ-GMM-GML-'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('typen_alt','Typen (ALT)',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('typen_alt',$propellerModellKompatibilitaet->typen_alt, ['class' => 'form-control','placeholder' =>'-Z-M-L-ES-EZ-EM-PV-SW-'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('rps','RPS',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('rps',$propellerModellKompatibilitaet->rps, ['class' => 'form-control','step' => '0.1','min' => '50', 'max' => '300', 'placeholder' =>'150'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('pli','PLI',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('pli',$propellerModellKompatibilitaet->pli, ['class' => 'form-control','step' => '0.5','min' => '0', 'max' => '300','placeholder' =>'80'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('ps','PS',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('ps',$propellerModellKompatibilitaet->ps, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '2500','placeholder' =>'450'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('beta','Beta',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('beta',$propellerModellKompatibilitaet->beta, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '35','placeholder' =>'15'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('pmi','PMI',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('pmi',$propellerModellKompatibilitaet->pmi, ['class' => 'form-control','step' => '0.01','min' => '0', 'max' => '1','placeholder' =>'0.33'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('pzi','PZI',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('pzi',$propellerModellKompatibilitaet->pzi, ['class' => 'form-control','step' => '0.01','min' => '-20','placeholder' =>'0'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('block_ay','Block AY',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('block_ay',$propellerModellKompatibilitaet->block_ay, ['class' => 'form-control','step' => '1','min' => '-150', 'max' => '150','placeholder' =>'80'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('block_fy','Block FY',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('block_fy',$propellerModellKompatibilitaet->block_fy, ['class' => 'form-control','step' => '1','min' => '-150', 'max' => '150','placeholder' =>'-120'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('rand','Rand',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('rand',$propellerModellKompatibilitaet->rand, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '50','placeholder' =>'10'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('block_rand','Block Rand',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('block_rand',$propellerModellKompatibilitaet->block_rand, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '50','placeholder' =>'10'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('kommentar','Kommentar',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::textarea('kommentar',$propellerModellKompatibilitaet->kommentar, ['class' => 'form-control','rows' => 3, 'cols' => 20, 'placeholder' =>'Kommentar'])}}
            </div>
        </div>

        {{Form::hidden('_method','PUT')}}
        {{Form::submit('ändern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
        @endsection
    </div>
</div>
