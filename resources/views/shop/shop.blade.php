@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Artikel</li>
                <li class="breadcrumb-item active" aria-current="page">Zubehör</li>
            </ol>
        </nav>
        @if($kundeID != NULL)
        <div class="row justify-content-center">
            <div class="col-lg-12">
                {{-- <div class="row">
                    <div class="col-lg-7">
                        <h4>Zubehör</h4>
                    </div>
                </div>
                <hr> --}}
                <h5>Distanzscheiben</h5>
                <div class="row">
                    @foreach($artikel05DistanzscheibeObj as $artikel05Distanzscheibe)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel05Distanzscheibe->name }}</h6>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(1,1000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel05Distanzscheibe->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel05Distanzscheibe->name }}" id="ds" name="ds">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h5>Adapterscheiben-Spinnergrundplatten</h5>
                <div class="row">
                    @foreach($artikel06ASGPObj as $artikel06ASGP)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel06ASGP->name }}</h6>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(1001,2000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel06ASGP->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel06ASGP->name }}" id="asgp" name="asgp">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h5>Spinnergrundplatten</h5>
                <div class="row">
                    @foreach($artikel06SPGPObj as $artikel06SPGP)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel06SPGP->name }}</h6>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(2001,3000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel06SPGP->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel06SPGP->name }}" id="spgp" name="spgp">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h5>Spinnerkappen</h5>
                <div class="row">
                    @foreach($artikel06SPKPObj as $artikel06SPKP)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel06SPKP->name }}</h6>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(3001,4000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel06SPKP->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel06SPKP->name }}" id="spkp" name="spkp">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h5>komplette Spinner</h5>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 200x240mm 2-Blatt ASGP 0</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 200x240mm 2-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 200x240" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 200mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 200x240mm 3-Blatt ASGP 0</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 200x240mm 3-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 200x240" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 200mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 230x275mm 2-Blatt ASGP 0</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 230x275mm 2-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 230x275" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 230mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 230x275mm 3-Blatt ASGP 0</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 230x275mm 3-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 230x275" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 230mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 260x340mm 2-Blatt</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 260x340mm 2-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 260x340" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 260mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 260x340mm 3-Blatt</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 260x340mm 3-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 260x340" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 260mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">DUC Spinner 260x340mm 3-Blatt</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="DUC Spinner 260x340mm 3-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 260x340" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 260mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm DUC" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">WARP Spinner 260x340mm 3-Blatt</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="WARP Spinner 260x340mm 3-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 260x340" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 260mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm WarpDrive" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 260x300mm 3-Blatt H60V</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 260x300mm 3-Blatt H60V" id="name" name="name">
                                    <input type="hidden" value="SPKP 260x300" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 260mm" id="spkp" name="spgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px; height: auto;">
                            <div class="card-body">
                                <h6 class="card-title">HELIX Spinner 260x300mm 3-Blatt ASGP 0</h6>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="7001" id="id" name="id"> {{-- ID-Range für komplette Spinner 7001-8000 --}}
                                    <input type="hidden" value="Standard Spinner 260x300mm 3-Blatt" id="name" name="name">
                                    <input type="hidden" value="SPKP 260x300" id="spkp" name="spkp">
                                    <input type="hidden" value="SPGP 260mm" id="spkp" name="spgp">
                                    <input type="hidden" value="ASGP 0mm" id="asgp" name="asgp">
                                    <input type="hidden" value="1" id="quantity" name="quantity">
                                    <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                    <input type="hidden" value="5" id="type" name="type">
                                    <div class="card-footer" style="background-color: white;">
                                        <div class="row">
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <h5>Andruckplatten</h5>
                <div class="row">
                    @foreach($artikel07APObj as $artikel07AP)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel07AP->name }}</h6>
                                    Lochkreis: {{ $artikel07AP->lochkreis}}
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(4001,5000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel07AP->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel07AP->name }}" id="ap" name="ap">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h5>Flansch-Buchsen</h5>
                <div class="row">
                    @foreach($artikel07BuchsenObj as $artikel07Buchsen)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel07Buchsen->name }}</h6>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(5001,6000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel07Buchsen->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel07Buchsen->name }}" id="buHX" name="buHX">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h5>Adapterscheiben</h5>
                <div class="row">
                    @foreach($artikel07ASObj as $artikel07Adapterscheibe)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel07Adapterscheibe->name }}</h6>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(8001,9000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel07Buchsen->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel07Adapterscheibe->name }}" id="as" name="as">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h5>PCR & PU-Band & Hyd-Verstellregler</h5>
                <div class="row">
                    @foreach($artikel08ZubehoerObj as $artikel08Zubehoer)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                {{-- <img src="/images/{{ $pro->image_path }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $pro->image_path }}"
                                > --}}
                                <div class="card-body">
                                    <h6 class="card-title">{{ $artikel08Zubehoer->name }}</h6>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ mt_rand(6001,7000) }}" id="id" name="id">
                                        {{-- <input type="hidden" value="{{ $artikel07Buchsen->id }}" id="id" name="id"> --}}
                                        <input type="hidden" value="Zubehoer" id="name" name="name">
                                        <input type="hidden" value="{{ $artikel08Zubehoer->name }}" id="addParts" name="addParts">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $kundeID }}" id="customerID" name="customerID">
                                        <input type="hidden" value="6" id="type" name="type">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                    <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
            Kein Kunde ausgewählt!
        @endif
    </div>
@endsection