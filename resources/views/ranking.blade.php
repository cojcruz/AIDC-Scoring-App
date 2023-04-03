@extends('layouts.app')

@section('appScript')
<link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">
<script src="{{ asset('js/live_app.js') }}"></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/jszip.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script>
    jQuery( function($) {
        var rankings = $('#rankings').DataTable({
            'order' : [[7, 'desc']],
            'scrollCollapse' : true,
            'columnDefs' : [
                {
                    'orderable' : false,
                    'targets' : '_all'
                }
            ],
            dom: 'Bfrtip',
            buttons: [{
                extend: 'csv',
                filename: 'ABAP Competition 2023 - Ranking for {{ $cat }}',
            },{
                extend: 'excel',
                filename: 'ABAP Competition 2023 - Ranking for {{ $cat }}',
            },{
                extend: 'pdf',
                filename: 'ABAP Competition 2023 - Ranking for {{ $cat }}',
            },{
                extend: 'print',
                filename: 'ABAP Competition 2023 - Ranking for {{ $cat }}',
            }]
        });

        $('.dt-buttons > button').addClass('btn btn-primary');
    });
</script>
@endsection

@section('content')

<div class="container h-100">
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
    <div class="row justify-content-center h-100" style="align-items: center;">
        <div class="col-md-12 h-100">   

                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h1> Find Rankings</h1>
                    </div>
                    <div class="card-body text-center pb-0">
                        <form action="{{ route('ranking.show') }}" method="post">
                            @csrf 
                            <div class="input-group w-50 m-auto">
                                <label class="input-group-text" class="h5" for="category">Category</label>
                                <select class="form-select" name="category">
                                    <option value="All">All</option>
                                    @foreach ( $categories as $category )
                                        
                                        <option value="{{ $category->code }}" <?php echo ($cat == $category->code) ? 'selected' : ''; ?>>{{ $category->name }}</option>
                                        
                                    @endforeach
                                </select>

                                <button class="btn btn-primary mx-auto" target="Ranking">Show</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if ( $layout == 'results' )

                <div class="card mt-2">
                    <div class="card-header text-center">
                        <h1>
                            @if ( $cat == 'All' )
                                Showing All Entries
                            @else
                                Ranking for {{ $cat }}
                            @endif
                        </h1>
                    </div>
                    <div class="card-body">
                        <table id="rankings" class="table">
                            <thead class="thead-light">    
                                <th scope="col">Category</th>            
                                <th scope="col">Entry</th>
                                <th scope="col">Name</th>
                                <th scope="col">School</th>
                                <th scope="col">Judge A</th>
                                <th scope="col">Judge B</th>
                                <th scope="col">Judge C</th>
                                <th scope="col">Average</th>
                            </thead>
                            <tbody>
                                @foreach ( $entries as $entry )

                                    @php
                                        $average = round( ( (int)$entry->judge_a + (int)$entry->judge_b + (int)$entry->judge_c) / 3, 2); // Compute for Average Score
                                    @endphp
                                
                                <tr>
                                    <td>
                                        {{ $entry->category }}
                                    </td>
                                    <td>
                                        {{ $entry->code }}
                                    </td>
                                    <td>
                                        {{ $entry->entry_name }}
                                    </td>
                                    <td>
                                        {{ $entry->entry_school }}
                                    </td>
                                    <td>
                                        @if ( $entry->judge_a )
                                            {{ $entry->judge_a }}
                                        @else 
                                            No Score
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $entry->judge_b )
                                            {{ $entry->judge_b }}
                                        @else 
                                            No Score
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $entry->judge_c )
                                            {{ $entry->judge_c }}
                                        @else 
                                            No Score
                                        @endif
                                    </td>
                                    <td>{{ $average }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @endif
        </div>
    </div>
    @endif
</div>

@endsection