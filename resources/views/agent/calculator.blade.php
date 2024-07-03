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

        <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 text-center">
            <form method="POST" action="{{ route('send.storeTransfer') }}">
                @csrf
                <input type="hidden" name="rate_input_h" value="" id="rate_input_h">
                <input type="hidden" name="charges_h" value="" id="charges_h">
                <input type="hidden" name="charges_rw" value="" id="charges_rw">
                <input type="hidden" name="receiver_rate" value="" id="sender_rate">
                <input type="hidden" name="sender_rate" value="" id="receiver_rate">
                <input type="hidden" name="names" value="" id="names_id">
                <input type="hidden" name="email" value="" id="email_id">
                <input type="hidden" name="amount_foregn_currency" value="" id="amount_foregn_currency_id">
                <input type="hidden" name="amount_local_currency" value="" id="amount_local_currency_id">
                <input type="hidden" name="amount_rw_currency" value="" id="amount_rw_currency">
                <input type="hidden" name="phone" value="" id="phone_id">

                <input type="hidden" name="address" value="" id="address_id">
                <input type="hidden" name="receiver_id" value="" id="receiver_id">

                <div class="card-body">
                    <h5>Base Currency {{config('app.Base-Currency')}}</h5>

                    <div class="form-group row" id="form_element">
                        <div class="card text-left" style="width: 100%; ">

                            <div class="card-body">
                                <div class="input-group">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-left">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input font-size-20" type="checkbox"
                                                aria-describedby="inputGroup-sizing-lg" name="switch1" id="switch1"
                                                checked>
                                            <label class="form-check-label font-weight-bold"
                                                for="flexSwitchCheckChecked"
                                                aria-describedby="inputGroup-sizing-lg">Transfer fees inclusive</label>
                                        </div>
                                    </div>
                                    <div class="input-group " style="margin-bottom:2px;">
                                        <Label>Discount in %</Label>
                                    </div>
                                    <div class="input-group ">
                                        <input type="text" class="p-2 mb-2 text-black form-control"
                                            placeholder="Enter Discount in %" aria-label="Search"
                                            name="discount" id="discount"
                                            aria-describedby="basic-addon2" data-type="discount">

                                    </div>


                                    <div class="input-group " style="margin-bottom:2px;">
                                        <Label>Amount to be Sent</Label>
                                    </div>

                                    <div class="input-group bg-light border-0 small" style="margin-bottom:2px;">
                                        <input type="text" class="p-2 mb-2 text-black form-control"
                                            placeholder="Enter Amount to send" aria-label="Search" name="amount_sent"
                                            id="amount_sent" aria-describedby="basic-addon2" data-type="currency">
                                            <div class="input-group-append">
                                                <select
                                            class="form- form-select-lg mb-2 px-10  @error('sender_currency') is-invalid @enderror"
                                            name="sender_currency" id="sender_currency">
                                            <option selected disabled>Currency</option>

                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->currency_name }}"
                                                    data-rate="{{ $currency->currency_selling_rate}}" data-charges="{{ $currency->charges_percentage }}">
                                                    {{ $currency->currency_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                        <div class="input-group-append">
                                            <a href="javascript:void(0)" id="amount_sent_btn"
                                                class="btn btn-info p-2 mb-2 ">Calculate</a>
                                        </div>
                                    </div>



                                    <div class="input-group " style="margin-bottom:2px;">
                                        <Label>Amount to be received</Label>
                                    </div>
                                    <div class="input-group ">
                                        <input type="text" class="p-2 mb-2 text-black form-control"
                                            placeholder="Enter Amount to receive" aria-label="Search"
                                            name="amount_receive" id="amount_receive"
                                            aria-describedby="basic-addon2" data-type="currency">
                                            <div class="input-group-append">
                                                <select
                                                class="form- form-select-lg mb-2 px-10 @error('receiver_currency') is-invalid @enderror"
                                                name="receiver_currency" id="receiver_currency">
                                                <option selected disabled>Currency</option>

                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->currency_name }}"
                                                        data-rate="{{ $currency->currency_buying_rate }}" data-charges="{{ $currency->charges_percentage }}">
                                                        {{ $currency->currency_name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            </div>
                                            <div class="input-group-append">
                                            <a href="javascript:void(0)" id="amount_receive_btn"
                                                class="btn btn-info p-2 mb-2">Calculate</a>
                                        </div>
                                    </div>

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" id="charges"></li>
                                        <li class="list-group-item" id="total_amount_local"></li>
                                        <li class="list-group-item" id="total_amount_with_fee"></li>
                                        <li class="list-group-item" id="recievable_amount"></li>

                                    </ul>





                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type='text/javascript'>

</script>
@include('agent.calculation')
@extends('agent.components.footer')
@include('common.logout-modal')
</body>

</html>
