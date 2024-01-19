<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <div class="row" style="background-image: url('/images/hintergrund.jpg')">
            <div class="col-sm-6">
                <!-- Required meta tags -->
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                <!-- CSRF Token -->
                <meta name="csrf-token" content="{{ csrf_token() }}">
                @csrf

                <!-- Scripts --> 
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
                {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}

                <!-- Styles -->
                <link href="{{ asset('css/app.css') }}" rel="stylesheet">


                <!-- Fonts -->
                <link rel="dns-prefetch" href="//fonts.gstatic.com">
                <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

                <link href="{{ URL::asset('public/css/bootstrap.css')}}" id="bootstrap-light" rel="stylesheet" type="text/css" />
                <link href="{{ URL::asset('public/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
                <link href="{{ URL::asset('public/css/app.min.css')}}" id="app-light" rel="stylesheet" type="text/css" />
                <link href="/open-iconic/font/css/open-iconic.css" rel="stylesheet">

                <link rel="shortcut icon" type="image/x-icon" href="/images/propellerFavicon.ico" />

                
                <img src = "/images/logo_helix_header.png" class="img-rounded" style="max-width: 20%">
            </div>
            <div class="col-sm-6">
                <h2>{{ config('app.name', 'Laravel') }}</h2>
            </div>
        </div>
    </head>
    
    <body>
        <main class="container-fluid panel-body">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <h1>Auftrag {{ $auftrag->id }} / {{ $auftrag->kundeMatchcode }}</h1><br>
                        <h1>{{ $auftrag->anzahl }}x {{ $auftrag->propeller }}</h1><br>
                        <h2>Vorgang: {{ $auftrag->auftragTyp->name }}</h2>
                        <h2>Status: {{ $auftrag->auftragstatus->name }}</h2>
                        <h5>Auftragsauslöser: {{ $auftrag->createdAtUser->name }}</h5>
                        <h5>geändert am: {{ $auftrag->updated_at }} durch {{ $auftrag->user->name }}</h5>
                    </div>
                    <div class="col-4">
                        @if($auftrag->dringlichkeit != NULL)
                            <h1>Dringlichkeit: {{ $auftrag->dringlichkeit }}</h1>
                        @else
                            <h1>Dringlichkeit: keine</h1>
                        @endif
                    </div>
                </div>      
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                @if($auftrag->auftrag_status_id != 13
                                    && $auftrag->auftrag_status_id != 8)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=22" class="btn btn-lg btn-check mr-4 mb-5">Prüfung für Lagereingang</a>
                                            {{-- @if(Auth::user()->id != 13 && Auth::user()->id != 15)
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=10" class="btn btn-lg btn-danger mr-4 mb-5">Lager</a>
                                            @else
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=15" class="btn btn-lg btn-outline-danger btn-block mr-4 mb-15">Eingangslager</a>
                                                <br>
                                                <br>
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=16" class="btn btn-lg btn-outline-danger btn-block mr-4 mb-15"><span class="oi" data-glyph="pie-chart" title="zum Auftrag" aria-hidden="true"> Teillieferung</span></a>
                                                <br>
                                                <br>
                                            @endif --}}
                                        </div>
                                        @if(Auth::user()->id != 15)
                                            <div class="col-lg-4">
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=10" class="btn btn-lg btn-danger mr-4 mb-5">Lager</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=2" class="btn btn-lg btn-dark mr-4 mb-15">Fertigung </a>
                                            <br><br>
                                            <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=9" class="btn btn-lg btn-secondary btn-block mr-4 mb-15">Lamination</a>
                                            <br><br>
                                            {{-- @if(Auth::user()->id != 15)
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=2" class="btn btn-lg btn-dark mr-4 mb-15">Fertigung </a>
                                                <br><br>
                                            @else
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=9" class="btn btn-lg btn-secondary btn-block mr-4 mb-15">Lamination</a>
                                                <br><br>
                                            @endif --}}
                                        </div>
                                        {{-- @if(Auth::user()->id != 15)
                                            <div class="col-lg-4">
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=9" class="btn btn-lg btn-secondary mr-4 mb-5">Lamination</a>
                                            </div>
                                            @endif --}}
                                            @if(Auth::user()->id != 15)
                                            <div class="col-lg-4">
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=3" class="btn btn-lg btn-purple mr-4 mb-15">Fertigung EXT HX</a>
                                                <br><br>
                                            </div>
                                            @endif
                                            @if(Auth::user()->id != 15)
                                        <div class="col-lg-4">
                                            <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=18" class="btn btn-lg btn-info mr-4 mb-15">Fertigung EXT KJ</a>
                                            <br><br>
                                        </div>
                                    @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=17" class="btn btn-lg btn-outline-secondary mr-4 mb-15">Entgratung</a>
                                            <br><br>
                                        </div>
                                    </div>
                                    @if(Auth::user()->id != 15)
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=4" class="btn-lg btn-warning mr-4 mb-15">Endfertigung</a>
                                                <br><br>
                                            </div>
                                            <div class="col-lg-4">
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=21" class="btn-lg btn-warning mr-4 mb-4"><span class="oi" data-glyph="external-link" title="zum Auftrag" aria-hidden="true"> Endf. Werkstatt</span></a>
                                            </div>
                                            <div class="col-lg-4">
                                                <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=30" class="btn-lg btn-hold mr-4 mb-4"><span class="oi" title="zum Auftrag" aria-hidden="true"> Endf. Auftrag wartend</span></a>
                                            </div>
                                        </div>
                                        @if(Auth::user()->id != 16)
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=14" class="btn btn-lg btn-outline-success mr-4 mb-15">Versandlager</a>
                                                </div>
                                                <div class="col-lg-4">
                                                    <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=8" class="btn btn-lg btn-success mr-4 mb-15">Retourniert</a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <a href="/auftraege/status/{{$auftrag->id}}/?auftragsstatus=8" class="btn btn-lg btn-success mr-4 mb-15">Versendet</a>
                                                    <br><br>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <div class="col-lg-4">
                                        @switch($auftrag->auftrag_status_id)
                                            @case(13)
                                                <h1><b>Auftrag wurde storniert !!!</b></h1>
                                                @break
                                            @case(8)
                                                <h1><b>Auftrag wurde bereits versendet.</b></h1>
                                                @break
                                        @endswitch
                                    </div>
                                @endif
                            </div>   
                        </div> 
                    </div>   
                </div>

                <div>
                    <a href="/dashboard" class="btn btn-success btn-lg">
                        <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"> Dashboard</span>
                    </a>
                </div>
                
            </div>
        </main>
    </body>
</html>
