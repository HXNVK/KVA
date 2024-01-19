@extends('layouts.app')

@section('content')
<a href="/propeller" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Artikel Propeller {{ $propeller->name }} bearbeiten</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                {!! Form::open(['action' => ['PropellerController@update', $propeller->id], 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{Form::label('propellername','Propellername',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8 text-muted">
                            {{Form::text('propellername', $propeller->name , ['class' => 'form-control','readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('artikelnummer','Artikelnummer',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('artikelnummer',$propeller->artikelnummer, ['class' => 'form-control', 'readonly' => 'true'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="artikel_01Propeller_id" class="col-sm-3 col-form-label">Propeller Artikel</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="artikel_01Propeller_id" id="artikel_01Propeller_id">
                                <option value="{{ $propeller->artikel01Propeller->id }}">{{ $propeller->artikel01Propeller->name }}</option>
                                @foreach($artikel_01PropellerObj as $artikel_01Propeller)
                                <option value="{{ $artikel_01Propeller->id }}" {{ old('artikel_01Propeller_id') == $artikel_01Propeller->id ? 'selected' : '' }}>{{ $artikel_01Propeller->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="propellerForm_id" class="col-sm-3 col-form-label">PropellerForm</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="propellerForm_id" id="propellerForm_id">
                                <option value="{{ $propeller->propellerForm->id }}">{{ $propeller->propellerForm->name_kurz }}</option>
                                @foreach($propellerFormen as $propellerForm)
                                <option value="{{ $propellerForm->id }}" {{ old('propellerForm_id') == $propellerForm->id ? 'selected' : '' }}>{{ $propellerForm->name_kurz }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz',$propeller->notiz, ['class' => 'form-control','rows' => 3, 'cols' => 10, 'placeholder' =>'500 Zeichen für Infos'])}}
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