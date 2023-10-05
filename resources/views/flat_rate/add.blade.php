@extends('layouts.app')

@section('title', 'Add Country')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Flat Rate</h1>
        <a href="{{route('country.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Flat Rates</h6>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="40%">From</th>
                            <th width="40%">to</th>
                            <th width="40%">amount</th>
                            <th width="40%">Currency</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($flat_rates as $flat_rate)
                           <tr>
                               <td>{{$flat_rate->from_amount}}</td>
                               <td>{{$flat_rate->to_amount}}</td>
                               <td>{{$flat_rate->charges_amount}}</td>
                               <td>{{$flat_rate->currency_name}}</td>
                               
                           </tr>
                       @endforeach
                    </tbody>
                </table>

            
            </div>
        </div>
    </div>
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Role</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('flat_rate.store')}}">
                @csrf
                <div class="form-group row">
                    <input type="hidden" name="currency_id" value="{{ $currency }}">

                     {{-- From --}}
                     
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>From Amount</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('from_amount') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="From Amount" 
                            name="from_amount" 
                            value="{{ old('from_amount') }}">

                        @error('from_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- To --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>To amount</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('to_amount') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="To Amount" 
                            name="to_amount" 
                            value="{{ old('to_amount') }}">

                        @error('to_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- Amount --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Charges for Flat Rate Scheme</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('charges_amount') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Charges" 
                            name="charges_amount" 
                            value="{{ old('charges_amount') }}">

                        @error('charges_amount')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- Amount --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Transefer Charges For Percentaile scheme</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('charges_amount_percentage') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Charges For Percentaile scheme" 
                            name="charges_amount_percentage" 
                            value="{{ old('charges_amount_percentage') }}">

                        @error('charges_amount_percentage')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    {{-- Amount --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Cashout Charges For Percentaile scheme</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('charges_amount_percentage_cashout') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Cashout Charges For Percentaile scheme" 
                            name="charges_amount_percentage_cashout" 
                            value="{{ old('charges_amount_percentage_cashout') }}">

                        @error('charges_amount_percentage_cashout')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                     {{-- Amount --}}
                     <div class="col-sm-6 mb-3 mb-sm-0">
                        <span style="color:red;">*</span>Charges Cashout</label>
                        <input 
                            type="text" 
                            class="form-control form-control-user @error('charges_amount_cashout') is-invalid @enderror" 
                            id="exampleName"
                            placeholder="Cashout Charges" 
                            name="charges_amount_cashout" 
                            value="{{ old('charges_amount_cashout') }}">

                        @error('charges_amount_cashout')
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