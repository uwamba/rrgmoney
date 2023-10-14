<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@extends('customer.components.head')

@include('customer.components.header')

    <div class="col-sm-6 container-fluid py-5">
        <div class="container">
            <div class="row g-2">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Account Top Up</h1>

                </div>

                {{-- Alert Messages --}}
                @include('common.alert')

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
                    </div>
                    <form method="POST" action="{{ route('topup.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="d-flex justify-content-center">

                                {{-- AMOUNT --}}
                                <div class="col-sm-6 mb-3 mt-3 mb-sm-0 text-center">
                                    <Label class="text-gray-800"><span style="color:red;">*</span>Amount</label>
                                    <input type="text"
                                        class="form-control form-control-user @error('amount') is-invalid @enderror text-gray-400"
                                        id="amount" placeholder="Amount" name="amount"
                                        value="{{ old('amount') }}">

                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror


                                    <span style="color:red;">*</span>Payment Type</label>
                                    <select
                                        class="form-control form-control-user @error('payment') is-invalid @enderror"
                                        id="payment" name="payment">
                                        <option selected disabled>Select Payment Type</option>
                                        <option value="CASH">CASH</option>
                                        <option value="Mobile">Mobile Money</option>
                                        <option value="BANK">BANK</option>
                                    </select>
                                    @error('payment')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <span style="color:red;">*</span>Account Number</label>
                                    <select
                                        class="form-control form-control-user @error('reference') is-invalid @enderror"
                                        id="account_number" name="reference">
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                            <a class="btn btn-primary float-right mr-3 mb-3"
                                href="{{ route('topup.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>


    <!-- Script -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {

            $('#payment').on('change', function() {

                var type = $('#payment').val();


                $.ajax({
                    url: "{{ route('topup.find') }}",
                    type: "GET",
                    dataType: 'JSON',
                    data: {
                        'type': type
                    },
                    success: function(dataResult) {
                        var resultData = dataResult.data;
                        $("#account_number").find('option').remove().end();


                        var option = $("<option />");
                        if (Object.keys(dataResult.data).length > 0) {

                            $.each(resultData, function(index, row) {
                                option.html(row.number);
                                option.val(row.number);
                                $('#account_number').append(option);

                            });
                        } else {

                            option.html("CASH");
                            option.val("CASH");
                            $('#account_number').append(option);
                        }


                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.responseText);
                    },

                })

            });
        });

        /* When click show user */
    </script>





    @extends('customer.components.footer')
    @include('common.logout-modal')
</body>

</html>
