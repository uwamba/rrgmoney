@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sent/Receive</h1>
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
                    <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th width="25%">Date</th>
                                                            <th width="7%">Class </th>
                                                            <th width="15%">Local Amount </th>
                                                            <th width="15%">Foreign Amount </th>
                                                            <th width="15%">USD Amount </th>
                                                            <th width="15%">Charges </th>
                                                            <th width="15%">Sender Names</th>
                                                            <th width="15%">Sender phone</th>
                                                            <th width="15%">Receiver Names</th>
                                                            <th width="15%">Receiver phone</th>
                                                            <th width="15%">Status</th>
                                                            <th width="15%">More</th>

                                                             @hasrole('Admin')
                                                                <th width="10%">Action</th>
                                                             @endhasrole
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($sents as $sent)

                                                            <tr>
                                                                <td>{{ $sent->created_on }}</td>
                                                                <td>{{ $sent->class }}</td>
                                                                <td>{{ $sent->amount_local_currency." ".$sent->local_currency }}</td>
                                                                <td>{{ $sent->amount_foregn_currency." ".$sent->currency }}</td>
                                                                <td>{{ $sent->amount_rw." USD" }}</td>
                                                                <td>{{ $sent->charges." USD" }}</td>
                                                                <td>{{ $sent->first_name." ".$sent->last_name }}</td>
                                                                <td>{{ $sent->mobile_number }}</td>
                                                                <td>{{ $sent->names }}</td>
                                                                <td>{{ $sent->phone }}</td>
                                                                <td>{{ $sent->status }}</td>
                                                                 <td>
                                                                    <button type="button" onclick="modal()" class="btn btn-primary float-right mb-3">More</button>
                                                                 </td>

                                                                @hasrole('Admin')
                                                                  <td style="display: flex">


                                                                         @if ($sent->status == 'Pending')
                                                                         <button type="button" onclick="confirmModal()"
                                                                            id="approve_btn"
                                                                            class="btn btn-success btn-user float-right mb-3"
                                                                             data-id="{{ $sent->id }}"
                                                                             data-amount_rw_currency="{{ $sent->amount_rw }}"
                                                                             data-amount_local_currency="{{ $sent->amount_local_currency }}"
                                                                             data-currency="{{ $sent->currency }}"

                                                                             data-sender_currency="{{ $sent->local_currency }}"
                                                                             data-amount_foregn_currency="{{ $sent->amount_foregn_currency }}"
                                                                             data-agent_id="{{ $sent->user_id }}"
                                                                             data-sender_id="{{ $sent->sender_id }}"
                                                                             data-receiver_id="{{ $sent->receiver_id }}"


                                                                            >
                                                                             <i class="fa fa-check"></i></button>
                                                                        <a class="btn btn-danger m-2"  onclick="rejectModal()"
                                                                        id="reject_btn"
                                                                        class="btn btn-success btn-user float-right mb-3"
                                                                         data-id="{{ $sent->id }}"
                                                                         data-amount_rw_currency="{{ $sent->amount_rw }}"
                                                                         data-amount_local_currency="{{ $sent->amount_local_currency }}"
                                                                         data-currency="{{ $sent->currency }}"

                                                                         data-sender_currency="{{ $sent->local_currency }}"
                                                                         data-amount_foregn_currency="{{ $sent->amount_foregn_currency }}"
                                                                         data-agent_id="{{ $sent->user_id }}"
                                                                         data-sender_id="{{ $sent->sender_id }}"
                                                                         data-receiver_id="{{ $sent->receiver_id }}"

                                                                        >
                                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                                        </a>
                                                                         @elseif ($sent->status == 'Approved')
                                                                         <button type="button" class="btn btn-success btn-danger float-right mb-3"> <i
                                                                                                                        class="fa fa-ban"></i></button>
                                                                         @elseif ($sent->status == 'Rejected')
                                                                         <button type="button" class="btn btn-success btn-danger float-right mb-3"> <i
                                                                            class="fa fa-ban"></i></button>
                                                                         @endif






                                                            </td>
                                                          @endhasrole

                                                            </tr>
                                                            @endforeach


                                                    </tbody>
                                                </table>

                    {{ $sents->links() }}
                    @include('send.more-modal')
                    @include('send.reject-modal')

                    @include('send.confirm-approval-modal')

                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type='text/javascript'>

   function modal() {
     $('#more-modal').modal('show');
     }
     function confirmModal() {
     $('#confirm-approval-modal').modal('show');
     }
    function rejectModal() {
     $('#rejectModal').modal('show');
     }
   function closeModal() {
    $('#more-modal').modal('hide');
    }
    function closeRejectModal() {
    $('#rejectModal').modal('hide');
    }
    function closeConfirmModal() {
    $('#confirm-approval-modal').modal('hide');
    }

 $(document).on("click", "#approve_btn", function () {
    var id= $(this).attr('data-id');
    $('#id').val(id);
    var account_name= $(this).attr('data-account_name');
    $('#account_name').val(account_name);
    var amount_rw_currency= $(this).attr('data-amount_rw_currency');
    $('#amount_rw_currency').val(amount_rw_currency);
    var amount_local_currency= $(this).attr('data-amount_local_currency');
    $('#amount_local_currency').val(amount_local_currency);
    var currency= $(this).attr('data-currency');
    $('#currency').val(currency);

    var sender_currency= $(this).attr('data-sender_currency');
    $('#sender_currency').val(sender_currency);
    var amount_foregn_currency= $(this).attr('data-amount_foregn_currency');
    $('#amount_foregn_currency').val(amount_foregn_currency);
    var agent_id= $(this).attr('data-agent_id');
    $('#agent_id').val(agent_id);
    var sender_id= $(this).attr('data-sender_id');
    $('#sender_id').val(sender_id);
    var receiver_id= $(this).attr('data-receiver_id');
    $('#receiver_id').val(receiver_id);



 });


 $(document).on("click", "#reject_btn", function () {
    var id= $(this).attr('data-id');
    $('#id').val(id);
    var account_name= $(this).attr('data-account_name');
    $('#account_name').val(account_name);
    var amount_rw_currency= $(this).attr('data-amount_rw_currency');
    $('#amount_rw_currency').val(amount_rw_currency);
    var amount_local_currency= $(this).attr('data-amount_local_currency');
    $('#amount_local_currency').val(amount_local_currency);
    var currency= $(this).attr('data-currency');
    $('#currency').val(currency);

    var sender_currency= $(this).attr('data-sender_currency');
    $('#sender_currency').val(sender_currency);
    var amount_foregn_currency= $(this).attr('data-amount_foregn_currency');
    $('#amount_foregn_currency').val(amount_foregn_currency);
    var agent_id= $(this).attr('data-agent_id');
    $('#agent_id').val(agent_id);
    var sender_id= $(this).attr('data-sender_id');
    $('#sender_id').val(sender_id);
    var receiver_id= $(this).attr('data-receiver_id');
    $('#receiver_id').val(receiver_id);



 });

    </script>
