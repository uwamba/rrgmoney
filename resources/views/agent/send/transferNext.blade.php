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
                               <div class="form-group row">
                                   <div class="card text-center bg-primary bg-gradient" style="width: 100%; ">
                                         <div class="row justify-content-center px-md-15">
                                            <div class="col-sm-3 d-flex justify-content-center">
                                               <ul class="list-group bg-primary bg-gradient">
                                                  <li class="list-group-item" ><h5>Country: {{$country}}</h5></li>
                                                  <li class="list-group-item" ><h5>Phone: {{$request->phone}}</h5></li>
                                                  <li class="list-group-item" ><h5>Email: {{$request->email}}</h5></li>

                                               </ul>
                                            </div>
                                            <div class="col-sm-3 d-flex justify-content-center ">
                                                   <ul class="list-group bg-primary bg-gradient">
                                                        <li class="list-group-item" ><h5>Names: {{$request->names}}</h5></li>
                                                        <li class="list-group-item" ><h5>Currency: {{$request->currency}}</h5></li>
                                                        <li class="list-group-item" ><h5>Rate:{{$request->sender_rate}}</h5></li>
                                                   </ul>
                                            </div>

                                         </div>
                                   </div>
                              </div>
                       <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 text-center" >
                         <form method="POST" action="{{ route('send.storeTransfer') }}">
                                @csrf
                                         <input type="hidden" name="rate_input_h" value="" id="rate_input_h">
                                          <input type="hidden" name="charges_h" value="" id="charges_h">
                                          <input type="hidden" name="receiver_rate" value="" id="receiver_rate">
                                           <input type="hidden" name="local_currency" value="{{$request->currency}}" id="sender_rate">
                                          <input type="hidden" name="names" value="" id="names_id">
                                          <input type="hidden" name="email" value="" id="email_id">
                                          <input type="hidden" name="amount_foregn_currency" value="" id="amount_foregn_currency_id">
                                          <input type="hidden" name="amount_local_currency" value="" id="amount_local_currency_id">
                                          <input type="hidden" name="currency" value="" id="currency_id">
                                          <input type="hidden" name="phone" value="" id="phone_id">
                                          <input type="hidden" name="sender_phone" value="{{$request->phone}}" id="sender_phone">
                                          <input type="hidden" name="address" value="" id="address_id">
                                          <input type="hidden" name="receiver_id" value="" id="receiver_id">
                                          <input type="hidden" name="sender_id" value="{{$request->sender_id}}" id="sender_id">
                              <div class="card-body">
                                  <div class="form-group row">
                                      <div class="card text-left" style="width: 100%; ">

                                         <div class="card-body">
                                                   <div class="input-group">
                                                        <input type="text" class="form-control bg-light border-0 small"
                                                            placeholder="Enter Receiver Phone" aria-label="Search" name="phone" id="phone" aria-describedby="basic-addon2">
                                                        <div class="input-group-append">
                                                            <a href="javascript:void(0)" id="find-user" class="btn btn-info">Find</a>
                                                        </div>
                                                        <div class="spinner-border" id="progress" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                   </div>
                                         </div>
                                         <div  class="row" id="details" style="padding-left:30px">

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" >
                                                    <ul class="list-group">
                                                      <li class="list-group-item" id="names"></li>
                                                      <li class="list-group-item" id="country"></li>
                                                      <li class="list-group-item" id="currency"></li>
                                                      <li class="list-group-item" id="rate_receiver"></li>
                                                      <li class="list-group-item" id="email"></li>
                                                      <li class="list-group-item" id="address"></li>
                                                    </ul>
                                                </div>
                                         </div>
                                      </div>
                                  </div>

                                <div class="form-group row" id="form_element">
                                 <div class="card text-left" style="width: 100%; ">

                                  <div class="card-body">
                                  <div class="input-group">
                                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left" >
                                   <div class="form-check form-switch">
                                    <input class="form-check-input font-size-20" type="checkbox" aria-describedby="inputGroup-sizing-lg"  name="switch1" id="switch1" checked>
                                    <label class="form-check-label font-weight-bold" for="flexSwitchCheckChecked" aria-describedby="inputGroup-sizing-lg">Transfer fees inclusive</label>
                                   </div>
                                  </div>
                                   <div class="input-group " style="margin-bottom:2px;">
                                   <Label>Amount to be Sent</Label>
                                   </div>

                                   <div class="input-group bg-light border-0 small" style="margin-bottom:2px;">
                                   <input type="text" class="p-2 mb-2 text-black form-control"
                                      placeholder="Enter Amount to send" aria-label="Search" name="amount_sent" id="amount_sent" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                     <a href="javascript:void(0)" id="amount_sent_btn" class="btn btn-info p-2 mb-2 ">Calculate</a>
                                   </div>
                                   </div>


                                   <div class="input-group " style="margin-bottom:2px;">
                                     <Label>Amount to be received</Label>
                                    </div>
                                    <div class="input-group ">
                                    <input type="text" class="p-2 mb-2 text-black form-control" placeholder="Enter Amount to receive" aria-label="Search" name="amount_receive" id="amount_receive" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <a href="javascript:void(0)" id="amount_receive_btn" class="btn btn-info p-2 mb-2">Calculate</a>
                                    </div>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                      <li class="list-group-item" id="charges"></li>
                                      <li class="list-group-item" id="total_amount_local"></li>
                                    </ul>

                                    <div class="input-group" style="margin-bottom:2px;">
                                     <Label>Select how to receive </Label>
                                    </div>
                                   <div class="input-group bg-light border-0 small">
                                      <select class="p-2 mb-2 text-black form-control" name="payment" id="payment">
                                        <option selected disabled>Select Payment Type</option>
                                        <option value="CASH" >CASH</option>
                                        <option value="MOMO" >Mobile Money</option>
                                        <option value="BANK" >BANK DEPOSIT</option>
                                        <option value="E-WALLET" >E-WALLET</option>
                                      </select>
                                    @error('payment')
                                      <span class="text-danger">{{$message}}</span>
                                    @enderror
                                   </div>
                                   <div class="input-group" style="margin-bottom:2px;">
                                      <Label>Enter receiver account details</Label>
                                   </div>
                                   <div class="input-group bbg-light border-0 small">
                                     <textarea class="p-3 mb-2 text-black form-control" id="description" name="details" rows="3"></textarea>
                                     @error('details')
                                      <span class="text-danger">{{$message}}</span>
                                     @enderror
                                   </div>
                                 </div>
                                </div>
                              </div>
                              </div>
                            <div class="card-footer" id="submit_button">
                                   <button type="button" id="open-modal" onclick="modal()" class="btn btn-primary"   data-id="">Next</button>
                            </div>
                            </div>
                            @include('agent.send.confirm-modal')
                         </form>
                      </div>
                </div>
              </div>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type='text/javascript'>
      $(document).ready(function() {
          $('#amount').hide();
          $('#submit_button').hide();
          $('#progress').hide();
          $('#sent_amount').hide();
          $('#rate').hide();
          $('#details').hide();
          $('#form_element').hide();

         var switchStatus = true;
         $("#switch1").on('change', function() {
             if ($(this).is(':checked')) {
                 switchStatus = $(this).is(':checked');

             }
             else {
                switchStatus = $(this).is(':checked');

             }
         });

          var rate2=0;

          $('#amount_sent_label').text("Amount To Sent in "+{{ Js::from($user_currency) }});
          $('#amount_receive_label').text("Amount To Receive in "+rate2);

          // Department Change
          $('#amount_sent_btn').click(function() {

              var amount = $('#amount_sent').val();
              var currencyRateReceiver = $('#receiver_rate').val();
              var currencyRateSender = {{ Js::from($request->sender_rate) }};
              var currencyRate=currencyRateSender/currencyRateReceiver;
              var perc={{ Js::from($percentage) }};
              var total=0;
              var fee=0;
              var sentAmount=0;

              if ({{ Js::from($pricing_plan) }} == 'percentage') {
                 if(switchStatus==true){
                   fee=parseFloat(amount) * parseFloat(perc)/(100+parseFloat(perc));
                   total=parseFloat(amount).toFixed(2);
                   sentAmount=parseFloat(amount).toFixed(2)-parseFloat(fee).toFixed(2);
                  $('#charges').text("Transfer Fee : "+parseFloat(fee).toFixed(2)) ;
                  $('#charges_h').val(fee);
                  $('#total_amount_local').text("Total amount: "+parseFloat(total).toFixed(2));
                 }else{
                   fee=parseFloat(amount) * parseFloat(perc)/100;
                   sentAmount=parseFloat(amount).toFixed(2);
                   total=eval(sentAmount)+eval(fee);
                   $('#charges').text("Transfer Fee : "+parseFloat(fee).toFixed(2)) ;
                   $('#charges_h').val(parseFloat(fee).toFixed(2));
                   $('#total_amount_local').text("Total amount: "+total);
                 }
              } else {

                  $.each({{ Js::from($flate_rates) }}, function() {

                   if(switchStatus==true){
                     total=parseFloat(amount);
                      if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent').val() <= this.to_amount) {
                          $('#charges').val("Transfer Fee: "+parseFloat(this.charges_amount).toFixed(2));
                          $('#charges_h').val(this.charges_amount);
                          $('#total_amount_local').text("Total amount: "+parseFloat(total).toFixed(2));
                      } else {
                          $('#charges').val("");
                          $('#charges_h').val("");
                          $('#total_amount_local').text("");
                                           }
                   }else{
                      total=parseFloat(this.charges_amount)+parseFloat(amount);
                       if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent').val() <= this.to_amount) {
                           $('#charges').val("Transfer Fee: "+parseFloat(this.charges_amount).toFixed(2));
                           $('#charges_h').val(parseFloat(this.charges_amount));
                           $('#total_amount_local').text("Total amount: "+parseFloat(total).toFixed(2));
                       } else {
                         $('#charges').val("");
                         $('#charges_h').val("");
                         $('#total_amount_local').text("");
                       }
                   }


                  });
              }
              $('#amount_receive').val(parseFloat(sentAmount*currencyRate).toFixed(2));
              $('#amount_local_currency_id').val(sentAmount);
              $('#amount_foregn_currency_id').val(parseFloat(sentAmount*currencyRate).toFixed(2));
          });

          $('#amount_receive_btn').click(function() {
              var amount = $('#amount_receive').val();
              var currencyRateReceiver = $('#receiver_rate').val();
              var currencyRateSender = {{ Js::from($request->sender_rate) }};
              var currencyRate=currencyRateSender/currencyRateReceiver;
              var perc={{ Js::from($percentage) }};
              var total = 0;
              var sentAmount = 0;
              var fee = 0;


              if ({{ Js::from($pricing_plan) }} == 'percentage') {
                 if(switchStatus==true){
                  sentAmount=eval(amount)+eval(fee);
                  fee=(amount/currencyRate) * perc/(100-perc);
                  total = (amount/currencyRate) + fee  ;
                  sentAmount=eval(total)+eval(fee);
                   $('#charges').text("Transfer Fee: "+parseFloat(fee).toFixed(2));
                   $('#charges_h').val(parseFloat(fee).toFixed(2));
                   $('#total_amount_local').text("Total amount: "+parseFloat(total).toFixed(2));
                 }else{
                  sentAmount = amount/currencyRate ;
                  fee=(amount/currencyRate) * perc/100 ;
                  total=(parseFloat(sentAmount) + parseFloat(fee));
                  $('#charges').text("Transfer Fee: "+parseFloat(fee).toFixed(2));
                  $('#charges_h').val(parseFloat(fee).toFixed(2));
                  $('#total_amount_local').text("Total amount: "+total);
                 }

              } else {
               total_amount=parseFloat(this.charges_amount)+parseFloat(amount);
                  $.each({{ Js::from($flate_rates) }}, function() {
                   if(switchStatus==true){

                      if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent').val() <= this.to_amount) {
                       fee=parseFloat(this.charges_amount);
                       total=parseFloat(amount);
                       sentAmount = (total-fee);

                       $('#charges').val("Transfer Fee in : "+fee);
                       $('#charges_h').val(fee);
                       $('#total_amount_local').text("Total amount: "+total);
                       } else {
                        $('#charges').val("");
                        $('#charges_h').val("");
                        $('#total_amount_local').text("");
                                                      }
                   }else
                   {

                    if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent').val() <= this.to_amount) {
                       fee=parseFloat(this.charges_amount/currencyRate);
                       sentAmount=parseFloat(amount);
                       total= (total+fee);
                     $('#charges').val("Transfer Fee in : "+fee);
                     $('#charges_h').val(this.charges_amount);
                     $('#total_amount_local').text("Total amount: "+total);
                    } else {
                     $('#charges').val("");
                     $('#charges_h').val("");
                     $('#total_amount_local').text("");
                    }
                   }

                  });
               }
              $('#amount_sent').val(parseFloat(sentAmount/currencyRate).toFixed(2));
              $('#amount_local_currency_id').val(parseFloat(sentAmount/currencyRate).toFixed(2));
              $('#amount_foregn_currency_id').val(parseFloat(sentAmount).toFixed(2));

          });

          $("#find-user").click(function() {
              $('#progress').show();
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
                      var rate = dataResult.rate;
                      var i = 1;
                      var currency="";
                      $('#receiver_rate').val(rate);
                      $('#rate_receiver').text("Rate: "+rate);
                          $.each(resultData, function(index, row) {
                              $('#names').text("Names: "+row.first_name+" "+row.last_name);
                              $('#email').text("Email: "+row.email);
                              $('#address').text("Address: "+row.address);
                              $('#currency').text("Currency: "+row.currency_name);
                              $('#country').text("Country: "+row.country);
                              rate2=row.currency_ratio;
                              currency=row.currency_name;
                              var name=row.first_name;
                              $('#names_id').val(row.first_name+" "+row.last_name);
                              $('#email_id').val(row.email);
                              $('#currency_id').val(row.currency_name);
                              $('#receiver_id').val(dataResult.user_id);
                              $('#phone_id').val(row.mobile_number);
                              $('#address_id').val(row.address);
                          })
                          if($('#phone_id').val()==""){
                              alert("Receiver not found, please verify number and try again");
                          }else{
                              $('#progress').hide();
                              $('#form_element').show();
                               $('#submit_button').show();
                              $('#details').show();
                              $('#amount_sent_label').text("Amount To Sent in "+{{ Js::from($user_currency) }});
                               $('#amount_receive_label').text("Amount To Receive in "+currency);
                          }

                  }

              })
          });
      });
     function modal() {
            var amount_local=$('#amount_local_currency_id').val();
            var amount_foreign=$('#amount_foregn_currency_id').val();
            $("#amount_local").text(amount_local);
            $("#amount_foreign").text(amount_foreign);

            var method=$('#payment').val();
            $("#method").text(method);

            var details=$('#description').val();
            $("#details_h").text(details);

            var sender_names={{ Js::from($request->names) }};
             $("#sender_names").text(sender_names);
            var receiver_names=$('#names_id').val();
            $("#receiver_names").text(receiver_names);


            $('#confirm-modal').modal('show');

          }
          function closeModal() {
            $('#confirm-modal').modal('hide');

         }
      /* When click show user */
  </script>
    @extends('agent.components.footer')
    @include('common.logout-modal')
</body>

</html>

