@extends('layouts.app')

@section('breadcrumb-name', 'Users')

@section('css')
@endsection

@section('content')
    <div class="container_wrapper pl-2 pr-2">
        <div class="container-fuild col-md-12">
            <div class="d-none">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                        Add New User
                    </button>
                </div>
            </div>

            @if ($users->count() > 0)
                <table id="example" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Email Verify</th>
                        </tr>
                    </thead>
                    @forelse($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($user->email_verified_at) }}
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

    <!--add use modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="registrationForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
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
                autoFill: false
            });


            // $("#saveButton").click(function() {
            // var ajaxRegisterUrl = "";
            //     var formData = {
            //         _token:$(this).data('token'),
            //         name: $('#name').val(),
            //         email: $('#email').val(),
            //         password: $('#password').val()
            //     };
            //     console.log(21212);
            //     $.ajax({
            //         type: "POST",
            //         url: ajaxRegisterUrl,
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         data: formData,
            //         dataType: 'json',
            //         success: function(response) {
            //             if (response.status === 'success') {
            //                 // Handle success
            //                 alert(response.message);
            //             } else {
            //                 console.log(response.errors); // Log validation errors
            //                 alert('Registration failed. Please check the form for errors.');
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr);
            //             console.error("status", status);
            //             console.error("error", error);
            //             alert('An error occurred during registration. Please try again.');
            //         }
            //     });
            // });
        });
    </script>
@endsection
