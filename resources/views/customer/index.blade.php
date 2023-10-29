<!DOCTYPE html>
<html lang="en">

{{-- Include Head --}}
@extends('customer.components.head')
@include('customer.components.header')

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 mb-4">Account Summary</h1>
                    <div class="row g-4 g-sm-5 justify-content-center">
                        <div class="col-sm-5">
                            <div class="about-fact btn-square flex-column rounded-circle bg-primary ms-sm-auto">
                                <p class="text-white mb-0">Balance</p>
                                <h1 class="text-white mb-0" >{{$balance}}</h1>
                            </div>
                        </div>
                        <div class="col-sm-5 text-start">
                            <div class="about-fact btn-square flex-column rounded-circle bg-secondary me-sm-auto">
                                <p class="text-white mb-0">Last Transfer Amount</p>
                                <h1 class="text-white mb-0" >{{$sent_amount}}</h1>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="about-fact mt-n130 btn-square flex-column rounded-circle bg-dark mx-sm-auto">
                                <p class="text-white mb-0">Last Received Amount</p>
                                <h1 class="text-white mb-0" >{{$received_amount}}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.5s">

                    <div class="row">
                        <div class="col-sm-14">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Sent</h5>
                              <p class="card-text">You Can sent Up to 30 Countries.</p>
                              <a href="{{ route('send.create') }}" class="btn btn-primary">Clic Here</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-14">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">TopUp</h5>
                              <p class="card-text">Top Up Your account through Momo or Bank deposit</p>
                              <a href="{{ route('topup.create') }}" class="btn btn-primary">Click here</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-14">
                            <div class="card">
                              <div class="card-body">
                                <h5 class="card-title">Safe Pay</h5>
                                <p class="card-text">Pay after get services or products</p>
                                <a href="#" class="btn btn-primary">Click here</a>
                              </div>
                            </div>
                          </div>
                      </div>
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
