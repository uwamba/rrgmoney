@extends('layouts.app')

@section('title', 'Countries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Country</h1>
        <a href="{{route('account.create')}}" class="btn btn-sm btn-primary" >
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Cuurencies</h6>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Type</th>
                            <th width="20%">Name</th>
                            <th width="20%">Number</th>
                            <th width="10%">Currency</th>
                            <th width="10%">Country</th>
                            <th width="10%">SWIFT CODE</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($accounts as $account)
                           <tr>
                               <td>{{$account->type}}</td>
                               <td>{{$account->name}}</td>
                               <td>{{$account->number}}</td>
                               <td>{{$account->currency}}</td>
                               <td>{{$account->country}}</td>
                               <td>{{$account->swift_code}}</td>
                            
                               <td style="display: flex">
                                   <form method="POST" action="{{ route('account.destroy', ['account' => $account->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-1" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                   </form>
                                   <form method="POST" action="{{ route('account.create', ['account' => $account->id]) }}">
                                
                                    <button class="btn btn-danger m-1" type="submit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                               </form>
                                </a>
                               </td>
                               
                           </tr>
                       @endforeach
                    </tbody>
                </table>

            
            </div>
        </div>
    </div>

</div>


@endsection