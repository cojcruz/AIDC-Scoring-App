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
           <div id="editCategory">
                <form action="{{ route('categories.delete') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label>ID</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="id" value="{{ $category->id }}" readonly>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Category Name</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="categoryLabel" value="{{ $category->name }}" readonly>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Code</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="categoryCode" value="{{ $category->code }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Are you sure you want to delete this category</strong>
                            <span class="alert-warning">This cannot be undone</span>
                            <button type="submit" class="btn btn-primary">Confirm Deletion</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    
</div>    
@endsection
