@if (count($errors) > 0)
<ul>       
        @foreach ($errors->all() as $e)
        <div class="alert alert-danger">
            <li>{{ $e }}</li>
        </div>
        @endforeach
</ul>
@endif


@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-error">
        {{ Session::get('error') }}
        @php
            Session::forget('error');
        @endphp
    </div>
@endif


@if(session()->has('success_msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session()->get('success_msg') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif

@if(session()->has('alert_msg'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session()->get('alert_msg') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif

{{-- @if(count($errors) > 0)
@foreach($errors0>all() as $error)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endforeach
@endif --}}