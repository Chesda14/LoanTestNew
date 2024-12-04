@extends('index')

@section('content')
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="pt-2">
                                        <u>Loan Type Form</u>
                                    </h5>
                                    <p class="card-description">
                                        Enter Information Below
                                    </p>
                                    <form class="forms-sample">
                                        <input type="hidden" id="txttypeId" name="loantypeId">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label"><b>Type
                                                    Name</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txttypename"
                                                     placeholder="Loan Type">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputEmail2"
                                                class="col-sm-3 col-form-label"><b>Description
                                                </b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="txtdesc"
                                                    placeholder="Loan Description">
                                            </div>
                                        </div>



                                        <button type="button" class="btn btn-primary mr-2" id="newType">Save</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- main-panel ends -->

                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="pt-2">
                                        <u>Loan Type List</u>
                                    </h5>
                                    {{-- <p class="card-description">
                                  Add class <code>.table-hover</code>
                                </p> --}}
                                    <div class="table-responsive pt-3">
                                        <table class="table table-hover" id="tblloantype">
                                            <thead>
                                                <tr>
                                                    <th><b>N0.</b></th>
                                                    <th><b>Type Name</b></th>
                                                    <th><b>Description</b></th>

                                                    <th><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                ?>
                                                @foreach ($loantypes as $loantype)
                                                    <tr data-id="{{ $loantype->loantypeId }}">
                                                        <td><b>{{ $i++ }}.</b></td>
                                                        <td>{{ $loantype->typename }}</td>
                                                        <td>{{ $loantype->desc }}</td>

                                                        <td>
                                                            <div class=" ">
                                                                <button data-id=""
                                                                    class="btn btn-outline-primary btn-sm editbtn"
                                                                    type="button" value=""><i class="fa fa-edit">
                                                                    </i>
                                                                </button>
                                                                <button class="btn btn-outline-danger btn-sm "
                                                                    type="button" id="deleteloantype"
                                                                    value="{{ $loantype->loantypeId }}"><i
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
            <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5" id="staticBackdropLabel">Delete Loan Type</h3>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <form action="/deleteLoantype" method="POST">
                            @csrf
                            <input type="hidden" name="loantypeId" id="deleteid">
                            <div class="modal-body">
                                Are you sure, You want to delete this Loan Type ?
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
    $(document).on('click', '#deleteloantype', function() {
        var id = $(this).val();

        $('#deleteModal').modal('show');
        $('#deleteid').val(id);
    });




    $(document).ready(function() {

        $('#newType').click(function() {


            var loantypeId = $('#txttypeId').val();
            var typename = $('#txttypename').val();
            var desc = $('#txtdesc').val();


            $.post('/addLoantype', {
                    txttypeId: loantypeId,
                    txttypename: typename,
                    txtdesc: desc

                },

                function(data, status) {
                    if (data == 1) {
                        window.location.href = 'loantype';
                    }
                });


        });

        $('#tblloantype').on('click', '.editbtn', function() {
            var current_row = $(this).closest('tr');
            var loantypeId = current_row.data('id');
            var typename = current_row.find('td').eq(1).text();
            var desc = current_row.find('td').eq(2).text();


            $('#txttypeId').val(loantypeId);
            $('#txttypename').val(typename);
            $('#txtdesc').val(desc);


        });

    });



</script>
@endsection
