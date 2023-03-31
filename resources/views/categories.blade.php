@extends('layouts.app')

@section('appScript')
<script src="{{ asset('js/categories_app.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
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
        <div class="modal fade" id="addCategory" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('categories') . '/add' }}" method="post">
                    <div class="modal-body">                        
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="category">Category Label</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="category" placeholder="Category Name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="code">Category Code</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="code" placeholder="Category Code">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            <div class="col-md-12">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addCategory">Add Category</button>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#importCategories">Import from File</button>
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
                                <a href="{{ route('categories') . '/' . $category->id . '/edit' }}">Edit</a> | <a href="{{ route('categories') . '/' . $category->id . '/delete' }}">Delete</a>
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
