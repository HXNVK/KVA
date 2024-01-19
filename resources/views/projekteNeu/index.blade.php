@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'ProjekteNeuController@store', 'method' => 'POST']) !!}
    <h1>Export / Import von {{count($projekteAlt)}}x Projekten aus alter KVA in neue KVA</h1>
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
    <div class="row">
        <table class="table table-striped mb-4" cellpadding="0" cellspacing="0">
            @foreach($projekteAlt as $projektAlt)
                @if($projektAlt->AA0 == 'PPG'
                    || $projektAlt->AA0 == 'SPEZIAL'
                    || $projektAlt->AA0 == 'UL-Trike'
                    || $projektAlt->AA0 == 'PPG-Trike')
                    <tr>
                        <th>Kundennummer</th>
                        <th>Projektklasse</th>
                        <th>Speicherdatum</th>
                        <th>Auftragsauslöser</th>
                        <th>Motorname</th>
                        <th>Untersetzung</th>
                        <th>Prop1</th>
                        <th>Prop1 Drehzahl</th>
                        <th>Prop1 Bem.</th>
                        <th>Prop1 Farbe</th>
                        <th>Prop2</th>
                        <th>Prop2 Drehzahl</th>
                        <th>Prop2 Bem.</th>
                        <th>Prop2 Farbe</th>
                        <th>Prop3</th>
                        <th>Prop3 Drehzahl</th>
                        <th>Prop3 Bem.</th>
                        <th>Prop3 Farbe</th>
                    </tr>
                    <tr>
                        <td>{{ $projektAlt->AA1 }}</td>
                        <td>{{ $projektAlt->AA0 }}</td>
                        <td>{{ $projektAlt->AC0 }}</td>
                        <td>{{ $projektAlt->AA4 }}</td>
                        <td>{{ $projektAlt->BB1 }}</td>
                        <td>{{ $projektAlt->CC9 }}</td>
                        <td>{{ $projektAlt->EE1 }}</td>
                        <td>{{ $projektAlt->EE2 }}</td>
                        <td>{{ $projektAlt->EE7 }}</td>
                        <td>{{ $projektAlt->EE8 }}</td>
                        <td>{{ $projektAlt->FF1 }}</td>
                        <td>{{ $projektAlt->FF2 }}</td>
                        <td>{{ $projektAlt->FF7 }}</td>
                        <td>{{ $projektAlt->FF8 }}</td>
                        <td>{{ $projektAlt->GG1 }}</td>
                        <td>{{ $projektAlt->GG2 }}</td>
                        <td>{{ $projektAlt->GG7 }}</td>
                        <td>{{ $projektAlt->GG8 }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    
    {!! Form::close() !!}   
@endsection


