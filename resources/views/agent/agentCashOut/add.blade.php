<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('agent.components.head')

@include('agent.components.header')

      {{-- Alert Messages --}}
      @include('common.alert')

      <!-- DataTales Example -->
      <div class="container-fluid">
         <div class="row justify-content-center">
           <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center" >
           <div class="card shadow mb-4">
                   <div class="card-header py-3">
                       <h6 class="m-0 font-weight-bold text-primary">New Request</h6>
                   </div>
                   <form method="POST" action="{{route('AgentCashOut.store')}}">
                       @csrf
                       <div class="card-body text-center">
                           <div class="form-group row">

                               {{-- AMOUNT --}}

                                   <Label><span style="color:red;">*</span>Amount to Cash Out</label>
                                   <input
                                       type="text"
                                       class="form-control form-control-user @error('amount') is-invalid @enderror"
                                       id="amount"
                                       placeholder="Enter Stock Amount"
                                       name="amount"
                                       value="{{ old('amount') }}">

                                   @error('amount')
                                       <span class="text-danger">{{$message}}</span>
                                   @enderror
                           </div>
                       </div>
                       <div class="card-footer">
                           <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                           <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('AgentCashOut.index') }}">Cancel</a>
                       </div>
                   </form>
           </div>
         </div>
      </div>

    @extends('agent.components.footer')
    @include('common.logout-modal')
</body>

</html>


