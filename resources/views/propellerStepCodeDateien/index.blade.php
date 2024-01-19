@extends('layouts.app')

@section('content')
<a href="/propellerStepCode" class="btn btn-success">
    <span class="oi" data-glyph="home" title="neu" aria-hidden="true"></span>
</a>
<br><br>
    <h1>Stp-Dateien Download</h1>
    <div class="row">
        @if(count($stpDateien) > 0)
            @foreach($stpDateien as $key => $stpDatei)
                __{{$key}}.
                <button><a href="{{route('getfile', $stpDatei)}}" download>{{$stpDatei}}</a></button>
            @endforeach
        @else
            <p>Keine Daten vorhanden!!!</p>
        @endif
    </div>
@endsection

