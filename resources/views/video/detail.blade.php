@extends('layouts.app')

@section('content')
<div class="container">
	
	<div class="col-md-12 ">
		<h2> {{ $video->title }} </h2>
		<hr/>
	</div>

	<div class="col-md-8">
		<!--video-->
			<video controls id="video-player">
				<source src="{{route('fileVideo', ['filename'=> $video->video_path] )}}" >
				</source> 
				Tu navegador no es compatible con HTML5
			</video>
		<!--descripcion-->	
		<div class="card">
		  	<h5 class="card-header ">Subido por 
		  		<strong class="text-capitalize"> 
		  		<a href="{{route('channel', ['user_id'=>$video->user->id])}}">  {{$video->user->name.' '.$video->user->surname}} 
		  		</strong>
		  		</a> 
		  		{{ \FormatTime::LongTimeFilter($video->created_at) }}  
		  	</h5>
		  	<!--FormatTime es el alias del Helper y LongTimeFilter es el nombre del metodo que hace el mamawebeteo en Helpers\FormatTime.php y ($video->created_at) es el formato de fecha que le voy a pasar-->
		  	<div class="card-body">
		    	<h5 class="card-title">{{$video->description}}</h5>		    	
		  	</div>
		</div>
		<!--comentarios-->
		@include('video.comments')
 	</div>
</div>

@endsection

