@extends('layouts.app')

@section('title', 'Stock List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Stock</h1>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('stock.adminCreate') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('users.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-check"></i> Export To Excel
                    </a>
                </div>

            </div>

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
                                <th width="15%">Amount</th>
                                <th width="15%">Names</th>
                                <th width="15%">Email</th>
                                <th width="15%">Phone Number</th>
                                <th width="10%">Currency</th>
                                <th width="20%">Balance Before</th>
                                <th width="20%">Balance After</th>
                                <th width="10%">Status</th>
                                @hasrole('Admin')<th width="10%">Actions</th>@endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)

                                <tr>
                                    <td>{{ $stock->created_at }}</td>
                                    <td>{{ $stock->amount }}</td>
                                    <td>{{ $stock->first_name." ".$stock->last_name }}</td>
                                    <td>{{ $stock->email }}</td>
                                    <td>{{ $stock->mobile_number }}</td>
                                    <td>{{ $stock->currency }}</td>
                                    <td>{{ $stock->balance_before }}</td>
                                    <td>{{ $stock->balance_after }}</td>
                                    <td>{{ $stock->status }}</td>
                                    @hasrole('Admin')
                                        <td style="display: flex">
                                            <form method="POST" action="{{ route('stock.status') }}">
                                                @csrf
                                               <input type="hidden" name="id" value="{{$stock->id}}"/>
                                               <input type="hidden" name="user_id" value="{{$stock->user_id}}"/>
                                               <input type="hidden" name="amount" value="{{$stock->amount}}"/>
                                               <input type="hidden" name="currency" value="{{$stock->currency}}"/>
                                               <input type="hidden" name="account_name" value="{{$stock->account_name}}"/>
                                               <input type="hidden" name="status" value="Approved"/>

                                                @if ($stock->status == 'Requested')
                                                    <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                                                            class="fa fa-check"></i></button>
                                                @elseif ($stock->status == 'Approved')
                                                    <button type="button" class="btn btn-success btn-danger float-right mb-3"> <i
                                                            class="fa fa-ban"></i></button>
                                                @else ($stock->status == 'Approved')
                                                <button type="button" class="btn btn-success btn-danger float-right mb-3"> <i
                                                class="fa fa-ban"></i></button>
                                                @endif

                                            </form>
                                        </td>
                                    @endhasrole

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $stocks->links() }}

                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

@endsection
