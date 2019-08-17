@extends('layouts.scoring')

@section('appScript')
    <script src="{{ asset('js/judgescoring_app.js') }}"></script>

    
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
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