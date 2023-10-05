@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Received</h1>
           
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your Records</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="20%">From</th>
                                <th width="15%">Amount </th>
                                <th width="15%">Balance</th>
                                <th width="15%">Currency</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sents as $sent)

                                <tr>
                                    <td>{{ $sent->created_at }}</td>
                                    <td>{{ $sent->first_name." ". $sent->last_name}}</td>
                                    <td>{{ $sent->amount_foregn_currency }}</td>
                                    <td>{{ $sent->balance_after }}</td>
                                    <td>{{ $sent->currency }}</td>
                                    
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                  
                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    
@endsection
