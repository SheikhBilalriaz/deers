<section class="secLogin" style="background-image: url('assets/images/bg_login.png');">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="logo">
                    <img src="assets/images/logo.png" alt="">
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
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
