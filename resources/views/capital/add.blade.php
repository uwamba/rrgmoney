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

                        <form method="POST" action="{{ route('income.store') }}">
                            @csrf

                            <div class="card-body">
                                <div class="d-flex justify-content-center">

                                    {{-- AMOUNT --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0 text-center">
                                        <Label class="text-gray-800"><span style="color:red;">*</span>Amount</label>
                                        <input type="text"
                                            class="form-control form-control-user @error('amount') is-invalid @enderror text-gray-400"
                                            id="amount" placeholder="Amount" name="amount"
                                            value="{{ old('amount') }}">

                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span style="color:red;">*</span>Account</label>
                                          <select class="form-control form-control-user @error('currency') is-invalid @enderror" name="account_name" id="account">
                                              <option selected disabled>Select Account</option>
                                              @foreach ($account as $account)
                                                  <option value="{{$account->name}}">{{$account->name." ".$account->currency}}</option>
                                              @endforeach
                                          </select>
                                          @error('currency')
                                              <span class="text-danger">{{$message}}</span>
                                          @enderror


                                       <Label class="text-gray-800"><span style="color:red;">*</span>Description</label>
                                         <input type="text"
                                          class="form-control form-control-user @error('description') is-invalid @enderror text-gray-400"
                                          id="description" placeholder="Description" name="description" value="{{ old('description') }}">


                                        </div>
                                </div>
                            </div>

                            <div class="card-footer">
                            <button type="button" id="open-modal" onclick="modal()" class="btn btn-primary"   data-id="">Next</button>


                            </div>
                              @include('capital.confirm-modal')
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
               var account=$('#account').val();
               $("#accountH").text(account);
               // var method=document.getElementById('payment').val();
               $('#confirm-modal').modal('show');

          }
          function closeModal() {
               $('#confirm-modal').modal('hide');

          }



       </script>
       @include('common.logout-modal')
