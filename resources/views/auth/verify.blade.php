@extends('users.layouts.master')

@section('title', 'Verify Email')

@section('content')
<!-- start Verify Email -->
<div class="sign-in segments-page">
    <div class="container">
        <div class="signin-contents">
            <h4>Verify Your Account</h4>
            <!-- Display the error message in a dynamic div -->
            <b style="color:green;">We Have Sent Your Verification When You Created Your Account!</b><br>
            <p id="message_error" style="color:red;"></p>
            <p id="message_success" style="color:green;"></p>
            <form id="verificationForm" method="POST">
                @csrf
                <label>Enter OTP</label>
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="number" name="otp" placeholder="Verification Code" required>
                <button class="button" type="submit"><i class="fa fa-send"></i>Verify</button>
            </form>
        </div>
        <p class="time"></p>
        <button id="resendOtpVerification">Resend Verification OTP</button>
    </div>
</div>
<!-- end verify email -->
@endsection

@section('scriptSection')
<script>
    $(document).ready(function(){
        $('#verificationForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('verifiedOtp') }}",
                type: "POST",
                data: formData,
                success: function(res){
                    if(res.success){
                        alert(res.msg);
                        window.location.href = "/";
                    }
                    else{
                        $('#message_error').text(res.msg);
                        setTimeout(() => {
                            $('#message_error').text('');
                        }, 3000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#resendOtpVerification').click(function(){
            $(this).text('Wait...');
            var userMail = "{{ $email }}";
            $.ajax({
                url: "{{ route('resendOtp') }}",
                type: "GET",
                data: { email: userMail },
                success: function(res){
                    $('#resendOtpVerification').text('Resend Verification OTP');
                    if(res.success){
                        timer();
                        $('#message_success').text(res.msg);
                        setTimeout(() => {
                            $('#message_success').text('');
                        }, 3000);
                    }
                    else{
                        $('#message_error').text(res.msg);
                        setTimeout(() => {
                            $('#message_error').text('');
                        }, 3000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });
    });

    function timer() {
        var seconds = 30;
        var minutes = 1;
        var timer = setInterval(() => {
            if (minutes < 0) {
                $('.time').text('');
                clearInterval(timer);
            } else {
                let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                $('.time').text(tempMinutes + ':' + tempSeconds);
            }
            if (seconds <= 0) {
                minutes--;
                seconds = 59;
            }
            seconds--;
        }, 1000);
    }
    timer();
</script>
@endsection
