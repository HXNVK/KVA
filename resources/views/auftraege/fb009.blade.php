@extends('layouts.app')

@section('content')
<a href="/kunden/{{$kunde->id}}" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<h1>Neuen Auftrag FB009 für {{ $kunde->matchcode }} anlegen</h1>
<div class="container-fluid">
    <div class="row">
        <!-- start card Projektdaten -->
        <form action="{{ route('cart.add') }}" method="POST">
            {{ csrf_field() }}
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">   
                        <div class="form-group row">
                            <label for="type" class="col-6 col-form-label">Vorgang</label>
                            <div class="col-sm-4">
                                    @foreach($auftragTypen as $auftragTyp)
                                        {{Form::radio('type',$auftragTyp->id)}} {{$auftragTyp->name}}<br>
                                    @endforeach
                                    @if ($errors->has('type'))
                                        <span class="text-danger">Vorgang auswählen!</span>
                                    @endif
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="ets" class="col-sm-4 col-form-label">Eingangsdatum</label>
                            <div class="col-sm-4">
                                    {{Form::date('ets','')}}
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Anz.</th>
                                        <th style="width: 300px">Artikel</th>
                                        <th style="width: 400px">Kommentar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <input type="hidden" value="{{ mt_rand(1,100) }}" id="id" name="id">
                                        <input type="hidden" value="{{ $kunde->id }}" id="customerID" name="customerID">
                                        <td style="width: 100px">{{Form::number('quantity','1', ['class' => 'form-control','step' => '1','min' => '1', 'max' => '500'])}}</td>
                                        <td style="width: 100px">
                                            <select class="form-control" name="name" id="name">
                                                <option value="" disabled>Bitte wählen</option>
                                                <option value="" disabled>---- Propeller ----</option>
                                                <option value=""> Bitte wählen</option>
                                                @foreach($propellerObj as $propeller)
                                                <option value="{{ $propeller->name }}">{{ $propeller->name }}</option>
                                                @endforeach
                                                <option value="" disabled>---- Distanzscheiben ----</option>
                                                @foreach($artikel05DistanzscheibeObj as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                                <option value="" disabled>---- ASGP ----</option>
                                                @foreach($artikel06ASGPObj as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                                <option value="" disabled>---- SPGP ----</option>
                                                @foreach($artikel06SPGPObj as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                                <option value="" disabled>---- SPKP ----</option>
                                                @foreach($artikel06SPKPObj as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                                <option value="" disabled>---- AP ----</option>
                                                @foreach($artikel07APObj as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                                <option value="" disabled>---- Buchsen ----</option>
                                                @foreach($artikel07BuchsenObj as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                                <option value="" disabled>---- Zubehör ----</option>
                                                @foreach($artikel08ZubehoerObj as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>    
                                        </td>
                                        <td style="width: 400px">{{Form::textarea('comment','', ['class' => 'form-control', 'rows' => 3])}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>   
                    </div>
                </div>
            </div>
        </form>
        <!-- Shopping Cart -->
        <div class="col-2">
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
                    <a class="btn btn-primary btn-sm btn-block mb-2" href="{{ route('cart.index') }}">
                        Artikelkorb <span class="oi" data-glyph="arrow-right" title="zum Artikelkorb" aria-hidden="true"></span>
                    </a>
                    <br><form action="{{ route('auftrag.add') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-success btn-sm btn-block">Auftrag speichern <span class="oi" data-glyph="arrow-right" title="Auftrag speichern" aria-hidden="true"></span></button>
                    </form>
                </div>
            @else
                <li class="list-group-item">Keine Artikel dem Auftrag hinzugefügt!</li>
            @endif
        </div>
    </div>
</div>
@endsection
