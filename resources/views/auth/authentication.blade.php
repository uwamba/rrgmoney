@extends('auth.layouts.app')
<br /><br />
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="alert alert-danger" id="error" style="display: none;"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Phone Number Authentication
                    </div>
                    <div class="card-body">

                        <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>

                        <form>
                            <div id="recaptcha-container"></div>
                        </form>
                        <form method="POST" action="{{ route('userLogin') }}" id="loginForm">
                          @csrf
                            <input type="hidden" class="form-control" name="credentials" id="credentials" value={{json_encode($credentials) }}>
                        </form>
                        <form>

                            <input type="text" id="verificationCode" class="form-control"
                                placeholder="Enter verification code">
                            <button type="button" class="btn btn-success" onclick="codeverify();">Verify code</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @endsection


    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyAVV14-w1XsJY-Wfa6Wjwk9Fvt6-Dd1D4M",
            authDomain: "money-transfer-a8aa8.firebaseapp.com",
            projectId: "money-transfer-a8aa8",
            storageBucket: "money-transfer-a8aa8.appspot.com",
            messagingSenderId: "660273871334",
            appId: "1:660273871334:web:a937fae9b13121c514fe27",
            measurementId: "G-5PXX7GPXK2"
        };

        firebase.initializeApp(firebaseConfig);
    </script>

    <script type="text/javascript">
        window.onload = function() {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
            phoneSendAuth();
        }

        function phoneSendAuth() {
            var phone = {{ Js::from($phone) }}

            var number = $("#number").val();

            firebase.auth().signInWithPhoneNumber(phone, window.recaptchaVerifier).then(function(confirmationResult) {

                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;

                console.log(coderesult);

                $("#sentSuccess").text("Message Sent Successfully.");
                $("#sentSuccess").show();


            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
            });

        }

        function codeverify() {

            var code = $("#verificationCode").val();

            coderesult.confirm(code).then(function(result) {
                var user = result.user;
                //console.log(user);

                $("#successRegsiter").text("you are register Successfully.");
                $("#successRegsiter").show();

                //submit credentials

               document.getElementById("loginForm").submit();
                

               

            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
                document.location.href = "{!! route('login') !!}";
            });
        }
    </script>
