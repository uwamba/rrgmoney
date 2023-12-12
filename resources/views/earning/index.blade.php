@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Topup</h1>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('topup.create') }}" class="btn btn-sm btn-primary">
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
                                <th width="25%">Payment Method</th>
                                <th width="15%">Amount</th>
                                <th width="15%">Currency</th>
                                 @hasrole('Agent')
                                  <th width="10%">Action</th>
                                 @endhasrole
                                <th width="15%">Names</th>
                                <th width="15%">Email</th>
                                <th width="15%">Phone</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topups as $topup)

                                <tr>
                                    <td>{{ $topup->created_at }}</td>
                                    <td>{{ $topup->payment_type }}</td>
                                    <td>{{ $topup->amount }}</td>
                                    <td>{{ $topup->currency }}</td>
                                    @hasrole('Agent')
                                    <td style="display: flex">
                                        <form method="POST" action="{{ route('topup.status') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$topup->id}}"/>
                                            <input type="hidden" name="amount" value="{{$topup->amount}}"/>
                                            <input type="hidden" name="currency" value="{{$topup->currency}}"/>
                                            <input type="hidden" name="status" value="Approved"/>

                                            @if ($topup->topUpStatus == 'Pending')
                                                <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                                                        class="fa fa-check"></i></button>
                                            @elseif ($topup->topUpStatus == 'Approved')
                                                <button type="button" class="btn btn-success btn-danger float-right mb-3"> <i
                                                        class="fa fa-ban"></i></button>
                                            @endif

                                        </form>


                                    </td>
                                    <td>{{ $topup->last_name." ".$topup->first_name }}</td>
                                    <td>{{ $topup->mobile_number }}</td>
                                    <td>{{ $topup->email }}</td>
                                    @endhasrole


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $topups->links() }}

                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')

@endsection
