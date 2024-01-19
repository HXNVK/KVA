@extends('layouts.app')

@section('content')
<a href="/motorGetriebe" class="btn btn-success">
    <span class="oi" data-glyph="home" title="Dashboard Motor" aria-hidden="true"></span>
</a>
<h1>Getriebe {{ $getriebe->name }} von Motor {{ $getriebe->motor->name }} dublizieren</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                {!! Form::open(['action' => 'MotorGetriebeController@store', 'method' => 'POST']) !!}
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
                        <label for="motor_id" class="col-sm-3 col-form-label">zu Motor</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_id">
                                <option value="{{ $getriebe->motor_id }}">{{ $getriebe->motor->name }}</option>
                                @foreach($motoren as $motor)
                                <option value="{{ $motor->id }}" {{ old('motor_id') == $motor->id ? 'selected' : '' }}>{{ $motor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="motor_getriebe_art_id" class="col-sm-3 col-form-label">Getriebeart</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="motor_getriebe_art_id">
                                <option value="{{ $getriebe->motor_getriebe_art_id }}">{{ $getriebe->motorGetriebeArt->name }}</option>
                                @foreach($getriebeArten as $getriebeArt)
                                <option value="{{ $getriebeArt->id }}" {{ old('motor_getriebe_art_id') == $getriebeArt->id ? 'selected' : '' }}>{{ $getriebeArt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('untersetzungszahl','Untersetzung [1:]',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('untersetzungszahl',$getriebe->untersetzungszahl, ['class' => 'form-control','step' => '0.01','min' => '1', 'max' => '5', 'placeholder' =>'Bsp.: 2.43'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('bemerkung_getriebe','Bemerkung Getriebe',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('bemerkung_getriebe',$getriebe->bemerkung_getriebe, ['class' => 'form-control','row' => 3, 'cols' => 10, 'placeholder' =>'500 Zeichen für Infos'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('bemerkung_flansch','Bemerkung Flansch',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('bemerkung_flansch',$getriebe->bemerkung_flansch, ['class' => 'form-control','row' => 3, 'cols' => 10, 'placeholder' =>'500 Zeichen für Infos'])}}
                        </div>
                    </div>
                    {{Form::submit('neu abspeichern', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>    
</div>
@endsection