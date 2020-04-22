@extends('layouts.app')
@section('content')

	<div class="container">
		<div class="row">
				
			<form action="{{ route ('updateVideo',['video_id'=> $video->id] )}}" method="post" enctype="multipart/form-data" class="col-lg-7">
				{!! csrf_field() !!}

				@if ( $errors->any() )
					<div class="alert alert-danger">
						<ul>
							@foreach ( $errors->all() as $error )
							<li>
								{{ $error }}
							</li>
							@endforeach
						</ul>	
					</div>
				@endif

			</br>
				<h2>Editar {{$video->title}} </h2>
				<hr>
				<div class="form-group">
					<label for="title">Titulo</label>
					<input type="text" class="form-control" id="title" name="title" value="{{ $video->title }}"/>
				</div>

				<div class="form-group">
					<label for="description">Descripción</label>
					<textarea class="form-control" id="description" name="description"> {{ $video->description }}</textarea> 
				</div>

				<div class="form-group"> 
					<label for="image">Miniatura</label>
						@if (Storage::disk('images') -> has($video->image))
		                    <div class=" video-image-thumb">
		                        <div class="video-image-mask rounded">
		                            <img src="{{  url('/miniatura/'.$video->image) }}" class="video-image ml-2 " alt="...">  
		                        </div>     
		                    </div>        
	                	@endif
					<input type="file" class="form-control-file" id="image" name="image"/>
				</div>

				<div class="form-group">
					<label for="video">Archivo de Video</label>
					<video controls id="video-player">
						<source src="{{route('fileVideo', ['filename'=> $video->video_path] )}}" >
						</source> 
						Tu navegador no es compatible con HTML5
					</video>
					<input type="file" class="form-control-file" id="video" name="video"/>
				</div>

				<div class="custom-file">
				  	<input type="file" class="custom-file-input" id="customFileLang" lang="es">
				  	<label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
				</div>

			
				
				<!-- <div class="input-group">
				 
				   <div class="custom-file">
				    <input type="file" class="custom-file-input" id="inputGroupFile01"
				      aria-describedby="inputGroupFileAddon01">
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>

				</div> --> 

				</br>
				<button type="submit" class="btn btn-success">Editar Video</button>

			</form>
		</div>
</div>
	

@endsection