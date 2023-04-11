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
    </style>
    <script src="{{ asset('js/jquery.stopwatch.js') }}"></script>
    <script>

        jQuery( function($) {
            $(document).ready(function() {
                var complete = false;

                @if ( !$check )
                $('#stopwatch').stopwatch().stopwatch('start');

                $(window).bind('beforeunload', function() {
                    if ( !complete ) {
                        return "Leaving would loss existing voice recording.";
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
                        var fd = new FormData();
                        var audio = new Blob(recordedChunks); 
                        var oReq = new XMLHttpRequest();

                        fd.append('_token', '{{ csrf_token() }}');
                        fd.append('file', audio);
                        fd.append('entryCode', '{{ $entrycode->code }}');
                        fd.append('catCode', '{{ $catcode }}');
                        fd.append('judge', '{{ Auth::user()->id }}');

                        oReq.open('POST', '{{ route('upload.recording') }}', true);
                        oReq.onload = function( oEvent ) {
                            //
                        }

                        oReq.send(fd);
                    });

                    mediaRecorder.start();

                    // Scoring Input Init    
                    var entry;

                    $('.numpad').click( function() {
                        var value = $(this).data('value');
                        
                        entry = $('#Entry').val();

                        if ( value == 'CLR' ) {
                            entry = entry.substring(0, entry.length -1);
                            $('#Entry').val( entry );
                        } else {
                            entry = entry + value;
                            $('#Entry').val( entry );
                            $('#score').val( entry );
                        }
                    });

                    $('#submit').click( function() {
                        if ( $('#Entry').val() ) {
                            $('#confirmScore').modal('show');
                            $('#score').val( entry );
                        } else {
                            alert('Please enter score.')
                        }
                    });

                    $('#savescore').click( function() {
                        complete = true;
                        mediaRecorder.stop();
                        $('#stopwatch').stopwatch().stopwatch('stop');
                        $('#submitModalForm').submit();
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
        setInterval(function() {
            window.location.reload();
        }, 2000);
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
                        Entry <span style="font-size: 50%;" class="d-inline-block">#</span>{{ $entrycode->code }}                            
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
                            <div class="col-md-6 mx-auto">
                                <div class="mx-auto text-center w-100">
                                    <h6 class="display-6 d-inline-block">
                                        <div class="spinner-grow text-danger" role="status"><span class="visually-hidden">Loading...</span></div> Recording (
                                        <div class="d-inline-block" id="stopwatch">00:00:00</div>
                                        )
                                    </h6>
                                </div>
                                <form method="post" id="entryscore">
                                    <input type="text" maxlength="5" id="Entry" class="input" readonly />
                                </form>
                                <div class="numpad_wrapper" style="display: flex; flex-wrap: wrap; justify-content: center;">
                                    <button class="btn btn-light numpad" data-value='1'>1</button>
                                    <button class="btn btn-light numpad" data-value='2'>2</button>
                                    <button class="btn btn-light numpad" data-value='3'>3</button>
                                    <button class="btn btn-light numpad" data-value='4'>4</button>
                                    <button class="btn btn-light numpad" data-value='5'>5</button>
                                    <button class="btn btn-light numpad" data-value='6'>6</button>
                                    <button class="btn btn-light numpad" data-value='7'>7</button>
                                    <button class="btn btn-light numpad" data-value='8'>8</button>
                                    <button class="btn btn-light numpad" data-value='9'>9</button>
                                    <button class="btn btn-light numpad" data-value='.'>.</button>
                                    <button class="btn btn-light numpad" data-value='0'>0</button>
                                    <button class="btn btn-light numpad" data-value='CLR'><i class="material-icons">backspace</i></button>
                                </div>
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
                            }, 5000);
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
            <input type="text" name="score" readonly id="score" class="confirmScore form-control">
        </form>

        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Change Score</button>
                <button type="button" id="savescore" class="btn btn-primary">Save Score</button>
            </div>
        </div>
    </div>
  </div>
</div>  
@endsection