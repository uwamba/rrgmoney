
<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@extends('customer.components.head')
@include('customer.components.header')



    <div class="col-sm-6 container-fluid py-5">
        <div class="container">
            <div class="row g-2">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Account Top Up</h1>
                   
                </div>

                {{-- Alert Messages --}}
                @include('common.alert')

                <!-- DataTales Example -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="20%">From</th>
                                <th width="15%">Amount </th>
                                <th width="15%">Balance</th>
                                <th width="15%">Currency</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sents as $sent)

                                <tr>
                                    <td>{{ $sent->created_at }}</td>
                                    <td>{{ $sent->first_name." ". $sent->last_name}}</td>
                                    <td>{{ $sent->amount_foregn_currency }}</td>
                                    <td>{{ $sent->balance_after }}</td>
                                    <td>{{ $sent->currency }}</td>
                                    
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                  
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


