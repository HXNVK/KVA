@extends('layouts.app')

@section('content')
<a href="/materialHersteller" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Neuer Hersteller</h1>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => 'MaterialHerstellerController@store', 'method' => 'POST']) !!}
            <div class="form-group row">
                {{Form::label('name','Name',['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    {{Form::text('name','', ['class' => 'form-control', 'placeholder' =>'Herstellername...'])}}
                </div>
            </div>
            <div class="form-group row">
                {{Form::label('kommentar','Kommentar',['class' => 'control-label col-sm-1'])}}
                <div class="col-sm-2">
                    {{Form::textarea('kommentar','', ['class' => 'form-control','rows' => 4, 'cols' => 20, 'placeholder' =>'100 Zeichen für Infos'])}}
                </div>
            </div>
            {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
        @endsection
    </div>
</div>
