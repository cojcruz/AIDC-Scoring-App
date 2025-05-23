@extends('layouts.scoring')

@section('appScript')
    <script src="{{ asset('js/judgescoring_app.js') }}"></script>

    @if ( $status == 'active' ) 
    <style>
        #app, #app main {
            height: 100vh !important;
        }
        #app main {
            display: flex;
        }
        #app main > .row {
            align-items: center;
        }
        #app main .fineTune {
            font-weight: bold;
        }
    </style>
    <script src="{{ asset('js/jquery.stopwatch.js') }}"></script>
    <script>
        jQuery( function($) {
            $(document).ready(function() {
                let catA = 65;
                let catB = 65;
                let catC = 65;
                let catD = 65;

                // Fine Tune Scores
                $('.fineTune').on("click", function() {
                    let func = $(this).data("function");
                    let target = $("#" + $(this).data('target'));
                    let value = new Number( target.val() );
                    let step = new Number( 0.05 );
                    let newValue = func == "add" ? value + step : value - step;

                    target.val( newValue ).trigger('input');

                });

                $('#technique').on('input', function() {
                    let score = Number( $(this).val() ).toFixed(2);

                    $('#techNumber').html( score ) ;
                    catA = new Number( score );
                    
                    sumUp();
                });

                $('#artistry').on('input', function() {
                    let score = Number( $(this).val() ).toFixed(2);

                    $('#artNumber').html( score ) ;
                    catB = new Number( score );
                    
                    sumUp();
                });
                
                $('#musicality').on('input', function() {
                    let score = Number( $(this).val() ).toFixed(2);

                    $('#musicNumber').html( score ) ;
                    catC = new Number( score );
                    
                    sumUp();
                });
                
                $('#costume').on('input', function() {
                    let score = Number( $(this).val() ).toFixed(2);

                    $('#costNumber').html( score ) ;
                    catD = new Number( score );

                    sumUp();
                });


                // Add up all categories 
                function sumUp() {
                    let score = new Number( ( catA * 0.4 ) + ( catB * 0.4 ) + ( catC * 0.15 ) + ( catD * 0.05 ) ).toFixed( 2 );
                    
                    $('#totalScore').val(score);
                }

                // Checksum if active entry is correct
                let i = 0;
                
                function validateEntry() {
                    $.ajax({
                        type: 'POST',
                        data: {
                            _token  : '{{ csrf_token() }}',
                            code    : '{{ $entrycode->code }}',
                        },
                        url: "{{ route('score.validateEntry') }}",
                        success: function( data ) {
                            console.log('success');                                
                            if ( i <= 15 ) {
                                ++i;

                                setTimeout( validateEntry, 2000 );
                            } else {
                                console.log('validation done');
                            }
                        }, 
                        error: function() {
                            console.log('failure');
                            window.location.reload();                                
                        }, 
                        dataType: 'json'
                    });
                }

                validateEntry();

                // Voice Recording Script
                let complete = false;

                @if ( !$check )
                $('#stopwatch').stopwatch().stopwatch('start');

                $(window).bind('beforeunload', function() {
                    if ( !complete ) {
                        return "Leaving would lose existing voice recording.";
                    }
                });

                // Voice Recorder Init
                const handleSuccess = function(stream) {
                    const options = {mimeType: 'audio/webm;codecs=opus'};
                    const recordedChunks = [];
                    const mediaRecorder = new MediaRecorder(stream);

                    mediaRecorder.addEventListener('dataavailable', function(e) {
                        if (e.data.size > 0) recordedChunks.push(e.data);
                    });

                    mediaRecorder.addEventListener('stop', function() {
                        let fd = new FormData();
                        let audio = new Blob(recordedChunks); 
                        let oReq = new XMLHttpRequest();

                        fd.append('_token', '{{ csrf_token() }}');
                        fd.append('file', audio);
                        fd.append('entryCode', '{{ $entrycode->code }}');
                        fd.append('catCode', '{{ $catcode }}');
                        fd.append('judge', '{{ Auth::user()->id }}');

                        console.log('test')

                        oReq.open('POST', '{{ route('upload.recording') }}', false);
                        oReq.onload = function( oEvent ) {
                            //
                        }

                        oReq.send(fd);
                    });

                    mediaRecorder.start();

                    // Scoring Input Init    
                    let entry;                    

                    $('#submit').click( function() {
                        if ( Number($('#totalScore').val()) > 65 ) {
                            entry = $('#totalScore').val();
                            $('#confirmScore').modal('show');
                            $('#catA').val( catA );
                            $('#catB').val( catB );
                            $('#catC').val( catC );
                            $('#catD').val( catD );
                            $('#score').val( entry );
                        } else {
                            alert( 'Please enter score.' );
                        }
                    });

                    $('#savescore').click( function() {
                        complete = true;
                        mediaRecorder.stop();
                        $('#stopwatch').stopwatch().stopwatch('stop');
                        $('#submitModalForm').submit();

                        $('#footer-buttons').addClass('d-none').removeClass('d-block');
                        $('#progress').removeClass('d-none').addClass('d-block');
                    });

                };
                // Init Mic Recording
                navigator.mediaDevices.getUserMedia({ 
                        audio: true, 
                        video: false 
                    })
                    .then(handleSuccess);
                @endif
            });
        });
    </script>

    @else 

    <script>
        // setInterval(function() {
        //     window.location.reload();
        // }, 2000);

        jQuery( function($) {
            $(document).ready( function() {
                function checkActive() {
                    setInterval( function() {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('score.checkActive') }}",
                            data: {
                                _token : '{{ csrf_token() }}',
                            },
                            success: function( data ) {
                                console.log('success');
                                window.location.reload();
                            }, 
                            error: function() {
                                console.log('failure');                               
                            }, 
                            dataType: 'json'
                        })
                    }, 2000);
                }

                checkActive();
            });
        })
    </script>

    @endif
@endsection

@section('content')
<div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-12 align-items-center">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center">
                    @if ( $status == 'standby' ) 
                        Live Scoring
                    @else
                        <span class="d-block mx-auto text-primary">Category: <span class="text-secondary">{{ $catcode }}</span></span>
                        Entry <span style="font-size: 50%;" class="d-inline-block">#</span>{{ substr($entrycode->code, 2) }}                            
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @if ( $status == 'standby' )
                <div class="row align-items-center">
                    <div class="col-12">
                        <h2 class="text-center">
                            @if ( $check )
                                Entry <span style="font-size: 50%;">#</span>{{ $check->code }}<br>
                                Score: <span class="text-primary display-3">{{ $check->score }}</span>
                            @else 
                                Waiting for Active Contestant
                            @endif
                        </h2>
                    </div>
                @else

                    @if ( !$check )
                        <div class="row justify-content-center">
                            <div class="col-md-10 mx-auto">
                                <div class="mx-auto text-center w-100">
                                    <h6 class="display-6 d-inline-block">
                                        <div class="spinner-grow text-danger" role="status"><span class="visually-hidden">
                                            Loading...</span>
                                        </div> 
                                        Recording ( <div class="d-inline-block" id="stopwatch">00:00:00</div> )
                                    </h6>
                                </div>
                                <form method="post" id="entryscore">
                                    <div class="row">
                                        <div class="col-md-6 p-4">
                                            <div class="row mb-1 align-items-center" >
                                                <div class="col-md-8">
                                                    <label for="technique" class="display-6">Technique</label>                                                    
                                                    <input type="range" min="65" max="100" step="0.05" value="65.00" name="technique" class="w-100 slider form-range mt-2 d-block" id="technique">
                                                    
                                                    <div class="btn-group w-100 my-3" role="group">
                                                        <input class="btn btn-info fineTune w-25 d-inline-block" data-function="sub" data-target="technique" type=button value="-">
                                                        <input class="btn btn-primary fineTune w-25 d-inline-block" data-function="add" data-target="technique" type=button value="+">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div id="techNumber" class="display-5 border scorelabel py-2">65.00</div>
                                                    <!-- <sub class="text-center d-block mt-2">Max Score of 40</sub> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 p-4">
                                            <div class="row mb-1 align-items-center">
                                                <div class="col-md-8">
                                                    <label for="artistry" class="display-6">Artistry</label>
                                                    <input type="range" min="65" max="100" step="0.05" value="65.00" name="artistry" class="w-100 slider form-range mt-2 d-block" id="artistry">
                                                   
                                                    <div class="btn-group w-100 my-3" role="group">
                                                        <input class="btn btn-info fineTune w-25 d-inline-block" data-function="sub" data-target="artistry" type=button value="-">
                                                        <input class="btn btn-primary fineTune w-25 d-inline-block" data-function="add" data-target="artistry" type=button value="+">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div id="artNumber" class="display-5 border scorelabel py-2">65.00</div>
                                                    <!-- <sub class="text-center d-block mt-2">Max Score of 40</sub> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 p-4">
                                            <div class="row mb-1 align-items-center">
                                                <div class="col-md-8">
                                                    <label for="musicality" class="display-6">Musicality</label>
                                                    <input type="range" min="65" max="100" step="0.05" value="65.00" name="musicality" class="w-100 slider form-range mt-2 d-block" id="musicality">
                                                    <div class="btn-group w-100 my-3" role="group">
                                                        <input class="btn btn-info fineTune w-25 d-inline-block" data-function="sub" data-target="musicality" type=button value="-">
                                                        <input class="btn btn-primary fineTune w-25 d-inline-block" data-function="add" data-target="musicality" type=button value="+">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div id="musicNumber" class="display-5 border scorelabel py-2">65.00</div>
                                                    <!-- <sub class="text-center d-block mt-2">Max Score of 15</sub> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 p-4">
                                            <div class="row mb-1 align-items-center">
                                                <div class="col-md-8">
                                                    <label for="costume" class="display-6">Costume</label>
                                                    <input type="range" min="65" max="100" step="0.05" value="65.00" name="costume" class="w-100 slider form-range mt-2 d-block" id="costume">
                                                    <div class="btn-group w-100 my-3" role="group">
                                                        <input class="btn btn-info fineTune w-25 d-inline-block" data-function="sub" data-target="costume" type=button value="-">
                                                        <input class="btn btn-primary fineTune w-25 d-inline-block" data-function="add" data-target="costume" type=button value="+">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div id="costNumber" class="display-5 border scorelabel py-2">65.00</div>
                                                    <!-- <sub class="text-center d-block mt-2">Max Score of 5</sub> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-8">
                                            <label for="totalScore" class="display-4">Total Score</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" maxlength="5" name="totalScore" id="totalScore" class="display-2 float-end w-100 text-center" value="65.00" readonly />
                                        </div>
                                    </div>
                                </form>
                                <div class="submit_wrapper px-2 text-center">
                                    <button id="submit" class="submit btn btn-primary w-75 mx-auto">Submit</button>
                                </div>            
                            </div>
                        </div>            
                    @else 
                        <h2 class="text-center">
                            Entry <span style="font-size: 50%;">#</span>{{ $check->code }}<br>
                            Score <span class="text-primary display-3 align-middle">{{ $score }}</span>
                        </h2>
                        <script>
                            setInterval(function() {
                                window.location.reload();
                            }, 2000);
                        </script>
                    @endif

                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<!-- Confirm Score -->
<div class="modal fade" id="confirmScore" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Entry Score?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <form action="{{ route('savescore') }}" method="post" id="submitModalForm">
            @csrf
            <input type="hidden" name="code" value="{{ $entrycode->code }}">
            <input type="hidden" name="judge" value="{{ Auth::user()->id }}">
            <input type="hidden" name="category" value="{{ $catcode }}"> 
            <div class="row align-items-center">
                <div class="col-md-3 text-center fw-bold">
                    <input type="text" class="form-control text-center fw-bold" readonly name="technique" id="catA"> 
                    <label>Technique</label>
                </div>
                <div class="col-md-3 text-center fw-bold">
                    <input type="text" class="form-control text-center fw-bold" readonly name="artistry" id="catB"> 
                    <label>Artistry</label>
                </div>
                <div class="col-md-3 text-center fw-bold">
                    <input type="text" class="form-control text-center fw-bold" readonly name="musicality" id="catC"> 
                    <label>Musicality</label>
                </div>
                <div class="col-md-3 text-center fw-bold">
                    <input type="text" class="form-control text-center fw-bold" readonly name="costume" id="catD">
                    <label>Costume</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center fw-bold">
                    <input type="text" name="score" readonly id="score" class="confirmScore form-control">
                    <label class="fs-1">Score</label>
                </div>
            </div>
        </form>

        </div>
        <div class="modal-footer">
            <div id="footer-buttons" class="d-block btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Change Score</button>
                <button type="button" id="savescore" class="btn btn-primary">Save Score</button>
            </div>
            <div id="progress" class="w-100 d-none text-center">
             <h4><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="40" height="40"><rect fill="#FF156D" stroke="#FF156D" stroke-width="15" width="30" height="30" x="25" y="85"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></rect><rect fill="#FF156D" stroke="#FF156D" stroke-width="15" width="30" height="30" x="85" y="85"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></rect><rect fill="#FF156D" stroke="#FF156D" stroke-width="15" width="30" height="30" x="145" y="85"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></rect></svg> Saving scores, please wait</h4>
            </div>
        </div>
    </div>
  </div>
</div>  
@endsection