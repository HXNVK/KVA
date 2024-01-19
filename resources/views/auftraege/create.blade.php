@extends('layouts.app')

@section('content')
<a href="/kunden/{{$kunde_id}}" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
<h1>Neuen Auftrag für {{ $kunde->matchcode }} anlegen</h1>
    <div class="row">
        <!-- start card Projektdaten -->
        <div class="col-xl-10">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h4 class="card-title mb-4">FB019 und FB094</h4>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Projekt</th>
                                    <th>Propeller</th>
                                    <th style="min-width: 100px">Farbe</th>
                                    <th>Ausführung</th>
                                    <th>Anordnung</th>
                                    <th style="min-width: 100px">Dringlichkeit</th>
                                    <th style="min-width: 150px">ETS</th>
                                    <th>Form-1</th>
                                    <th style="width: 130px"><button id ="anbauteile" type="button" class="btn btn-primary btn-sm">Anbauteile<span class="oi" data-glyph="arrow-bottom"></span></button></th>
                                    <th>Notiz</th>
                                    <th>Anzahl</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($projektPropellerObjects) > 0)
                                @foreach($projektPropellerObjects as $projektPropeller)
                                <form action="{{ route('cart.add') }}" method="POST">
                                    {{ csrf_field() }}
                                    <?php 
                                        if($projektPropeller->propellerGek == 0){
                                            // if($projektPropeller->farbe != NULL){
                                            //     $propellername = "$projektPropeller->propellername / $projektPropeller->farbe";
                                            // }else{
                                            //     $propellername = $projektPropeller->propellername;
                                            // }
                                            $propellername = $projektPropeller->propellername;
                                        }
                                        else{
                                            $propellername = "$projektPropeller->propellername gek. ".$projektPropeller->propellerDurchmesserNeu."m" ;
                                        }

                                        $projektPropellerPreis = $projektPropeller->artikel_01PropellerPreis + ($projektPropeller->blattanzahl * ($projektPropeller->ausfuehrungPreis + $projektPropeller->farbePreis))
                                    ?>
                                    <tr>
                                        <input type="hidden" value="{{ $kunde_id }}" id="customerID" name="customerID">
                                        <input type="hidden" value="{{ $projektPropeller->projektPropellerID }}" id="id" name="id">
                                        <input type="hidden" value="{{ $projektPropeller->propellerFormID }}" id="propellerFormID" name="propellerFormID">
                                        <input type="hidden" value="{{ $propellername }}" id="name" name="name">
                                        <input type="hidden" value="{{ $projektPropellerPreis }}" id="price" name="price">
                                        <input type="hidden" value="{{ $projektPropeller->blattanzahl }}" id="numOfBlades" name="numOfBlades">
                                        <input type="hidden" value="{{ $projektPropeller->projektID }}" id="projectID" name="projectID">
                                        <input type="hidden" value="{{ $projektPropeller->projektname }}" id="projectname" name="projectname">
                                        <input type="hidden" value="{{ $projektPropeller->geraeteklasse }}" id="projectclass" name="projectclass">
                                        <input type="hidden" value="{{ $projektPropeller->ausfuehrung }}" id="option" name="option">
                                        <input type="hidden" value="{{ $projektPropeller->farbe }}" id="color" name="color">
                                        <input type="hidden" value="{{ $projektPropeller->bohrschema }}" id="drilling" name="drilling">
                                        <input type="hidden" value="{{ $projektPropeller->typenaufkleber }}" id="typesticker" name="typesticker">
                                        <input type="hidden" value="{{ $projektPropeller->kantenschutzband }}" id="protectionTape" name="protectionTape">
                                        <input type="hidden" value="1" id="type" name="type">
                                        <input type="hidden" value="0" id="testpropeller" name="testpropeller">
                                        <td style=min-width:50px>{{ $projektPropeller->fluggeraet }} {{ $projektPropeller->motorname }} / {{ number_format($projektPropeller->untersetzung,2) }}</td>
                                        <td style=min-width:250px>{{ $propellername }}</td>
                                        <td style=min-width:30px>{{ $projektPropeller->farbe }}</td>
                                        <td style=min-width:50px>{{ $projektPropeller->ausfuehrung }}</td>
                                        <td style=min-width:50px>
                                            <!-- Propellerausrichtung -->
                                            <div class="form-group row">
                                                @if($projektPropeller->ausrichtung != NULL)
                                                    @if($projektPropeller->ausrichtung == 'Druck')
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Druck', true, ['checked' => 'checked'])}}Druck 
                                                        </div>
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Zug', false, [])}}Zug 
                                                        </div>
                                                    @else
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Druck', false, [])}}Druck 
                                                        </div>
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Zug', true, ['checked' => 'checked'])}}Zug 
                                                        </div>
                                                    @endif
                                                @else
                                                    @if($projektPropeller->geraeteklasse == 'UL-Trike' ||
                                                        $projektPropeller->geraeteklasse == 'MS-Trike' ||
                                                        $projektPropeller->geraeteklasse == 'MS' ||
                                                        $projektPropeller->geraeteklasse == 'GYRO')
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Druck', true, ['checked' => 'checked'])}}Druck
                                                        </div>
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Zug', false, [])}}Zug 
                                                        </div>
                                                    @else
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Druck', false, [])}}Druck 
                                                        </div>
                                                        <div class="col-10">
                                                            {{Form::radio('assembly','Zug', true, ['checked' => 'checked'])}}Zug 
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <!-- Aufkleber -->
                                            <input type="hidden" value="{{ $projektPropeller->propellerAufkleber }}" id="sticker" name="sticker">
                                        {{-- <td>
                                            
                                            <div class="row">
                                                @if($kunde->kundeAufkleber->name == 'Helix')
                                                    <div class="col-10">
                                                        {{Form::radio('sticker',$projektPropeller->propellerAufkleber, true, ['checked' => 'checked'])}} Helix
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::radio('sticker','ohne', false, [])}} ohne
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::radio('sticker','Kunde', false, [])}} Kunde
                                                    </div>
                                                @endif
                                                @if($kunde->kundeAufkleber->name == 'ohne')
                                                    <div class="col-10">
                                                        {{Form::radio('sticker',$projektPropeller->propellerAufkleber, false, [])}} Helix
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::radio('sticker','ohne', true, ['checked' => 'checked'])}} ohne
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::radio('sticker','Kunde', false, [])}} Kunde
                                                    </div>
                                                @endif
                                                @if($kunde->kundeAufkleber->name == 'Kunde')
                                                    <div class="col-10">
                                                        {{Form::radio('sticker',$projektPropeller->propellerAufkleber, false, [])}} Helix
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::radio('sticker','ohne', false, [])}} ohne
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::radio('sticker','Kunde', true, ['checked' => 'checked'])}} Kunde
                                                    </div>
                                                @endif
                                            </div>
                                        </td> --}}

                                        <td style=min-width:30px>
                                            <!-- Dringlichkeit -->
                                            <div class="row">
                                                <div class="col-10">
                                                    {{Form::radio('urgency','dringend', false, [])}} dringend
                                                </div>
                                                <div class="col-10">
                                                    {{Form::radio('urgency','nochHeute', false, [])}} noch heute
                                                </div>
                                            </div>
                                        </td>
                                        <td style=min-width:50px>
                                            <!-- ETS -->
                                            <div class="row">
                                                <div class="col-10">
                                                    {{Form::date('ets','')}}
                                                </div>
                                            </div>
                                        </td>
                                        <td style=min-width:30px>
                                            <!-- Zertifikation -->
                                            <div class="row">
                                                <div class="col-10">
                                                    {{Form::radio('certification','Form1', false, [])}} ja
                                                </div>
                                            </div>
                                        </td>
                                        <td style=width:100px>
                                            <!-- Anbauteile -->
                                            <div class="row anbauteile">
                                                @if($projektPropeller->geraeteklasse == '3-ACHS' ||
                                                    $projektPropeller->geraeteklasse == 'GYRO') 
                                                    <div class="col-10">
                                                        {{Form::checkbox('ds',$projektPropeller->ds, false, [])}} DS
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::checkbox('asgp',$projektPropeller->asgp, false, [])}} ASGP
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::checkbox('spgp',$projektPropeller->spgp, false, [])}} SPGP
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::checkbox('spkp',$projektPropeller->spkp, false, [])}} SPKP
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::checkbox('ap',$projektPropeller->ap, false, [])}} AP
                                                    </div>
                                                    <!-- <div class="col-10">
                                                    <select class="form-control" name="artikel07Buchse">
                                                        <option value="" disabled>Bitte wählen</option>
                                                        <option value="">----</option>
                                                        @foreach($artikel07Buchsen as $artikel07Buchse)
                                                        <option value="BU-HX">{{ $artikel07Buchse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    </div> -->
                                                    <div class="col-10">
                                                        {{Form::checkbox('buHX','BU-HX', false, [])}} BU-HX
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::checkbox('btSet','BT-SET', false, [])}} BT-Set
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::checkbox('PCR','PCR', false, [])}} PCR
                                                    </div>
                                                @else
                                                    <div class="col-10">
                                                        {{Form::checkbox('ap',$projektPropeller->ap, false, [])}} AP
                                                    </div>
                                                    <div class="col-10">
                                                        {{Form::checkbox('btSet','BT-SET', false, [])}} BT-Set
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td style=min-width:30px>
                                            <!-- Notiz -->
                                            {{Form::textarea('comment',$projektPropeller->produktionsNotiz, ['class' => 'form-control', 'rows' => 2, 'placeholder' =>'100 Zeichen für Infos'])}}
                                        </td>
                                        <td style=min-width:50px>
                                            <!-- Anzahl -->
                                            {{Form::number('quantity','1', ['class' => 'form-control','step' => '1','min' => '1', 'max' => '500'])}}
                                            @if ($errors->has('quantity'))
                                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" class="tooltip-test" title="zum Artikelkorb hinzufügen">
                                                <span class="oi" data-glyph="cart" title="zum Artikelkorb hinzufügen" aria-hidden="true"></span> hinzufügen
                                            </button>
                                        </td>
                                    </tr>
                                </form>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">Kein Propellereintrag vorhanden.</p>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shopping Cart -->
        <div class="col-xl-2">
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
</form>

<script>
    $(document).ready(function() {
        $("#anbauteile").ready(function(){
            $(".anbauteile").toggle();
        });
        $("#anbauteile").click(function(){
            $(".anbauteile").toggle();
        });
    });

 </script>

@endsection