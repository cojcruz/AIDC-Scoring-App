@extends('layouts.app')

@section('appScript')
<link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">
<script src="{{ asset('js/categories_app.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script defer>
    jQuery( function($) {
        $('#categories').DataTable({
            'order' : [[0, 'asc']],
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
                <div class="alert alert-success alert-dismissible fade slow" role="alert">
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
        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategory" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('categories') . '/add' }}" method="post">
                    <div class="modal-body">                        
                        @csrf
                        <div class="row">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="category">Category Name</label>
                                <input class="form-control" type="text" name="category" placeholder="Category Name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-2">
                                <label class="input-group-text w-25" for="code">Category Code</label>
                                <input class="form-control" type="text" name="code" placeholder="Category Code">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Category Modal -->
        <div class="modal fade" id="importCategories" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('categories.import') }}" method="POST" enctype="multipart/form-data">
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">Add Category</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importCategories">Import from File</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">                
                <table id="categories" class="table bg-white table-bordered">
                    <thead class="thead-light">   
                        <th scope="col">ID</th>             
                        <th scope="col" class="col-8">Name</th>
                        <th scope="col" class="col-2">Code</th>
                        <th scope="col" class="col-2">Action</th>
                    </thead>
                    <tbody>
                        @foreach ( $categories as $category )
                        
                        <tr>
                            <td>
                                {{ $category->id }}
                            </td>
                            <th scope="row">
                                {{ $category->name }}
                            </th>
                            <td>
                                {{ $category->code }}
                            </td>
                            <td>
                                <div class="dropdown my-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="ActionsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                    <div class="dropdown-menu" arial-labelledby="ActionsMenu">
                                        <a href="{{ route('categories') . '/' . $category->id . '/edit' }}"class="dropdown-item">Edit</a>
                                        <a href="{{ route('categories') . '/' . $category->id . '/delete' }}" class="dropdown-item">Delete</a>
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
