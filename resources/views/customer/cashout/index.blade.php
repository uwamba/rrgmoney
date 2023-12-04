
{{-- Include Head --}}
@include('customer.components.head')
@include('customer.components.header')
 @include('customer.components.alert')

    <div class="col-sm-6 container-fluid py-5">
           <div class="container">
               <div class="row g-3">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Cash out historical records</h1>

                </div>

                {{-- Alert Messages --}}
                @include('common.alert')

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Your Records</h6>

                    </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Date</th>
                                        <th width="12%">Payment Method</th>
                                        <th width="12%">Amount</th>
                                        <th width="20%">Details</th>
                                        <th width="10%">Status</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashouts as $cashout)
                                        <tr>
                                            <td>{{ $cashout->id }}</td>
                                            <td>{{ $cashout->created_at }}</td>
                                            <td>{{ $cashout->method }}</td>
                                            <td>{{ $cashout->amount }}</td>
                                            <td>{{ $cashout->details }}</td>
                                            @hasrole('Customer')
                                            <td>{{ $cashout->status }}</td>

                                            <td>
                                                 @if($cashout->status == 'Action')
                                               <div class="alert alert-danger">
                                                     <span>Action Required, Check your email for details</span>
                                               </div>
                                                 @endif
                                            </td>

                                            <td>
                                             @if($cashout->status == 'Action')
                                            <a href="{{ route('cashout.edit', ['cashout' => $cashout->id]) }}"
                                                class="btn btn-primary m-2">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            @endif
                                            </td>
                                            @endhasrole

                                            @hasrole('Admin')
                                            <td style="display: flex">

                                                <form method="POST" action="{{ route('cashout.status') }}">
                                                    @csrf
                                                    <input type="hidden" name="cashout_id" value="{{$cashout->id}}"/>
                                                    <input type="hidden" name="status" value="Approved"/>
                                                    <input type="hidden" name="receiver_id" value="{{$cashout->receiver_id}}"/>

                                                    @if ($cashout->status == 'Requested')
                                                    <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                                                        class="fa fa-check"></i></button>
                                                    <button type="button" id="open-modal" onclick="modal({{$cashout->id}})" class="btn btn-primary"  data-id="{{$cashout->id}}"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                                    @elseif ($cashout->status == 'Action')
                                                    <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                                                        class="fa fa-check"></i></button>
                                                    <button type="button" id="open-modal" onclick="modal({{$cashout->id}})" class="btn btn-primary"  data-id="{{$cashout->id}}"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                                   @else
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
                            {{ $cashouts->links() }}

                        </div>
                </div>


            </div>
        </div>
    </div>


    <!-- Script -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




    @include('cashout.comment-modal')

    @extends('customer.components.footer')
    @include('common.logout-modal')
<script type='text/javascript'>
function modal(id) {
    $('#cashout_id').val(id);

   //alert( $('#cashout_id').val());
    $('#commentModal').modal('show');

  }
</script>

