@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="dashNav" class="col-md-12">
                        <ul>
                            <li><a class="dashboard-item" href="{{ route('scoring') }}">Live Scoring</a></li>
                            @if ( Auth::user()->admin )
                            <li>
                                <a class="dashboard-item" href="{{ route('admin') }}">Admin Tools</a>
                            </li>
                            @endif
                            <li><a class="dashboard-item" href="{{ route('logout') }}" 
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
