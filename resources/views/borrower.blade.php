@extends('index')

@section('content')
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="pt-2"><u>Borrower List</u></h5>
                                                {{-- <p class="card-description">
                                    Add class <code>.table-striped</code>
                                    </p> --}}
                                    <div class="template-demo d-flex float-right">
                                        <button type="button" class="btn btn-primary" id="newBorrower">New
                                            Borrower
                                        </button>
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
                                        <table class="table table-striped" id="tblBorrower">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <b>N0.</b>
                                                    </th>
                                                    <th>
                                                        <b>Full Name</b>
                                                    </th>
                                                    <th>
                                                        <b>Gender</b>
                                                    </th>
                                                    <th>
                                                        <b>Address</b>
                                                    </th>
                                                    <th>
                                                        <b>Contact</b>
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
                                                @foreach ($borrowers->reverse() as $key)
                                                    <tr>
                                                        {{-- <input type="hidden" name="borrowerid"
                                                            value="{{ $key->borrowerid }}"> --}}
                                                        <td class="">
                                                            {{ $i++ }}.
                                                        </td>
                                                        <td>
                                                            {{ $key->firstname }} {{ $key->lastname }}
                                                        </td>
                                                        <td>
                                                            {{ $key->genderName }}
                                                        </td>
                                                        <td>
                                                            {{ $key->address }}
                                                        </td>
                                                        <td>
                                                            {{ $key->contact }}
                                                        </td>
                                                        {{-- <td>
                                                            {{ $key->email }}
                                                        </td>
                                                        <td>
                                                            {{ $key->taxid }}

                                                        </td> --}}

                                                        <td>
                                                            <div class=" ">
                                                                <button data-id=""
                                                                    class="btn btn-outline-primary btn-sm editbtn"
                                                                    type="button" value="{{ $key->borrowerid }}"><i
                                                                        class="fa fa-edit">
                                                                    </i>
                                                                </button>
                                                                <button
                                                                    class="btn btn-outline-danger btn-sm delete_borrower"
                                                                    type="button" id="deleteborrower"
                                                                    value="{{ $key->borrowerid }}"><i
                                                                        class="fa fa-trash"></i>
                                                                </button>

                                                            </div>

                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                        {{-- <div> {{ $borrowers->links() }}</div> --}}


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
                                            <span
                                                class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright
                                                © bootstrapdash.com 2020</span>
                                            <span
                                                class="text-muted d-block text-center text-sm-left d-sm-inline-block">Distributed
                                                By: <a href="https://www.themewagon.com/"
                                                    target="_blank">ThemeWagon</a></span>
                                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                                                Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap
                                                    dashboard templates</a> from
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
                </div>
                <!-- container-scroller -->
            </div>


            <!-- New Borrower Modal -->
            <div class="modal fade " id="borrowerModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="">Borrower Form</h4>
                                <p class="card-description">
                                    Please Enter Information Below
                                </p>
                                <hr>

                                <form class="forms-sample" action="/addBorrower" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-3 col-form-label"><b>FirstName</b></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                        id="exampleInputUsername2" placeholder="FirstName"
                                                        name="firstname" id="firstname"

                                                        required>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputEmail2"
                                                    class="col-sm-3 col-form-label"><b>LastName</b></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="exampleInputEmail2"
                                                        placeholder="LastName" name="lastname" id="lastname" required
                                                        >
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Gender</b></label>


                                                <div class="col-sm-9">

                                                    <select name="genderId" id="genderId" class="form-control"
                                                        required>
                                                        <option selected disabled value="">
                                                            Select Gender</option>
                                                        @foreach ($genders as $gender)
                                                            <option value="{{ $gender->genderId }}">
                                                                {{ $gender->genderName }}
                                                            </option>
                                                        @endforeach
                                                    </select>


                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Contact</b></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                        id="exampleInputMobile" placeholder="Contact" name="contact"
                                                        id="contact"

                                                        required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Address</b></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                        id="exampleInputMobile" placeholder="Address" name="address"
                                                        id="address"

                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputPassword2"
                                                    class="col-sm-3 col-form-label"><b>Email</b></label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control"
                                                        id="exampleInputPassword2" placeholder="Email" name="email"
                                                        id="email"

                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputConfirmPassword2"
                                                    class="col-sm-3 col-form-label"><b>Tax
                                                        ID</b></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                        id="exampleInputConfirmPassword2" placeholder="Tax ID"
                                                        name="taxid" id="taxid"

                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <button type="submit" id="" class="btn btn-primary mr-2">Save
                                    </button>
                                    <button class="btn btn-light" data-dismiss="modal">Cancel
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--END New Borrower Modal -->


            <!-- Edit Borrower Modal -->
            <div class="modal fade " id="editModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="">Borrower Form Update</h4>
                                <p class="card-description">
                                    Please Enter Information Below
                                </p>
                                <hr>

                                <form class="forms-sample" action="/updateBorrower" method="POST">

                                    @csrf
                                    @method('PUT')



                                    <input type="hidden" name="borrowerid" id="edit_borrowerid">


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-3 col-form-label"><b>FirstName</b>
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="firstname"
                                                        id="edit_firstname">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputEmail2"
                                                    class="col-sm-3 col-form-label"><b>LastName</b></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" placeholder="LastName"
                                                        name="lastname" id="edit_lastname" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="edit_genderid"
                                                    class="col-sm-3 col-form-label"><b>Gender</b></label>


                                                <div class="col-sm-9">

                                                    <select name="genderId" id="edit_genderid" class="form-control">

                                                    </select>


                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Contact</b></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="Contact"
                                                        name="contact" id="edit_contact" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Address</b></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="Address"
                                                        name="address" id="edit_address" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputPassword2"
                                                    class="col-sm-3 col-form-label"><b>Email</b></label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" placeholder="Email"
                                                        name="email" id="edit_email" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputConfirmPassword2"
                                                    class="col-sm-3 col-form-label"><b>Tax
                                                        ID</b></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="Tax ID"
                                                        name="taxid" id="edit_taxid" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <button type="submit" class="btn btn-primary mr-2">
                                        Save
                                        Change
                                    </button>
                                    <button class="btn btn-light" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--END Edit Borrower Modal -->

            <!-- Delete Modal -->
            <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5" id="staticBackdropLabel">Delete Borrower</h3>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <form action="/deleteBorrower" method="POST">
                            @csrf
                            <input type="hidden" name="borrowerid" id="deleteid">
                            <div class="modal-body">
                                Are you sure, You want to delete this Borrower?
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

        $('#newBorrower').click(function(e) {
            e.preventDefault();
            $('#borrowerModal').modal('show');
        });


        $(document).on('click', '#deleteborrower', function() {
            var id = $(this).val();

            $('#deleteModal').modal('show');
            $('#deleteid').val(id);
        });



        $(document).on('click', '.editbtn', function() {
            var id = $(this).val();

            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/editBorrower/" + id,
                success: function(response) {
                    // Debugging
                    console.log('Borrower Data:', response.borrower);
                    console.log('Gender Data:', response.genders);

                    // Check if the response data exists and has the expected structure
                    if (response.borrower && response.genders) {
                        $('#edit_borrowerid').val(response.borrower.borrowerid);
                        $('#edit_firstname').val(response.borrower.firstname);
                        $('#edit_lastname').val(response.borrower.lastname);
                        $('#edit_contact').val(response.borrower.contact);
                        $('#edit_address').val(response.borrower.address);
                        $('#edit_email').val(response.borrower.email);
                        $('#edit_taxid').val(response.borrower.taxid);

                        // Populate genders select field
                        var genderSelect = $('#edit_genderid');
                        genderSelect.empty(); // Clear previous options

                        $.each(response.genders, function(key, gender) {
                            // Debugging
                            //console.log('Processing Gender:', gender);

                            var isSelected = (response.borrower.genderId == gender
                                .genderId) ? 'selected' : '';
                            //console.log('isSelected:', isSelected);
                            genderSelect.append('<option value="' + gender
                                .genderId + '" ' + isSelected + '>' + gender
                                .genderName + '</option>');
                        });

                        // Ensure the selected option is set correctly
                        $('#edit_genderid').val(response.borrower.genderId);
                    } else {
                        console.error('Unexpected response structure:', response);
                    }
                },
                error: function(err) {
                    console.error('AJAX Error:', err.responseText);
                }
            });


        });
    });
</script>

@endsection
