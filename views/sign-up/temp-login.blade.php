@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

		<h2 class="form-signin-heading">Sign Up</h2>

		<div class="form-wrap">
			<div class="sign-up-form">
				@if($flash != '')
					<div class="alert alert-block alert-danger fade in">
						{{$flash}}
					</div><!-- /.notification error -->
				@endif
				@if(!empty($errors))
					<div class="alert alert-block alert-danger fade in">
						@foreach ($errors as $err)
							{{$err}}
						@endforeach

					</div><!-- /.notification error -->
				@endif
				<p>
					A 6 digit PIN is send to you phone. Please use it to login for Wifi access.

				</p>
				<p><a href="{{ $site_url }}user-select-plan.php" class="btn btn-danger">Login</a></p>
				<hr />

				<p>If you haven't received SMS please press Resend Access Code</p>
				<p><a href="{{ $site_url }}resend-access-code.php" class="btn btn-primary">Resend Access Code</a> </p>
			</div><!-- /.sign-up-form -->



		</div><!-- /.sign-up-wrap -->



	</div><!-- /.sign-up -->

@stop