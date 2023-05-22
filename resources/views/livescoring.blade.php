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
                <h2 style="align-middle">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div> 
                    No Active Entry</h2>
                <script>
                    setInterval( function() {
                        window.location.reload();
                    }, 10000);
                </script>
            </card>
        </div>
        @elseif ( $layout == 'active' )
        <div class="col-md-12 my-auto">
            <card title="Now Performing" class="shadow-lg">
                <div class="row justify-content-center">
                    <div class="col-lg-3 text-end">
                        <img src="{{ asset('images/cbap_logo.png') }}" class="rounded img-fluid">
                    </div>
                    <div class="col-lg-9 d-flex align-items-center">
                        <h1 class="display-1 text-primary w-100 text-center font-weight-bold" style="font-size: 1000%;text-shadow: 3px 3px 3px rgba(0,0,0,.25);">Entry <span style="font-size: 50%; vertical-align: middle;">#</span>{{ $code }}</h1>
                    </div>
                
                <script>
                    setInterval( function() {
                        window.location.reload();
                    }, 15000);
                </script>
            </card>
        </div>
        @elseif ( $layout == 'showscores' )
        <div class="col-md-12 my-auto w-100">
            <div class="card h-100 rounded shadow-lg">
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col-md-4 text-center py-3">
                            <img src="{{ asset('images/cbap_logo.png') }}" class="w-75 img-fluid">
                        </div>
                        <div class="col-md-8">
                            <h2 class="text-primary display-3 text-end">{{ $entry->entry_name }}</h2>
                            <h4 class="display-6 text-end">{{ $category->name }} | {{ $category->code }}</h4>  
                            <h4 class="display-6 text-end w-100" style="font-weight: bold; top: 100px; left: 0;">Entry <span style="font-size: 75%;">#</span>{{ $code }}</h4>                          
                        </div>
                    </div>
                </div>
                <div id="livescores" class="card-body p-0 border-0">
                    @php
                        $judges = array($judge_a, $judge_b, $judge_c);

                        shuffle($judges);
                        $i = 1;
                    @endphp
                    <div class="card-group">
                        @foreach ( $judges as $judge )                        
                        <div class="card text-center border border-black">
                            <h5 class="card-title bg-primary display-6 text-white py-2">Judge {{ $i++ }}</h5>

                            <div class="card-body py-5">
                                <h2 class="score display-3">{{ $judge }}</h2>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @php
                        $average = round( ( (int)$entry->judge_a + (int)$entry->judge_b + (int)$entry->judge_c) / 3, 2); // Compute for Average Score
                    @endphp
                    <div class="card-footer border text-bg-primary">
                        <h4 class="fw-bold text-center display-5">Average</h4>
                        <h2 class="score h1 display-1 text-center">{{ $average }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    @endif
</div>

@endsection