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
        <form
            method="POST" action="{{route('users.userSearch')}}"
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
                            <th width="12%">Country</th>
                            <th width="10%">Name</th>
                            <th width="12%">Buying Exch Rate</th>
                            <th width="12%">Selling Exch Rate</th>
                            <th width="12%">Reference</th>
                            <th width="12%">Fees</th>
                            <th width="30%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($currencies as $currency)
                           <tr>
                               <td>{{$currency->currency_country}}</td>
                               <td>{{$currency->currency_name}}</td>
                               <td>{{$currency->currency_buying_rate}}</td>
                               <td>{{$currency->currency_selling_rate}}</td>
                               <td>{{$currency->currency_reference}}</td>
                               <td>{{$currency->charges_percentage}} %</td>
                               <td style="display: flex">
                                  <form method="POST" action="{{ route('currency.destroy', ['currency' => $currency->id]) }}">
                                   @csrf
                                   @method('POST')
                                   <button class="btn btn-danger m-1" type="submit">
                                      <i class="fa fa-trash"></i>
                                   </button>
                                   </form>
                                   <form method="HEAD" action="{{ route('flat_rate.create', ['currency' => $currency->id]) }}">

                                     <button class="btn btn-primary" type="submit">
                                         Charges<i class="fa fa-edit"></i>
                                     </button>
                                   </form>
                                   <div class="h-25 d-inline-block" style="width: 120px; background-color: rgba(0,0,255,.1)">
                                    <a class="btn btn-primary" href="{{ route('currency.changeRate', ['currency' =>$currency->id]) }}" >
                                        Change Rate</i>
                                       </a>
                                    </div>



                               </td>

                           </tr>
                       @endforeach
                    </tbody>
                </table>
                {{ $currencies->links() }}

            </div>
        </div>
    </div>

</div>


@endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type='text/javascript'>



        function modal(id) {

            $('#rate-modal').modal('show');
           // document.getElementById('id_2').value(id);
           // document.getElementById('rate_buying').value(id);

        }
        function closeModal() {
            $('#rate-modal').modal('hide');

        }
</script>
