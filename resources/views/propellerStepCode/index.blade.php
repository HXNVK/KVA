@extends('layouts.app')

@section('content')
    <div class="row">
        @include('internals.messages')
    </div>

    <br><br>
    <div class="row">
        <h1>STEPCODE - GENERATOR</h1>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    {!! Form::open(['action' => 'PropellerStepCodeController@Main_Step_Code', 'method' => 'POST']) !!}
                    <table class="table table-striped" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Beschreibung</th>
                                <th scope="col">Datum / Anwender</th>
                                <th scope="col">Stp-file generieren</th>
                                <th scope="col">Ändern</th>
                                <th scope="col">Dublizieren</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($propellerStepCodes) > 0)
                            @foreach($propellerStepCodes as $propellerStepCode)
                            <tr>
                                <td style=min-width:50px>{{ $propellerStepCode->name }}</td>
                                <td style=min-width:50px>{{ $propellerStepCode->beschreibung }}</td>
                                <td style=min-width:50px>
                                    @if($propellerStepCode->updated_at > $propellerStepCode->created_at) 
                                        geändert: {{ $propellerStepCode->updated_at }} / {{ $propellerStepCode->user->name }}
                                    @else
                                        erstellt: {{ $propellerStepCode->created_at }} / {{ $propellerStepCode->user->name }}
                                    @endif
                                </td>
                                <td>
                                {{Form::submit('StepCode generieren', ['class'=>'btn btn-primary'])}}
                                </td>
                                <td style=min-width:50px>
                                    <a href="/propellerStepCode/{{$propellerStepCode->id}}/edit" class="btn btn-warning">
                                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                                    </a></td>
                                </td>
                                <td style=min-width:50px>
                                    <a href="/propellerStepCode/{{$propellerStepCode->id}}" class="btn btn-default">
                                        <span class="oi" data-glyph="layers" title="dublizieren" aria-hidden="true">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <p>Keine Daten vorhanden!!!</p>
                        @endif
                        </tbody>
                    </table>
                    {{ $propellerStepCodes->appends(request()->query())->links() }}
                    {!! Form::close() !!}
                </div>
                <div class="col-3">
                    <h2>Neu</h2>
                    <a href="/propellerStepCode/create" class="btn btn-success">
                        <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
                <div class="col-3">
                    <h2>Stp.-Datei - Download</h2>
                    <a href="/propellerStepCodeDateien" class="btn btn-success">
                        <span class="oi" data-glyph="data-transfer-download" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    <h1>Eingabemasken:</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-2">

                </div>
                <div class="col-3">
                    <h2>Profildaten</h2>
                </div>
                <div class="col-3">
                    <a href="/propellerStepCodeProfile" class="btn btn-success">
                        <span class="oi" data-glyph="arrow-right" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">

                </div>
                <div class="col-3">
                    <h2>Blattebenen</h2>
                </div>
                <div class="col-3">
                    <a href="/propellerStepCodeBlaetter" class="btn btn-success">
                        <span class="oi" data-glyph="arrow-right" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-2">

                </div>
                <div class="col-3">
                    <h2>Block Blätter</h2>
                </div>
                <div class="col-3">
                    <a href="/propellerStepCodeBlattBloecke" class="btn btn-success">
                        <span class="oi" data-glyph="arrow-right" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-2">

                </div>
                <div class="col-3">
                    <h2>Wurzeln GF "F"</h2>
                </div>
                <div class="col-3">
                    <a href="/propellerStepCodeWurzelnF" class="btn btn-success">
                        <span class="oi" data-glyph="arrow-right" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-2">

                </div>
                <div class="col-3">
                    <h2>Wurzeln GF "AV"</h2>
                </div>
                <div class="col-3">
                    <a href="/propellerStepCodeWurzelnAV" class="btn btn-success">
                        <span class="oi" data-glyph="arrow-right" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-2">

                </div>
                <div class="col-3">
                    <h2>Block Wurzeln</h2>
                </div>
                <div class="col-3">
                    <a href="/propellerStepCodeWurzelBloecke" class="btn btn-success">
                        <span class="oi" data-glyph="arrow-right" title="neu" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

