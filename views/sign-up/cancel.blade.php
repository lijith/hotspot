@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

	<section class="panel">
		<div class="panel-body">

				<div class="alert alert-warning fade in">
					<h4>Cancelled</h4>
					<p>
					Transaction was cancelled before completion. <br />
					If you want to choose plan for wifi access press Continue
					</p>
				</div><!-- /.notification error -->


				<a href="user-select-plan.php" class="btn btn-success  btn-sm">Continue</a>

		</div>
	</section>



	</div><!-- /.sign-up -->

@stop

