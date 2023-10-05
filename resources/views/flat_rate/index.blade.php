@extends('layouts.app')

@section('title', 'Countries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Flat Rates</h1>
        <a href="{{route('currency.index')}}" class="btn btn-sm btn-primary" >
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Flat Rates</h6>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">From Amount</th>
                            <th width="20%">To Amount</th>
                            <th width="20%">Transfer </th>
                            <th width="20%">Cashout </th>
                            <th width="20%">Transfer %</th>
                            <th width="20%">Cashout %</th>
                            <th width="20%">currency</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($flat_rates as $flat_rate)
                           <tr>
                               <td>{{$flat_rate->from_amount}}</td>
                               <td>{{$flat_rate->to_amount}}</td>
                               <td>{{$flat_rate->charges_amount}}</td>
                               <td>{{$flat_rate->charges_amount_cashout}}</td>
                               <td>{{$flat_rate->charges_amount_percentage}}</td>
                               <td>{{$flat_rate->charges_amount_percentage_cashout}}</td>
                               <td>{{$flat_rate->currency_name}}</td>
                               <td style="display: flex">
                                   <form method="POST" action="{{ route('flat_rate.destroy', ['flat_rate' => $flat_rate->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-1" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                   </form>
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>

            
            </div>
        </div>
    </div>

</div>


@endsection