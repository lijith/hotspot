@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

		<h2 class="form-signin-heading">Sign up here</h2>

		<div class="form-wrap">
			<div class="sign-up-form">
				@if(!empty($errors))
					<div class="alert alert-block alert-danger fade in">
						<ul>
						@foreach($errors as $error)
							<li>{{$error}}</li>
						@endforeach
						</ul>
					</div><!-- /.notification error -->
				@endif
				<form method="POST" action="" id="myform">
					<input type="tel" name="phone-number" autofocus="" placeholder="phone number" class="form-control phone-number" autocomplete="off" value="{{ $form_data['phone-number'] }}">

					<button type="submit" class="btn btn-lg btn-login btn-block">Sign Up</button>
				</form>
				<p><small>Use your phone number here. An access code will be send to that number by sms.</small></p>
			</div><!-- /.sign-up-form -->



		</div><!-- /.sign-up-wrap -->



	</div><!-- /.sign-up -->

@stop