@extends('layouts.app')

@section('content')
<a href="/propellerModellKompatibilitaeten" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Kompatibilitaet neu anlegen</h1>
<div class="row">
    <div class="col">
    {!! Form::open(['action' => 'PropellerModellKompatibilitaetenController@store', 'method' => 'POST']) !!}
        <div class="form-group row">
            {{Form::label('name','Name',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('name','', ['class' => 'form-control','placeholder' =>'Bsp.: K30-1'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('typen','Typen',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('typen','', ['class' => 'form-control','placeholder' =>'Bsp.: -GMZ-GMM-GML-'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('typen_alt','Typen (ALT)',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('typen_alt','', ['class' => 'form-control','placeholder' =>'Bsp.: -Z-M-L-ES-EZ-EM-PV-SW-'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('rps','RPS',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('rps','', ['class' => 'form-control','step' => '0.1','min' => '50', 'max' => '300', 'placeholder' =>'Bsp.: 150'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('pli','PLI',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('pli','', ['class' => 'form-control','step' => '0.5','min' => '0', 'max' => '300','placeholder' =>'Bsp.: 80'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('ps','PS',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('ps','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '2500','placeholder' =>'Bsp.: 450'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('beta','Beta',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('beta','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '55','placeholder' =>'Bsp.: 15'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('pmi','PMI',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('pmi','', ['class' => 'form-control','step' => '0.01','min' => '0.01', 'max' => '1','placeholder' =>'Bsp.: 0.33'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('pzi','PZI',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('pzi','', ['class' => 'form-control','step' => '0.01','min' => '-20','placeholder' =>'Bsp.: 0'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('block_ay','Block AY',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('block_ay','', ['class' => 'form-control','step' => '1','min' => '-150', 'max' => '150','placeholder' =>'Bsp.: 80'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('block_fy','Block FY',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('block_fy','', ['class' => 'form-control','step' => '1','min' => '-150', 'max' => '150','placeholder' =>'Bsp.: -120'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('rand','Rand',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('rand','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '50','placeholder' =>'Bsp.: 10'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('block_rand','Block Rand',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::number('block_rand','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '50','placeholder' =>'Bsp.: 10'])}}
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('kommentar','Kommentar',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::textarea('kommentar','', ['class' => 'form-control','rows' => 3, 'cols' => 20, 'placeholder' =>'Kommentar'])}}
            </div>
        </div>
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    @endsection
    </div>
</div>