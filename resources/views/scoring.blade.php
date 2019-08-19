@extends('layouts.scoring')

@section('appScript')
    <script src="{{ asset('js/judgescoring_app.js') }}"></script>

    @if ( $status == 'active' ) 
    
    <script>
        jQuery( function($) {
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
                $('#myModal').modal();
                $('#score').val( entry );
            });

            $('#savescore').click( function() {
                $('#submitModalForm').submit();
            });
        });
    </script>

    @else 
    <script>
        setInterval(function() {
            window.location.reload();
        }, 5000);
    </script>

    @endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

                    <h2 class="text-center">
                        @if ( $check )
                            Entry <span style="font-size: 50%;">#</span>{{ $check->code }}<br>
                            Score {{ $check->score }}
                        @else 
                            Waiting for data...
                        @endif
                    </h2>
                    
                    @else
                        @if ( !$check )
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <form method="post" id="entryscore">
                                        <input type="text" maxlength="5" id="Entry" class="input" readonly />
                                    </form>
                                    </div>
                                </div>
                        	</div>
                            <div class="numpad_wrapper">
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
                            <div class="submit_wrapper">
                                <button id="submit" class="submit btn btn-primary">Submit</button>
                            </div>
                        @else 
                            <h2 class="text-center">
                                Entry <span style="font-size: 50%;">#</span>{{ $check->code }}<br>
                                Score {{ $score }}
                            </h2>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<!-- Confirm Score -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Entry Score?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('savescore') }}" method="post" id="submitModalForm">
            @csrf

            <input type="hidden" name="code" value="{{ $entrycode->code }}">
            <input type="hidden" name="judge" value="{{ Auth::user()->id }}">
            <input type="hidden" name="category" value="{{ $catcode }}"> 
            <input type="text" name="score" readonly id="score">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="savescore" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>  
@endsection