@extends('layouts.app')

@section('title', 'Countries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Accounts</h1>
        <a href="{{route('StockAccount.create')}}" class="btn btn-sm btn-primary" >
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Accounts</h6>

        </div>
        <form
            method="POST" action="{{route('stockAccount.stockAccountSearch')}}"
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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="30%">Name</th>
                            <th width="10%">Currency</th>
                            <th width="30%">Description</th>
                            <th width="20%">Default</th>

                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($accounts as $account)
                               <td>{{$account->id}}</td>
                               <td>{{$account->name}}</td>
                               <td>{{$account->currency}}</td>
                               <td>{{$account->description}}</td>

                               @hasrole('Admin')
                                        <td style="display: flex">
                                            <form method="POST" action="{{ route('StockAccount.setDefault') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$account->id}}"/>


                                                @if ($account->default == 0)
                                                    <button type="submit" class="btn btn-success btn-user float-right mb-3"> <i
                                                            class="fa fa-check">Set AS Default</i></button>
                                                @else
                                                    <button type="button" class="btn btn-success btn-danger float-right mb-3"> <i
                                                            class="fa fa-ban"></i></button>

                                                @endif

                                            </form>


                                        </td>
                                    @endhasrole
                                    @hasrole('Finance')
                                        <td style="display: flex">
                                            <form method="POST" action="{{ route('StockAccount.setDefault') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$account->id}}"/>


                                                @if ($account->default == 0)
                                                    <button type="button" class="btn btn-success btn-user float-right mb-3">No</button>
                                                @else
                                                    <button type="button" class="btn btn-success btn-danger float-right mb-3">Yes</button>

                                                @endif

                                            </form>


                                        </td>
                                    @endhasrole



                           </tr>
                       @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

</div>


@endsection
