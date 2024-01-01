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
                                                                <td>{{ $sent->amount_local_currency }}</td>
                                                                <td>{{ $sent->amount_foregn_currency }}</td>
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
                                                                       @include('send.more-modal')
                                                                      </form>
                                                            </td>
                                                          @endhasrole

                                                            </tr>


                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @include('send.more-modal')
                    {{ $sents->links() }}

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
   function closeModal() {
    $('#more-modal').modal('hide');
    }
    </script>
