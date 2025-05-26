@extends('layouts.live')

@section('appScript')
<script src="{{ asset('js/live_app.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

@if ( $layout == 'active' )
<script>
    jQuery(function($) {
        $(document).ready(function(){
            $('#nowPerforming').delay(3000).fadeOut();

            setInterval( function() {
                $('body').addClass('showBg');
            }, 3000);

            setInterval( function() {
                $.ajax({
                    type    : "POST",
                    url     : '{{ route('score.validation') }}',
                    data    : { 
                        _token  : '{{ csrf_token() }}', 
                        code    : '{{ $code }}'
                    },
                    success : function(response) {
                        window.location.reload();                    
                    },
                    error   : function(response) {
                        console.log('no scores entered yet.');
                    }
                });
            }, 250);

            setInterval( function() {
                $.ajax({
                    type    : "POST",
                    url     : '{{ route('livescoring.checkMatch') }}',
                    data    : {
                        _token  : '{{ csrf_token() }}',
                        code    : '{{ $code }}',                                
                    },
                    success     : function(response) {
                        console.log('Active Match');
                    },
                    error       : function(response) {
                        window.location.reload();
                    }
                });
            }, 250);
        })
    });
</script>
@endif
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
                <!-- <h2 style="align-middle">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div> 
                    No Active Entry</h2> -->
                <script>
                    jQuery( function($) {
                        $(document).ready( function() {
                            function checkActive() {
                                $.ajax({
                                    type    : 'POST',
                                    url     : "{{ route('livescoring.checkActive') }}",
                                    data    : {
                                        _token : "{{ csrf_token() }}",
                                    },
                                    success : function( request ) {
                                        window.location.reload();
                                    },
                                    error   : function( request ) {
                                        setTimeout( checkActive , 2000 );
                                    }
                                })
                            }

                            checkActive();

                            $('body').addClass('showBg');
                        });
                    });
                </script>
            </card>
        </div>
        @elseif ( $layout == 'active' )
        <div id="nowPerforming" class="col-md-12 my-auto">
            <card title="Now Performing" class="shadow-lg">
                <div class="row justify-content-center">
                    <div class="col-lg-3 text-end">
                        <img src="{{ asset('images/cbap_logo.png') }}" class="rounded img-fluid">
                    </div>
                    <div class="col-lg-9 d-flex align-items-center">
                        <h1 class="display-1 text-primary w-100 text-center font-weight-bold" style="font-size: 1000%;text-shadow: 3px 3px 3px rgba(0,0,0,.25);">Entry <span style="font-size: 50%; vertical-align: middle;">#</span>{{ substr($code, 2) }}</h1>
                    </div>
                </div>
            </card>
        </div>
        @elseif ( $layout == 'showscores' )
        <script>
            jQuery( function($) {
                $(document).ready(function(){
                    // setInterval( function() {
                    //     $.ajax({
                    //         type    : "POST",
                    //         url     : '{{ route('livescoring.checkActive') }}',
                    //         data    : { 
                    //             _token  : '{{ csrf_token() }}', 
                    //             code    : '{{ $code }}',
                    //             scores  : true
                    //         },
                    //         success : function(response) {
                    //             window.location.reload();                    
                    //         },
                    //         error   : function(response) {
                    //             console.log('no scores entered yet.');
                    //         }
                    //     });
                    // }, 250);

                    setInterval( function() {
                        $.ajax({
                            type    : "POST",
                            url     : '{{ route('livescoring.checkMatch') }}',
                            data    : {
                                _token  : '{{ csrf_token() }}',
                                code    : '{{ $code }}',                                
                            },
                            success     : function(response) {
                                console.log('Active Match');
                            },
                            error       : function(response) {
                                window.location.reload();
                            }
                        });
                    }, 250);

                    setInterval( function() {
                        $('#scoreContainer').hide();
                        $('body').addClass('showBg');
                    }, 5000);
                })
            });
        </script>
        <div id="scoreContainer" class="col-md-12 my-auto w-100">
            <div class="card h-100 rounded shadow-lg">
                <div class="card-header bg-light">
                    <div class="row">
                        <div class="col-md-4 text-center py-3">
                            <img src="{{ asset('images/cbap_logo.png') }}" class="w-75 img-fluid">
                        </div>
                        <div class="col-md-8">
                            <h2 class="text-primary display-3 text-end">{{ $entry->entry_name }}</h2>
                            <h4 class="display-6 text-end">{{ $category->name }} | {{ $category->code }}</h4>  
                            <h4 class="display-6 text-end w-100" style="font-weight: bold; top: 100px; left: 0;">Entry <span style="font-size: 75%;">#</span>{{ substr($code, 2) }}</h4>                          
                        </div>
                    </div>
                </div>
                <div id="livescores" class="card-body p-0 border-0">
                    @php
                    
                        $judges = array($judge_a, $judge_b, $judge_c);

                        shuffle($judges);
                    
                        $average = round( ( (float)$entry->judge_a + (float)$entry->judge_b + (float)$entry->judge_c) / 3, 2); // Compute for Average Score
                        
                    @endphp
                    <div class="card-footer border text-bg-primary">
                        <h4 class="fw-bold text-center display-5">Average</h4>
                        <h2 class="score h1 display-1 text-center">{{ $average }}</h2>
                    </div>
                    <div class="card-group">
                        @foreach ( $judges as $judge )                        
                        <div class="card text-center border border-black">

                            <div class="card-body py-5">
                                <h2 class="score display-3">{{ (float)$judge <= 65 ? 65 : $judge }}</h2>
                            </div>

                            <h5 class="card-title bg-primary display-6 text-white py-0 my-0">Judge</h5>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    @endif
</div>

@endsection