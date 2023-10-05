@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sent</h1>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('send.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-sm btn-success">
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
                                <th width="15%">Amount </th>
                                <th width="15%">Receiver Names</th>
                                <th width="15%">Receiver phone</th>
                                <th width="15%">Reason</th>
                                <th width="15%">Attachement</th>
                                <th width="15%">Status</th>
                                @hasrole('Agent')
                                  <th width="10%">Action</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($safe_pays as $safe_pay)

                                <tr>
                                    <td>{{ $safe_pay->created_at }}</td>
                                    <td>{{ $safe_pay->amount_local_currency }}</td>
                                    <td>{{ $safe_pay->names }}</td>
                                    <td>{{ $safe_pay->phone }}</td>
                                    <td>{{ $safe_pay->reason }}</td>
                                    <td>{{ $safe_pay->attachement }}</td>
                                    <td>{{ $safe_pay->status }}</td>
                                    @hasrole('Agent')
                                    <td style="display: flex">
                                        <form method="POST" action="{{ route('safe_pay.status') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$safe_pay->id}}"/>
                                            <input type="hidden" name="status" value="Approved"/>

                                            @if ($topup->status == 'onhold')
                                                <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                                                        class="fa fa-check"></i></button>
                                            @elseif ($topup->status == 'Approved')
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
                    {{ $safe_pays->links() }}
                  
                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    
@endsection
