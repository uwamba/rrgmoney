<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('agent.components.head')
@include('agent.components.header')

    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="15%">Mobile</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->full_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->mobile_number }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $users->links() }}
                            </div>
                        </div>
        </div>
    </div>
    <!-- Features End -->
    @extends('customer.components.footer')
    @include('common.logout-modal')
</body>
</html>


