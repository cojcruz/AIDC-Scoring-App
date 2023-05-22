@extends('layouts.scoring')

@section('appScript')

    <script src="{{ asset('js/judgescoring_app.js') }}"></script>
    <script>
        setInterval( function() {
                        window.location.href = "{{ route('scoring') }}";
                    }, 10000);
    </script>
    
@endsection

@section('content')
<div class="container" style="height: 100vh;">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-12 d-flex align-items-center">
            <div class="card w-100">
                <div class="card-header">
                    <h1 class="card-title text-center">
                        Success!
                    </h1>
                </div>
                <div class="card-body text-center">
                    {{ $message }}
                    <div class="text-center">
                        <a href="{{ $returnURL }}" id="return" class="submit btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection