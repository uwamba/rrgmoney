@extends('layouts.app')

@section('title', 'Cash Out')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Account Cashout</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
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
                        <select class="form-control form-control-user @error('payment') is-invalid @enderror" name="payment">
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

                    {{-- Currency --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Currency</label>
                        <select class="form-control form-control-Currency @error('currency') is-invalid @enderror" name="currency">
                            <option selected disabled>Select Currency</option>
                            <option value="1" selected>RWF</option>
                            <option value="0">DOLLARS</option>
                        </select>
                        @error('currency')
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
                            name="details" 
                            value="{{ old('details') }}">

                        @error('details')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('topup.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection