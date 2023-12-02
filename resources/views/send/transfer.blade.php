@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transfers</h1>


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
                                <th width="15%">Local Amount </th>
                                <th width="15%">Foreign Amount </th>
                                <th width="15%">Sender Names</th>
                                <th width="15%">Sender phone</th>
                                <th width="15%">Receiver Names</th>
                                <th width="15%">Receiver phone</th>
                                <th width="15%">Status</th>
                                <th width="15%">Receipt</th>
                                 @hasrole('Admin')
                                    <th width="10%">Action</th>
                                 @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sents as $sent)

                                <tr>
                                    <td>{{ $sent->created_at }}</td>
                                    <td>{{ $sent->amount_local_currency }}</td>
                                    <td>{{ $sent->amount_foregn_currency }}</td>
                                    <td>{{ $sent->first_name." ".$sent->last_name }}</td>
                                    <td>{{ $sent->mobile_number }}</td>
                                    <td>{{ $sent->names }}</td>
                                    <td>{{ $sent->phone }}</td>
                                    <td>{{ $sent->status }}</td>
                                    <td style="display: flex">
                                       <form method="POST" action="{{ route('send.transferReceipt') }}">
                                         @csrf
                                         <input type="hidden" name="id" value="{{$sent->id}}"/>
                                          <input type="hidden" name="names" value="{{$sent->names}}"/>
                                          <input type="hidden" name="phone" value="{{$sent->phone}}"/>
                                          <input type="hidden" name="first_name" value="{{$sent->first_name}}"/>
                                          <input type="hidden" name="last_name" value="{{$sent->last_name}}"/>
                                          <input type="hidden" name="amount_local_currency" value="{{$sent->amount_local_currency}}"/>
                                          <input type="hidden" name="currency" value="{{$sent->currency}}"/>
                                          <input type="hidden" name="amount_foregn_currency" value="{{$sent->amount_foregn_currency}}"/>
                                          <input type="hidden" name="agent_id" value="{{$sent->user_id}}"/>
                                          <input type="hidden" name="sender_id" value="{{$sent->sender_id}}"/>
                                          <input type="hidden" name="sender_email" value="{{$sent->sender_email}}"/>
                                          <input type="hidden" name="charges" value="{{$sent->charges}}"/>
                                          <input type="hidden" name="receiver_id" value="{{$sent->receiver_id}}"/>
                                          <input type="hidden" name="status" value="Approved"/>
                                        <button type="submit" class="btn btn-success btn-user float-right mb-3"><i class="fa fa-print"></i>

                                    </form>
                                    </td>

                                    @hasrole('Admin')
                                      <td style="display: flex">
                                          <form method="POST" action="{{ route('send.approve') }}">
                                          @csrf
                                             <input type="hidden" name="id" value="{{$sent->id}}"/>
                                             <input type="hidden" name="names" value="{{$sent->names}}"/>
                                             <input type="hidden" name="phone" value="{{$sent->phone}}"/>
                                             <input type="hidden" name="first_name" value="{{$sent->first_name}}"/>
                                             <input type="hidden" name="last_name" value="{{$sent->last_name}}"/>
                                             <input type="hidden" name="amount_local_currency" value="{{$sent->amount_local_currency}}"/>
                                             <input type="hidden" name="currency" value="{{$sent->currency}}"/>
                                              <input type="hidden" name="amount_foregn_currency" value="{{$sent->amount_foregn_currency}}"/>
                                             <input type="hidden" name="agent_id" value="{{$sent->user_id}}"/>
                                             <input type="hidden" name="sender_id" value="{{$sent->sender_id}}"/>
                                             <input type="hidden" name="receiver_id" value="{{$sent->receiver_id}}"/>
                                             <input type="hidden" name="status" value="Approved"/>

                                             @if ($sent->status == 'Pending')
                                             <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                                                                                            class="fa fa-check"></i></button>
                                             @elseif ($sent->status == 'Approved')
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
                    {{ $sents->links() }}

                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')

@endsection
