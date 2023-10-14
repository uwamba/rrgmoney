@extends('auth.layouts.app')

@section('title', 'Login')
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">.
       @if (session('error'))
          <span class="text-danger"> {{ session('error') }}</span>
       @endif
       <form method="POST" action="{{ route('login') }}">
         @csrf
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Sign Up Here</p>

          </div>

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0">Or</p>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input id="login" type="text" placeholder="Email or Phone Number"
               class="form-control{{ $errors->has('mobile_number') || $errors->has('email') ? ' is-invalid' : '' }}"
                 name="login" value="{{ old('mobile_number') ?: old('email') }}" required autofocus>

                @if ($errors->has('mobile_number') || $errors->has('email'))
                    <span class="invalid-feedback">
                      <strong>{{ $errors->first('mobile_number') ?: $errors->first('email') }}</strong>
                    </span>
                @endif
            <label class="form-label" for="form3Example3">Email or Phone number</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
          <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                @enderror
            <label class="form-label" for="form3Example4">Password</label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
              <label class="form-check-label" for="form2Example3">
                Remember me
              </label>
            </div>
            <a href="{{route('password.request')}}" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
           <button class="btn btn-primary btn-user btn-block">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{route('register')}}"
                class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
    <!-- Copyright -->
    <div class="text-white mb-3 mb-md-0">
      Copyright © 2023. All rights reserved.
    </div>
    <!-- Copyright -->

    <!-- Right -->
    <div>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-google"></i>
      </a>
      <a href="#!" class="text-white">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>
    <!-- Right -->
  </div>
</section>
