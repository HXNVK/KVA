<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <div class="row" style="background-image: url('/images/hintergrund.jpg')">
            <div class="col-sm-6">
                <!-- Required meta tags -->
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                <!-- CSRF Token -->
                <meta name="csrf-token" content="{{ csrf_token() }}">
                
                <!-- Scripts --> 
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
                {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}

                <!-- Styles -->
                <link href="{{ asset('css/app.css') }}" rel="stylesheet">


                <!-- Fonts -->
                <link rel="dns-prefetch" href="//fonts.gstatic.com">
                <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

                <link href="{{ URL::asset('public/css/bootstrap.css')}}" id="bootstrap-light" rel="stylesheet" type="text/css" />
                <link href="{{ URL::asset('public/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
                <link href="{{ URL::asset('public/css/app.min.css')}}" id="app-light" rel="stylesheet" type="text/css" />
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
        <main class="container-fluid panel-body">
            <div class="container">

                <h1>Esp Data</h1>
                {{-- <a href="/espData/create" class="btn btn-success">
                    <span class="oi" data-glyph="plus" title="neu" aria-hidden="true"></span>
                </a> --}}
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <td>ID</td> 
                        <td>SensorData</td> 
                        <td>LocationData</td> 
                        <td>Value 1</td> 
                        <td>Value 2</td>
                        <td>Value 3</td> 
                        <td>Timestamp</td> 
                    </tr>
                    @if(count($espDataObj) > 0)
                        @foreach($espDataObj as $espData)
                            <td>{{ $espData->SensorData }}</td>
                            <td>{{ $espData->LocationData }}</td>
                            <td>{{ $espData->value1 }}</td>
                            <td>{{ $espData->value2 }}</td>
                            <td>{{ $espData->value3 }}</td>
                            <td>{{ $espData->reading_time }}</td>
                        @endforeach
                    @else
                        <p>Keine Daten vorhanden!!!</p>
                    @endif
                </table>

            </div>
        </main>
    </body>
</html>
