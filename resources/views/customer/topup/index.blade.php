

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
                                <th width="25%">Payment Method</th>
                                <th width="15%">Amount</th>
                                @hasrole('Agent')
                                  <th width="10%">Action</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topups as $topup)

                                <tr>
                                    <td>{{ $topup->created_at }}</td>
                                    <td>{{ $topup->payment_type }}</td>
                                    <td>{{ $topup->amount }}</td>
                                    @hasrole('Agent')
                                    <td style="display: flex">
                                        <form method="POST" action="{{ route('topup.status') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$topup->id}}"/>
                                            <input type="hidden" name="status" value="Approved"/>

                                            @if ($topup->status == 'Pending')
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
                    {{ $topups->links() }}
                  
                </div>


            </div>
        </div>
    </div>


    <!-- Script -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {

            $('#payment').on('change', function() {

                var type = $('#payment').val();


                $.ajax({
                    url: "{{ route('topup.find') }}",
                    type: "GET",
                    dataType: 'JSON',
                    data: {
                        'type': type
                    },
                    success: function(dataResult) {
                        var resultData = dataResult.data;
                        $("#account_number").find('option').remove().end();


                        var option = $("<option />");
                        if (Object.keys(dataResult.data).length > 0) {

                            $.each(resultData, function(index, row) {
                                option.html(row.number);
                                option.val(row.number);
                                $('#account_number').append(option);

                            });
                        } else {

                            option.html("CASH");
                            option.val("CASH");
                            $('#account_number').append(option);
                        }


                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.responseText);
                    },

                })

            });
        });

        /* When click show user */
    </script>





    @extends('customer.components.footer')
    @include('common.logout-modal')
</body>

</html>

