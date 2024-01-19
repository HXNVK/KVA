@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'KundenNeuController@store', 'method' => 'POST']) !!}
    <h1>Export / Import von {{count($kundenAlt)}}x Kunden aus alter KVA in neue KVA</h1>
        {{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
    <div class="row">
        <table class="table table-striped mb-4" cellpadding="0" cellspacing="0">
            
                <tr>
                    <th>Checked AA0</th>
                    <th>Kundengruppe AB0</th>
                    <th>Aktiv AC0</th>
                    <th>Kundennummer AA1</th>
                    <th>Matchcode AA2</th>
                    <th>Firmenname AA4</th>
                    <th>Rating AA3</th>
                    <th>Webseite AA14</th>
                    <th>Aufkleber FF1</th>
                    <th>Notiz ZZ1</th>
                </tr>
            @foreach($kundenAlt as $kundeAlt)
                <tr>
                    <td>{{ $kundeAlt->AA0 }}</td>
                    <td>{{ $kundeAlt->AB0 }}</td>
                    <td>{{ $kundeAlt->AC0 }}</td>
                    <td>{{ $kundeAlt->AA1 }}</td>
                    <td>{{ $kundeAlt->AA2 }}</td>
                    <td>{{ $kundeAlt->AA4 }}</td>
                    <td>{{ $kundeAlt->AA3 }}</td>
                    <td>{{ $kundeAlt->AA14 }}</td>
                    <td>{{ $kundeAlt->FF1 }}</td>
                    <td>{{ $kundeAlt->ZZ1 }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    
    {!! Form::close() !!}   
@endsection


