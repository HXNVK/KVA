@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Auftrag</li>
                <li class="breadcrumb-item active" aria-current="page">Artikelkorb</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $kunde->matchcode }} ({{$kunde->name1}})</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <br>
                @if(\Cart::getTotalQuantity()>0)
                    <h4>{{ \Cart::getTotalQuantity()}} Artikel der Bestellung</h4><br>
                @else
                    <h4>Keine Artikel ausgewählt!</h4><br>
                    <a href="/kunden/{{session('customerID')}}" class="btn btn-primary">zurück zum Kunden</a>
                @endif

                @foreach($cartCollection as $item)
                
                    <div class="row">
                        <div class="col-lg-6">
                            <p>
                                @if($item->type == 1)
                                    @if($item->option != 'S')
                                        @if($item->color != 'S')
                                            <b>{{$item->quantity}}x {{ $item->name }} / {{ $item->color }} / {{ $item->option }}</b><br>
                                            @else
                                            <b>{{$item->quantity}}x {{ $item->name }} / {{ $item->option }}</b><br>
                                        @endif
                                    @else
                                        @if($item->color != 'S')
                                            <b>{{$item->quantity}}x {{ $item->name }} / {{ $item->color }}</b><br>
                                        @else
                                            <b>{{$item->quantity}}x {{ $item->name }}</b><br>
                                        @endif
                                    @endif
                                    {{ $item->projectname }}<br>
                                    {{-- Bohrschema: {{Form::text('bohrschema',$item->drilling, ['class' => 'form-control'])}}<br> --}}
                                    Bohrschema: {{ $item->drilling }}<br>
                                    Anordnung: {{ $item->assembly }}<br>
                                    Aufkleber: {{ $item->sticker }}<br>
                                    @if($item->typesticker != NULL)
                                        Typenaufkleber: {{ $item->typesticker }}<br>
                                    @endif
                                    @if($item->protectionTape != NULL)
                                        KSB: {{ $item->protectionTape }}<br>
                                    @endif
                                    @if($item->urgency != NULL)
                                        Dringlichkeit: {{ $item->urgency }}<br>
                                    @endif
                                    @if($item->ets != NULL)
                                        ETS: {{ $item->ets }}<br>
                                    @endif
                                    @if($item->ds != NULL)
                                        DS: {{ $item->ds }}<br>
                                    @endif
                                    @if($item->asgp != NULL)
                                        ASGP: {{ $item->asgp }}<br>
                                    @endif
                                    @if($item->spgp != NULL)
                                        SPGP: {{ $item->spgp }}<br>
                                    @endif
                                    @if($item->spkp != NULL)
                                        SPKP: {{ $item->spkp }}<br>
                                    @endif
                                    @if($item->ap != NULL)
                                        Andruckplatte: {{ $item->ap }}<br>
                                    @endif
                                    @if($item->buHX != NULL)
                                        Buchsen: {{ $item->buHX }}<br>
                                    @endif
                                    @if($item->btSet != NULL)
                                        Schrauben: {{ $item->btSet }}<br>
                                    @endif
                                    @if($item->testpropeller == 1)
                                        <b style="font-size: 15pt; font-weight: 900; color: rgb(255, 174, 0)">Testpropeller</b><br>
                                    @endif
                                @else
                                    <b>{{ $item->name }}</b><br>
                                    @switch($item->type)
                                        @case(2)
                                            FB009: Retoure<br>
                                            @break
                                        @case(3)
                                            FB009: Reparatur<br>
                                            @break
                                        @case(4)
                                            FB009: Reklamation<br>
                                            @break
                                    @endswitch
                                    @if($item->ets != NULL)
                                        ETS: {{ $item->ets }}<br>
                                    @endif
                                @endif
                                @if($item->type == 5 || $item->type == 6)
                                    @if($item->ds != NULL)
                                        DS: {{ $item->ds }}<br>
                                    @endif
                                    @if($item->asgp != NULL)
                                        ASGP: {{ $item->asgp }}<br>
                                    @endif
                                    @if($item->spgp != NULL)
                                        SPGP: {{ $item->spgp }}<br>
                                    @endif
                                    @if($item->spkp != NULL)
                                        SPKP: {{ $item->spkp }}<br>
                                    @endif
                                    @if($item->ap != NULL)
                                        Andruckplatte: {{ $item->ap }}<br>
                                    @endif
                                    @if($item->as != NULL)
                                        Adapterscheibe: {{ $item->as }}<br>
                                    @endif
                                    @if($item->buHX != NULL)
                                        Buchsen: {{ $item->buHX }}<br>
                                    @endif
                                    @if($item->btSet != NULL)
                                        Schrauben: {{ $item->btSet }}<br>
                                    @endif
                                    @if($item->btSet2 != NULL)
                                    Schrauben Flansch: {{ $item->btSet2 }}<br>
                                @endif
                                    @if($item->addParts != NULL)
                                        {{ $item->addParts }}<br>
                                    @endif
                                @endif

                                {{-- <br><br>
                                <b>Einzelpreis: </b>€{{ $item->price }}<br>
                                <b>Summe: </b>€{{ \Cart::get($item->id)->getPriceSum() }}<br> --}}
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <form action="{{ route('cart.update') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                    Anzahl +/-: <input type="hidden" value="{{ $item->id }},{{ $item->name }},0" id="artikel" name="artikel">
                                        <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}"
                                                id="quantity" name="quantity" style="width: 70px; margin-right: 10px;">
                                        <button class="btn btn-warning btn-sm" style="margin-right: 25px;"><span class="oi" data-glyph="pencil" title="bearbeiten" aria-hidden="true"></span></button>
                                    </div>
                                </form>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <button class="btn btn-danger btn-sm" style="margin-right: 10px;"><span class="oi" data-glyph="trash" title="löschen" aria-hidden="true"></span></button>
                                </form>
                            </div>
                            @if($item->testpropeller == 0)
                                <div class="row">
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $item->id }},{{ $item->name }},1" id="artikel" name="artikel">
                                        <button class="btn btn-warning btn-sm"><span class="oi" data-glyph="warning" title="Testpropeller" aria-hidden="true">als Testpropeller markieren</span></button>
                                    </form>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                @endforeach
                @if(count($cartCollection)>0)
                    <form action="{{ route('cart.clear') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-danger">Alles löschen</button>
                    </form>
                @endif
            </div>
            @if(count($cartCollection)>0)
                <div class="col-lg-3">
                    {{-- <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Summe Gesamt: </b>€{{ \Cart::getTotal() }} excl. MwSt</li>
                        </ul>
                    </div> --}}
                    <br><a href="/auftraege/create/?kundenId={{$kundeID}}" class="btn btn-primary mb-2">Weitere Artikel über Liste</a>
                    <br><a href="/kunden/{{$kundeID}}" class="btn btn-primary mb-2">Weitere Artikel über Projekte</a>
                    <br><a href="/shop/" class="btn btn-primary mb-2">Weiteres Zubehör</a>
                    <br>
                    <br>
                    <br><a href="/fb009/{{$kundeID}}" class="btn btn-primary mb-2">weiteres FB009</a>
                    <br><form action="{{ route('auftrag.add') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            {{Form::label('myFactoryAB','MyFactory AB',['class' => 'col-sm-6 col-form-label'])}}
                            <div class="col-sm-6">
                                {{Form::number('myFactoryAB','', ['class' => 'form-control','step' => '1','min' => '2200015', 'max' => '9999999'])}}
                            </div>
                        </div>
                        
                        <button class="btn btn-success">Auftrag speichern</button>
                    </form>
                </div>
            @endif
        </div>
        <br><br>
    </div>
@endsection