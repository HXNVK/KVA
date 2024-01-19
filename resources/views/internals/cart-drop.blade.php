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