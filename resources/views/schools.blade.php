@extends('layouts.app')

@section('appScript')
<link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">
<script src="{{ asset('js/categories_app.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script defer>
    jQuery( function($) {
        $('#schools').DataTable({
            'order' : [[1, 'acs']],
            'scrollCollapse' : true,
            'columnDefs' : [
                {
                    'orderable' : false,
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
        <!-- Add School Modal -->
        <div class="modal fade" id="addEntries" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New School</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('schools') . '/add' }}" method="post">
                    <div class="modal-body">                        
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="name">School Name</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Name of School">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add School</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <form action="{{ route('schools.import') }}" method="POST" enctype="multipart/form-data">
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
            <div class="btn-group w-25">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEntries">Add School</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importEntries">Import from File</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table id="schools" class="table bg-white table-bordered">
                    <thead class="thead-light">                
                        <th scope="col">School</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        @foreach ( $schools as $school )
                        
                        <tr>
                            <th scope="row">
                                {{ $school->school_name }}
                            </th>
                            <td>
                                <a href="{{ route('schools') . '/' . $school->id . '/edit' }}">Edit</a> | <a href="{{ route('schools') . '/' . $school->id . '/delete' }}">Delete</a>
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
