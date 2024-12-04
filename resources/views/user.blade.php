@extends('index')

@section('content')
{{-- Hello --}}
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="pt-2"><u>User List</u></h5>

                    <div class="template-demo d-flex float-right">
                        <a href="/register">
                            <button type="button" class="btn btn-primary">New User</button>
                        </a>
                    </div>

                    <div class="table-responsive pt-3">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <hr>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <b>N0.</b>
                                    </th>
                                    <th>
                                        <b>User</b>
                                    </th>
                                    <th>
                                        <b>Full Name</b>
                                    </th>
                                    <th>
                                        <b>Email</b>
                                    </th>

                                    <th class="">
                                        <b>Action</b>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                @foreach ($User->reverse() as $key)

                                    <tr>
                                        <input type="hidden" name="userid"
                                                            value="{{ $key->userid }}">
                                        <td class="">
                                            {{ $i++ }}.
                                        </td>
                                        <td>
                                            {{ $key->username }}
                                        </td>
                                        <td>
                                            {{ $key->username }}
                                        </td>
                                        <td>
                                            {{ $key->email }}

                                        </td>

                                        <td>
                                            <div class=" ">
                                                <a href="./editUser/{{$key->userid}}">
                                                    <button class="btn btn-outline-primary btn-sm edit_borrower"
                                                    type="button"><i class="fa fa-edit">
                                                    </i>
                                                </button>
                                                </a>



                                                {{-- <button class="btn btn-outline-danger btn-sm delete_borrower"
                                                    type="button"><i class="fa fa-trash"></i></button> --}}

                                                    <button
                                                    class="btn btn-outline-danger btn-sm "
                                                    type="button" id="deleteuser"
                                                    value="{{ $key->userid }}"><i
                                                        class="fa fa-trash"></i>
                                                </button>

                                            </div>

                                        </td>
                                    </tr>
                                @endforeach





                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- row end -->
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:./partials/_footer.html -->
            <footer class="footer">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright
                                © bootstrapdash.com 2020</span>
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Distributed
                                By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                                Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard
                                    templates</a> from
                                Bootstrapdash.com</span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->

    <!-- Delete Modal -->
    <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="staticBackdropLabel">Delete User</h3>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <form action="/deleteUser" method="POST">
                    @csrf

                    <input type="text" name="userid " id="deleteid">
                    <div class="modal-body">
                        Are you sure, You want to delete this user ?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {

            // $('#newBorrower').click(function(e) {
            //     e.preventDefault();
            //     $('#borrowerModal').modal('show');
            // });


            $(document).on('click', '#deleteuser', function() {
                var id = $(this).val();

                $('#deleteModal').modal('show');
                $('#deleteid').val(id);
            });



            // $(document).on('click', '.editbtn', function() {
            //     var id = $(this).val();

            //     $('#editModal').modal('show');
            //     $.ajax({
            //         type: "GET",
            //         url: "/editBorrower/" + id,
            //         success: function(response) {
            //             // Debugging
            //             console.log('Borrower Data:', response.borrower);
            //             console.log('Gender Data:', response.genders);

            //             // Check if the response data exists and has the expected structure
            //             if (response.borrower && response.genders) {
            //                 $('#edit_borrowerid').val(response.borrower.borrowerid);
            //                 $('#edit_firstname').val(response.borrower.firstname);
            //                 $('#edit_lastname').val(response.borrower.lastname);
            //                 $('#edit_contact').val(response.borrower.contact);
            //                 $('#edit_address').val(response.borrower.address);
            //                 $('#edit_email').val(response.borrower.email);
            //                 $('#edit_taxid').val(response.borrower.taxid);

            //                 // Populate genders select field
            //                 var genderSelect = $('#edit_genderid');
            //                 genderSelect.empty(); // Clear previous options

            //                 $.each(response.genders, function(key, gender) {
            //                     // Debugging
            //                     //console.log('Processing Gender:', gender);

            //                     var isSelected = (response.borrower.genderId == gender
            //                         .genderId) ? 'selected' : '';
            //                     //console.log('isSelected:', isSelected);
            //                     genderSelect.append('<option value="' + gender
            //                         .genderId + '" ' + isSelected + '>' + gender
            //                         .genderName + '</option>');
            //                 });

            //                 // Ensure the selected option is set correctly
            //                 $('#edit_genderid').val(response.borrower.genderId);
            //             } else {
            //                 console.error('Unexpected response structure:', response);
            //             }
            //         },
            //         error: function(err) {
            //             console.error('AJAX Error:', err.responseText);
            //         }
            //     });


            // });
        });
    </script>
@endsection
