@extends('layouts.app')

@section('content')
    <h1>Q13 Nullpunkte</h1>
    <a href="/q13Nullpunkte/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
    </a>
    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Bezeichnung</th>
                    <th scope="col">x-Richtung</th>
                    <th scope="col">y-Richtung</th>
                    <th scope="col">z-Richtung</th>
                </tr>
            </thead>
            <tbody>
                @if(count($q13Nullpunkte) > 0)
                    @foreach($q13Nullpunkte as $q13Nullpunkt)
                    <tr>

                    </tr>
                    @endforeach
                @else
                    <p>Keine Daten vorhanden!!!</p>
                @endif
            </tbody>
            {{ $q13Nullpunkte->appends(request()->query())->links() }}
        </table>
    </div>
@endsection
