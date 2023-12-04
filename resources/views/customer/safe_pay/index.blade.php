<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('customer.components.head')
@include('customer.components.header')



    <div class="col-sm-8 container-fluid py-5">
        <div class="container">
            <div class="row g-2">


                {{-- Alert Messages --}}
                @include('common.alert')

                <!-- DataTales Example -->
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


    <!-- Script -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>





    @extends('customer.components.footer')
    @include('common.logout-modal')
</body>

</html>

