@extends('layouts.app')

@section('content')
    <h1>Neues Propellerprofil für StepCode</h1>
    <a href="/propellerStepCodeProfile" class="btn btn-success">
        <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
    </a>
    <br><br>
    <div class="form-group">
        {!! Form::open(['action' => 'PropellerStepCodeProfileController@store', 'method' => 'POST']) !!}

            <div class="row">
                {{Form::label('name','Name',['class' => 'col-sm-1 col-form-label' ])}}
                <div class="col-sm-3">
                    {{Form::text('name','', ['class' => 'form-control', 'placeholder' => 'Bsp.: RKS1'])}}
                </div>
            </div>

            <div class="row">
                {{Form::label('profilpunkte','Profilpunkte',['class' => 'col-sm-1 col-form-label'])}}
                <div class="col-sm-3">
                    {{Form::textarea('profilpunkte','', ['class' => 'form-control'])}}
                </div>
            </div>

            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>



   
@endsection