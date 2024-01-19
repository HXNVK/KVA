@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>
    <h1>Lärmmessungen</h1>
    <a href="/laermmessungen/create" class="btn btn-success">
        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span> LVL / Kap.10 / Kap.11 
    </a>
    <br><br>

    <div class="row">
        <table class="table table-striped" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Fluggerät</th>
                    <th scope="col">Kunde</th>
                    <th scope="col">Motor</th>
                    <th scope="col">Kennung</th>
                    <th scope="col">Propeller</th>
                    <th scope="col">MTOW</th>
                    <th scope="col">Messort</th>
                    <th scope="col">Referenzhöhe</th>
                    <th scope="col">Lärmmessgruppe</th>
                    <th scope="col">Notiz</th>
                    <th scope="col">Bericht erstellt u. gesperrt</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($laermmessungen) > 0)
                @foreach($laermmessungen as $laermmessung)
                <tr>
                    <td style=min-width:150px>{{ $laermmessung->fluggeraet }}</td>
                    <td style=min-width:50px>{{ $laermmessung->kunde->matchcode }}</td>
                    <td style=min-width:50px>{{ $laermmessung->motor }}</td>
                    <td style=min-width:50px>{{ $laermmessung->kennung }}</td>
                    <td style=min-width:50px>{{ $laermmessung->typenbezeichnung }}</td>
                    <td style=min-width:50px>{{ $laermmessung->mtow }}</td>
                    <td style=min-width:50px>{{ $laermmessung->messort }}</td>
                    <td style=min-width:50px>{{ round($laermmessung->Href) }}</td>
                    <td style=min-width:50px>{{ $laermmessung->fluggeraetGruppe }}</td>
                    <td style=min-width:50px>{{ Str::limit($laermmessung->notiz,15,'...') }}</td>
                    <td style=min-width:50px>
                        @if($laermmessung->berichtGesperrt == '1') 
                            gesperrt
                        @endif
                    </td>
                    <td style=min-width:50px>
                        @if($laermmessung->updated_at > $laermmessung->created_at) 
                            geändert: {{ $laermmessung->updated_at }} / {{ $laermmessung->user->name }}
                        @else
                            erstellt: {{ $laermmessung->created_at }} / {{ $laermmessung->user->name }}
                        @endif
                    </td>
                    <td style=min-width:50px>
                        <a href="/laermmessungen/{{$laermmessung->id}}/edit" class="btn btn-primary">
                            <span class="oi" data-glyph="eye" title="Lärmmessung bearbeiten + Messflüge eintragen" aria-hidden="true"></span>
                        </a></td>
                    </td>
                    <td style=min-width:50px>
                        <a href="/laermmessungen/{{$laermmessung->id}}" class="btn btn-default">
                            <span class="oi" data-glyph="layers" title="dublizieren" aria-hidden="true">
                        </a>
                    </td>
                    {{-- <td style=min-width:50px>
                        <a href="/kunden/{{$laermmessung->kunde_id}}" class="btn btn-primary">
                            <span class="oi" data-glyph="arrow-thick-right" title="zum Kunde" aria-hidden="true"></span>
                        </a></td>
                    </td> --}}
                </tr>
                @endforeach
            @else
                <p>Keine Daten vorhanden!!!</p>
            @endif
            </tbody>
            {{ $laermmessungen->appends(request()->query())->links() }}
        </table>
    </div>
@endsection


