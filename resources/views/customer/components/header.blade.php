<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid py-2 d-none d-lg-flex">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="me-3"><i class="fa fa-map-marker-alt me-2"></i>123 Street, Makuza City Plaza,
                        Rwanda</small>
                    <small class="me-3"><i class="fa fa-clock me-2"></i>Mon-Sat 09am-5pm, Sun Closed</small>
                </div>
                <nav class="breadcrumb mb-0">
                    <a class="breadcrumb-item small text-body" href="#">Home</a>
                    <a class="breadcrumb-item small text-body" href="#">Send</a>
                    <a class="breadcrumb-item small text-body" href="#">Received</a>
                    <a class="breadcrumb-item small text-body" href="#">Help</a>
                    <a class="breadcrumb-item small text-body" href="#">FAQs</a>

                </nav>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Brand Start -->
    <div class="container-fluid bg-primary text-white pt-4 pb-5 d-none d-lg-flex">
        <div class="container pb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    <i class="bi bi-telephone-inbound fs-2"></i>
                    <div class="ms-3">
                        <h5 class="text-white mb-0">Call Now</h5>
                        <span>+250 7xx xxx</span>
                    </div>
                </div>
                <a href="index.html" class="h1 text-white mb-0">RRG<span class="text-dark">MONEY</span></a>
                <div class="d-flex">
                    <i class="bi bi-envelope fs-2"></i>
                    <div class="ms-3">
                        <h5 class="text-white mb-0">Mail Now</h5>
                        <span>info@rrgmoney.com</span>
                    </div>
                </div>
                <div class="d-flex">
                    <a href="#" class="dropdown-item active" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <span class="bi bi-box-arrow-right"></span>Logout</a>
                </div>

            </div>
        </div>
    </div>
    <!-- Brand End -->


    <!-- Navbar Start -->
    <div class="container-fluid sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-lg-0 px-lg-3">
                <a href="{{ route('home') }}" class="navbar-brand d-lg-none">
                    <h1 class="text-primary m-0">RRG<span class="text-dark">MONEY</span></h1>
                </a>
                <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav">
                        <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Send/Receive</a>

                            <div class="dropdown-menu bg-light m-0">

                                <a href="{{ route('send.create') }}" class="dropdown-item">New Transfer</a>
                                <a href="{{ route('send.index') }}" class="dropdown-item">History</a>
                            
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">cash out</a>

                                                    <div class="dropdown-menu bg-light m-0">

                                                        <a href="{{ route('cashout.create') }}" class="dropdown-item">Cash out request </a>
                                                        <a href="{{ route('cashout.index') }}" class="dropdown-item">History</a>

                                                    </div>
                                                </div>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Top Up</a>

                            <div class="dropdown-menu bg-light m-0">

                                <a href="{{ route('topup.create') }}" class="dropdown-item">New Topup</a>
                                <a href="{{ route('topup.index') }}" class="dropdown-item">History</a>
                            </div>
                        </div>
                        <a href="#" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="ms-auto d-none d-lg-flex">

                        <a href="#" class="dropdown-item">{{ auth()->user()->email }}</a>
                        <img class="img-profile rounded-circle" width="30" height="30"
                            src="{{ asset('admin/img/undraw_profile.svg') }}">
                        </a>


                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
