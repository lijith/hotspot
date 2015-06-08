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
				<p>Your Plan : <strong>{{ucwords($plan['planname'])}}</strong></p>
				<p>Pay Rs : <strong>{{$plan['price']}}</strong></p>
				 <form action="https://www.ccavenue.com/shopzone/cc_details.jsp" method="post" name="itemsform">

						<input type="hidden" name="Order_Id" value="{{ $form_data['Order_Id'] }}" />
						<input type="hidden" name="Amount" value="{{ $form_data['Amount'] }}" />
						<input type="hidden" name="billing_cust_name" value="{{ $form_data['billing_cust_name'] }}" />
						<input type="hidden" name="billing_cust_address" value="{{ $form_data['billing_cust_address'] }}" />
						<input type="hidden" name="billing_cust_country" value="{{ $form_data['billing_cust_country'] }}" />
						<input type="hidden" name="billing_cust_email" value="{{ $form_data['billing_cust_email'] }}" />
						<input type="hidden" name="billing_cust_tel" value="{{ $form_data['billing_cust_tel'] }}" />
						<!--<input type="hidden" name="delivery_cust_name" value="<?//=$name; ?>">-->
						<input type="hidden" name="Merchant_Id" value="M_eshopsbg_6774" />
						<input type="hidden" name="cmd" value="_xclick" />
						<input type="hidden" name="business" value="admin@sobg.org" />
						<input type="hidden" name="item_name" value="{{ $form_data['item_name'] }}" />
						<input type="hidden" name="currency_code" value="USD" />
						<input type="hidden" name="amount" value="{{ $form_data['amount'] }}" />
						<input type="hidden" name="shipping" value="{{ $form_data['shipping'] }}" />
						<input type="hidden" name="delivery_cust_name" value="{{ $form_data['delivery_cust_name'] }}" />
						<input type="hidden" name="delivery_cust_address" value="{{ $form_data['delivery_cust_address'] }}" />
						<input type="hidden" name="delivery_cust_country" value="{{ $form_data['delivery_cust_country'] }}" />
						<input type="hidden" name="delivery_cust_email" value="{{ $form_data['delivery_cust_email'] }}" />
						<input type="hidden" name="delivery_cust_tel" value="{{ $form_data['delivery_cust_tel'] }}" />
						<button type="submit" class="btn btn-lg btn-login btn-block">Make Payment</button>
				 </form>
				<p><small>You will be forwarded to payment gateway</small></p>
			</div><!-- /.sign-up-form -->





		</div><!-- /.sign-up-wrap -->



	</div><!-- /.sign-up -->

@stop