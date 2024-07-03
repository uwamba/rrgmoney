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

                            <li class="list-group-item">
                                <h5>Phone: {{ $request->phone }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h5>Email: {{ $request->email }}</h5>
                            </li>

                        </ul>
                    </div>
                    <div class="col-sm-3 d-flex justify-content-center ">
                        <ul class="list-group bg-primary bg-gradient">
                            <li class="list-group-item">
                                <h5>Names: {{ $request->names }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h5>Rate:{{ $request->sender_rate }}</h5>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
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
                <input type="hidden" name="sender_phone" value="{{ $request->phone }}" id="sender_phone">
                <input type="hidden" name="address" value="" id="address_id">
                <input type="hidden" name="receiver_id" value="" id="receiver_id">
                <input type="hidden" name="sender_id" value="{{ $request->sender_id }}" id="sender_id">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="card text-left" style="width: 100%; ">

                            <div class="card-body">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Enter Receiver Phone" aria-label="Search" name="phone"
                                        id="phone" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <a href="javascript:void(0)" id="find-user" class="btn btn-info">Find</a>
                                    </div>
                                    <div class="spinner-border" id="progress" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="details" style="padding-left:30px">

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
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
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                        <div class="input-group " style="margin-bottom:2px;">
                                            <span style="color:red;">*</span>Sender Currency</label>
                                        </div>

                                        <select
                                            class="form-control form-control-user @error('sender_currency') is-invalid @enderror"
                                            name="sender_currency" id="sender_currency">
                                            <option selected disabled>Select Sender Currency</option>

                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->currency_name }}"
                                                    data-rate="{{ $currency->currency_selling_rate}}" data-charges="{{ $currency->charges_percentage }}">
                                                    {{ $currency->currency_name . ' ' . $currency->currency_selling_rate }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('sender_currency')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                        <div class="input-group " style="margin-bottom:2px;">
                                            <span style="color:red;">*</span>Receiver Currency</label>
                                        </div>

                                        <select
                                            class="form-control form-control-user @error('receiver_currency') is-invalid @enderror"
                                            name="receiver_currency" id="receiver_currency">
                                            <option selected disabled>Select Reciever Currency</option>

                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->currency_name }}"
                                                    data-rate="{{ $currency->currency_buying_rate }}" data-charges="{{ $currency->charges_percentage }}">
                                                    {{ $currency->currency_name . ' ' . $currency->currency_buying_rate }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('receiver_currency')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                            <a href="javascript:void(0)" id="amount_receive_btn"
                                                class="btn btn-info p-2 mb-2">Calculate</a>
                                        </div>
                                    </div>

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" id="charges"></li>
                                        <li class="list-group-item" id="total_amount_local"></li>
                                        <li class="list-group-item" id="total_amount_with_fee"></li>
                                        <li class="list-group-item" id="recievable_amount"></li>
                                        <li class="list-group-item" id="feeRW"></li>
                                        <li class="list-group-item" id="totalRW"></li>
                                    </ul>

                                    <div class="input-group" style="margin-bottom:2px;">
                                        <Label>Select how to receive </Label>
                                    </div>
                                    <div class="input-group bg-light border-0 small">
                                        <select class="p-2 mb-2 text-black form-control" name="payment"
                                            id="payment">
                                            <option selected disabled>Select Payment Type</option>
                                            <option value="CASH">CASH</option>
                                            <option value="MOMO">Mobile Money</option>
                                            <option value="BANK">BANK DEPOSIT</option>
                                            <option value="E-WALLET">E-WALLET</option>
                                        </select>
                                        @error('payment')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-group" style="margin-bottom:2px;">
                                        <Label>Enter receiver account details</Label>
                                    </div>
                                    <div class="input-group bbg-light border-0 small">
                                        <textarea class="p-3 mb-2 text-black form-control" id="description" name="details" rows="3"></textarea>
                                        @error('details')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" id="submit_button">
                        <button type="button" id="open-modal" onclick="modal()" class="btn btn-primary"
                            data-id="">Next</button>
                    </div>
                </div>
                @include('agent.send.confirm-modal')
            </form>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type='text/javascript'>

</script>
@include('agent.send.calculation')
@extends('agent.components.footer')
@include('common.logout-modal')
</body>

</html>
