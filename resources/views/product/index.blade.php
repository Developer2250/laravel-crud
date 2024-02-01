@extends('layouts.app')

@section('breadcrumb-name', 'Product')

@section('content')
    <div class="container_wrapper pl-2 pr-2">
        <div class="container-fuild col-md-12">
            <div class="">
                @if ($products->count() > 0)
                    <button type="button" class="btn btn-danger" id="deleteAllProducts">
                        Delete All Product
                    </button>
                @endif
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                    Add New Product
                </button>
            </div>
        </div>
        @if ($products->count() > 0)
            <table id="example" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                @forelse($products as $key => $product)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ optional($product->category)->name }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @if ($product->is_active == 1)
                                <label class="switch">
                                    <input type="checkbox" checked data-id="{{ $product->id }}">
                                    <span class="slider round"></span>
                                </label>
                            @else
                                <label class="switch">
                                    <input type="checkbox" data-id="{{ $product->id }}">
                                    <span class="slider round"></span>
                                </label>
                            @endif
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
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addNewProduct" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Product Name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Category:</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="null">Select Any Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Quantity:</label>
                            <input class="form-control" type="number" name="quantity" id="quantity"
                                placeholder="Select Quantity">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Price:</label>
                            <input class="form-control" type="text" name="price" id="price"
                                placeholder="Select Price">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="6"
                                placeholder="Enter Product Description"></textarea>
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
@endsection
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            //dataTables
            $('#example').DataTable({
                info: true,
                ordering: true,
                paging: true,
                autoWidth: true,
                lengthChange: true,
                searching: true,
                pageLength: 10,
                processing: true,
            });

            $('#deleteAllProducts').on('click', function() {
                // Perform AJAX request to delete all products
                $.ajax({
                    url: '{{ route('product.all.delete') }}',
                    type: 'get',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Delete all data successfully...!!!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: 'Something went wrong....',
                            });
                        }
                    },
                    error: function(error) {
                        console.error('Error deleting all products: ', error);
                    }
                });
            });

            $("#addNewProduct").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                    },
                    description: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    price: {
                        required: true
                    },
                    quantity: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a value",
                        minlength: "Value must be at least 3 characters long",
                    },
                    description: {
                        required: "Please enter a value",
                    },
                    category_id: {
                        required: "Please Select Any Category",
                    },
                    quantity: {
                        required: "Please enter a value"
                    },
                    price: {
                        required: "Please enter a value"
                    }
                },
                submitHandler: function(form) {
                    // Serialize the form data
                    var formData = $(form).serializeArray();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('product.store') }}',
                        data: formData,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.status == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Added successfully...!!!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $(form).trigger('reset');
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: 'Something went wrong....',
                                });
                            }
                        },
                        error: function(error) {
                            // Handle error response
                            console.error('Error:', error);
                            // You can add your error handling logic here
                        }
                    });
                }
            });

            $('input[type="checkbox"]').change(function() {
                // Determine if the checkbox is checked or not
                var isChecked = $(this).is(':checked');
                var productID = $(this).attr('data-id');

                // Your AJAX call
                $.ajax({
                    url: '{{ route('product.status.update') }}',
                    type: 'POST',
                    data: {
                        product_id: productID,
                        is_active: isChecked
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Update status successfully...!!!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: 'Something went wrong....',
                            });
                        }
                    },
                    error: function(error) {
                        // Handle the error response
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endpush
