@extends('layouts.app')

@section('breadcrumb-name', 'Categories')

@section('content')
    <div class="container_wrapper pl-2 pr-2">
        <div class="container-fuild col-md-12">
            <div class="">
                @if ($categories->count() > 0)
                    <button type="button" class="btn btn-danger" id="deleteAllCategories"
                        data-categories-delete-url="{{ route('categories.all.delete') }}">
                        Delete All Categories
                    </button>
                @endif
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                    Add New Category
                </button>
            </div>
            @if ($categories->count() > 0)
                <table id="example" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @forelse($categories as $key => $category)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @if ($category->is_active == 1)
                                    <label class="switch">
                                        <input type="checkbox" checked data-id="{{ $category->id }}">
                                        <span class="slider round"></span>
                                    </label>
                                @else
                                    <label class="switch">
                                        <input type="checkbox" data-id="{{ $category->id }}">
                                        <span class="slider round"></span>
                                    </label>
                                @endif
                            </td>
                            <td>
                                <div class="product-detials">

                                    <div class="product-detials-figure">
                                        <button type="button" class="btn btn-success btn-sm view-product-btn"
                                            data-toggle="modal" data-target="#viewProduct"
                                            data-category-id="{{ $category->id }}" title="View Product">
                                            <i class="fa fa-list-ul" aria-hidden="true"></i>
                                        </button>
                                        <div class="badge-number">
                                            <span class="productCountStyle">{{ $category->products()->count() }}</span>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary btn-sm edit-btn" data-toggle="modal"
                                        data-target="#editModal" data-category-id="{{ $category->id }}" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm delete-btn text-white view-history"
                                        data-toggle="modal" style="background: #17a2b8;" data-target="#viewLog"
                                        data-category-id="{{ $category->id }}" title="History">
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-toggle="modal"
                                        data-target="#deleteModal" data-category-id="{{ $category->id }}" title="Delete">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No data Found</td>
                        </tr>
                    @endforelse
                </table>
            @else
                <h3>No data Found</h3>
            @endif
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addNewCategory" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="EditCategory" method="post">
                        <input type="hidden" name="categoryID" id="categoryID">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item? If you delete this Category then based on that product
                        also Deleted</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Product Modal -->
    <div class="modal fade bd-example-modal-lg" id="viewProduct" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryName"></h5>
                    <p class="modal-title">
                        <span class="dot">
                            <span id="productCount" class="text-white ml-2 fw-bolder"></span>
                        </span>
                    </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="productDataTable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- View Log Modal -->
    <div class="modal fade bd-example-modal-xl" id="viewLog" tabindex="-1" role="dialog"
        aria-labelledby="viewLogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLogModalLabel">Activity Log</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <table id="activityLogTable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Action Log</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/modifiers/category.js') }}"></script>
@endpush
