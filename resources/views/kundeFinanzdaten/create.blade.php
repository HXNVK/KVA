@extends('layouts.app')

@section('content')
<a href="/kunden/{{$kunde_id}}" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<h1>Finanzdaten anlegen</h1>
<div class="row">
    <div class="col">
    {!! Form::open(['action' => 'KundeFinanzdatenController@store',$kunde_id, 'method' => 'POST']) !!}
        <div class="form-group row">
            {{Form::label('id','Kunden ID',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('id', $kunde_id, ['class' => 'form-control','readonly' => 'true'])}}
            </div>
        </div> 
        <div class="form-group row"> 
            <label for="kunde_finanzdatei_zahlungsart_id" class="col-sm-1 col-form-label">Zahlungsart</label>
            <div class="col-sm-2">
                <select class="form-control" name="kunde_finanzdatei_zahlungsart_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($kundeFinanzdateiZahlungsarten as $kundeFinanzdateiZahlungsart)
                    <option value="{{ $kundeFinanzdateiZahlungsart->id }}" {{ old('kunde_finanzdatei_zahlungsart_id') == $kundeFinanzdateiZahlungsart->id ? 'selected' : '' }}>{{ $kundeFinanzdateiZahlungsart->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="kunde_finanzdatei_zahlungsziel_id" class="col-sm-1 col-form-label">Zahlungsziel</label>
            <div class="col-sm-2">
                <select class="form-control" name="kunde_finanzdatei_zahlungsziel_id">
                    <option value="" disabled>Bitte wählen</option>
                    @foreach($kundeFinanzdateiZahlungsziele as $kundeFinanzdateiZahlungsziel)
                    <option value="{{ $kundeFinanzdateiZahlungsziel->id }}" {{ old('kunde_finanzdatei_zahlungsziel_id') == $kundeFinanzdateiZahlungsziel->id ? 'selected' : '' }}>{{ $kundeFinanzdateiZahlungsziel->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            {{Form::label('steuernummer','Steuernummer',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::text('steuernummer','', ['class' => 'form-control','placeholder' =>'Bsp.: DE 999999999 (9 Ziffern)'])}}
            </div>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#steuernummer">
                <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
            </button>
            @if ($errors->has('steuernummer'))
                <span class="text-danger">{{ $errors->first('steuernummer') }}</span>
            @endif
        </div>
        <div class="form-group row">
            {{Form::label('notiz','Notiz',['class' => 'col-sm-1 col-form-label'])}}
            <div class="col-sm-2">
                {{Form::textarea('notiz','', ['class' => 'form-control','placeholder' =>'100 Zeichen für Infos'])}}
            </div>
        </div>
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    </div>
</div>
@endsection

@include('kundeFinanzdaten.modal')
