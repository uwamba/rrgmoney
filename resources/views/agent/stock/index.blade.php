<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('agent.components.head')
@include('agent.components.header')



    <div class="col-sm-6 container-fluid py-5">
        <div class="container">
        <div class="card-body">
                 <div class="card shadow mb-4">
                         <div class="card-header py-3">
                             <h6 class="m-0 font-weight-bold text-primary">Stock Request List</h6>
                         </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="30%">Date</th>
                                        <th width="10%">Amount</th>
                                        <th width="5%">Currency</th>
                                        <th width="15%">Balance</th>
                                        <th width="10%">Status</th>
                                        @hasrole('Admin')<th width="10%">Actions</th>@endhasrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)

                                        <tr>
                                            <td>{{ $stock->created_at }}</td>
                                            <td>{{ $stock->amount }}</td>
                                            <td>{{ $stock->currency }}</td>
                                            <td>{{ $stock->balance_after}}</td>
                                            <td>{{ $stock->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $stocks->links() }}

                        </div>
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


