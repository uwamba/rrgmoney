@extends('layouts.app')

@section('title', 'Income List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('income.reset') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Reset Count
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
                                <th width="25%">Description</th>
                                <th width="15%">Amount</th>
                                 <th width="15%">Balance</th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topup as $row)

                                <tr>
                                    <td>{{ $row->created_at }}</td>
                                    <td>{{ $row->payment_type }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td>{{ $row->balance_after }}</td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $topup->links() }}

                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')

@endsection
