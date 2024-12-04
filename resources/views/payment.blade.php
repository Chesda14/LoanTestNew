@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="pt-2"><u>Payment List</u></h5>
                    {{-- <p class="card-description">
            Add class <code>.table-striped</code>
            </p> --}}
                    <div class="template-demo d-flex float-right">
                        <button type="button" class="btn btn-primary" id="newPayment">New
                            Payment
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
                        <table class="table table-striped" id="tblPayment">
                            <thead>
                                <tr>
                                    <th>
                                        <b>N0.</b>
                                    </th>
                                    <th>
                                        <b>Loan Detail</b>
                                    </th>
                                    <th>
                                        <b>Return Amount</b>
                                    </th>
                                    <th>
                                        <b>Penalty</b>
                                    </th>
                                    <th>
                                        <b>Datetime</b>
                                    </th>
                                    <th>
                                        <b>Next Payment</b>
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
                                @foreach ($payments->reverse() as $payment)
                                    <tr>
                                        {{-- <input type="hidden" name="borrowerid"
                                        value="{{ $key->borrowerid }}"> --}}
                                        <td class="">
                                            {{ $i++ }}.
                                        </td>
                                        <td>
                                            Borrower:{{ $payment->firstname }} {{ $payment->lastname }}<br>
                                            <br>
                                            Loan Plan: Month:{{ $payment->month }} / Interest:{{ $payment->interest }} /
                                            Penalty: {{ $payment->penalty }}<br>
                                            <br>
                                            Loan Amount:$ {{ $payment->amount }}

                                        </td>
                                        <td>
                                            $ {{ $payment->costAmount}}
                                        </td>
                                        <td>
                                            $ {{ $payment->penaltyAmount }}
                                        </td>
                                        <td>
                                             {{ $payment->datetime }}
                                        </td>
                                        <td>
                                            {{ $payment->nextpayment }}
                                       </td>


                                        <td>
                                            <div class=" ">
                                                <button data-id="" class="btn btn-outline-primary btn-sm editbtn"
                                                    type="button" value="{{ $payment->paymentId }}"><i class="fa fa-edit">
                                                    </i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm delete_borrower" type="button"
                                                    id="deletepayment" value="{{ $payment->paymentId }}"><i
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
            <!-- New Payment Modal -->
            <div class="modal fade " id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="">Payment Form</h4>
                                <p class="card-description">
                                    Please Enter Information Below
                                </p>
                                <hr>

                                <form class="forms-sample" action="/addPayment" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-4 col-form-label"><b>Loan Recovery Number</b></label>
                                                <div class="col-sm-8">
                                                    <select name="lrcid" id="lrc" class="form-control lrc" required>
                                                        <option selected disabled value="">
                                                            Select Loan</option>
                                                        @foreach ($loans as $loan)
                                                            <option value="{{ $loan->lrcid }}">
                                                                {{ $loan->lrcid }}

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
                                                <label for="exampleInputEmail2"
                                                    class="col-sm-3 col-form-label"><b>Amount</b></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control returnamount"
                                                        placeholder="Return Amount" name="costAmount" id="returnamount"
                                                        required>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Penalty</b></label>


                                                <div class="col-sm-9">

                                                    <input type="text" class="form-control returnpenalty"
                                                        placeholder="Penalty Amount" name="penaltyAmount" id="returnpenalty"
                                                        required>


                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Payment Date</b></label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control"
                                                        placeholder="Payment Date" name="datetime"
                                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


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
            <!--END New Payment Modal -->

            <!-- Edit Payment Modal -->
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

                                <form class="forms-sample" action="/updatePayment" method="POST">

                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="paymentId" id="edit_paymentId">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-4 col-form-label"><b>Loan Recovery Number</b>
                                                </label>
                                                <div class="col-sm-8">
                                                    <select name="lrcid" id="edit_lrcid" class="form-control lrc">

                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputEmail2"
                                                    class="col-sm-3 col-form-label"><b>Amount</b></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control returnamount"
                                                        placeholder="Return Amount" name="costAmount"
                                                        id="edit_returnamount" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="edit_genderid" class="col-sm-3 col-form-label"><b>
                                                        Penalty</b></label>


                                                <div class="col-sm-9">

                                                    <input type="text" class="form-control returnpenalty"
                                                        placeholder="Return Amount" name="penaltyAmount"
                                                        id="edit_returnpenalty" required>


                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group row">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label"><b>Payment Date</b></label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control"
                                                        placeholder="Payment Date" name="datetime" id="edit_datetime"
                                                        required>
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
            <!--END Edit Payment Modal -->

            <!-- Delete Modal -->
            <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5" id="staticBackdropLabel">Delete Borrower</h3>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <form action="/deletePayment" method="POST">
                            @csrf
                            <input type="hidden" name="paymentId" id="deleteid">
                            <div class="modal-body">
                                Are you sure, You want to delete this Payment ?
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {

            $('#newPayment').click(function(e) {
                e.preventDefault();
                $('#paymentModal').modal('show');
            });


            $(document).on('click', '#deletepayment', function() {
                var id = $(this).val();

                $('#deleteModal').modal('show');
                $('#deleteid').val(id);
            });

            $('.lrc').change(function() {
            var lrcid = $(this).val();
            if (lrcid) {
                $.ajax({
                    url: "/getpayment/",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        lrcid: lrcid
                    },
                    success: function(data) {
                        if(data) {
                            $('.returnamount').val(data.costAmount);
                            $('.returnpenalty').val(data.penaltyAmount);
                        } else {
                            $('.returnamount').val('');
                            $('.returnpenalty').val('');
                        }
                    }
                });
            } else {
                $('.returnamount').val('');
                $('.returnpenalty').val('');
            }
        });



            $(document).on('click', '.editbtn', function() {
                var id = $(this).val();

                // $('#editModal').modal('show');
                // $.ajax({
                //     type: "GET",
                //     url: "/editPayment/" + id,
                //     success: function(response) {
                //         console.log('Response Data:', response);
                //         if (response.payments && response.loans ) {

                //             $('#edit_paymentId').val(response.payments.paymentId);
                //             $('#edit_returnamount').val(response.payments.returnamount);
                //             $('#edit_returnpenalty').val(response.payments.returnpenalty);


                //             var loanSelect = $('#edit_loanId');
                //             loanSelect.empty();

                //             $.each(response.loans, function(key, loan) {
                //                 var isSelected = (response.payments.loanId == loan
                //                     .loanId) ? 'selected' : '';
                //                 loanSelect.append('<option value="' + loan.loanId +
                //                     '" ' + isSelected + '>' + loan.firstname + ' ' +
                //                     loan.lastname +' | '+ loan.taxid + '</option>');
                //             });


                //             $('#edit_loanId').val(response.payments.edit_loanId);



                //         } else {
                //             console.error('Unexpected response structure:', response);
                //         }
                //     },
                //     error: function(err) {
                //         console.error('AJAX Error:', err.responseText);
                //     }
                // });


                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/editPayment/" + id,
                    success: function(response) {
                        console.log('Response Data:', response);
                        if (response.payments && response.loans) {
                            // Populate the form fields
                            $('#edit_paymentId').val(response.payments.paymentId);
                            $('#edit_returnamount').val(response.payments.costAmount);
                            $('#edit_returnpenalty').val(response.payments.penaltyAmount);
                            $('#edit_datetime').val(response.payments.datetime);

                            // Populate loan select field
                            var loanSelect = $('#edit_lrcid');

                            // Clear previous options
                            loanSelect.empty();

                            $.each(response.loans, function(key, loan) {
                                var isSelected = (response.payments.lrcid == loan.lrcid) ? 'selected' : '';
                                loanSelect.append('<option value="' + loan.lrcid + '" ' + isSelected + '>' + loan.lrcid +  '</option>');
                            });

                            // Ensure the selected option is set correctly
                            $('#edit_lrcid').val(response.payments.lrcid);

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
