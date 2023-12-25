

<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('agent.components.head')
@include('agent.components.header')
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
                                <th width="15%">Amount </th>
                                <th width="15%">Receiver Names</th>
                                <th width="15%">Receiver phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sents as $sent)
                                <tr>
                                    <td>{{ $sent->created_at }}</td>
                                    <td>{{ $sent->amount_local_currency }}</td>
                                    <td>{{ $sent->names }}</td>
                                    <td>{{ $sent->phone }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $sents->links() }}
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

