@extends('layouts.app')

@section('content')
<a href="/propellerFormen" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Form {{ $propellerForm->name }}duplizieren</h1>

{!! Form::open(['action' => 'PropellerFormenController@store', 'method' => 'POST']) !!}
    <div class="form-group row">
        <label for="propeller_modell_wurzel_id" class="col-sm-1 col-form-label">Wurzelmodell</label>
        <div class="col-sm-2">
            <select class="form-control" name="propeller_modell_wurzel_id">
                <option value="{{ $propellerForm->propellerModellWurzel->id }}">{{ $propellerForm->propellerModellWurzel->name }}</option>
                @foreach($propellerModellWurzeln as $propellerModellWurzel)
                <option value="{{ $propellerModellWurzel->id }}">{{ $propellerModellWurzel->name }}</option>
                @endforeach
            </select>    
        </div>
    </div>
    <div class="form-group row">
        <label for="propeller_modell_blatt_id" class="col-sm-1 col-form-label">Blatt-Alu-Modell</label>
        <div class="col-sm-3">
            <select class="form-control" name="propeller_modell_blatt_id">
                <option value="{{ $propellerForm->propellerModellBlatt->id }}">{{ $propellerForm->propellerModellBlatt->name }} mit Blatt-Basis-Winkel: {{ $propellerForm->propellerModellBlatt->winkel }}°</option>
                @foreach($propellerModellBlaetter as $propellerModellBlatt)
                <option value="{{ $propellerModellBlatt->id }}">{{ $propellerModellBlatt->name }} mit Blatt-Basis-Winkel: {{ $propellerModellBlatt->winkel }}°</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('anzahl','Formenanzahl',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-2">
            {{Form::number('anzahl',$propellerForm->anzahl, ['class' => 'form-control','step' => '1', 'min' => '1','placeholder' =>'Bsp.: 2'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('winkel','Abweichender Winkel',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-2">
            {{Form::number('winkel','', ['class' => 'form-control','step' => '0.5', 'placeholder' =>'Bsp.: 8'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('kommentar','Kommentar',['class' => 'col-sm-1 col-form-label'])}}
        <div class="col-sm-2">
            {{Form::textarea('kommentar',$propellerForm->kommentar, ['class' => 'form-control','placeholder' =>'100 Zeichen für Infos'])}}
        </div>
    </div>
    {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
@endsection