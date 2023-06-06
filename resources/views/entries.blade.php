@extends('layouts.app')

@section('appScript')
<link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">
<script src="{{ asset('js/categories_app.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script defer>
    jQuery( function($) {
        var entriesTable = $('#entries').DataTable({
            'order' : [[0, 'desc']],
            'scrollCollapse' : true,
            'columnDefs' : [
                {
                    'orderable' : false,
                    'targets' : '_all'
                }
            ],
        });

        entriesTable.on('draw', function() {
            $('.editThis').click(function(e) {
                e.preventDefault();

                var edit = $(this);
                
                $('#editEntry input[name="id"]').val( edit.data('id') );
                $('#editEntry input[name="entryCode"]').val( edit.data('code') );
                $('#editEntry input[name="entryName"]').val( edit.data('fullname') );
                if ( edit.data('school') != '' ) {
                    $('#editEntry select[name="entrySchool"] option:contains("' + edit.data('school') + '")').prop('selected',true);
                } else {
                    $('#editEntry select[name="entrySchool"] option[data-empty]').prop('selected',true);
                }
                $('#editEntry select[name="entryCategory"] option[value="' + edit.data('category') + '"]').prop('selected',true);                               
            });
        });

        $('.editThis').click(function(e) {
            e.preventDefault();

            var edit = $(this);
            
            $('#editEntry input[name="id"]').val( edit.data('id') );
            $('#editEntry input[name="entryCode"]').val( edit.data('code') );
            $('#editEntry input[name="entryName"]').val( edit.data('fullname') );
            if ( edit.data('school') != '' ) {
                $('#editEntry select[name="entrySchool"] option:contains("' + edit.data('school') + '")').prop('selected',true);
            } else {
                $('#editEntry select[name="entrySchool"] option[data-empty]').prop('selected',true);
            }
            $('#editEntry select[name="entryCategory"] option[value="' + edit.data('category') + '"]').prop('selected',true);                        
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
        <!-- Add Entry Modal -->
        <div class="modal fade" id="addEntries" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('entries') . '/add' }}" method="post">
                    <div class="modal-body">                        
                        @csrf
                        <div class="row form-group align-items-center">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="entryCode">Entry Code</label>
                                <input type="text" class="form-control" name="entryCode" placeholder="Entry Code">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="entryName">Entry Name</label>
                                <input type="text" class="form-control" name="entryName" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="entrySchool">Entry School</label>
                                <select class="form-select" name="entrySchool" placeholder="School/Academy">
                                    <option data-empty=""></option>
                                    @foreach ( $schools as $school )
                                    <option value="{{ $school->school_name }}">{{ $school->school_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="categoryCode">Category Code</label>
                                <select name="entryCategory" class="form-select">
                                    <option></option>
                                    @foreach ( $categories as $category )
                                        <option value="{{ $category->code }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group w-auto">
                            <button type="submit" class="btn btn-primary">Add Entry</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Entry Modal -->
        <div class="modal fade" id="editEntries" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editEntry" action="" method="post">
                    <div class="modal-body">                        
                        @csrf
                        <input type="hidden" name="id" />
                        <div class="row form-group align-items-center">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="entryCode">Entry Code</label>
                                <input type="text" class="form-control" name="entryCode" placeholder="Entry Code">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="entryName">Entry Name</label>
                                <input type="text" class="form-control" name="entryName" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="entrySchool">Entry School</label>
                                <select class="form-select" name="entrySchool" placeholder="School/Academy">
                                    <option data-empty=""></option>
                                    @foreach ( $schools as $school )
                                    <option value="{{ $school->school_name }}">{{ $school->school_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group align-items-center">
                            <div class="input-group">
                                <label class="input-group-text w-25" for="categoryCode">Category Code</label>
                                <select name="entryCategory" class="form-select">
                                    <option></option>
                                    @foreach ( $categories as $category )
                                        <option value="{{ $category->code }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group w-auto">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
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
        <div class="jumbotron jumbotron-fluid">

        </div>
        <div id="toolbar" class="row justify-content-right">
            <div class="row">
                <div class="col-sm-4">
                    <div class="btn-group">                
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEntries">Add Entry</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importEntries">Import from File</button>
                    </div>
                </div>
                <div class="col-sm-8">
                    <h1 class="display-5 text-end">Active Entry: 
                        @empty ( $activeEntry->code ) 
                            No Active Entry
                        @else
                            {{ $activeEntry->code }}
                        @endempty
                    </h1>
                </div>
            </div>
        </div>
        <div class="card justify-content-center">
            <div class="card-body">
                <table id="entries" class="table bg-white ">
                    <thead class="thead-light"> 
                        <th scope="col" class="d-none">Active</th>               
                        <th scope="col" class="col-2">Entry</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">School</th>
                        <th scope="col">Category</th>
                        <th scope="col">Scores</th>
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
                            <th scope="row">
                                <h4>{{ $entry->code }}

                                @if ($activeEntry->code != $entry->code)
                                <a href="{{ '/dashboard/admin/activate/' . $entry->code }}" class="well-sm p-2 btn btn-sm btn-primary text-white" role="button">Activate</a>
                                @else 
                                <a href="{{ '/dashboard/admin/clear/' . $entry->code }}" class="well-sm p-2 btn btn-sm btn-secondary" role="button">Deactivate</a>
                                @endif

                                </h4>
                            </th>
                            <td>
                                {{ $entry->entry_name }}
                            </td>
                            <td>
                                {{ round($entry->age, 2) }}
                            </td>
                            <td>
                                {{ $entry->entry_school }}
                            <td>
                                {{ $entry->category }}
                            </td>
                            <td class="entryScores">
                                <div class="row">
                                    <div class="col text-center">
                                        <h6>{{ $entry->judge_a }}</h6>                                        
                                        <strong>Judge A</strong>
                                    </div>
                                    <div class="col text-center">
                                        <h6>{{ $entry->judge_b }}</h6>
                                        <strong>Judge B</strong>
                                    </div>
                                    <div class="col text-center">
                                        <h6>{{ $entry->judge_c }}</h6>
                                        <strong>Judge C</strong>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-1">
                                <div class="dropdown my-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="ActionsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                    <div class="dropdown-menu" arial-labelledby="ActionsMenu">
                                        <a href="{{ route('entries') . '/' . $entry->id . '/edit' }}" 
                                            class="dropdown-item editThis" 
                                            data-id="{{ $entry->id }}"
                                            data-code="{{ $entry->code }}" 
                                            data-fullname="{{ $entry->entry_name }}" 
                                            data-school="{{ $entry->entry_school }}" 
                                            data-category="{{ $entry->category }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editEntries"><span class="material-icons align-middle">edit</span> Edit</a>
                                        <a href="{{ route('entries') . '/' . $entry->id . '/delete' }}" class="dropdown-item"><span class="material-icons align-middle">delete</span> Delete</a>
                                    </div>
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
