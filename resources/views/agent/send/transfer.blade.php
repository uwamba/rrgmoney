<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('agent.components.head')

@include('agent.components.header')

{{-- Alert Messages --}}
@include('common.alert')

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center">

            <form method="POST" action="{{ route('send.transferNext') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group text-center">
                        <div class="card text-center ">
                            <div class="card-header">
                                Find Sender
                            </div>
                            <div class="card-header">


                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Enter Sender Phone" aria-label="Search" name="phone"
                                        id="phone" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <a href="javascript:void(0)" id="find-user" class="btn btn-info">Find</a>
                                    </div>
                                    <div class="spinner-border" id="progress" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" id="details">
                                <ul class="list-group">

                                    <li class="list-group-item" id="names"></li>
                                    <li class="list-group-item" id="country"></li>
                                    <li class="list-group-item" id="email"></li>
                                    <li class="list-group-item" id="address"></li>
                                </ul>
                            </div>


                        </div>
                       
                        <input type="hidden" name="names" value="" id="names_id">
                        <input type="hidden" name="email" value="" id="email_id">
                        <input type="hidden" name="phone" value="" id="phone_id">
                        <input type="hidden" name="address" value="" id="address_id">
                        <input type="hidden" name="sender_id" value="" id="sender_id">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Next</button>
                </div>
        </div>
    </div>
    </form>
</div>
</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('#amount').hide();
        $('#progress').hide();
        $('#sent_amount').hide();
        $('#rate').hide();
        $('#details').hide();


        $("#find-user").click(function() {
            $('#progress').show();
            var phone = $('#phone').val();
            var currency = "";
            var name = "";


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
                    var user_id = dataResult.user_id;
                    var bodyData = '';
                    var i = 1;
                    var currency = "";
                    if(resultData.length === 0){
                        $('#progress').hide();
                        alert("Recever not found, please verify number and try again");

                    }
                    else{

                        $.each(resultData, function(index, row) {
                        $('#balance').text("Balance: " + balance);
                        $('#names').text("Names: " + row.first_name + " " + row
                            .last_name);
                        $('#email').text("Email: " + row.email);
                        $('#address').text("Address: " + row.address);
                        $('#country').text("Country: " + row.country);
                        currency = row.currency_name;
                        var name = row.first_name;

                        $('#sender_id').val(user_id);
                        $('#sender_rate').val(row.currency_ratio);
                        $('#balance_id').val(balance);
                        $('#names_id').val(row.first_name + " " + row.last_name);
                        $('#email_id').val(row.email);
                        $('#currency_id').val(row.currency_name);
                        $('#phone_id').val(row.mobile_number);
                        $('#address_id').val(row.address);




                    })
                    if ($('#phone_id').val() == "") {
                        alert("Recever not found, please verify number and try again");
                    } else {
                        $('#progress').hide();
                        $('#details').show();
                        $('#amount_sent_label').text("Amount To Sent in " +
                            {{ Js::from($user_currency) }});
                        $('#amount_receive_label').text("Amount To Receive in " + currency);
                    }


                    }


                    

                },
                error: function(xhr, status, error) {
                    $('#progress').hide();
                  alert("Error: please verfy number and try agian");
                }

            })





        });
    });

    /* When click show user */
</script>






@extends('customer.components.footer')
@include('common.logout-modal')
</body>

</html>
