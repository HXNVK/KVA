@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>HELIX Propeller Formen Matrix nach Geometrieklassen</h1>
        <div class="row">
          <div class="col-3">
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF25_0L')}}" class="btn-lg btn-primary">GF25-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF26_0L')}}" class="btn-lg btn-primary">GF26-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF30_0L')}}" class="btn-lg btn-primary">GF30-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF31_0L')}}" class="btn-lg btn-primary">GF31-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF40_0L')}}" class="btn-lg btn-primary">GF40-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF45_0L')}}" class="btn-lg btn-primary">GF45-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF50_0L')}}" class="btn-lg btn-primary">GF50-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>          
          </div>
          <div class="col-3">
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGK30_0L')}}" class="btn-lg btn-primary">GK30-0 L
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
          </div>
          <div class="col-3">
            <div class="float-sm-right-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF25_0R')}}" class="btn-lg btn-danger">GF25-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-right-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF26_0R')}}" class="btn-lg btn-danger">GF26-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-right-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF30_0R')}}" class="btn-lg btn-danger">GF30-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-right-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF31_0R')}}" class="btn-lg btn-danger">GF31-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-right-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF40_0R')}}" class="btn-lg btn-danger">GF40-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-right-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF45_0R')}}" class="btn-lg btn-danger">GF45-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
            <div class="float-sm-right-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGF50_0R')}}" class="btn-lg btn-danger">GF50-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
          </div>
          <div class="col-3">
            <div class="float-sm-left-4 p-4">
              <a href="{{action('PropellerFormMatritzenController@indexGK30_0R')}}" class="btn-lg btn-danger">GK30-0 R
                <span class="oi" data-glyph="collapse-down" title="view"></span>
              </a>
            </div>
          </div>
        </div>

        

@endsection