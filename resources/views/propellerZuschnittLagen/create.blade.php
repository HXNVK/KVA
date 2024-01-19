@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <a href="/propellerZuschnitte/{{$propellerZuschnitt->id}}/edit" class="btn btn-success">
        <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
    </a>
    <div class="form-group">
        {!! Form::open(['action' => ['PropellerZuschnittLagenController@store', $propellerZuschnitt->id], 'method' => 'POST']) !!}
        <h1>Neue Lage zu Zuschnitt </h1>
            {{Form::hidden('propellerZuschnitt_id',$propellerZuschnitt->id)}}

            <div class="row col-6">
                {{Form::label('material','Material:',['class' => 'col-sm-2 col-form-label'])}}
                <div class="col-sm-4">            
                    <select class="form-control" name="material_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($materialien as $material)
                        <option value="{{ $material->MaterialID }}" {{ old('material_id') == $material->MaterialID ? 'selected' : '' }}>{{ $material->MaterialNameLang }}</option>
                        @endforeach
                    </select>
                </div>    
            </div>
            <div class="row col-6">
                {{Form::label('anzahl','Anzahl',['class' => 'col-sm-2 col-form-label'])}}
                <div class="col-sm-4">
                    {{Form::number('anzahl', 1, ['class' => 'form-control','step' => '1','min' => '1', 'max' => '20'])}}
                </div>
            </div>
            <div class="row col-6">
                {{Form::label('schablone','Schablone:',['class' => 'col-sm-2 col-form-label'])}}
                <div class="col-sm-4">            
                    <select class="form-control" name="schablone_id">
                        <option value="" disabled>Bitte wählen</option>
                        @foreach($schablonen as $schablone)
                        <option value="{{ $schablone->id }}" {{ old('schablone_id') == $schablone->id ? 'selected' : '' }}>{{ $schablone->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row col-6">
                {{Form::label('bemerkung','Bemerkung',['class' => 'col-sm-2 col-form-label'])}}
                <div class="col-sm-4">
                    {{Form::textarea('bemerkung','', ['class' => 'form-control', 'rows' => 3, 'placeholder' =>'50 Zeichen für Infos'])}}
                </div>
            </div>
            <div class="row col-6">
                {{Form::label('reihenfolge','Reihenfolge Nr.:',['class' => 'col-sm-2 col-form-label'])}}
                <div class="col-sm-4">
                    {{Form::text('reihenfolge','', ['class' => 'form-control'])}}
                </div>
            </div>
            <div class="row col-6">
                {{Form::label('sortiernummer','Sortier Nr.:',['class' => 'col-sm-2 col-form-label'])}}
                <div class="col-sm-4">
                    {{Form::text('sortiernummer',$naechsteSortiernummer, ['class' => 'form-control'])}}
                </div>
            </div>
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection