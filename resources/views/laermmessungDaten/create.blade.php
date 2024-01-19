@extends('layouts.app')

@section('content')
<a href="/laermmessungen/{{$laermmessung->id}}/edit" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<div class="row">
    <div class="col">
        {!! Form::open(['action' => 'LaermmessungDatenController@store', 'method' => 'POST']) !!}
    <h1>Neue Messdaten für Lärmmessung "{{$laermmessung->fluggeraet}} / {{$laermmessung->mtow}}kg" {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}</h1>
    <input type="hidden" value="{{$laermmessung->id}}" name="laermmessungID">
    <div class="form-group row">
        {{Form::label('messzeit','Uhrzeit der Messung',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::time('messzeit', $laermessungDatei->messzeit, ['class' => 'form-control'])}}
                    @break;
                @endforeach
            @else
                    {{Form::time('messzeit', '', ['class' => 'form-control'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('windrichtung','Windrichtung [°]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('windrichtung',$laermessungDatei->windrichtung, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '360', 'placeholder' =>'Bsp.: 170'])}}
                @break;
                @endforeach
            @else
                {{Form::number('windrichtung','', ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '360', 'placeholder' =>'Bsp.: 170'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('windgeschwindigkeit','Windgeschwindigkeit [kt]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('windgeschwindigkeit',$laermessungDatei->windgeschwindigkeit, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 12'])}} 
                    @break;
                @endforeach
            @else
                {{Form::number('windgeschwindigkeit','', ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '30', 'placeholder' =>'Bsp.: 12'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('flugbahn','Flugbahn [°]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('flugbahn',$laermessungDatei->flugbahn, ['class' => 'form-control','step' => '1','min' => '0', 'max' => '360', 'placeholder' =>'Bsp.: 170'])}}
                @break;
                @endforeach
            @else
                {{Form::number('flugbahn','', ['class' => 'form-control','step' => '1','min' => '0', 'max' => '360', 'placeholder' =>'Bsp.: 170'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('temperaturBoden','Temp. am Boden [°C]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('temperaturBoden',$laermessungDatei->temperatur_boden, ['class' => 'form-control','step' => '0.1','min' => '-5', 'max' => '40', 'placeholder' =>'Bsp.: 22'])}}
                @break;
                @endforeach
            @else
                {{Form::number('temperaturBoden','', ['class' => 'form-control','step' => '0.1','min' => '-5', 'max' => '40', 'placeholder' =>'Bsp.: 22'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('relFeuchte','rel. Feuchte [%]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('relFeuchte',$laermessungDatei->luftfeuchte_rel, ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '100', 'placeholder' =>'Bsp.: 45'])}}
                @break;
                @endforeach
            @else
                {{Form::number('relFeuchte','', ['class' => 'form-control','step' => '0.1','min' => '0', 'max' => '100', 'placeholder' =>'Bsp.: 45'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('QNH','QNH [hPa]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('QNH',$laermessungDatei->QNH, ['class' => 'form-control','step' => '0.01','min' => '900', 'max' => '1200', 'placeholder' =>'Bsp.: 1013'])}}
                @break;
                @endforeach
            @else
                {{Form::number('QNH','', ['class' => 'form-control','step' => '0.01','min' => '900', 'max' => '1200', 'placeholder' =>'Bsp.: 1013'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('PropDrehzahl','Propellerdrehzahl [U/min]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('PropDrehzahl',$laermessungDatei->drehzahl, ['class' => 'form-control','step' => '1','min' => '500', 'max' => '3500', 'placeholder' =>'Bsp.: 2120'])}}
                @break;
                @endforeach
            @else
                {{Form::number('PropDrehzahl','', ['class' => 'form-control','step' => '1','min' => '500', 'max' => '3500', 'placeholder' =>'Bsp.: 2120'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('ladedruck','Ladedruck [inchHG]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('ladedruck',$laermessungDatei->ladedruck, ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 27.3'])}}
                @break;
                @endforeach
            @else
                {{Form::number('ladedruck','', ['class' => 'form-control','step' => '0.1', 'placeholder' =>'Bsp.: 27.3'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('IAS','IAS [m/s]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('IAS',$laermessungDatei->IAS, ['class' => 'form-control','step' => '0.1','min' => '15', 'max' => '50', 'placeholder' =>'Bsp.: 30'])}} 
                @break;
                @endforeach
            @else
                {{Form::number('IAS','', ['class' => 'form-control','step' => '0.1','min' => '15', 'max' => '45', 'placeholder' =>'Bsp.: 30'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('flughoeheGND','Flughöhe über Micro [m]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('flughoeheGND',$laermessungDatei->hoehe_ueb_micro, ['class' => 'form-control','step' => '0.1','min' => '100', 'max' => '600', 'placeholder' =>'Bsp.: 194.4'])}}
                @break;
                @endforeach
            @else
                {{Form::number('flughoeheGND','', ['class' => 'form-control','step' => '0.1','min' => '100', 'max' => '500', 'placeholder' =>'Bsp.: 194.4'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('seitlAbw','seitl. Abweichung [°]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('seitlAbw',$laermessungDatei->seitl_abweichung, ['class' => 'form-control','step' => '0.1','min' => '-15', 'max' => '15', 'placeholder' =>'Bsp.: 8.5'])}}
                @break;
                @endforeach
            @else
                {{Form::number('seitlAbw','', ['class' => 'form-control','step' => '0.1','min' => '-15', 'max' => '15', 'placeholder' =>'Bsp.: 8.5'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('messpegel','Messpegel [db(A)]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('messpegel',$laermessungDatei->messpegel, ['class' => 'form-control','step' => '0.01','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 67,61'])}}
                @break;
                @endforeach
            @else
                {{Form::number('messpegel','', ['class' => 'form-control','step' => '0.01','min' => '50', 'max' => '120', 'placeholder' =>'Bsp.: 67,61'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('messpegelUmgeb','Messpegel Umgebung [db(A)]',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            @if(count($laermmessungDaten) > 0)
                @foreach($laermmessungDaten as $laermessungDatei)
                    {{Form::number('messpegelUmgeb',$laermessungDatei->messpegel_umgeb, ['class' => 'form-control','step' => '0.01','min' => '10', 'max' => '120', 'placeholder' =>'Bsp.: 40,3'])}}
                @break;
                @endforeach
            @else
                {{Form::number('messpegelUmgeb','', ['class' => 'form-control','step' => '0.01','min' => '10', 'max' => '120', 'placeholder' =>'Bsp.: 67,61'])}}
            @endif
        </div>
    </div>
    <div class="form-group row">
        {{Form::label('checked','Messung gültig?',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::radio('checked', '1')}} JA<br>
            {{Form::radio('checked', '0')}} NEIN
        </div>
        @if ($errors->has('checked'))
            <span class="text-danger">{{ $errors->first('checked') }}</span>
        @endif
    </div>
    <div class="form-group row">
        {{Form::label('verwendet','Messung gültig und soll verwendet werden?',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::radio('verwendet', '1')}} JA<br>
            {{Form::radio('verwendet', '0')}} NEIN
        </div>
        @if ($errors->has('verwendet'))
            <span class="text-danger">{{ $errors->first('verwendet') }}</span>
        @endif
    </div>
    <div class="form-group row">
        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
        <div class="col-sm-3">
            {{Form::textarea('notiz','', ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
        </div>
    </div>
    {!! Form::close() !!}
    @endsection
    </div>
</div>