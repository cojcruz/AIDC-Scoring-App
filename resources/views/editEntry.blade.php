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
           <div id="editEntry">
                <form action="{{ route('entries.save') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label>ID</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="id" value="{{ $entry->id }}" readonly>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Entry Code</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="entryCode" value="{{ $entry->code }}">
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Entry Name</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="entryName" value="{{ $entry->entry_name }}">
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Entry School</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="entrySchool" value="{{ $entry->entry_school }}">
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Category Code</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="entryCategory" value="{{ $entry->category }}">
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
