@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="pt-2"><u>Loan List</u></h5>
                    {{-- <p class="card-description">
                      Add class <code>.table-striped</code>
                    </p> --}}
                    <div class="template-demo d-flex float-right">
                        <button type="button" class="btn btn-primary" id="newLoan">New
                            Loan
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
                        <table class="table table-striped" id="tblLoan">
                            <thead>
                                <tr>
                                    <th>
                                        <b>N0.</b>
                                    </th>
                                    <th>
                                        <b>Borrower</b>
                                    </th>
                                    <th>
                                        <b>Loan Plan</b>
                                    </th>
                                    {{-- <th>
                                        <b>Loan Giver</b>
                                    </th> --}}

                                    <th>
                                        <b>Amount</b>
                                    </th>
                                    <th>
                                        <b>Monthly Return</b>
                                    </th>
                                    <th>
                                        <b>Status</b>
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
                                @foreach ($loans->reverse() as $loan)
                                    <input type="hidden" name="loanId" value="{{ $loan->loanId }}">
                                    <tr>

                                        <td class="">
                                            {{ $i++ }}.
                                        </td>
                                        <td>
                                            <div class="pb-2">
                                                LRCN: {{ $loan->lrcid }}  <br />
                                            </div>
                                            <div class="pb-2">
                                                Full Name: {{ $loan->firstname }} {{ $loan->lastname }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Gender: {{ $loan->genderName }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Address: {{ $loan->address }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Contact: {{ $loan->contact }} <br />
                                            </div>




                                        </td>
                                        <td>
                                            <div class="pb-2">
                                                Duration: {{ $loan->month }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Interest Rate: {{ $loan->interest }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Penalty Rate: {{ $loan->penalty }} <br />
                                            </div>




                                        </td>
                                        {{-- <td>
                                            {{ $loan->staff_firstname }} {{ $loan->staff_lastname }} <br />

                                        </td> --}}
                                        <td>
                                            <div class="pb-2">
                                                Loan Amount: ${{ $loan->amount }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Start Date: {{$loan->startdate}}<br>
                                            </div>
                                            <div class="pb-2">

                                                End Date:  {{$loan->enddate}}
                                            </div>




                                        </td>
                                        <td>
                                            <div class="pb-2">
                                                Monthly Paid: ${{ $loan->costAmount }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Interest Paid: ${{ $loan->interestAmount }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Penalty Paid: ${{ $loan->penaltyAmount }} <br />
                                            </div>
                                            <div class="pb-2">
                                                Total Amount: ${{ $loan->totalAmount }} <br />
                                            </div>
                                        </td>
                                        <td>
                                            @if($loan->status == 0)
                                                <label class="badge badge-warning">In progress</label>
                                            @elseif($loan->status == 1)
                                                <label class="badge badge-success">Completed</label>
                                            @elseif($loan->status == 2)
                                                <label class="badge badge-danger">Pending</label>
                                            @endif

                                        </td>

                                        <td>
                                            <div class=" ">
                                                <button class="btn btn-outline-primary btn-sm editbtn" type="button"
                                                    value="{{ $loan->loanId }}"><i class="fa fa-edit">
                                                    </i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm delete_borrower" type="button"
                                                    id="deleteloan" value="{{ $loan->loanId }}"><i class="fa fa-trash"></i>
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
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright
                                © bootstrapdash.com 2020</span>
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Distributed
                                By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span>
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
    <div class="modal fade " id="loanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Loan Form</h4>
                        <p class="card-description">
                            Please Enter Information Below
                        </p>
                        <hr>

                        <form class="forms-sample" action="/addLoan" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label"><b>Borrower</b></label>
                                        <div class="col-sm-9">

                                            <select name="borrowerid" id="borrowerid" class="form-control" required>
                                                <option selected disabled value="">
                                                    Select Borrower</option>
                                                @foreach ($borrowers as $borrower)
                                                    <option value="{{ $borrower->borrowerid }}">
                                                        {{ $borrower->firstname }} {{ $borrower->lastname }}
                                                    </option>
                                                @endforeach
                                            </select>


                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label"><b>Loan
                                                Plan</b></label>
                                        <div class="col-sm-9">

                                            <select name="loanplanId" id="loanplanId" class="form-control" required>
                                                <option selected disabled value="">
                                                    Select Loan Plan</option>
                                                @foreach ($loanplans as $loanplan)
                                                    <option value="{{ $loanplan->loanplanId }}">
                                                        Month:{{ $loanplan->month }} Interest %:{{ $loanplan->interest }}
                                                    </option>
                                                @endforeach
                                            </select>


                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label"><b>Loan
                                                Type</b></label>


                                        <div class="col-sm-9">

                                            <select name="loantypeId" id="loantypeId" class="form-control" required>
                                                <option selected disabled value="">
                                                    Select Loan Type</option>
                                                @foreach ($loantypes as $loantype)
                                                    <option value="{{ $loantype->loantypeId }}">
                                                        {{ $loantype->typename }}
                                                    </option>
                                                @endforeach
                                            </select>


                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label"><b>Loan
                                                Giver</b></label>
                                        <div class="col-sm-9">

                                            <select name="staffId" id="staffId" class="form-control" required>
                                                <option selected disabled value="">
                                                    Select Loan Giver</option>
                                                @foreach ($staffs as $staff)
                                                    <option value="{{ $staff->staffId }}">
                                                        {{ $staff->staff_firstname }} {{ $staff->staff_lastname }}
                                                    </option>
                                                @endforeach
                                            </select>


                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>Amount</b></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="exampleInputMobile"
                                                placeholder="Amount" name="amount" id="amount" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>LRC</b></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="exampleInputMobile"
                                                placeholder="Loan Recovery Number" name="lrcid" id="lrc" required>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>Start Date</b></label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="exampleInputMobile"
                                                placeholder="Start Date" name="startdate" id="startdate"
                                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>Status</b></label>
                                        <div class="col-sm-9">
                                            <select name="status" id="" class="form-control" >
                                                <option selected disabled value="">
                                                    Select Status</option>
                                                <option value="0">In Progress</option>
                                                <option value="1">Complete</option>
                                                <option value="2">Pending</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">

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
                                    </div> --}}
                            <hr>

                            <button type="submit" class="btn btn-primary mr-2">Save
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
    <div class="modal fade " id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Loan Form Update</h4>
                        <p class="card-description">
                            Please Enter Information Below
                        </p>
                        <hr>

                        <form class="forms-sample" action="/updateLoan" method="POST">

                            @csrf
                            @method('PUT')



                            <input type="hidden" name="loanId" id="edit_loanid">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label"><b>Borrower</b></label>
                                        <div class="col-sm-9">

                                            <select name="borrowerid" id="edit_borrowerid" class="form-control">

                                            </select>


                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label"><b>Loan
                                                Plan</b></label>
                                        <div class="col-sm-9">

                                            <select name="loanplanId" id="edit_loanplanId" class="form-control" required>

                                            </select>


                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label"><b>Loan
                                                Type</b></label>


                                        <div class="col-sm-9">

                                            <select name="loantypeId" id="edit_loantypeId" class="form-control" required>

                                            </select>


                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label"><b>Loan
                                                Giver</b></label>
                                        <div class="col-sm-9">

                                            <select name="staffId" id="edit_staffid" class="form-control">

                                            </select>


                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>Amount</b></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Amount"
                                                name="amount" id="edit_amount" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>LRC</b></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                placeholder="Loan Recovery Number" name="lrcid" id="edit_lrc" required>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>Start Date</b></label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control"
                                                placeholder="Start Date" name="startdate" id="edit_startdate"
                                                value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputMobile"
                                            class="col-sm-3 col-form-label"><b>Status</b></label>
                                        <div class="col-sm-9">
                                            <select name="status" id="edit_status" class="form-control" >
                                                <option selected disabled value="">
                                                    Select Status</option>
                                                <option value="0">In Progress</option>
                                                <option value="1">Complete</option>
                                                <option value="2">Pending</option>

                                            </select>
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
    <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="staticBackdropLabel">Delete Loan</h3>
                </div>
                <form action="/deleteLoan" method="POST">
                    @csrf
                    <input type="hidden" name="LoanId" id="deleteid">
                    <div class="modal-body">
                        Are you sure, You want to delete this Loan?
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

            $('#newLoan').click(function(e) {
                e.preventDefault();
                $('#loanModal').modal('show');
            });


            $(document).on('click', '#deleteloan', function() {
                var id = $(this).val();

                $('#deleteModal').modal('show');
                $('#deleteid').val(id);
            });

            // $(document).on('click', '.editbtn', function() {
            //     var id = $(this).val();

            //     $('#editModal').modal('show');
            //     $.ajax({
            //         type: "GET",
            //         url: "/editLoan/" + id,
            //         success: function(response) {
            //              Debugging
            //             console.log('Borrower Data:', response.borrowers);

            //              Check if the response data exists and has the expected structure
            //             if (response.loans && response.borrowers && response.loanplans && response.loantypes ) {
            //                 $('#edit_loanid').val(response.loans.loanId);
            //                 $('#edit_amount').val(response.loans.amount);


            //                  Populate genders select field
            //                 var borrowerSelect = $('#edit_borrowerid');
            //                 borrowerSelect.empty(); // Clear previous options

            //                 $.each(response.borrowers, function(key, borrower) {
            //                      Debugging
            //                     console.log('Processing Gender:', gender);

            //                     var isSelected = (response.loans.borrowerid == borrower
            //                         .borrwerid) ? 'selected' : '';
            //                     console.log('isSelected:', isSelected);
            //                     borrowerSelect.append('<option value="' + borrower
            //                         .borrowerid + '" ' + isSelected + '>' + borrower.firstname +'' + borrower.firstname +  '</option>');

            //                 });

            //                 Ensure the selected option is set correctly
            //                 $('#edit_borrowerid').val(response.loans.borrowerid);
            //             } else {
            //                 console.error('Unexpected response structure:', response);
            //             }
            //         },
            //         error: function(err) {
            //             console.error('AJAX Error:', err.responseText);
            //         }
            //     });


            // });

            $(document).on('click', '.editbtn', function() {
                var id = $(this).val();

                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/editLoan/" + id,
                    success: function(response) {
                        // Debugging
                        console.log('Loan Data:', response.loans);
                        console.log('Borrower Data:', response.borrowers);
                        console.log('Loan Plan Data:', response.loanplans);
                        console.log('Loan Type Data:', response.loantypes);

                        // Check if the response data exists and has the expected structure
                        if (response.loans && response.borrowers && response.loanplans &&
                            response.loantypes) {
                            // Populate the form fields

                            $('#edit_loanid').val(response.loans.loanId);
                            $('#edit_amount').val(response.loans.amount);
                            $('#edit_lrc').val(response.loans.lrcid);
                            $('#edit_status').val(response.loans.status);
                            $('#edit_startdate').val(response.loans.startdate);


                            // Populate borrower select field
                            var borrowerSelect = $('#edit_borrowerid');
                            borrowerSelect.empty(); // Clear previous options

                            $.each(response.borrowers, function(key, borrower) {
                                var isSelected = (response.loans.borrowerid == borrower
                                    .borrowerid) ? 'selected' : '';
                                borrowerSelect.append('<option value="' + borrower
                                    .borrowerid + '" ' + isSelected + '>' + borrower
                                    .firstname + ' ' + borrower.lastname +
                                    '</option>');
                            });

                            // Ensure the selected option is set correctly
                            $('#edit_borrowerid').val(response.loans.borrowerid);

                            // Populate loan plan select field
                            var loanplanSelect = $('#edit_loanplanId');
                            loanplanSelect.empty(); // Clear previous options

                            $.each(response.loanplans, function(key, loanplan) {
                                var isSelected = (response.loans.loanplanId == loanplan
                                    .loanplanId) ? 'selected' : '';
                                //loanplanSelect.append('<option value="' + loanplan.loanplanId + '" ' + isSelected + '>' 'Month:'+ loanplan.month +'Interest:'''+ loanplan.interest +'Penalty:'''+ loanplan.penalty + ' </option>');
                                loanplanSelect.append('<option value="' + loanplan
                                    .loanplanId + '" ' + isSelected + '>Month: ' +
                                    loanplan.month + ' ,Interest: ' + loanplan
                                    .interest + '% ,  Penalty: ' + loanplan
                                    .penalty + '%</option>');
                            });

                            // Ensure the selected option is set correctly
                            $('#edit_loanplanId').val(response.loans.loanplanId);

                            // Populate loan type select field
                            var loantypeSelect = $('#edit_loantypeId');
                            loantypeSelect.empty(); // Clear previous options

                            $.each(response.loantypes, function(key, loantype) {
                                var isSelected = (response.loans.loantypeId == loantype
                                    .loantypeId) ? 'selected' : '';
                                loantypeSelect.append('<option value="' + loantype
                                    .loantypeId + '" ' + isSelected + '>' + loantype
                                    .typename + '</option>');
                            });

                            // Ensure the selected option is set correctly
                            $('#edit_loantypeId').val(response.loans.loantypeId);

                            // Populate borrower select field
                            var staffSelect = $('#edit_staffid');
                            staffSelect.empty(); // Clear previous options

                            $.each(response.staffs, function(key, staff) {
                                var isSelected = (response.loans.staffId == staff
                                    .staffId) ? 'selected' : '';
                                staffSelect.append('<option value="' + staff.staffId +
                                    '" ' + isSelected + '>' + staff
                                    .staff_firstname + ' ' + staff.staff_lastname +
                                    '</option>');
                            });

                            // Ensure the selected option is set correctly
                            $('#edit_staffid').val(response.loans.staffId);
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
