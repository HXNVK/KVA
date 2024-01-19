{{-- Warndreieck-Zeichen für Dringlichkeiten --}}
@if($auftrag->dringlichkeit != NULL)
    <span class="oi" data-glyph="warning" title="zum Auftrag" aria-hidden="true"></span>
@endif
{{-- Euro-Zeichen für Bezahlt Status --}}
@if($auftrag->auftrag_bezahltstatus == 1)
    <span class="oi" data-glyph="euro" title="zum Auftrag" aria-hidden="true"></span>
@endif
{{-- Euro-Zeichen für Testpropeller --}}
@if($auftrag->testpropeller == 1)
    <span class="oi" data-glyph="text" title="zum Auftrag" aria-hidden="true"></span>
@endif
{{-- Schraubenschlüssel-Zeichen  für Reparaturen --}}
@if($auftrag->auftrag_typ_id == 3)
    @if($auftrag->dringlichkeit == NULL)
        @if($auftrag->ets == NULL)
            <span class="oi" data-glyph="wrench" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{$auftrag->teilauftrag}})</small></span>
        @else
            <span class="oi" data-glyph="wrench" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{$auftrag->teilauftrag}})__{{ $auftrag->ets }}</small></span>
        @endif
    @else
        <span class="oi" data-glyph="wrench" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{$auftrag->teilauftrag}})__{{ $auftrag->dringlichkeit }}</small></span>
    @endif
@endif
{{-- Pfeil Rückwärts bei Retouren und Reklamationen --}}   
@if($auftrag->auftrag_typ_id == 2 || $auftrag->auftrag_typ_id == 4)
    @if($auftrag->dringlichkeit == NULL)
        @if($auftrag->ets == NULL)
            <span class="oi" data-glyph="action-undo" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }}</small></span>
        @else
            <span class="oi" data-glyph="action-undo" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} __{{ $auftrag->ets }}</small></span>
        @endif
    @else
        <span class="oi" data-glyph="action-undo" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} __{{ $auftrag->dringlichkeit }}</small></span>
    @endif
@endif
{{-- Warenkorb-Zeichen bei Zubehör --}}   
@if($auftrag->auftrag_typ_id == 5 || $auftrag->auftrag_typ_id == 6)
    @if($auftrag->dringlichkeit == NULL)
        @if($auftrag->ets == NULL)
            <span class="oi" data-glyph="cart" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{$auftrag->teilauftrag}})</small></span>
        @else
            <span class="oi" data-glyph="cart" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{$auftrag->teilauftrag}})__{{ $auftrag->ets }}</small></span>
        @endif
    @else
        <span class="oi" data-glyph="cart" title="zum Auftrag" aria-hidden="true"> {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{$auftrag->teilauftrag}})__{{ $auftrag->dringlichkeit }}</small></span>
    @endif
@endif
{{-- Standardauftrag --}} 
@if($auftrag->auftrag_typ_id == 1)
    @if($auftrag->dringlichkeit == NULL)
        @if($auftrag->ets == NULL)
            {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{ $auftrag->anzahl}} - {{$auftrag->teilauftrag}})</small>
        @else
            {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{ $auftrag->anzahl}} - {{$auftrag->teilauftrag}})__{{ $auftrag->ets }}</small>
        @endif
    @else
        {{ $auftrag->id }} / <small>{{ $auftrag->kundeMatchcode }} ({{ $auftrag->anzahl}} - {{$auftrag->teilauftrag}})__{{ $auftrag->dringlichkeit }}</small>
    @endif
@endif
    

                                 