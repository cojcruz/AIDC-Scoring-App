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
        let date = new Date();
        let rankings = $('#rankings').DataTable({
            'order' : [[19, 'desc']],
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
                filename: 'AIDC ' + date.getFullYear() + ' - Ranking for {{ $cat }}',
            },{
                extend: 'excel',
                filename: 'AIDC ' + date.getFullYear() + ' - Ranking for {{ $cat }}',
            },{
                extend: 'pdf',
                orientation: 'landscape',
                filename: 'AIDC ' + date.getFullYear() + ' - Ranking for {{ $cat }}',
            },{
                extend: 'print',
                orientation: 'landscape',
                filename: 'AIDC ' + date.getFullYear() + ' - Ranking for {{ $cat }}',
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
                                <th scope="col" class="text-center">Category</th>            
                                <th scope="col" class="text-center">Entry</th>
                                <th scope="col" class="text-center" style="width: 15%;">Name</th>
                                <th scope="col" class="text-center" style="width: 15%;">School</th>
                                <th scope="col" class="text-center">Judge 1</th>
                                <th scope="col" class="text-center fs-6">A</th>
                                <th scope="col" class="text-center fs-6">B</th>
                                <th scope="col" class="text-center fs-6">C</th>
                                <th scope="col" class="text-center fs-6">D</th>
                                <th scope="col" class="text-center">Judge 2</th>
                                <th scope="col" class="text-center fs-6">A</th>
                                <th scope="col" class="text-center fs-6">B</th>
                                <th scope="col" class="text-center fs-6">C</th>
                                <th scope="col" class="text-center fs-6">D</th>
                                <th scope="col" class="text-center">Judge 3</th>
                                <th scope="col" class="text-center fs-6">A</th>
                                <th scope="col" class="text-center fs-6">B</th>
                                <th scope="col" class="text-center fs-6">C</th>
                                <th scope="col" class="text-center fs-6">D</th>
                                <th scope="col" class="text-center">Average</th>
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
                                        {{ substr($entry->code, 2) }}
                                    </td>
                                    <td>
                                        {{ $entry->entry_name }}
                                    </td>
                                    <td>
                                        {{ $entry->entry_school }}
                                    </td>
                                    <td class="text-center">
                                        @if ( $entry->judge_a )
                                            <strong>{{ $entry->judge_a }}</strong>
                                        @else 
                                            No Score
                                        @endif
                                    </td>
                                    <td>
                                        {{ $entry->jAcatA }}
                                    </td>
                                    <td>
                                        {{ $entry->jAcatB }}
                                    </td>
                                    <td>
                                        {{ $entry->jAcatC }}
                                    </td>
                                    <td>
                                        {{ $entry->jAcatD }}
                                    </td>
                                    <td class="text-center">
                                        @if ( $entry->judge_b )
                                            <strong>{{ $entry->judge_b }}</strong>
                                        @else 
                                            No Score
                                        @endif
                                    </td>
                                    <td>
                                        {{ $entry->jBcatA }}
                                    </td>
                                    <td>
                                        {{ $entry->jBcatB }}
                                    </td>
                                    <td>
                                        {{ $entry->jBcatC }}
                                    </td>
                                    <td>
                                        {{ $entry->jBcatD }}
                                    </td>
                                    <td class="text-center">
                                        @if ( $entry->judge_c )
                                            <strong>{{ $entry->judge_c }}</strong>
                                        @else 
                                            No Score
                                        @endif
                                    </td>
                                    <td>
                                        {{ $entry->jCcatA }}
                                    </td>
                                    <td>
                                        {{ $entry->jCcatB }}
                                    </td>
                                    <td>
                                        {{ $entry->jCcatC }}
                                    </td>
                                    <td>
                                        {{ $entry->jCcatD }}
                                    </td>
                                    <td class="fw-bold">
                                        {{ $average }}
                                    </td>
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