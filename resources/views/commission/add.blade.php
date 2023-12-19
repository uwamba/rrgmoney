@extends('layouts.app')

@section('title', 'Capital')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Fund</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

                        <form method="POST" action="{{ route('commission.store') }}">
                            @csrf

                            <div class="card-body">
                                <div class="d-flex justify-content-center">

                                    {{-- Rate --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0 text-center">
                                        <Label class="text-gray-800"><span style="color:red;">*</span>Rate in percentage(%)</label>
                                        <input type="text"
                                            class="form-control form-control-user @error('rate') is-invalid @enderror text-gray-400"
                                            id="rate" placeholder="Rate" name="rate"
                                            value="{{ old('rate') }}">

                                        @error('rate')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                            <button type="submit" class="btn btn-primary"   data-id="">Save</button>
                            </div>
                        </form>
                    </div>
                    </div>


@endsection

 <!-- Script -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
       <script type='text/javascript'>


           function modal() {
               var amount=$('#amount').val();
               $("#amountH").text(amount);



               var description=$('#description').val();
               $("#descriptionH").text(description);
               // var method=document.getElementById('payment').val();
               $('#confirm-modal').modal('show');

          }
          function closeModal() {
               $('#confirm-modal').modal('hide');

          }



       </script>
       @include('common.logout-modal')
