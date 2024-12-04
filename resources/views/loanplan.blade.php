@extends('index')

@section('content')
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="pt-2">
                                        <u>Loan Plan Form</u>
                                    </h5>
                                    <p class="card-description">
                                        Enter Information Below
                                    </p>
                                    <hr>
                                    <form class="forms-sample">
                                        <input type="hidden" id="txtloanId" name="loanplanId">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label"><b>Month</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txtmonth"
                                                    placeholder=" Month">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label"><b>Interest
                                                    Percentage</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txtinterest"
                                                    placeholder="Interest Percentage">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label"><b>Penalty
                                                    Rate</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txtpenalty"
                                                    placeholder="Penalty Rate">
                                            </div>
                                        </div>
                                        <hr>

                                        <button type="button" class="btn btn-primary mr-2" id="newPlan">Save</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- main-panel ends -->

                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="pt-2">
                                        <u>Loan Plan Form</u>
                                    </h5>
                                    {{-- <p class="card-description">
                                  Add class <code>.table-hover</code>
                                </p> --}}

                                    <div class="table-responsive pt-3">
                                        <hr>
                                        <table class="table table-hover" id="tblloanplan">
                                            <thead>
                                                <tr>
                                                    <th><b>N0.</b></th>
                                                    <th><b>Month</b></th>
                                                    <th><b>Interest %</b></th>
                                                    <th><b>Penalty Rate</b></th>
                                                    <th><b>Action</b></th>
                                                </tr>

                                            </thead>

                                            <tbody>
                                                <?php
                                                $i = 1;
                                                ?>
                                                @foreach ($loanplans as $loanplan)


                                                <tr data-id="{{ $loanplan->loanplanId }}">
                                                    <td><b>{{$i++}}.</b></td>
                                                    <td>{{$loanplan ->month}}</td>
                                                    <td>{{$loanplan ->interest}}</td>
                                                    <td>{{$loanplan ->penalty}}</td>
                                                    <td>
                                                        <div class=" ">
                                                            <button data-id=""
                                                                class="btn btn-outline-primary btn-sm editbtn"
                                                                type="button" value=""><i
                                                                    class="fa fa-edit">
                                                                </i>
                                                            </button>
                                                            <button
                                                                    class="btn btn-outline-danger btn-sm delete_borrower"
                                                                    type="button" id="deleteloanplan"
                                                                    value="{{ $loanplan->loanplanId }}"><i
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
                            </div>
                        </div>
                    </div>
                    <!-- page-body-wrapper ends -->
                </div>
                <!-- container-scroller -->
            </div>


           <!-- Delete Modal -->
           <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog"
           aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                   <div class="modal-header">
                       <h3 class="modal-title fs-5" id="staticBackdropLabel">Delete Loan Plan</h3>
                       {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                   </div>
                   <form action="/deleteLoanplan" method="POST">
                       @csrf
                       <input type="hidden" name="loanplanId" id="deleteid">
                       <div class="modal-body">
                           Are you sure, You want to delete this Loan Plan ?
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
    $(document).on('click', '#deleteloanplan', function() {
            var id = $(this).val();

            $('#deleteModal').modal('show');
            $('#deleteid').val(id);
        });

    $(document).ready(function() {

        $('#newPlan').click(function(e) {
            e.preventDefault();

            var loanplanId = $('#txtloanId').val();
            var month = $('#txtmonth').val();
            var interest = $('#txtinterest').val();
            var penalty = $('#txtpenalty').val();

            $.post('/addLoanplan', {
                    txtloanId: loanplanId,
                    txtmonth: month,
                    txtinterest: interest,
                    txtpenalty: penalty
                },

                function(data, status) {
                   if(data == 1){
                    window.location.href='loanplan';
                   }
                });

        });

        $('#tblloanplan').on('click', '.editbtn', function() {
            var current_row = $(this).closest('tr');
            var loanplanId = current_row.data('id');
            var month = current_row.find('td').eq(1).text();
            var interest = current_row.find('td').eq(2).text();
            var penalty = current_row.find('td').eq(3).text();

            $('#txtloanId').val(loanplanId);
            $('#txtmonth').val(month);
            $('#txtinterest').val(interest);
            $('#txtpenalty').val(penalty);


        });




        // $(document).on('click', '#deleteborrower', function() {
        //     var id = $(this).val();

        //     $('#deleteModal').modal('show');
        //     $('#deleteid').val(id);
        // });




    });
</script>

@endsection
