@extends('layouts.app')

@section('content')
    <h1>Airfoil-Data into .BAS-Datei Wandler</h1>
    @foreach($airfoilData as $row)
        <h4>{{ $row->name}}</h4>
        @break
    @endforeach

    @foreach($airfoilData as $row)

        point.x = HPX<br>
        point.y = {{ $row->x }}<br>
        point.z = {{ $row->y }}<br>
        MbeSendDataPoint point<br>

    @endforeach

@endsection


