@extends('layouts.live')

@section('appScript')
<script src="{{ asset('js/live_app.js') }}" defer></script>
@endsection

@section('content')

<div class="container h-100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div> 
    </div> 
    @if ( !Auth::user()->admin )
    <div class="row justify-content-center">       
        <div class="col-md-12">
            <card title="You are not authorized to view this content"></card>
        </div>
    </div>
    @else

    <div class="row justify-content-center h-100">

        @if ( $layout == 'standby' )   
        <div class="col-md-8 my-auto">
            <card title="Live Scoring">
                <h2 style="align-middle">No Active Entry</h2>
                <script>
                    setInterval( function() {
                        window.location.reload();
                    }, 10000);
                </script>
            </card>
        </div>
        @elseif ( $layout == 'active' )
        <div class="col-md-8 my-auto">
            <card title="Now Performing">
                <h2 style="font-size: 100px;">Entry <span style="font-size: 50%;">#</span>{{ $code }}</h2>

                <script>
                    setInterval( function() {
                        window.location.reload();
                    }, 15000);
                </script>
            </card>
        </div>
        @elseif ( $layout == 'showscores' )
        <div class="col-md-12 my-auto w-100">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <img src="{{ asset('images/abap_logo_trans.png') }}" class="w-25 d-inline-block" style="max-width: 150px;">
                    <h3 class="d-inline-block" style="font-size: 42px; text-shadow: 0 3px 3px rgba(0,0,0,0.25)"><span class="text-secondary">{{ $category->code }}</span> <span class="text-primary">|</span> {{ $category->name }}</h3>
                </div>
                <div id="livescores" class="card-body py-0">
                    <div class="row">
                        <div class="col-md-12 my-auto text-center">
                            <span class="h4 d-inline-block position-absolute text-primary w-100" style="font-weight: bold; top: 100px; left: 0;">Entry</span>
                            <p class="mb-0" style="font-size: 80px; font-weight: bold;"><span style="font-size: 25%;">#</span>{{ $code }}</p>
                            
                        </div>
                    </div>
                    <div class="row h-50">
                        <div class="col-md-4 my-auto text-center">
                            <h2 class="h1 score">{{ $judge_a }}</h2>
                            <div class="card-body">
                                <p class="h3">Judge A</p>
                            </div>
                        </div>

                        <div class="col-md-4 my-auto text-center">
                            <h2 class="h1 score">{{ $judge_b }}</h2>
                            <div class="card-body">
                                <p class="h3">Judge B</p>
                            </div>
                        </div>

                        <div class="col-md-4 my-auto text-center">
                            <h2 class="h1 score">{{ $judge_c }}</h2>
                            <div class="card-body">
                                <p class="h3">Judge C</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    @endif
</div>

@endsection