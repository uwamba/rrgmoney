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


    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries
      
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
          apiKey: "AIzaSyAA-OYxLCAuQzgqUXP1fvvnWo6zMDoadjg",
          authDomain: "test-rrgmoney.firebaseapp.com",
          projectId: "test-rrgmoney",
          storageBucket: "test-rrgmoney.appspot.com",
          messagingSenderId: "559118850458",
          appId: "1:559118850458:web:0a6c2dfe0adacdbc5b0223",
          measurementId: "G-YBQE9H4WTF"
        };
      
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        // const analytics = getAnalytics(app);
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
