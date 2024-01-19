@extends('layouts.app')

@section('content')
<a href="/propeller" class="btn btn-success">
    <span class="oi" data-glyph="home" title="home" aria-hidden="true"></span>
</a>
<h1>Neuen Artikel Propeller anlegen</h1>
<div class="row">
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-body">
                {!! Form::open(['action' => 'PropellerController@store', 'method' => 'POST']) !!}
                    <div class="form-group row">
                        {{Form::label('name','Name',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8 text-muted">
                            {{Form::text('name','', ['class' => 'form-control','readonly' => 'true','placeholder' =>'Bsp.: H50F 1.75m R-SSI-18-3'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-8 text-muted">
                            ( ! Name wird automatisch generiert ! )
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="artikel_01Propeller" class="col-sm-3 col-form-label">Propeller Artikel</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="artikel_01Propeller" id="artikel_01Propeller">
                                <option value="" disabled>Bitte wählen</option>
                                @foreach($artikel_01PropellerObj as $artikel_01Propeller)
                            <option value="{{ $artikel_01Propeller->propeller_klasse_geometrie_id }},{{ $artikel_01Propeller->id }}" {{ old('artikel_01Propeller') == $artikel_01Propeller->propeller_klasse_geometrie_id ? 'selected' : '' }}>{{ $artikel_01Propeller->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="propeller_form" class="col-sm-3 col-form-label">Modell</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="propeller_form" id="propeller_form">
                                <option value="" disable="true" selected="true">=== Wähle Form ===</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('winkel','Winkel',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::number('winkel', '', ['class' => 'form-control','step' => '0.5', 'min' => '3', 'max' => '30', 'placeholder' =>' Für H60A/V: Bsp. 19'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz','', ['class' => 'form-control','rows' => 3, 'cols' => 10, 'placeholder' =>'500 Zeichen für Infos'])}}
                        </div>
                    </div>
                    <hr>
                    EINGABE Propellerbezeichnung der Konkurrenz:
                    <div class="form-group row">
                        {{Form::label('konkurrenzPropeller','Propellername',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('konkurrenzPropeller','', ['class' => 'form-control', 'placeholder' =>'Bsp.: DUC Flash-2'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            {{Form::submit('neu speichern', ['class'=>'btn btn-primary'])}}
                        </div>
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-4">
                            <a href="/propellerFormen/create" class="btn btn-success">
                                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> neue Laminierform</span>
                            </a>
                        </div>                       
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <button id = "propellerliste" type="button" class="btn btn-info"><span class="oi" data-glyph="eye"></span> Bisher angelegte Propeller</button>
        <div class="propellerliste">
            @foreach($propellerObj as $key => $propeller)
                {{ $propeller }}<br>
            @endforeach    
        </div>
    </div>
    <div class="col-xl-4">
        <div>
            <table class="table table-striped mb-4" cellpadding="0" cellspacing="0">
                <tr>
                    <th>Typenbez. NEU</th>
                    <th>=></th>
                    <th>Alt</th>
                    <th>Designklasse</th>
                </tr>
            @foreach($propellerModellBlattTypen as $propellerModellBlattTyp)
            <tr>
                <td>{{ $propellerModellBlattTyp->text }}</td>
                <td>=></td>
                <td>{{ $propellerModellBlattTyp->name_alt }}</td>
                <td>{{ $propellerModellBlattTyp->propellerKlasseDesign->name }}</td>
            </tr>
            @endforeach   
            </table> 
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        $('select[name="artikel_01Propeller"]').on('change', function() {
            var propellerKlasseGeometrieID = $(this).val();
            if(propellerKlasseGeometrieID) {
                $.ajax({
                    url: '/propeller/create/json-propellerForm/'+propellerKlasseGeometrieID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="propeller_form"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="propeller_form"]').append('<option value="'+ value +'">'+ key +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="propeller_form"]').empty();
            }
        });

        $("#propellerliste").ready(function(){
            $(".propellerliste").toggle();
        });
        $("#propellerliste").click(function(){
            $(".propellerliste").toggle();
        });


    });

</script>
@endsection