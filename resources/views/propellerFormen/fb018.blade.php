@extends('layouts.app')

@section('content')
<a href="/propellerFormen" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Formenbauauftrag FB018</h1>
<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            {!! Form::open(['action' => 'PropellerFormenController@fb018speichern', 'method' => 'POST']) !!}
                <div class="form-group row">
                    <label for="kunde_id" class="col-sm-4 col-form-label">Matchcode Kunde</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="kunde_id">
                            <option value="" disabled>Bitte wählen</option>
                            <option value=""></option>
                            @foreach($kunden as $kunde)
                            <option value="{{ $kunde->id }}">{{ $kunde->matchcode }}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>
                <div class="form-group row">
                    <label for="propeller_form_id" class="col-sm-4 col-form-label">Propellerform</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="propeller_form_id">
                            <option value="" disabled>Bitte wählen</option>
                            @foreach($propellerFormen as $propellerForm)
                            <option value="{{ $propellerForm->id }}">{{ $propellerForm->name_kurz }}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>
                <div class="form-group row">
                    <label for="formenhaelfte" class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-4">
                        {{Form::radio('formenhaelfte','oben', false, [])}} nur oben
                    </div>
                    <div class="col-sm-4">
                        {{Form::radio('formenhaelfte','unten', false, [])}} nur unten
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label"></label>
                    <div class="col-sm-4">
                        {{Form::checkbox('formBlattNeu','1', false, [])}} Blatt NEU
                    </div>
                    <div class="col-sm-4">
                        {{Form::checkbox('formWurzelNeu','1', false, [])}} Wurzel NEU
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('anzahl','Formenanzahl',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::number('anzahl','', ['class' => 'form-control','step' => '1', 'min' => '1','placeholder' =>'Bsp.: 2'])}}
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('dringlichkeit','Dringlichkeit',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-4">
                        {{Form::radio('dringlichkeit','dringend', false, [])}} dringend
                    </div>
                    <div class="col-sm-4">
                        {{Form::radio('dringlichkeit','nochHeute', false, [])}} noch heute
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('ETA','ETA',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::date('eta','')}}
                    </div>
                </div>
                <div class="form-group row">
                    {{Form::label('kommentar','Kommentar',['class' => 'col-sm-4 col-form-label'])}}
                    <div class="col-sm-8">
                        {{Form::textarea('kommentar','', ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                    </div>
                </div>
                {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
