<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@include('agent.components.head')
@include('agent.components.header')

    <!-- About Start -->
    <div class="container-fluid py-5">
         <div class="container-fluid">
                 <div class="row justify-content-center">
                     <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 text-center" >
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add New Customer</h6>
                        </div>

                        <form method="POST" action="{{route('users.customerStore')}}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">

                                    {{-- First Name --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>First Name</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                            id="exampleFirstName"
                                            placeholder="First Name"
                                            name="first_name"
                                            value="{{ old('first_name') }}">

                                        @error('first_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    {{-- Last Name --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Last Name</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                            id="exampleLastName"
                                            placeholder="Last Name"
                                            name="last_name"
                                            value="{{ old('last_name') }}">

                                        @error('last_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Email</label>
                                        <input
                                            type="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="exampleEmail"
                                            placeholder="Email"
                                            name="email"
                                            value="{{ old('email') }}">

                                        @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    {{-- Mobile Number --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Mobile Number</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                                            id="exampleMobile"
                                            placeholder="Mobile Number"
                                            name="mobile_number"
                                            value="{{ old('mobile_number') }}">

                                        @error('mobile_number')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    {{-- address --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Address</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-user @error('address') is-invalid @enderror"
                                            id="exampleMobile"
                                            placeholder="Address"
                                            name="address"
                                            value="{{ old('address') }}">

                                        @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    {{-- country --}}

                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>country</label>
                                        <select class="form-control form-control-user @error('country') is-invalid @enderror" name="country">
                                            <option selected disabled>Select Country</option>

                                                @foreach ($countries as $country)
                                                 <option value="{{$country->currency_country}}">{{$country->currency_country}}</option>
                                                @endforeach

                                        </select>
                                        @error('country')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>


                                    {{-- Role --}}
                                    @hasrole('Admin')
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Role</label>
                                        <select class="form-control form-control-user @error('role_id') is-invalid @enderror" name="role_id">
                                            <option selected disabled>Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                   @endhasrole
                                   @hasrole('Agent')
                                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                              <span style="color:red;">*</span>Role</label>
                                              <select class="form-control form-control-user @error('role_id') is-invalid @enderror" name="role_id">
                                                <option value="3">Customer</option>

                                              </select>
                                              @error('role_id')
                                                  <span class="text-danger">{{$message}}</span>
                                              @enderror
                                        </div>
                                   @endhasrole
                                    {{-- Status --}}
                                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                        <span style="color:red;">*</span>Status</label>
                                        <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                                            <option selected disabled>Select Status</option>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-0 feature-row">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="text-solid bi bi-flag" style="color: #4bc729;"></i>
                        </div>
                        <h5 class="mb-3">Countries</h5>
                        <p class="mb-0">Rwanda,Kenya,Uganda,Tanzani.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-arrow-left-right" style="color: #4813a9;"></i>
                        </div>
                        <h5 class="mb-3">Payment Channel</h5>
                        <p class="mb-0">Bank Deposit,Mobile Money.Cash</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-cash-coin text-dark"></i>
                        </div>
                        <h5 class="mb-3">Pricing</h5>
                        <p class="mb-0">Percentile,Flat fee</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                    <div class="feature-item border h-100 p-5">
                        <div class="icon-box-primary mb-4">
                            <i class="bi bi-headphones text-dark"></i>
                        </div>
                        <h5 class="mb-3">24/7 Support</h5>
                        <p class="mb-0">Tel: +250 xxxxxxx, Email: email@email.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->
    @extends('customer.components.footer')
    @include('common.logout-modal')
</body>
</html>

