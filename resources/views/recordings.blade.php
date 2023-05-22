@extends('layouts.app')

@section('appScript')
<link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">
<script src="{{ asset('js/categories_app.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script defer>
    jQuery( function($) {
        var entriesTable = $('#recordings').DataTable({           
            'scrollCollapse' : true,
            'columnDefs' : [
                {
                    'orderable' : true,
                    'targets' : '_all'
                }
            ],
        });

       
    });
</script>
@endsection

@section('content')
    @if (session('status') || session('success'))
        <div class="row justify-content-left">
            <div class="status position-absolute top-0 end-0 w-100">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>            
            </div>
        </div>
    @endif

    @if ( !Auth::user()->admin )
        <card title="You are not authorized to view this content"></card>            
    @else         
        <div class="card justify-content-center">
            <div class="card-body">
                <table id="recordings" class="table bg-white ">
                    <thead class="thead-light"> 
                        <th scope="col">Entry</th>
                        <th scope="col" class="col-2">Category</th>
                        <th scope="col" class="col-2">Judge</th>
                        <th scope="col" class="col-2">Timestamp</th>
                        <th scope="col" class="col-2">Link</th>
                    </thead>
                    <tbody>
                        @foreach ( $files as $file )
                        
                        @php

                        $fileinfo = explode('_', $file);

                        $entry = $fileinfo[0];
                        $category = $fileinfo[1];
                        $judge = ucwords(str_replace('-', ' ', $fileinfo[2]));
                        $timestamp = rtrim($fileinfo[3],'.mp3');

                        @endphp

                        <tr>
                            <th scope="row">
                                <h5>{{ $entry }}</h5>
                            </th>
                            <td>
                                <h5>{{ $category }}</h5>
                            </td>
                            <td>
                                <h5>{{ $judge }}</h5>
                            </td>
                            <td>
                                <h5>{{ $timestamp }}</h5>
                            </td>
                            <td>
                                <a href="{{ $path . '/' . $file }}" target="_blank">Download</a>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif    
</div>    
@endsection
