@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'AuftraegeNeuController@store', 'method' => 'POST']) !!}
    <h1>Export / Import von {{count($auftraegeAlt)}}x Aufträgen aus alter KVA in neue KVA</h1>
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
    <div class="row">
        <table class="table table-striped mb-4" cellpadding="0" cellspacing="0">
            
                <tr>
                    <th>KVA AB</th>
                    <th>Lex AB</th>
                    <th>Kundennummer AA1</th>
                    <th>Matchcode AA2</th>
                    <th>Motor AA4</th>
                    <th>Untersetzung AA5</th>
                    <th>Bohrschema AA6</th>
                    <th>Anzahl AA12</th>
                    <th>Propeller AA7</th>
                    <th>Kantenschutz</th>
                    <th>Bauweise</th>
                    <th>Datum</th>
                </tr>
            @foreach($auftraegeAlt as $auftragAlt)
                <tr>
                    <td>{{ $auftragAlt->AA0 }}</td>
                    <td>{{ $auftragAlt->AB0 }}</td>
                    <td>{{ $auftragAlt->AA1 }}</td>
                    <td>{{ $auftragAlt->AA2 }}</td>
                    <td>{{ $auftragAlt->AA4 }}</td>
                    <td>{{ $auftragAlt->AA5 }}</td>
                    <td>{{ $auftragAlt->AA6 }}</td>
                    <td>{{ $auftragAlt->AA12 }}</td>
                    <td>{{ $auftragAlt->AA7 }}</td>
                    <td>{{ $auftragAlt->AA9 }}</td>
                    <td>{{ $auftragAlt->AA10 }}</td>
                    <td>{{ $auftragAlt->AA17 }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    
    {!! Form::close() !!}   
@endsection


