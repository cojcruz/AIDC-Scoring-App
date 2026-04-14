@extends('layouts.app')

@section('appScript')
<script src="{{ asset('js/admin_react_app.js') }}" defer></script>
@endsection

@section('content')

    @if (session('status'))
    <div class="status">
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    </div>
    @endif

    @if ( !Auth::user()->admin )
    <div class="card">
        <div class="card-header">You are not authorized to view this content</div>
    </div>
    @else
    <div id="admin-react-root"></div>
    @endif
@endsection
