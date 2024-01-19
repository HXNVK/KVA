@extends('layouts.app')

@section('content')
    <a href="/kunden" class="btn btn-success">
        <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"> Übersicht</span>
    </a>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Dashboard Kunde {{ $kunde->matchcode }} [{{ $kunde->name1 }}]</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-2">
            <!-- start card Stammdaten -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <h5 class="card-title mb-4">Stammdaten</h5>
                        </div>
                        <div class="col-sm-2">
                            <a href="/kunden/{{$kunde->id}}/edit" class="btn btn-warning btn-sm">
                                <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('id','ID',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->id}}
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('lexId','MyFactory ID',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->lexware_id}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('matchcode','Matchcode',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->matchcode}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('name1','Firmenname / Nachname',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->name1}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('name2','Zusatz / Vorname',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->name2}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('kunden_typ','Typ',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->kundeTyp->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('kunden_gruppe','Gruppe',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->kundeGruppe->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('kunden_rating','Rating',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->kundeRating->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('kunden_status','Status',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->kundeStatus->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('webseite','Webseite',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->webseite}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('kunden_aufkleber','Aufkleber',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{$kunde->kundeAufkleber->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{Form::label('kunden_notiz','Notiz',['col-form-label'])}}
                        </div>
                        <div class="col-sm-8 text-muted">
                            {{Str::limit($kunde->notiz,20,'...siehe Bearbeiten')}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- start card Adressdaten -->
            <button id = "adressdaten" type="button" class="btn btn-primary mb-2"><span class="oi" data-glyph="eye"></span> Adressdaten</button>
            <div class="card mb-3 adressdaten"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <h5 class="card-title mb-4">Adressdaten</h5>
                        </div>
                        <div class="col-sm-2">
                            <a href="/kundeAdressen/create/?kundenId={{$kunde->id}}" class="btn btn-success">
                                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                    @if(count($kundeAdressen) > 0)
                        @foreach($kundeAdressen as $kundeAdresse)
                            <div class="row">
                                <div class="col-sm-5">
                                    {{Form::label('typ',$kundeAdresse->kundeAdresseTyp->name,['col-form-label'])}}
                                </div>
                                <div class="col-sm-6 text-muted">
                                    @if($kundeAdresse->name1 == NULL || $kundeAdresse->name2 == NULL)
                                        {{$kundeAdresse->kunde->name2}} {{ $kundeAdresse->kunde->name1}}
                                    @else
                                        {{$kundeAdresse->name1}} {{$kundeAdresse->name2}}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <a href="/kundeAdressen/{{$kundeAdresse->id}}/edit" class="btn btn-warning btn-sm">
                                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                                    </a>
                                    {!! Form::open(['action' => ['KundeAdressenController@destroy', $kundeAdresse->id], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen der Kundenadresse .&quot;)"])}}
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-sm-6 text-muted">
                                    {{$kundeAdresse->strasse}} , {{$kundeAdresse->postleitzahl}} , {{$kundeAdresse->stadt}} , {{$kundeAdresse->kundeAdresseLand->name}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">

                                </div>
                                <div class="col-sm-6 text-muted">
                                    Info: {{$kundeAdresse->notiz}}
                                </div>
                            </div>
                        @endforeach      
                    @else
                    <p class="text-muted mb-0">Kein Adresseintrag vorhanden.</p>
                    @endif              
                </div>
            </div>
            <!-- start card Kontaktdaten -->
            <button id = "kontaktdaten" type="button" class="btn btn-primary mb-2"><span class="oi" data-glyph="eye"></span> Kontaktdaten</button>
            <div class="card mb-3 kontaktdaten"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <h5 class="card-title mb-4">Kontaktdaten</h5>
                        </div>
                        <div class="col-sm-2">
                            <a href="/kundeKontaktpersonen/create/?kundenId={{$kunde->id}}" class="btn btn-success">
                                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                    @if(count($kundeKontaktpersonen) > 0)
                        @foreach($kundeKontaktpersonen as $kundeKontaktperson)
                            <div class="row">
                                <div class="col-sm-3">
                                    @if($kundeKontaktperson->kunde_kontaktperson_position_id != 99)
                                        {{Form::label('Typ',$kundeKontaktperson->kundeKontaktpersonPosition->name,['col-form-label'])}}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 text-muted">
                                    {{$kundeKontaktperson->vorname}} {{$kundeKontaktperson->nachname}}
                                </div>
                                <div class="col-sm-1 mb-2">
                                    <a href="/kundeKontaktpersonen/{{$kundeKontaktperson->id}}/edit" class="btn btn-warning btn-sm">
                                        <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                                    </a></td>
                                </div>
                                <div class="col-sm-1">
                                    {!! Form::open(['action' => ['KundeKontaktpersonenController@destroy', $kundeKontaktperson->id], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen der Kontaktperson .&quot;)"])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-muted">
                                    @if(!empty($kundeKontaktperson->buero))Büro: {{$kundeKontaktperson->buero}}@endif
                                    @if(!empty($kundeKontaktperson->mobile))Mobile: {{$kundeKontaktperson->mobile}}@endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-muted">
                                    @if(!empty($kundeKontaktperson->email))Email: {{$kundeKontaktperson->email}}@endif
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 text-muted">
                                    @if(!empty($kundeKontaktperson->notiz))Notiz: {{Str::limit($kundeKontaktperson->notiz,15,'...')}}@endif
                                </div>
                            </div>
                        @endforeach      
                    @else
                    <p class="text-muted mb-0">Keine Kontaktperson eingetragen.</p>
                    @endif              
                </div>
            </div>
            <!-- start card Finanzdaten -->
            <button id = "finanzdaten" type="button" class="btn btn-primary mb-2"><span class="oi" data-glyph="eye"></span> Finanzdaten</button>
            <div class="card mb-3 finanzdaten">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <h5 class="card-title mb-4">Finanzdaten</h5>
                        </div>
                        @if(count($kundeFinanzdaten) == 0)
                        <div class="col-sm-2">
                            <a href="/kundeFinanzdaten/create/?kundenId={{$kunde->id}}" class="btn btn-success">
                                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                            </a></td>
                        </div>
                        @endif  
                    </div>
                    @if(count($kundeFinanzdaten) > 0)
                        @foreach($kundeFinanzdaten as $kundeFinanzdatei)

                                <div class="row">
                                    <div class="col-sm-4">
                                        {{Form::label('zahlungsart','Zahlungsart',['col-form-label'])}}
                                    </div>
                                    <div class="col-sm-6 text-muted">
                                        {{$kundeFinanzdatei->kundeFinanzdateiZahlungsart->name}}
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="/kundeFinanzdaten/{{$kundeFinanzdatei->id}}/edit" class="btn btn-warning btn-sm">
                                            <span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span>
                                        </a></td>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{Form::label('zahlungsziel','Zahlungsziel',['col-form-label'])}}
                                    </div>
                                    <div class="col-sm-6 text-muted">
                                        {{$kundeFinanzdatei->kundeFinanzdateiZahlungsziel->name}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        {{Form::label('steuernummer','USt-IdNr.',['col-form-label'])}}
                                    </div>
                                    <div class="col-sm-6 text-muted">
                                        {{$kundeFinanzdatei->steuernummer}}
                                    </div>
                                </div>
                        @endforeach         
                    @else
                    <p class="text-muted mb-0">Kein Eintrag vorhanden.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- start card Projekte -->
            {{-- <div class="overflow-auto col-lg-12" style="width: 500px; max-height: 600px;"> --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h5 class="card-title mb-4">Projekte</h5>
                            </div>
                            <div class="col-sm-5">
                                <a href="/projekte/create/?kundenId={{$kunde->id}}" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($projekte) > 0)
                            @foreach($projekte as $projekt)
                                @if($projekt->projektGeraeteklasse->name == '3-ACHS' 
                                    || $projekt->projektGeraeteklasse->name == 'GYRO'
                                    || $projekt->projektGeraeteklasse->name == 'UL-Trike'
                                    || $projekt->projektGeraeteklasse->name == 'MC'
                                    || $projekt->projektGeraeteklasse->name == 'VTOL'
                                    || $projekt->projektGeraeteklasse->name == 'UAV')
                                    <div class="col-sm-10">
                                        @if($projekt->motor_id != NULL)
                                            @if($projekt->fluggeraet_id != NULL)
                                                @if($projekt->beschreibung != NULL)
                                                    <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                    <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->fluggeraet->name }} / {{ $projekt->motor->name }} / {{ $projekt->beschreibung }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                    </a>
                                                @else
                                                    <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                    <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->fluggeraet->name }} / {{ $projekt->motor->name }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                    </a>
                                                @endif
                                            @else
                                                @if($projekt->beschreibung != NULL)
                                                    <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                    <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->motor->name }} / {{ $projekt->beschreibung }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                    </a>
                                                @else
                                                    <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                    <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->motor->name }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            @if($projekt->fluggeraet_id != NULL)
                                                <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->fluggeraet->name }} / {{ $projekt->name }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                </a>
                                            @else
                                                <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->name }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                </a>
                                            @endif   
                                        @endif
                                    </div>
                                    <div class="col-sm-1">
                                        {!! Form::open(['action' => ['ProjekteController@destroy', $projekt->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method','DELETE')}}
                                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Projektes $projekt->name .&quot;)"])}}
                                        {!! Form::close() !!}
                                    </div>
                                @else
                                    <div class="col-sm-10">
                                        @if($projekt->motor_id != NULL)
                                            @if($projekt->beschreibung != NULL)
                                                <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->motor->name }} / {{ $projekt->beschreibung }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                </a>
                                            @else
                                                <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->motor->name }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                </a>
                                            @endif
                                        @else
                                            @if($projekt->beschreibung != NULL)
                                                <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->name }} / {{ $projekt->beschreibung }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                </a>
                                            @else
                                                <a href="/projekte/{{$projekt->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                                <span class="oi" data-glyph="eye" title="zum Projekt" aria-hidden="true"> {{ $projekt->name }} ({{$projekt->projektGeraeteklasse->name}})</span>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-sm-1">
                                        {!! Form::open(['action' => ['ProjekteController@destroy', $projekt->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method','DELETE')}}
                                            {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Projektes $projekt->name .&quot;)"])}}
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                            @endforeach
                            @else
                                <p>Keine Projekte angelegt.</p>
                            @endif
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            @if($kunde->kundeGruppe->name == 'Hersteller')
                <!-- start card Fluggeraete -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <h5 class="card-title mb-4">Fluggeräte</h5>
                            </div>
                            <div class="col-sm-5">
                                <a href="/fluggeraete/create/?kundenId={{$kunde->id}}" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($fluggeraete) > 0)
                            @foreach($fluggeraete as $fluggeraet)
                                <div class="col-sm-10">
                                    <a href="/fluggeraete/{{$fluggeraet->id}}/edit" class="btn btn-primary mb-2">
                                    <span class="oi" data-glyph="eye" title="zum Fluggerät" aria-hidden="true"> {{ $fluggeraet->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                            @else
                                <p>Keine Fluggeräte angelegt.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- start card Motoren -->
        @if($kunde->kundeGruppe->name == 'Motorhersteller' ||
            $kunde->kundeGruppe->name == 'Motormodifizierer' ||
            $kunde->kundeGruppe->name == 'Hersteller')
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 class="card-title mb-4">Motoren</h5>
                            </div>
                            <div class="col-sm-6">
                                <a href="/motoren/create/?kundenId={{$kunde->id}}" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($motoren) > 0)
                            @foreach($motoren as $motor)
                                <div class="col-sm-6">
                                    <a href="/motoren/{{$motor->id}}/edit" class="btn btn-primary btn-sm mb-2">
                                        <span class="oi" data-glyph="eye" title="zum Motor" aria-hidden="true"> {{ $motor->name }}</span>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::open(['action' => ['MotorenController@destroy', $motor->id], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-sm btn-danger', 'onclick' => "return confirm(&quot;Click Ok zum löschen des Motors ".$motor->name." .&quot;)"])}}
                                    {!! Form::close() !!}
                                </div>
                            @endforeach
                            @else
                                <p>Keine Motoren angelegt.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- start card Aufträge -->
        <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h5 class="card-title mb-4">Aufträge</h5>
                            </div>
                            <div class="col-sm-4">
                                <a href="/auftraege/create/?kundenId={{$kunde->id}}" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span> aus Liste
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <a href="/fb009/{{$kunde->id}}" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="FB009" aria-hidden="true"></span> FB009
                                </a>
                            </div>
                            {{-- <div class="col-sm-3">
                                <a href="/fb094/{{$kunde->id}}" class="btn btn-success">
                                    <span class="oi" data-glyph="plus" title="FB094" aria-hidden="true"></span> FB094
                                </a>
                            </div> --}}
                        </div>
                        <div class="row">
                            @if(count($auftraege) > 0)
                                @foreach($auftraege as $auftrag)
                                    {{-- @if($auftrag->auftrag_status_id != 13) --}}
                                        <div class="col-sm-11">
                                            @switch($auftrag->auftrag_status_id)
                                                @case(1)
                                                    @if($auftrag->auftrag_typ_id == 1)
                                                        <a href="/auftraege/{{$auftrag->id}}" class="btn btn-primary btn-sm mb-2">
                                                            <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                        </a>
                                                        @break
                                                    @else
                                                        <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-primary btn-sm mb-2">
                                                            <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                        </a>
                                                        @break     
                                                    @endif
                                                @case(2)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-dark btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(3)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-purple btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(4)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-warning btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(8)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-success btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(9)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-secondary btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(10)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-danger btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(11)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-purple btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(13)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-light btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(14)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-success btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(15)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(16)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                                        <span class="oi" data-glyph="pie-chart" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(17)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-secondary btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(18)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-info btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(19)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-primary btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(20)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-light active btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(21)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-warning active btn-sm mb-2">
                                                        <span class="oi" data-glyph="external-link" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(22)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-check active btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                                @case(30)
                                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-hold active btn-sm mb-2">
                                                        <span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} </span>
                                                    </a>
                                                    @break
                                            @endswitch
                    
                                            @if($auftrag->auftrag_typ_id == 1)
                                                @if($auftrag->ausfuehrung == 'A25-0' 
                                                    || $auftrag->ausfuehrung == 'A20-0'
                                                    || $auftrag->ausfuehrung == 'A30-0'
                                                    || $auftrag->ausfuehrung == 'A40-0'
                                                    || $auftrag->ausfuehrung == 'A45-0'
                                                    || $auftrag->ausfuehrung == 'A50-0'
                                                    || $auftrag->ausfuehrung == 'A45-0'
                                                    || $auftrag->ausfuehrung == 'A50-0'
                                                    || $auftrag->ausfuehrung == 'A60-0'
                                                    || $auftrag->ausfuehrung == 'A100-0')
                                                    @if($auftrag->form1 != 'Form1')
                                                        @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' || $auftrag->farbe == 'FD' )
                                                            <?php $propeller = "$auftrag->propeller / $auftrag->farbe"?>
                                                        @else
                                                            @if($auftrag->ets != NULL)
                                                                <?php $propeller = "$auftrag->propeller (ETS:$auftrag->ets)"?>
                                                            @else
                                                                <?php $propeller = "$auftrag->propeller"?>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' || $auftrag->farbe == 'FD'  )
                                                            <?php $propeller = "$auftrag->propeller / $auftrag->farbe / $auftrag->form1"?>
                                                        @else
                                                        <?php $propeller = "$auftrag->propeller / $auftrag->form1"?>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if($auftrag->form1 != 'Form1')
                                                        @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' || $auftrag->farbe == 'FD'  )
                                                            <?php $propeller = "$auftrag->propeller / $auftrag->farbe / $auftrag->ausfuehrung" ?>
                                                        @else
                                                            @if($auftrag->ets != NULL)
                                                                <?php $propeller = "$auftrag->propeller / $auftrag->ausfuehrung (ETS:$auftrag->ets)" ?>
                                                            @else
                                                                <?php $propeller = "$auftrag->propeller / $auftrag->ausfuehrung" ?>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if($auftrag->farbe == 'SW' || $auftrag->farbe == 'WTD' || $auftrag->farbe == 'FD' )
                                                            <?php $propeller = "$auftrag->propeller / $auftrag->farbe / $auftrag->ausfuehrung / $auftrag->form1" ?>
                                                        @else
                                                            <?php $propeller = "$auftrag->propeller / $auftrag->ausfuehrung / $auftrag->form1" ?>
                                                        @endif
                                                    @endif
                                                @endif
                                            
                                                @if($auftrag->distanzscheibe != NULL ||
                                                    $auftrag->asgp != NULL ||
                                                    $auftrag->spgp != NULL ||
                                                    $auftrag->spkp != NULL ||
                                                    $auftrag->ap != NULL ||
                                                    $auftrag->buchsen != NULL ||
                                                    $auftrag->schrauben != NULL
                                                    )
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->created_at)) }}: {{ $auftrag->anzahl }}x {{ $propeller }} + Zubehör ({{$auftrag->user->kuerzel}})</small>
                                                    {{-- @if($auftrag->updated_at > $auftrag->created_at)
                                                        <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->updated_at)) }}: {{ $auftrag->anzahl }}x {{ $propeller }} + Zubehör ({{$auftrag->user->kuerzel}})</small>
                                                    @else
                                                        <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->created_at)) }}: {{ $auftrag->anzahl }}x {{ $propeller }} + Zubehör ({{$auftrag->user->kuerzel}})</small>
                                                    @endif --}}
                                                @else
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->created_at)) }}: {{ $auftrag->anzahl }}x {{ $propeller }} ({{$auftrag->user->kuerzel}})</small>
                                                    {{-- @if($auftrag->updated_at > $auftrag->created_at)
                                                        <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->updated_at)) }}: {{ $auftrag->anzahl }}x {{ $propeller }} ({{$auftrag->user->kuerzel}})</small>
                                                    @else
                                                        <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->created_at)) }}: {{ $auftrag->anzahl }}x {{ $propeller }} ({{$auftrag->user->kuerzel}})</small>
                                                    @endif --}}
                                                @endif
                                            @endif
                                            
                                            @if($auftrag->auftrag_typ_id == 2 || $auftrag->auftrag_typ_id == 3 || $auftrag->auftrag_typ_id == 4)
                                                @if($auftrag->updated_at > $auftrag->created_at)
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->updated_at)) }}: {{ $auftrag->anzahl }}x {{ $auftrag->auftragTyp->name }}: {{Str::limit($auftrag->propeller,25,'...')}} ({{$auftrag->user->kuerzel}})</small>
                                                @else
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->created_at)) }}: {{ $auftrag->anzahl }}x {{ $auftrag->auftragTyp->name }}: {{Str::limit($auftrag->propeller,25,'...')}} ({{$auftrag->user->kuerzel}})</small>
                                                @endif
                                            @endif

                                            @if($auftrag->auftrag_typ_id == 5  || $auftrag->auftrag_typ_id == 6)
                                                @if($auftrag->updated_at > $auftrag->created_at)
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->updated_at)) }}: {{ $auftrag->anzahl }}x {{ $auftrag->auftragTyp->name }} ({{$auftrag->user->kuerzel}})</small>
                                                @else
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->created_at)) }}: {{ $auftrag->anzahl }}x {{ $auftrag->auftragTyp->name }} ({{$auftrag->user->kuerzel}})</small>
                                                @endif
                                            @endif

                                            @if($auftrag->auftrag_typ_id == 7)
                                                <?php $propeller = $auftrag->auftragTyp->name ?>
                                                @if($auftrag->updated_at > $auftrag->created_at)
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->updated_at)) }}: {{ $auftrag->anzahl }}x {{ $auftrag->propeller }} ({{$auftrag->user->kuerzel}})</small>
                                                @else
                                                    <small>{{ $auftrag->lexwareAB }} // {{ date('Y-m-d', strtotime($auftrag->created_at)) }}: {{ $auftrag->anzahl }}x {{ $auftrag->propeller }} ({{$auftrag->user->kuerzel}})</small>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="/auftragPDF/{{$auftrag->id}}" class="btn btn-warning btn-sm">
                                                <span class="oi" data-glyph="data-transfer-download" title="download" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    {{-- @endif --}}
                                @endforeach
                            @else
                                <p>Keine Aufträge angelegt.</p>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
        <!-- start card Warenkorb -->
        <div class="col-lg-2">
            @if(count(\Cart::getContent()) > 0)
                @foreach(\Cart::getContent() as $item)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-9">
                                <b>{{$item->name}}</b>
                                <br><small>Anzahl: {{$item->quantity}}</small>
                            </div>
                            {{-- <div class="col-lg-2">
                                <p>€{{ \Cart::get($item->id)->getPriceSum() }}</p>
                            </div> --}}
                            <hr>
                        </div>
                    </li>
                @endforeach
                <br>
                <li class="list-group-item">
                    <div class="row">
                        {{-- <div class="col-lg-10">
                            <b>Gesamt: </b>€{{ \Cart::getTotal() }} excl. MwSt
                        </div> --}}
                        <div class="col-lg-2">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                {{ csrf_field() }}
                                <button class="btn btn-danger btn-sm"><span class="oi" data-glyph="trash" title="alles löschen" aria-hidden="true"></span></button>
                            </form>
                        </div>
                    </div>
                </li>
                <br>
                <div class="row" style="margin: 0px;">
                    <a class="btn btn-primary btn-sm btn-block" href="{{ route('cart.index') }}">
                        Artikelkorb <span class="oi" data-glyph="arrow-right" title="zum Artikelkorb" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-success btn-sm btn-block" href="">
                        Auftrag speichern <span class="oi" data-glyph="arrow-right" title="zum Checkout" aria-hidden="true"></span>
                    </a>
                </div>
            @endif
        </div>
    </div>

<script>
    $(document).ready(function() {
        $("#adressdaten").ready(function(){
            $(".adressdaten").toggle();
        });
        $("#adressdaten").click(function(){
            $(".adressdaten").toggle();
        });

        $("#kontaktdaten").ready(function(){
            $(".kontaktdaten").toggle();
        });
        $("#kontaktdaten").click(function(){
          $(".kontaktdaten").toggle();
        });

        $("#finanzdaten").ready(function(){
            $(".finanzdaten").toggle( );
        });
        $("#finanzdaten").click(function(){
            $(".finanzdaten").toggle( );
        });
    });
</script>

@endsection

