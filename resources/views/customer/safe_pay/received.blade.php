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
                                <th width="25%">Amount </th>
                                <th width="25%">Payer Names</th>
                                <th width="25%">Reason</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($safe_pays as $safe_pay)

                                <tr>
                                    <td>{{ $safe_pay->created_at }}</td>
                                    <td>{{ $safe_pay->amount_foregn_currency }}</td>
                                    <td>{{ $safe_pay->sfname." ".$safe_pay->slname }}</td>

                                    <td>{{ $safe_pay->reason }}</td>


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

