@extends('layouts.app')

@section('title', 'Countries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Country</h1>
        <a href="{{route('currency.create')}}" class="btn btn-sm btn-primary" >
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
                            <th width="40%">Country</th>
                            <th width="40%">Name</th>
                            <th width="40%">rate</th>
                            <th width="40%">Reference</th>
                            <th width="40%">Plan</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($currencies as $currency)
                           <tr>
                               <td>{{$currency->currency_country}}</td>
                               <td>{{$currency->currency_name}}</td>
                               <td>{{$currency->currency_ratio}}</td>
                               <td>{{$currency->currency_reference}}</td>
                               <td>{{$currency->pricing_plan}}</td>
                               <td style="display: flex">
                                  <form method="POST" action="{{ route('currency.destroy', ['currency' => $currency->id]) }}">
                                   @csrf
                                   @method('DELETE')
                                   <button class="btn btn-danger m-1" type="submit">
                                      <i class="fa fa-trash"></i>
                                   </button>
                                   </form>
                                   <form method="HEAD" action="{{ route('flat_rate.create', ['currency' => $currency->id]) }}">

                                     <button class="btn btn-primary" type="submit">
                                         Charges<i class="fa fa-edit"></i>
                                     </button>
                                   </form>
                                   <form method="POST" action="{{ route('currency.changeRate') }}">
                                     @csrf

                                    <input type="hidden" name="id" value="{{$currency->id}}" id="id">

                                    <button class="btn btn-primary m-1" onclick="modal()" type="button">
                                      <i class="fa fa-edit">Change Rate</i>
                                    </button>
                                     @include('currency.rate-modal')
                                   </form>


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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type='text/javascript'>
        function modal() {
            $('#rate-modal').modal('show');

        }
        function closeModal() {
            $('#rate-modal').modal('hide');

        }
</script>
