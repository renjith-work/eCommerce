@extends('front.layout') 
@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="/front/frame/auth/loginRegister.css" rel="stylesheet">
@endsection
@section('content')

    <div class="content-wraper">
		<div class="px-main-content-cover">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<div class="px-auth-box-cover">

						<div class="px-auth-box-head">
							<div class="px-auth-box-head-title">Login</div>
						</div>
							<div class="px-auth-box-body">
							<form method="POST" action="{{route('front.auth.user.login')}}" id="login">
		                	{{ csrf_field() }}
								<div class="form-group">
									<label for="email">Email address</label>
									<input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="emai1" name="email" placeholder="Please enter your email...">
									@error('email') <p class="error-p">{{ $errors->first('email') }}</p> @enderror
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Please enter your minimum 6-character password..">
									@error('password') <p class="error-p">{{ $errors->first('password') }}</p> @enderror
								</div>
								<div class="px-atuh-box-check-cover">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-check">
												<input type="checkbox" class="form-check-input" id="remeber" name="remember">
												<label class="form-check-label" for="remember">Remeber Me</label>
											</div>	
										</div>
										<div class="col-md-6">
											<div class="login-forgot-pass-link">
												<a href="/password/reset">Forgot Password?</a>
											</div>
										</div>
									</div>
								</div>
								@error('message')
		                            <div class="alert alert-danger ssifu-alert">
		                              Sorry, we couldn't find an account the matches the credentials you provided. You can try and log in with another account or try to retrieve your password by <a href="/user/forgot-password">clicking this link</a>.
		                            </div>
	                            @enderror
								<div class="px-auth-login-button-cover">
									<input type="Submit" value="Login" class="btn px-black-btn">
								</div>
							</form>
								<div class="px-auth-social-media-login-cover">
									<div class="px-auth-social-media-login-item">
										<a href="/login/facebook" class="btn px-btn-fb-social">
											<div class="row">
												<div class="col-2 px-social-icon-border"><div class="px-btn-social-icon"><i class="fa fa-facebook" aria-hidden="true"></i></div></div>
												<div class="col-10 px-social-icon-text">Login with Facebook</div>
											</div>
										</a>
									</div>	
									<div class="px-auth-social-media-login-item">
										<a href="/login/google" class="btn px-btn-gp-social">
											<div class="row">
												<div class="col-2 px-social-icon-border"><div class="px-btn-social-icon"><i class="fa fa-google" aria-hidden="true"></i></div></div>
												<div class="col-10 px-social-icon-text">Login with Google</div>
											</div>
										</a>
									</div>	
									
								</div>
								<div class="px-auth-login-register-account">Don't have an account? <a href="/register">Register Here</a></div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('footer')
<script>
 	
 </script>
@endsection