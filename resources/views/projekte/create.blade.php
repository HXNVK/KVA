@extends('layouts.app')

@section('content')
{{-- <div class="row">
    @include('internals.messages')
</div> --}}
<a href="/projekte" class="btn btn-success">
    <span class="oi" data-glyph="arrow-thick-left" title="home" aria-hidden="true"></span>
</a>
@if(isset($kunde_id))
    <h1>Projekt neu anlegen für {{ $kunde->matchcode }} / {{ $kunde->name1 }}</h1>
@else
    <h1>Projekt neu anlegen</h1>
@endif
{!! Form::open(['action' => 'ProjekteController@store', 'method' => 'POST']) !!}
    <div class="row">
        <!-- start card Projektdaten -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4 class="card-title mb-4">Projektdaten</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kunde_id" class="col-sm-3 col-form-label">Kunde</label>
                        @if(isset($kunde_id))
                            <div class="col-sm-8">
                                {{Form::text('kunde_id',$kunde_id, ['class' => 'form-control','readonly' => 'true'])}}
                            </div>
                        @else
                            <div class="col-sm-8">
                                <select class="form-control" name="kunde_id">
                                    <option value="" disabled>Bitte wählen</option>
                                    <option value="">----</option>
                                    @foreach($kunden as $kunde)
                                    <option value="{{ $kunde->id }}" {{ old('kunde_id') == $kunde->id ? 'selected' : '' }}>{{ $kunde->matchcode }} / {{ $kunde->name1 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('beschreibung','Beschreibung',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::text('beschreibung', '', ['class' => 'form-control', 'placeholder' =>'Bsp.: "Prototyp" oder "H160FUNBI-R"'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="projekt_geraeteklasse_id" class="col-sm-3 col-form-label">Geräteklasse</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="projekt_geraeteklasse_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($projektGeraeteklassen as $projektGeraeteklasse)
                                <option value="{{ $projektGeraeteklasse->id }}" {{ old('projekt_geraeteklasse_id') == $projektGeraeteklasse->id ? 'selected' : '' }}>{{ $projektGeraeteklasse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#geraeteklassen">
                                <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
                            </button>
                        </div>
                        @if ($errors->has('projekt_geraeteklasse_id'))
                            <span class="text-danger">Geräteklasse wählen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="fluggeraet_id" class="col-sm-3 col-form-label">Fluggerät</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="fluggeraet_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($fluggeraete as $fluggeraet)
                                <option value="{{ $fluggeraet->id }}" {{ old('fluggeraet_id') == $fluggeraet->id ? 'selected' : '' }}>{{ $fluggeraet->name }} [{{ $fluggeraet->kunde->matchcode }}]</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#fluggeraet">
                                <span class="oi" data-glyph="info" title="info" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">

                        </div>
                        <div class="col-sm-8">
                            <a href="/fluggeraete/create" class="btn btn-success">
                                <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"> neues Fluggerät</span>
                            </a>    
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="projekt_kategorie_id" class="col-sm-3 col-form-label">Kategorie</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="projekt_kategorie_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($projektKategorien as $projektKategorie)
                                <option value="{{ $projektKategorie->id }}" {{ old('projekt_kategorie_id') == $projektKategorie->id ? 'selected' : '' }}>{{ $projektKategorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('projekt_kategorie_id'))
                            <span class="text-danger">Projektkategorie wählen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="projekt_typ_id" class="col-sm-3 col-form-label">Typ</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="projekt_typ_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($projektTypen as $projektTyp)
                                <option value="{{ $projektTyp->id }}" {{ old('projekt_typ_id') == $projektTyp->id ? 'selected' : '' }}>{{ $projektTyp->name }} ({{ $projektTyp->beziehung }})</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('projekt_typ_id'))
                            <span class="text-danger">Projekttype wählen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="projekt_status_id" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="projekt_status_id">
                                <option value="" disabled>Bitte wählen</option>
                                <option value="">----</option>
                                @foreach($projektStatusObjects as $projektStatus)
                                <option value="{{ $projektStatus->id }}" {{ old('projekt_status_id') == $projektStatus->id ? 'selected' : '' }}>{{ $projektStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('projekt_status_id'))
                            <span class="text-danger">Projektstatus wählen</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        {{Form::label('notiz','Notiz',['class' => 'col-sm-3 col-form-label'])}}
                        <div class="col-sm-8">
                            {{Form::textarea('notiz','', ['class' => 'form-control', 'rows' => 4, 'placeholder' =>'100 Zeichen für Infos'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- start card Motor-, Getriebe- und Flanschdaten im Projekt -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h4 class="card-title mb-4">Motor</h4>
                        </div>
                        </div>   
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <select name="motor" id="motor" class="form-control">
                                <option value="">----</option>
                                <option value="" disabled>Motor wählen</option>
                                @foreach($motoren as $motor)
                                <option value="{{ $motor->id }}" {{ old('motor') == $motor->id ? 'selected' : '' }}>{{ $motor->kunde }} / {{$motor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start card Flanschdaten im Projekt -->
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title mb-4">Flanschmaße</h4>
                        </div>
                        </div>   
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <select name="motorFlansch" id="motorFlansch" class="form-control">
                                <option value="" disable="true" selected="true">=== Wähle Flansch ===</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
{{Form::submit('speichern', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}    

<script type="text/javascript">

    $(document).ready(function() {

        $('select[name="motor"]').on('change', function() {
            var motorID = $(this).val();
            if(motorID) {
                $.ajax({
                    url: '/projekte/create/json-motorFlansch/'+motorID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="motorFlansch"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="motorFlansch"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="motorFlansch"]').empty();
            }
        });
    });

</script>
@endsection

@include('projekte.modalGeraeteklasse')
@include('projekte.modalFluggeraet')