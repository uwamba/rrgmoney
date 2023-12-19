@extends('layouts.app')

@section('title', 'List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('commission.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="15%">Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commission as $row)

                                <tr>
                                    <td>{{ $row->created_at }}</td>
                                    <td>{{ $row->rate }} %</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $commission->links() }}

                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')

@endsection
