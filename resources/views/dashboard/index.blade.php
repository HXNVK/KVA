@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        {{-- <div class="col-xl-4"> <!-- Notizen User--> --}}
        <div class="overflow-auto mb-4 ml-3 mr-4" style="width: 600px; max-height: 250px;">    
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Notizen {{ Auth::user()->name }}</h4>
                    <div class="form-group row">
                        {!! Form::open(['action' => 'DashboardController@store', 'method' => 'POST']) !!}
                            <div class="col-sm-10">
                                {{Form::text('notiz', '', ['class' => 'form-control'])}}
                            </div>
                    </div>
                    <div class="form-group row">
                            <div class="col-3">
                                Teaminfo {{Form::checkbox('teamInfo','1', false, [])}}
                            </div>
                            <div class="col-sm-2">
                                {{Form::submit('neu abspeichern', ['class'=>'btn btn-sm btn-primary'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                    @if(count($notizen) > 0)
                        @foreach($notizen as $notiz)
                            <div class="row">
                                <div class="col-sm-10 text-muted">
                                    <b>{{$notiz->text}}</b> ({{ $notiz->created_at }})
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::open(['action' => ['DashboardController@destroy', $notiz->id], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen der Notiz .&quot;)"])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Keine Notizen eingetragen.</p>
                    @endif 
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4"> <!-- Notizen Alle --> --}}
        <div class="overflow-auto mb-4 ml-3 mr-4" style="width: 600px; max-height: 350px;">  
            <div class="card mb-4">
                {{-- <div class="card-body">
                    <h4 class="card-title mb-4">Danke Kollegen</h4>
                    <img src = "/images/Karte_Yuna_vorne_klein.jpg" class="img-rounded" style="max-width: 80%">
                    <img src = "/images/Karte_Yuna_hinten_klein.jpg" class="img-rounded" style="max-width: 80%">
                </div> --}}
                <div class="card-body">
                    <h4 class="card-title mb-4">Notizen alle</h4>
                    @if(count($notizenAlleObj) > 0)
                        @foreach($notizenAlleObj as $notizAlle)
                            <div class="row">
                                <div class="col-sm-10 text-muted">
                                    <b>{{$notizAlle->text}}</b> ({{ $notizAlle->created_at }} von {{ $notizAlle->user->name }})
                                </div>
                                <div class="col-sm-2">
                                {!! Form::open(['action' => ['DashboardController@destroy', $notizAlle->id], 'method' => 'POST']) !!}
                                    {{Form::hidden('_method','DELETE')}}
                                    {{Form::button('<span class="oi" data-glyph="delete" title="Löschen" aria-hidden="true"></span>', ['type' => 'submit', 'class'=>'btn btn-danger btn-sm', 'onclick' => "return confirm(&quot;Click Ok zum löschen der Notiz .&quot;)"])}}
                                {!! Form::close() !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Keine Notizen eingetragen.</p>
                    @endif 
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4"> <!-- Standard-Infos --> --}}
        <div class="overflow-auto" style="width: 600px; max-height: 350px;">  
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Standard-Infos</h4>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ausfuehrung"> 
                        <span class="oi" data-glyph="info" title="Ausfuehrung Bausweise" aria-hidden="true"></span>Defintionen Ausführung Bauweisen
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <h4 class="card-title mb-4">Aufträge an der Wand</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="row mb-2">
                                <a href="#" class="btn btn-primary btn-sm mr-2">Auftragsannahme</a>
                                <a href="#" class="btn btn-outline-primary btn-sm mr-2">Zubehör / Rep / Ret / Rek</a>
                                <a href="#" class="btn btn-dark btn-sm mr-2">Fertigung</a>
                                <a href="#" class="btn btn-secondary btn-sm mr-2">Lamination</a>
                                <a href="#" class="btn btn-outline-secondary btn-sm mr-2">Entgratung</a>
                                <a href="#" class="btn btn-purple btn-sm mr-2">Extern HX</a>
                                <a href="#" class="btn btn-info btn-sm mr-2">Extern KJ</a>    
                                <a href="#" class="btn btn-light active btn-sm mr-2">Extern HD / Zulieferer</a>    
                            </div>
                            <div class="row">
                                <a href="#" class="btn btn-check btn-sm mr-2">Lagereingang Prüfung</a>
                                <a href="#" class="btn btn-danger btn-sm mr-2">Lager</a>
                                <a href="#" class="btn btn-outline-danger btn-sm mr-2">Eingangslager</a>
                                <a href="#" class="btn btn-warning btn-sm mr-2">Endfertigung</a>
                                <a href="#" class="btn btn-warning btn-sm mr-2"><span class="oi" data-glyph="external-link" aria-hidden="true"></span> Endfertigung Werkstatt</a>
                                <a href="#" class="btn btn-hold btn-sm mr-2"><span class="oi" aria-hidden="true"></span> Endfertigung Warteschleife</a>
                                <a href="#" class="btn btn-outline-success btn-sm mr-2">Versandlager</a> 
                            </div>
                        </div>
                        @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 14)
                            <div class="col-3">
                                    <div class="col-8 mb-2">
                                        {!! Form::open(['url' => '/kunden/?', 'method' => 'get']) !!}
                                        {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Kunde...']) !!}
                                        {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}    
                                    </div>
                                
                                    <div class="col-8">
                                        {!! Form::open(['url' => '/auftraege/?', 'method' => 'get']) !!}
                                        {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Auftragsnummer...']) !!}
                                        {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}    
                                    </div>
                            </div>
                        @endif   
                            <div class="col-3">
                                <div class="col-8 mb-2">
                                    {!! Form::open(['url' => '/dashboard/?', 'method' => 'get']) !!}
                                    {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Propeller...']) !!}
                                    {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                                    {!! Form::close() !!}   
                                </div>
                                <div class="col-2">
                                    <a href="/dashboard/" class="btn btn-warning">Reset</a>
                                </div>
                            </div>
                         
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{-- <button><span class="oi" data-glyph="eye" title="zum Auftrag" aria-hidden="true"> Standard Auftrag</button> --}}
                            <button><span class="oi" data-glyph="warning" title="zum Auftrag" aria-hidden="true"></span> Dringlichkeit</button>
                            <button><span class="oi" data-glyph="euro" title="zum Auftrag" aria-hidden="true"></span> "ist bezahlt"</button>
                            <button><span class="oi" data-glyph="text" title="zum Auftrag" aria-hidden="true"></span> Testpropeller</button>
                            <button><span class="oi" data-glyph="cart" title="zum Auftrag" aria-hidden="true"></span> Auftrag Zubehör</button>
                            <button><span class="oi" data-glyph="action-undo" title="zum Auftrag" aria-hidden="true"></span> Retoure oder Reklamation</button>
                            <button><span class="oi" data-glyph="wrench" title="zum Auftrag" aria-hidden="true"></span> Reparatur</button>
                            <button><span class="oi" data-glyph="pie-chart" title="zum Auftrag" aria-hidden="true"></span> Teillieferung</button>
                            
                        </div>
                    </div>
                    @if(count($auftraege) > 0)
                    <div class="row">
                        <div class="col-2">
                            Auftragsannahme: ({{$auftraegeAnzAnnahme}})<br>
                            @foreach($auftraege as $auftrag)
                                @if($auftrag->auftrag_status_id == 1)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                        @if($auftrag->auftrag_typ_id == 1)
                                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-primary btn-sm mb-2">
                                        @else
                                            <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-primary btn-sm mb-2">    
                                        @endif
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-primary btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 19)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                        <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-primary btn-sm mb-2">
                                        @else
                                        <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-outline-primary btn-sm mb-2">
                                    @endif
                                        <span class="oi" data-glyph="pie-chart" title="zum Auftrag" aria-hidden="true"></span>
                                        @include('dashboard.button')
                                        </a><br>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-2">
                            Fertigung: ({{$auftraegeAnzFertigung}})<br>
                            @foreach($auftraege as $auftrag)
                                @if($auftrag->auftrag_status_id == 2)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-dark btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-dark btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 9)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-secondary btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-secondary btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 17)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-secondary btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-outline-secondary btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-2">
                            Extern: ({{$auftraegeAnzExtern}})<br>
                            @foreach($auftraege as $auftrag)
                                @if($auftrag->auftrag_status_id == 3)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-purple btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-purple btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 18)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-info btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-info btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 20)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-light active btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-light active btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-2">
                            Lager: ({{$auftraegeAnzLager}})<br>
                            @foreach($auftraege as $auftrag)
                                @if($auftrag->auftrag_status_id == 10)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                        <a href="/auftraege/{{$auftrag->id}}" class="btn btn-danger btn-sm mb-2">
                                        @else
                                        <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-danger btn-sm mb-2">
                                    @endif
                                            @include('dashboard.button')
                                        </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 15)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                        <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                        @else
                                        <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                    @endif
                                            @include('dashboard.button')
                                        </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 16)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                        <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                        @else
                                        <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-outline-danger btn-sm mb-2">
                                    @endif
                                        <span class="oi" data-glyph="pie-chart" title="zum Auftrag" aria-hidden="true"></span>
                                        @include('dashboard.button')
                                        </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 22)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                        <a href="/auftraege/{{$auftrag->id}}" class="btn btn-check btn-sm mb-2">
                                        @else
                                        <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-check btn-sm mb-2">
                                    @endif
                                            @include('dashboard.button')
                                        </a><br>
                                @endif

                            @endforeach
                        </div>
                        <div class="col-2">
                            Endfertigung: ({{$auftraegeAnzEndfertigung}})<br>
                            @foreach($auftraege as $auftrag)
                                @if($auftrag->auftrag_status_id == 4)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-warning btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-warning btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 21)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-warning btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-warning btn-sm mb-2">
                                    @endif
                                        <span class="oi" data-glyph="external-link" title="zum Auftrag" aria-hidden="true"></span>
                                        @include('dashboard.button')
                                        </a><br>
                                @endif
                                @if($auftrag->auftrag_status_id == 30)
                                @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                <a href="/auftraege/{{$auftrag->id}}" class="btn btn-hold btn-sm mb-2">
                                @else
                                <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-hold btn-sm mb-2">
                                @endif
                                    <span class="oi" title="zum Auftrag" aria-hidden="true"></span>
                                    @include('dashboard.button')
                                    </a><br>
                            @endif
                            @endforeach
                        </div>
                        <div class="col-2">
                            Versandlager: ({{$auftraegeAnzVersandbereit}})<br>
                            @foreach($auftraege as $auftrag)
                                @if($auftrag->auftrag_status_id == 14)
                                    @if(Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                                    <a href="/auftraege/{{$auftrag->id}}" class="btn btn-outline-success btn-sm mb-2">
                                    @else
                                    <a href="/auftraege/status/{{$auftrag->id}}" class="btn btn-outline-success btn-sm mb-2">
                                    @endif
                                        @include('dashboard.button')
                                    </a><br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @else
                        Keine Aufträge an der Wand.
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection

@include('dashboard.modalAusfuehrung')
