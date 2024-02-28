<ul class="nav nav-tabs">
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Kunden</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Kunden</button>
                @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15)
                    <ul class="dropdown-menu" style="background-color: ">
                        <li class="dropdown-header">in Bearbeitung</li>
                        <li><a href="/kunden/{{ session('customerID') }}">aktiver Kunde</a></li>
                        <li class="dropdown-header">Verwaltung</li>
                        <li><a href="/kunden">Übersicht</a></li>
                        <li><a href="/kunden/create">anlegen</a></li>
                        {{-- <li class="dropdown-header">Export/Import Daten</li>
                        <li><a href="/kundenNeu">von alt in neue KVA</a></li> --}}
                    </ul>
                @endif
            </div>
        </li>
        @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
            <button class="btn btn-warning"><a href="/kunden/{{ session('customerID') }}">aktiver Kunde</a></button>
        @endif
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Projekte &
                    Fluggeräte</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Projekte &
                    Fluggeräte</button>
                @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Projekte</li>
                        <li><a href="/projekte">Übersicht</a></li>
                        <li><a href="/projekte/create">anlegen</a></li>
                        <li class="dropdown-header">Fluggeraete</li>
                        <li><a href="/fluggeraete">Übersicht</a></li>
                        <li><a href="/fluggeraete/create">anlegen</a></li>
                        {{-- <li class="dropdown-header">Export/Import Daten</li>
                        <li><a href="/projekteNeu">von alt in neue KVA</a></li> --}}
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Aufträge</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Aufträge</button>
                @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">alle Aufträge</li>
                        <li><a href="/auftraege">Übersicht</a></li>
                        <li class="dropdown-header">aktueller Auftrag</li>
                        <a id="dropdown" href="{{ route('cart.index') }}" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Artikelkorb <span class="oi" data-glyph="cart" title="bearbeiten" aria-hidden="true"></span>
                            {{ \Cart::getTotalQuantity() }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
                            style="width: 450px; padding: 0px; border-color: #9DA0A2">
                            <ul class="list-group" style="margin: 20px;">
                                @include('internals.cart-drop')
                            </ul>
                        </div>
                        <li class="dropdown-header">ESPData</li>
                        <li><a href="/espData">Übersicht</a></li>
                        {{-- <li class="dropdown-header">Arduino</li>
                        <li><a href="/arduinoData">Übersicht</a></li> --}}
                        {{-- <li class="dropdown-header">Export/Import Daten</li>
                        <li><a href="/auftraegeNeu">von alt in neue KVA</a></li> --}}
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller &
                    Zubehör</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller &
                    Zubehör</button>
                @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Propeller</li>
                        <li><a href="/propeller">Übersicht</a></li>
                        <li><a href="/propeller/create">anlegen</a></li>
                        <li class="dropdown-header">Zubehör</li>
                        <li><a href="/shop">Übersicht</a></li>
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller Tools, Matrix &
                    CAD</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Propeller Tools, Matrix &
                    CAD</button>
                @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                    <ul class="dropdown-menu">
                        {{-- <li class="dropdown-header">Kurvenbearbeitung</li>
                        <li><a href="#">Eingabe Prüftstandsdaten - NOT ACTIVE</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">Kurvenvergleich</li>
                        <li><a href="#">Start - NOT ACTIVE</a></li>
                        <div class="dropdown-divider"></div> --}}
                        <li class="dropdown-header">Matrix</li>
                        <li><a href="/propellerFormMatritzen">Übersicht</a></li>
                        <li><a href="/propellerFormen">Formen</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">CAD-Daten</li>
                        <li><a href="/propellerModellBlattTypen">Typen</a></li>
                        <li><a href="/propellerModellKompatibilitaeten">Kompatibilitaeten</a></li>
                        <li><a href="/propellerModellWurzeln">Modell Wurzeln</a></li>
                        <li><a href="/propellerModellBlaetter">Modell Blätter</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">Zuschnitte</li>
                        <li><a href="/propellerZuschnitte">Übersicht</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">StepCode</li>
                        <li><a href="/propellerStepCode">Dashboard</a></li>
                        {{-- <li><a href="/propellerStepCodeProfile/create">Profil anlegen</a></li> --}}
                        {{-- <li class="dropdown-header">Profil-Daten</li>
                        <li><a href="/airfoilData">Bas-Wandler</a></li> --}}
                    </ul>
                @endif
                @if (Auth::user()->id == 13 || Auth::user()->id == 14 || (Auth::user()->id == 15 && Auth::user()->id != 16))
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Matrix</li>
                        <li><a href="/propellerFormMatritzen">Übersicht</a></li>
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Motoren, Getriebe &
                    Flansche</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Motoren, Getriebe &
                    Flansche</button>
                @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Motoren</li>
                        <li><a href="/motoren">Übersicht</a></li>
                        <li><a href="/motoren/create">anlegen</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">Getriebe</li>
                        <li><a href="/motorGetriebe">Übersicht</a></li>
                        <li><a href="/motorGetriebe/create">anlegen</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-header">Flansche</li>
                        <li><a href="/motorFlansche">Übersicht</a></li>
                        <li><a href="/motorFlansche/create">anlegen</a></li>
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Produktion</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Produktion</button>
                @if (Auth::user()->id != 13 && Auth::user()->id != 14 && Auth::user()->id != 15 && Auth::user()->id != 16)
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Materialien & Hersteller</li>
                        <li><a href="/materialien">Materialien</a></li>
                        <li><a href="/materialHersteller">Hersteller</a></li>
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">LFA</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">LFA</button>
                @if (Auth::user()->id == 1 || Auth::user()->id == 7)
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Lärmmessungen</li>
                        <li><a href="/laermmessungen">Übersicht</a></li>
                        <li><a href="/laermmessungen/create">Eingabe</a></li>
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    @guest
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Q13</button>
            </div>
        </li>
    @else
        <li class="nav-item dropdown mr-2">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Q13</button>
                @if (Auth::user()->id == 1 || Auth::user()->id == 7)
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Nullpunkte</li>
                        <li><a href="/q13Nullpunkte">Übersicht</a></li>
                        <li><a href="/q13Nullpunkte/create">Eingabe</a></li>
                    </ul>
                @endif
            </div>
        </li>
    @endguest
    <!-- Authentication Links -->
    @guest
        <li class="nav-item dropdown">
            <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Benutzer
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @else
                    <button class="btn btn-warning"><a href="/dashboard">Dashboard</a></button>
                    <li class="dropdown">
                        <a id="navbarDropdown" class="btn btn-success dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @can('user-list')
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                        {{ __('Benutzer') }}
                                    </a></li>
                            @endcan


                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a></li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </li>
</ul>
