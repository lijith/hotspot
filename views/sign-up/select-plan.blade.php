@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

		<h2 class="form-signin-heading">Select Plan</h2>

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
					<label>Select A Plan</label>
					<select class="form-control input-lg m-bot15" name="user-plan">
							@foreach ($plans as $plan)
              	<option value="{{ $plan['id'] }}">Rs {{ $plan['price'] }} for	{{ $plan['planname'] }}</option>
							@endforeach
          </select>

					<button type="submit" class="btn btn-lg btn-login btn-block">BUY</button>
				</form>
				<p><small>You will be forwarded to payment gateway</small></p>
			</div><!-- /.sign-up-form -->



		</div><!-- /.sign-up-wrap -->



	</div><!-- /.sign-up -->

@stop