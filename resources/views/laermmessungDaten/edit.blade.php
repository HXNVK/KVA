@extends('layouts.app')

@section('content')
<a href="/laermmessungen/{{$laermmessungDatei->laermmessung_id}}/edit" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<div class="row">
    <div class="col">
    {!! Form::open(['action' => ['LaermmessungDatenController@update', $laermmessungDatei->id], 'method' => 'POST']) !!}
    <h1>Messdatensatz {{$laermmessungDatei->messdatenNr_id}}  von Lärmmessung "{{$laermmessungDatei->laermmessung->type}} / {{$laermmessungDatei->laermmessung->mtow}}kg" {{Form::submit('ändern', ['class'=>'btn btn-primary'])}}</h1>
    <input type="hidden" value="{{$laermmessungDatei->laermmessung_id}}" name="laermmessungID">
    <input type="hidden" value="{{$laermmessungDatei->messdatenNr_id}}" name="messdatenNr_id">
    <div class="form-group row">
        {{Form::label('messzeit','Uhrzeit der Messung',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
                {{Form::time('messzeit', $laermmessungDatei->messzeit, ['class' => 'form-control'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('windgeschwindigkeit','Windgeschwindigkeit [kt]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('windgeschwindigkeit',$laermmessungDatei->windgeschwindigkeit, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 12'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('windrichtung','Windrichtung [°]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('windrichtung',$laermmessungDatei->windrichtung, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '360', 'placeholder' =>'Bsp.: 170'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('flugbahn','Flugbahn [°]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('flugbahn',$laermmessungDatei->flugbahn, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '360', 'placeholder' =>'Bsp.: 170'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('temperaturBoden','Temp. am Boden [°C]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('temperaturBoden',$laermmessungDatei->temperatur_boden, ['class' => 'form-control','step' => '0.1','min' => '-5', 'max' => '40', 'placeholder' =>'Bsp.: 22'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('relFeuchte','rel. Feuchte [%]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('relFeuchte',$laermmessungDatei->luftfeuchte_rel, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '100', 'placeholder' =>'Bsp.: 45'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('QNH','QNH [hPa]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('QNH',$laermmessungDatei->QNH, ['class' => 'form-control','step' => '0.01','min' => '900', 'max' => '1200', 'placeholder' =>'Bsp.: 1013'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('PropDrehzahl','Propellerdrehzahl [U/min]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('PropDrehzahl',$laermmessungDatei->drehzahl, ['class' => 'form-control','step' => '1','min' => '500', 'max' => '3500', 'placeholder' =>'Bsp.: 2120'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('ladedruck','Ladedruck [inchHG]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('ladedruck',$laermmessungDatei->ladedruck, ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 27.3'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('IAS','IAS [m/s]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('IAS',$laermmessungDatei->IAS, ['class' => 'form-control','step' => '0.1','min' => '15', 'max' => '50', 'placeholder' =>'Bsp.: 30'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('flughoeheGND','Flughöhe über Micro [m]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('flughoeheGND',$laermmessungDatei->hoehe_ueb_micro, ['class' => 'form-control','step' => '0.1','min' => '100', 'max' => '600', 'placeholder' =>'Bsp.: 194.4'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('seitlAbw','seitl. Abweichung [°]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('seitlAbw',$laermmessungDatei->seitl_abweichung, ['class' => 'form-control','step' => '0.1','min' => '-15', 'max' => '15', 'placeholder' =>'Bsp.: 8.5'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('messpegel','Messpegel [db(A)]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('messpegel',$laermmessungDatei->messpegel, ['class' => 'form-control','step' => '0.01','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 67,61'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('messpegelUmgeb','Messpegel Umgebung [db(A)]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::number('messpegelUmgeb',$laermmessungDatei->messpegel_umgeb, ['class' => 'form-control','step' => '0.01','min' => '10', 'max' => '120', 'placeholder' =>'Bsp.: 40,2'])}}
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('checked','Messung gültig?',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if($laermmessungDatei->checked == 1)
                {{Form::radio('checked', '1', true)}} JA <br>
                {{Form::radio('checked', '0', false)}} NEIN
            @else
            {{Form::radio('checked', '1', false)}} JA <br>
            {{Form::radio('checked', '0', true)}} NEIN
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('verwendet','Messung gültig und soll verwendet werden?',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if($laermmessungDatei->verwendet == 1)
                {{Form::radio('verwendet', '1', true)}} JA <br>
                {{Form::radio('verwendet', '0', false)}} NEIN
            @else
            {{Form::radio('verwendet', '1', false)}} JA <br>
            {{Form::radio('verwendet', '0', true)}} NEIN
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::textarea('notiz',$laermmessungDatei->notiz, ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
        </div>
    </div>
    {{Form::hidden('_method','PUT')}}
    {!! Form::close() !!}
    @endsection
    </div>
</div>