@extends('layouts.app')

@section('content')
    <h1>Neues Propellerprofil für StepCode</h1>
    <a href="/propellerStepCodeProfile" class="btn btn-success">
        <span class="oi" data-glyph="arrow-left" title="back" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => ['PropellerStepCodeProfileController@update', $propellerStepCodeProfil->id], 'method' => 'POST']) !!}

            <div class="row">
                {{Form::label('name','Name',['class' => 'col-sm-1 col-form-label' ])}}
                <div class="col-sm-3">
                    {{Form::text('name',$propellerStepCodeProfil->name, ['class' => 'form-control', 'placeholder' => 'Bsp.: RKS1'])}}
                </div>
            </div>
            <div class="row">
                {{Form::label('beschreibung','Beschreibung',['class' => 'col-sm-1 col-form-label' ])}}
                <div class="col-sm-3">
                    {{Form::text('beschreibung',$propellerStepCodeProfil->beschreibung, ['class' => 'form-control', 'placeholder' => 'Bsp.: Blumiges Profil'])}}
                </div>
            </div>

            <div class="row">
                {{Form::label('profilpunkte','Profilpunkte',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-3">
                    {{Form::textarea('profilpunkte',$propellerStepCodeProfil->inputProfil, ['class' => 'form-control'])}}
                </div>
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
   
@endsection