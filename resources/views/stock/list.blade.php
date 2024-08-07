@extends('layouts.app')

@section('title', 'Topup List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Stock Topup</h1>
            <div class="row">


            </div>
            <form
            method="POST" action="{{route('stock.stockSearch')}}"
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                    name="query"
                aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>

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
                                <th width="25%">Amount</th>
                                <th width="15%">Currency</th>
                                <th width="15%">Balance Before</th>
                                <th width="10%">Balance After</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)

                                <tr>
                                    <td>{{ $stock->created_at }}</td>
                                    <td>{{ $stock->amount }}</td>
                                    <td>{{ $stock->currency }}</td>
                                    <td>{{ $stock->balance_before }}</td>
                                    <td>{{ $stock->balance_after }}</td>
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

@endsection

@section('scripts')

@endsection
