@extends('layouts.app')

@section('title', 'Add Country')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Country</h1>
        <a href="{{route('country.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Role</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('currency.store')}}">
                @csrf
                <div class="form-group row">

                     {{-- Name --}}
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Country Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('currency_country') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Country Name" 
                            name="currency_country" 
                            value="{{ old('currency_country') }}">

                        @error('currency_country')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Currency Name</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('currency_name') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Curency Name" 
                            name="currency_name" 
                            value="{{ old('currency_name') }}">

                        @error('currency_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- reference --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Reference To Exchange</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('currency_reference') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Reference Name" 
                            name="currency_reference" 
                            value="{{ old('currency_reference') }}">

                        @error('currency_reference')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>


                    {{-- rate --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Exchange Rate Buying</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('currency_buying_rate') is-invalid @enderror" 
                            id="currency_buying_rate"
                            placeholder="Currency Buying Rate" 
                            name="currency_buying_rate" 
                            value="{{ old('currency_buying_rate') }}">

                        @error('currency_buying_rate')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Exchange Rate Selling</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('currency_selling_rate') is-invalid @enderror" 
                            id="currency_selling_rate"
                            placeholder="currency selling rate" 
                            name="currency_selling_rate" 
                            value="{{ old('currency_selling_rate') }}">

                        @error('currency_rate_selling')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- reception Method --}}
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Service Pricing Plan</label>
                        <select class="form-control form-control-user @error('pricing_plan') is-invalid @enderror" name="pricing_plan">
                            <option selected disabled>Service Pricing Plan</option>
                            <option value="flat-rate" >Flate rate</option>
                            <option value="percentage" >Percentage</option>
                            <option value="flat_rate_percentage" >Flat Rate%</option>
                        </select>
                        @error('pricing_plan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- percentage --}}
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;"></span>Charges(%)</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('charges_percentage') is-invalid @enderror" 
                            id="charges_percentage"
                            placeholder="Charges(%)" 
                            name="charges_percentage" 
                            value="{{ old('charges_percentage') }}">

                        @error('charges_percentage')
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