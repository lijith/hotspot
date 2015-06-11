@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

		<h2 class="form-signin-heading">Payment</h2>

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
				<p>Order ID : <strong>{{ $form_data['Order_Id'] }}</strong></p>
				<p>Your Plan : <strong>{{ucwords($plan['planname'])}}</strong></p>
				<p>Pay Rs : <strong>{{$plan['price']}}</strong></p>
				 <form method="post" name="redirect" action="http://www.ccavenue.com/shopzone/cc_details.jsp">

						<input type="hidden" name="encRequest" value="{{$form_data['encrypted']}}">
						<input type="hidden" name="Merchant_Id" value="{{$form_data['Merchant_Id']}}">

						<button type="submit" class="btn btn-lg btn-login btn-block">Make Payment</button>
				 </form>
				<p><small>You will be forwarded to payment gateway</small></p>
			</div><!-- /.sign-up-form -->





		</div><!-- /.sign-up-wrap -->



	</div><!-- /.sign-up -->

@stop