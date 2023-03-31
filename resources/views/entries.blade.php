@extends('layouts.app')

@section('appScript')
<script src="{{ asset('js/categories_app.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script defer>
    jQuery( function($) {
        $('#entries').DataTable({
            'order' : [[0, 'desc']],
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
            <div class="status">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                    {{ session('success') }}
                </div>            
            </div>
        </div>
    @endif

    @if ( !Auth::user()->admin )
        <card title="You are not authorized to view this content"></card>            
    @else 
        <!-- Add Category Modal -->
        <div class="modal fade" id="addEntries" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Entry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('entries') . '/add' }}" method="post">
                    <div class="modal-body">                        
                        @csrf
                        <div class="row form-group" style="align-items: center;">
                            <div class="col-sm-4">
                                <label for="entryCode">Entry Code</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="entryCode" placeholder="Entry Code">
                            </div>
                        </div>
                        <div class="row form-group" style="align-items: center;">
                            <div class="col-sm-4">
                                <label for="entryName">Entry Name</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="entryName" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="row form-group" style="align-items: center;">
                            <div class="col-sm-4">
                                <label for="entrySchool">Entry School</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="form-control" name="entrySchool" placeholder="School/Academy">
                                            @foreach ( $schools as $school )
                                            <option value="{{ $school->school_name }}">{{ $school->school_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" style="align-items: center;">
                            <div class="col-sm-4">
                                <label for="categoryCode">Category Code</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="categoryCode" placeholder="Category Code">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Entry</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Category Modal -->
        <div class="modal fade" id="importEntries" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('entries.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control">
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="toolbar" class="row justify-content-right">
            <div class="col-md-12">

                <h1 class="display-4 text-center">Active Entry: 
                    @empty ( $activeEntry->code ) 
                        No Active Entry
                    @else
                        {{ $activeEntry->code }}
                    @endempty
                </h1>

                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addEntries">Add Entry</button>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#importEntries">Import from File</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table id="entries" class="table bg-white table-bordered">
                    <thead class="thead-light"> 
                        <th scope="col" class="d-none">Active</th>               
                        <th scope="col">Entry</th>
                        <th scope="col">Name</th>
                        <th scope="col">School</th>
                        <th scope="col">Code</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        @foreach ( $entries as $entry )
                        
                        <tr>
                            <th class="d-none">
                                @if ( $activeEntry->code  == $entry->code )
                                    1
                                @else
                                    0
                                @endif
                            </th>
                            <th scope="row" class="col-sm-1">
                                {{ $entry->code }}
                            </th>
                            <td>
                                {{ $entry->entry_name }}
                            </td>
                            <td>
                                {{ $entry->entry_school }}
                            <td>
                                {{ $entry->category }}
                            </td>
                            <td class="col-sm-1">
                                @if ($activeEntry->code != $entry->code)
                                <a href="{{ '/dashboard/admin/activate/' . $entry->code }}" class="well-sm p-2 button btn-primary">Activate</a>
                                @else 
                                <a href="{{ '/dashboard/admin/clear/' . $entry->code }}" class="well-sm p-2 button btn-secondary">Deactivate</a>
                                @endif

                                <div style="margin-top: 5px;">
                                    <a href="{{ route('entries') . '/' . $entry->id . '/edit' }}">Edit</a> | <a href="{{ route('entries') . '/' . $entry->id . '/delete' }}">Delete</a>
                                </div>
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
