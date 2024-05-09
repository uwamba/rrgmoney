@extends('layouts.app')

@section('title', 'Add Accounts')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Account</h1>
        <a href="{{route('country.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Account</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('account.store')}}">
                @csrf
                <div class="form-group row">

                       {{-- account Type --}}
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Currency</label>
                        <select class="form-control form-control-user @error('type') is-invalid @enderror" name="type">
                            <option selected disabled>Select Payment Type</option>
                            <option value="Mobile" >Mobile Money</option>
                            <option value="BANK" >BANK </option>
                             <option value="Other" >Other </option>
                        </select>
                        @error('type')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Account Name --}}
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Account Name</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('name') is-invalid @enderror"
                            id="exampleName"
                            placeholder="Account Name"
                            name="name"
                            value="{{ old('name') }}">

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{--Account  Number --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Account Number</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('number') is-invalid @enderror"
                            id="exampleName"
                            placeholder="Account Number Name"
                            name="number"
                            value="{{ old('number') }}">

                        @error('number')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- swift_code --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>SWIFT CODE</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('swift_code') is-invalid @enderror"
                            id="exampleName"
                            placeholder="SWIFT CODE"
                            name="swift_code"
                            value="{{ old('swift_code') }}">

                        @error('swift_code')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- country --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Country</label>
                        <select class="form-control form-control-user @error('country') is-invalid @enderror" name="country">
                            <option selected disabled>Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{$country->currency_country}}">{{$country->currency_country}}</option>
                            @endforeach
                        </select>
                        @error('country')
                            <span class="text-danger">{{$message}}</span>
                        @enderror

                    </div>

                     {{-- currency --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Currency</label>
                        <select class="form-control form-control-user @error('currency') is-invalid @enderror" name="currency">
                            <option selected disabled>Select Currency</option>
                            @foreach ($currencies as $currency)
                                <option value="{{$currency->currency_name}}">{{$currency->currency_name}}</option>
                            @endforeach
                        </select>
                        @error('currency')
                            <span class="text-danger">{{$message}}</span>
                        @enderror

                    </div>





                </div>

                {{-- Save Button --}}
                <button type="submit" class="btn btn-success btn-user btn-block">
                    Save
                </button>

            </form>
        </div>
    </div>

</div>


@endsection
