@extends('layouts.app')

@section('content')
<a href="/motorGetriebe" class="btn btn-success">
    <span class="oi" data-glyph="home" title="Dashboard Motor" aria-hidden="true"></span>
</a>
<h1>Getriebe {{ $getriebe->name }} für Motor {{ $getriebe->motor->name }} bearbeiten</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                {!! Form::open(['action' => ['MotorGetriebeController@update', $getriebe->id], 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{Form::label('name','Name',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8 text-muted">
                            {{Form::text('name',$getriebe->name, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('name_zusatz','Name Zusatz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8 text-muted">
                            {{Form::text('name_zusatz',$getriebe->name_zusatz, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('motorname','zu Motor',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::hidden('motor_id',$getriebe->motor->id)}}
                            {{Form::text('motorname',$getriebe->motor->name, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('getriebe_art','Art',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8 text-muted">
                            {{Form::hidden('getriebe_art_id',$getriebe->motorGetriebeArt->id)}}
                            {{Form::text('getriebe_art',$getriebe->motorGetriebeArt->name, ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('untersetzungszahl','Untersetzung [1:]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('untersetzungszahl',$getriebe->untersetzungszahl, ['class' => 'form-control','step' => '0.001','min' => '1', 'max' => '5', 'placeholder' =>'Bsp.: 2.43'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('bemerkung_getriebe','Bemerkung Getriebe',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('bemerkung_getriebe',$getriebe->bemerkung_getriebe, ['class' => 'form-control','rows' => 3, 'cols' => 10, 'placeholder' =>'500 Zeichen für Infos'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('bemerkung_flansch','Bemerkung Flansch',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('bemerkung_flansch',$getriebe->bemerkung_flansch, ['class' => 'form-control','rows' => 3, 'cols' => 10, 'placeholder' =>'500 Zeichen für Infos'])}}
                        </div>
                    </div>
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit('ändern', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>    
</div>
@endsection