@extends('layouts.app')

@section('title', 'Sender Details')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Money Transfer</h5>
                <a href="{{ route('users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <form method="POST" action="{{ route('send.transferNext') }}">
                @csrf

                <div class="card-body">
                    <div class="form-group row">
                        <div class="card text-center" style="width: 100%; ">
                            <div class="card-header">
                                Transfer
                            </div>
                            <div class="card-body">
                                <div class="col-sm-7 mb-3 mt-3 mb-sm-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Enter Sender Phone" aria-label="Search" name="phone" id="phone" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" id="find-user" class="btn btn-info">Find</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="row" id="details" style="padding-left:30px">

                                <div class="card d-flex text-left col-sm-6 mb-3 mt-3 mb-sm-0" >
                                    <ul class="list-group list-group-flush">
                                      <li class="list-group-item" id="balance"></li>
                                       <li class="list-group-item" id="names"></li>
                                      <li class="list-group-item" id="country"></li>
                                      <li class="list-group-item" id="currency"></li>
                                      <li class="list-group-item" id="email"></li>
                                      <li class="list-group-item" id="address"></li>
                                    </ul>
                                </div>

                            </div>


                        </div>
                        <input type="hidden" name="balance_id" value="" id="balance_id">
                        <input type="hidden" name="rate_input_h" value="" id="rate_input_h">
                        <input type="hidden" name="sender_rate" value="" id="sender_rate">
                        <input type="hidden" name="charges_h" value="" id="charges_h">
                        <input type="hidden" name="names" value="" id="names_id">
                        <input type="hidden" name="email" value="" id="email_id">
                        <input type="hidden" name="amount_foregn_currency" value="" id="amount_foregn_currency_id">
                        <input type="hidden" name="amount_local_currency" value="" id="amount_local_currency_id">
                        <input type="hidden" name="currency" value="" id="currency_id">
                        <input type="hidden" name="phone" value="" id="phone_id">
                        <input type="hidden" name="address" value="" id="address_id">
                        <input type="hidden" name="receiver_id" value="" id="receiver_id">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Next</button>
                </div>
            </form>
        </div>

    </div>


@endsection
<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('#amount').hide();
        $('#sent_amount').hide();
        $('#rate').hide();
        $('#details').hide();
        var rate2=0;

        $('#amount_sent_label').text("Amount To Sent in "+{{ Js::from($user_currency) }});
        $('#amount_receive_label').text("Amount To Receive in "+rate2);

        // Department Change
        $('#amount_sent_btn').click(function() {

            var amount = $('#amount_sent').val();
            var userRate = {{ Js::from($rate) }}

            if ({{ Js::from($pricing_plan) }} == 'percentage') {
                $('#charges').text("Transfer Fee: "+{{ Js::from($percentage) }} * amount / 100);
                $('#charges_h').val({{ Js::from($percentage) }} * amount / 100);
            } else {
                $.each({{ Js::from($flate_rates) }}, function() {
                    if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent').val() <= this
                        .to_amount) {
                        $('#charges').val("Transfer Fee: "+this.charges_amount);
                        $('#charges_h').val(this.charges_amount);
                    } else {
                        $('#charges').val("");
                        $('#charges_h').val("");
                    }

                });
            }
            var rate = rate2;
            var total = parseFloat(((amount / userRate) * rate)).toFixed(2);
            $('#amount_receive').val(total);



            $('#amount_local_currency_id').val(amount);
            $('#amount_foregn_currency_id').val(total);



        });
        $('#amount_receive_btn').click(function() {
            var amount = $('#amount_receive').val();
            var userRate = {{ Js::from($rate) }}
            var rate = rate2;
            var total = parseFloat(((amount / rate) * userRate)).toFixed(2);
            $('#amount_sent').val(total);
            $('#amount_local_currency_id').val($('#amount_sent').val());
            $('#amount_foregn_currency_id').val(amount);
            var amount_sent = $('#amount_sent').val();

            if ({{ Js::from($pricing_plan) }} == 'percentage') {
                $('#charges').text("Transfer Fee: "+{{ Js::from($percentage) }} * amount_sent / 100);
                $('#charges_h').val({{ Js::from($percentage) }} * amount_sent / 100);
            } else {
                $.each({{ Js::from($flate_rates) }}, function() {

                    if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent').val() <= this
                        .to_amount) {
                        $('#charges').val("Transfer Fee in : "+this.charges_amount);
                        $('#charges_h').val(this.charges_amount);
                    } else {
                        $('#charges').val("");
                        $('#charges_h').val("");
                    }

                });
            }


        });

        $("#find-user").click(function() {

            var phone = $('#phone').val();
            var currency="";
            var rate1={{ Js::from($rate) }};
            var name="";


            $.ajax({
                url: "{{ route('send.find') }}",
                type: "GET",
                dataType: 'json',
                data: {
                    'mobile_number': phone
                },
                success: function(dataResult) {
                    var resultData = dataResult.data;
                     var balance = dataResult.balance;
                    var bodyData = '';
                    var i = 1;
                    var currency="";


                        $.each(resultData, function(index, row) {
                           $('#balance').text("Balance: "+balance);
                            $('#names').text("Names: "+row.first_name+" "+row.last_name);
                            $('#email').text("Email: "+row.email);
                            $('#address').text("Address: "+row.address);
                            $('#currency').text("Currency: "+row.currency_name);
                            $('#country').text("Country: "+row.country);
                            rate2=row.currency_ratio;
                            currency=row.currency_name;
                            var name=row.first_name;
                            $('#sender_rate').val(row.currency_ratio);
                            $('#balance_id').val(balance);
                            $('#names_id').val(row.first_name+" "+row.last_name);
                            $('#email_id').val(row.email);
                            $('#currency_id').val(row.currency_name);
                            $('#phone_id').val(row.mobile_number);
                            $('#address_id').val(row.address);




                        })
                        if($('#phone_id').val()==""){
                            alert("Recever not found, please verify number and try again");
                        }else{
                            $('#details').show();
                            $('#amount_sent_label').text("Amount To Sent in "+{{ Js::from($user_currency) }});
                             $('#amount_receive_label').text("Amount To Receive in "+currency);
                        }












                }

            })





        });
    });

    /* When click show user */
</script>
