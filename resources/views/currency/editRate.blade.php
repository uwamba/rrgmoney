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
            <h6 class="m-0 font-weight-bold text-primary">Change Rate</h6>
        </div>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalExample">Change Exchange rate</h5>
                    <button class="close" onclick="closeModal()" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                  <div class="modal-body">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <form method="POST" action="{{ route('currency.updateRate') }}">
                            @csrf
                                   @method('POST')
                        <input type="hidden" name="id" value="{{$id}}" id="id">
                        
                        <span style="color:red;">*</span>Exchange Rate Buying</label>
                         <input type="input" value="{{$buying}}" name="currency_buying_rate"  id="rate_buying">
                         <span style="color:red;" >*</span>Exchange Rate Selling</label>
                         <input type="input" name="currency_selling_rate" value="{{$selling}}" id="rate_selling">
                         <div class="modal-footer">
                         <button class="btn btn-secondary" onclick="closeModal()" type="button" data-dismiss="modal">Cancel</button>
                         <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                         </form>
    
                  </div>
                </div>
    
            </div>
        </div>
        
    </div>

</div>


@endsection