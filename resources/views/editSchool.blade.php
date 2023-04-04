@extends('layouts.app')

@section('appScript')
<script src="{{ asset('js/categories_app.js') }}" defer></script>
@endsection

@section('content')
<div class="row justify-content-left">

    @if (session('status'))
    <div class="status">
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>            
    </div>
    @endif

    @if ( !Auth::user()->admin )
    <card title="You are not authorized to view this content"></card>            
    @else            
    <div clas="row justify-content-center">
        <div class="col-md-12">
           <div id="editSchool">
                <form action="{{ route('schools.save') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label>ID</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="id" value="{{ $school->id }}" readonly>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>School Name</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="name" value="{{ $school->school_name }}">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    
</div>    
@endsection
