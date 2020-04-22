@extends('layouts.app')

@section('content')
	<div class="container">
	 	 	
		<h2 class="text-capitalize">
			Canal de {{$user->name. ' '.$user->surname}}
		</h2>
		

		
	 	<div class="clearfix"></div>
	    @include('video.videosList')
	</div>
@endsection