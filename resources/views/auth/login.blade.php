<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deers | login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .secLogin {
        padding: 50px;
        height: 100vh;
        background-size: cover;
        background-position: center;
    }


    .login_form {
        background: #fff;
        padding: 42px 80px;
        border-radius: 40px;
        border: 8px solid #102BFE;
        margin-left: 12%;
    }


    .login_form h2 {
        font-size: 64px;
        line-height: 94px;
        color: #000;
        font-family: 'Oswald';
        margin-bottom: 70px;
        font-weight: 800;
    }


    .login_form p {
        font-size: 22px;
        line-height: 38px;
        color: #000;
        margin-bottom: 70px;
    }


    .login_form .field .form-control {
        background: #EEEEEE;
        border: 1px solid #C1C1C1;
        border-radius: 10px;
        height: 78px;
        font-size: 22px;
        color: #000;
        padding: 0 33px;
        box-shadow: none;
        outline: none;
    }


    .login_form .field .form-control::placeholder {
        color: #000;
    }


    .login_form .field {
        margin-bottom: 32px;
    }


    .login_form .field.ip_check {
        margin-top: 10px;
        margin-bottom: 68px;
    }


    .login_form .field.ip_check label {
        display: block;
        font-size: 22px;
        line-height: 1.4;
        color: #000;
        margin: 0;
        padding: 3px 0;
        padding-left: 64px;
        position: relative;
    }


    .login_form .field.ip_check label input {
        width: 0;
        height: 0;
    }


    .login_form .field.ip_check label input:before {
        content: '';
        width: 40px;
        height: 40px;
        background: #EEEEEE;
        border-radius: 5px;
        border: 1px solid #C1C1C1;
        position: absolute;
        left: -40px;
        top: -8px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }


    .login_form .field.ip_check label input:checked:before {
        content: '\f00c';
        font-family: 'Font Awesome 5 Free';
        font-weight: 600;
        background: #102BFE;
        border-color: #102BFE;
    }


    .login_form .btn_submit {
        font-size: 19px;
        background: #102BFE;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 22px 84px;
        box-shadow: none;
        outline: none;
    }
</style>
<body>

                <section class="secLogin" style="background-image: url('{{asset("dashboard_assets/images/bg_login.png")}}');">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="logo">
                                    <img src="{{asset("dashboard_assets/images/logo.png")}}" alt="">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="login_form">
                                    <h2>Welcome Back!</h2>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque.</p>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="field">
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required value="{{ old('email') }}" autocomplete="email" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="field">
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="field ip_check  ">
                                            <label for="agree">
                                                <input class="form-check-input" type="checkbox" id="agree" name="agree" value="Remember Me" {{ old('remember') ? 'checked' : '' }}>
                                                Remember Me
                                            </label>
                                        </div>
                                        <div class="btn_form">
                                            <input type="submit" name="submit" class="btn_submit" value="Sign In">
{{--                                            @if (Route::has('password.request'))--}}
{{--                                                <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                                    {{ __('Forgot Your Password?') }}--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
</body>
</html>

