@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

	<section class="panel">
		<div class="panel-body">
			@if(!empty($errors))

				<div class="alert alert-block alert-danger fade in">
					<ul>
					@foreach($errors as $error)
						<li>{{$error}}</li>
					@endforeach
					</ul>
				</div><!-- /.notification error -->
				<p>
					<a href="" class="btn btn-primary  btn-sm">Try Again</a>
				</p>
			@endif
		</div>
	</section>



	</div><!-- /.sign-up -->

@stop

