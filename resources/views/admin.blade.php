@extends('layouts.app')

@section('appScript')
<script src="{{ asset('js/admin_app.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div> 
    @if ( !Auth::user()->admin )
    <div class="row justify-content-center">       
        <div class="col-md-12">
            <card title="You are not authorized to view this content"></card>
        </div>
    </div>
    @else
    <div class="row justify-content-center">
        <div class="col-md-4">
            <card title="Find Entry">
                <input type="text" v-model="findCode" value="" class="entry">
                <div class="btn btn-primary mx-auto" @click="findEntry">Submit</div>
            </card>
        </div>
        <div class="col-md-4">
            <card title="Set Active Entry">
                <input type="text" v-model="code" placeholder="Enter Participant Number" v-on:keyup.enter="setActive" class="entry">
                <div class="btn btn-primary mx-auto" @click="setActive">Submit</div>
            </card>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <card title="Clear Active Entry">
                <div class="btn btn-primary mx-auto" @click="clearActive">Clear</div>
            </card>
        </div>
        <div class="col-md-4">
            <card title="Current Active Entry">
                <input id="activeCode" readonly v-model="activeCode" placeholder="No Active Entry" value="" class="entry mx-auto">
            </card>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <card title="Live Scoring Page">
                <a href="{{ route('livescoring') }}" class="btn btn-primary mx-auto" target="LiveScoring">Launch</a>
            </card>
        </div>
        <div class="col-md-4">
            <card title="Ranking">
                <form action="{{ route('ranking.show') }}" method="post" target="Ranking">
                    @csrf 
                    <label class="h5" for="category">Category</label>
                    <select class="custom-select mb-2" name="category">
                        <option value="All" selected>All</option>
                        @foreach ( $categories as $category )
                            <option value="{{ $category->code }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary mx-auto" target="Ranking">Show</button>
                </form>
            </card>
        </div>
    </div>

    @endif
</div>
@endsection
