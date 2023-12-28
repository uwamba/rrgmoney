@extends('layouts.app')

@section('title', 'Cashout History')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cashout</h1>
            <div class="row">
                <div class="col-md-6">
                @hasrole('Customer')
                   <a href="{{ route('cashout.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Add New
                   </a>
                @endhasrole

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
                                <th width="5%">ID</th>
                                <th width="20%">Date</th>
                                <th width="12%">Amount</th>
                                <th width="10%">Status</th>
                                <th width="10%">Check Balance</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cashouts as $cashout)
                                <tr>
                                    <td>{{ $cashout->id }}</td>
                                    <td>{{ $cashout->created_at }}</td>
                                    <td>{{ $cashout->amount }}</td>
                                    <td>{{ $cashout->status }}</td>
                                     <td>
                                      <button type="button" id="check_balance" class="btn btn-primary"   data-id="">Check Balance</button>
                                     </td>


                                    @hasrole('Admin')
                                    <td style="display: flex">

                                        <form method="POST" action="{{ route('AgentCashOut.status') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$cashout->id}}"/>
                                            <input type="hidden" name="amount" value="{{$cashout->amount}}"/>
                                            <input type="hidden" name="status" value="Approved"/>
                                            <input type="hidden" id="user_id" name="user_id" value="{{$cashout->user_id}}"/>

                                            @if ($cashout->status == 'Requested')
                                            <button type="submit" class="btn btn-success btn-user float-right mb-3">
                                             <i class="fa fa-check"></i>
                                            </button>


                                           @else
                                           <button type="submit" class="btn btn-success btn-danger float-right mb-3"> <i
                                            class="fa fa-ban"></i></button>
                                           @endif


                                        </form>
                                     @include('agent.AgentCashOut.balance-modal')

                                    </td>
                                    @endhasrole


                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $cashouts->links() }}

                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

<script type='text/javascript'>
$("#check_balance").click(function() {
var user_id=$('#user_id').val();
              $.ajax({
                  url: "{{ route('AgentCashOut.check_balance') }}",
                  type: "GET",
                  dataType: 'json',
                  data: {
                      'user_id': user_id
                  },
                  success: function(dataResult) {
                      var balance = dataResult.balance;
                      $('#balance').text("The current Balance is: "+balance);
                      $('#balance-modal').modal('show');


                  }

              })
          });


  function modal() {

  $('#balance-modal').modal('show');

  }
  function closeModal() {
  $('#balance-modal').modal('hide');

  }
</script>



@endsection
