@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

		<h2 class="form-signin-heading">Verify Access code</h2>

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
				<form method="POST" action="">
					<input type="text" name="access-code" autofocus="" placeholder="access code here" class="form-control" autocomplete="off" >

					<button type="submit" class="btn btn-lg btn-login btn-block">Verify</button>
				</form>
				<p><small>Enter Access Code</small></p>
				<p><a href="{{ $site_url }}resend-access-code.php" class="btn btn-default">Resend Access Code</a> </p>
			</div><!-- /.sign-up-form -->



		</div><!-- /.sign-up-wrap -->



	</div><!-- /.sign-up -->

@stop