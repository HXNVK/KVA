<!DOCTYPE html>
<html lang="en">
    <head>
        <div class="row" style="background-image: url('/images/hintergrund.jpg')">
            <div class="col-sm-6">
                <!-- Required meta tags -->
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                <!-- CSRF Token -->
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <!-- Fonts -->
                <link href="/open-iconic/font/css/open-iconic.css" rel="stylesheet">

                <link rel="shortcut icon" type="image/x-icon" href="/images/propellerFavicon.ico" />
                
                <img src = "/images/logo_helix_header.png" class="img-rounded" style="max-width: 20%">
            </div>
            <div class="col-sm-6">
                <h2>{{ config('app.name', 'Laravel') }}</h2>
            </div>
        </div>
    </head>

    <body>
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        
        <div class="row" style="background-color: rgb(0, 0, 0)">
            <div class="col-lg-2 ml-3">
                {{-- {!! Form::open(['url' => '#', 'method' => 'get']) !!}
                {!! Form::text('suche', null, ['class' => 'search-input', 'placeholder' => 'Super-Suche...']) !!}
                {!! Form::button('<span class="oi" data-glyph="magnifying-glass" title="Suchen" aria-hidden="true"></span>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                {!! Form::close() !!}     --}}
            </div>
            <div class="col-lg-12">
                @include('internals.nav')
            </div>
        </div>
        <div class="row">
            @include('internals.messages')
        </div>
        <main class="container-fluid panel-body">

            <!-- Bootstrap CSS -->
            <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

            @yield('content')

        </main>
    </body>
</html>
