@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

	<section class="panel">
		<div class="panel-body">

				<div class="alert alert-success fade in">
					<h4><i class="icon-ok-sign"></i>Success!</h4>
					<p>Transaction done Successfully</p>
				</div><!-- /.notification error -->
				<div class="alert alert-warning fade in">
					<h4>username : {{ $username }}</h4>
					<h4>password : {{ $password }}</h4>
					<p>
						Use this username and password <br />
						Click Login Here button below to continue
					</p>
				</div><!-- /.notification error -->

				<a href="" class="btn btn-success  btn-sm">Login Here</a>

		</div>
	</section>



	</div><!-- /.sign-up -->

@stop

