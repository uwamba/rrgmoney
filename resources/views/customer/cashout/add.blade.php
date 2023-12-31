
{{-- Include Head --}}
@include('customer.components.head')
@include('customer.components.header')

    <div class="col-sm-6 container-fluid py-5">
        <div class="container">
            <div class="row g-2">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">CASH OUT</h1>

                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cash out</h6>
                    </div>
                    <form method="POST" action="{{route('cashout.store')}}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">

                                {{-- AMOUNT --}}
                                <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                    <span style="color:red;">*</span>Amount</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-user @error('amount') is-invalid @enderror"
                                        id="amount"
                                        placeholder="Amount"
                                        name="amount"
                                        value="{{ old('amount') }}">

                                    @error('amount')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                      {{-- Payment Type --}}
                                <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                    <span style="color:red;">*</span>Payment Type</label>
                                    <select class="form-control form-control-user @error('payment') is-invalid @enderror" name="payment" id="payment">
                                        <option selected disabled>Select Payment Type</option>
                                        <option value="CASH" selected>CASH</option>
                                        <option value="MOMO" selected>MOMO</option>
                                        <option value="BANK DEPOSIT" selected>BANK DEPOSIT</option>
                                        <option value="BANK TRANSFER" selected>BANK TRANSFER</option>
                                    </select>
                                    @error('payment')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>


                                 {{-- details --}}
                                 <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                    <span style="color:red;">*</span>details</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-user @error('details') is-invalid @enderror"
                                        id="details"
                                        placeholder="Add payment detail like bank account,bank name,momo number for payment"
                                        name="details" id="details"
                                        value="{{ old('details') }}">

                                    @error('details')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                             <button type="button" id="open-modal" onclick="modal()" class="btn btn-primary"   data-id="">Cash out</button>

                        </div>
                         @include('customer.cashout.confirm-modal')
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
         function modal() {
                    var amount=$('#amount').val();
                    $("#amountH").text(amount);

                    var method=$('#payment').val();
                    $("#method").text(method);

                    var details=$('#details').val();
                    $("#Details").text(details);
                    // var method=document.getElementById('payment').val();
                    $('#confirm-modal').modal('show');

                  }
                  function closeModal() {
                    $('#confirm-modal').modal('hide');

                 }

        /* When click show user */
    </script>





    @extends('customer.components.footer')
    @include('common.logout-modal')
</body>

</html>
