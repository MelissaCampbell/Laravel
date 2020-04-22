<hr/>
<h4>Comentarios</h4>
<hr/>

    @if ( session('message') )
    
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
      {{ session('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    
    @if(Auth::check())
	<form class="col-md-4" method="post" action="{{ url('/comment') }}"> 
		{!! csrf_field() !!}
		<input type="hidden" name="video_id" value="{{$video->id}}" required/>
		<p>
			<textarea class="form-control" name="body" required>			
			</textarea>
		</p> 
		<input type="submit" value="Comentar" class="btn btn-success"/>
	</form>


	@endif

	@if(isset($video->comments))
		<div id="comment-list ">
			@foreach($video->comments as $comment)
				<div class="comment-item col-md-12 pull-left">
					<div class="card">
					  	<h5 class="card-header ">  <strong class="text-capitalize">{{$comment->user->name.' '.$comment->user->surname}} </strong> {{ \FormatTime::LongTimeFilter($comment->created_at) }} 
					  	</h5>
					  	<!--FormatTime es el alias del Helper y LongTimeFilter es el nombre del metodo que hace el mamawebeteo en Helpers\FormatTime.php y ($video->created_at) es el formato de fecha que le voy a pasar--> 
					  	<div class="card-body">
					    	<p class="card-text"> {{$comment->body}}</p>
					  	
				
							@if( (Auth::check() ) && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id) )
							<!-- Botón en HTML (lanza el modal en Bootstrap) -->
						
							<a href="#eliminarModal{{$comment->id}}" role="button" class="btn btn-sm btn-primary float-right" data-toggle="modal">Eliminar</a>
							
							<div id="eliminarModal{{$comment->id}}" class="modal" tabindex="-1" role="dialog">
							  	<div class="modal-dialog" role="document">
							    	<div class="modal-content">
							      		<div class="modal-header">
							        		<h5 class="modal-title">¿Estás seguro?</h5>
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          		<span aria-hidden="true">&times;</span>
							        		</button>
							     		</div>
							      		<div class="modal-body">
							        		<p>¿Seguro que quieres borrar este comentario?</p>
							        		<p><small>{{$comment->body}}</small> </p>
							    		</div>
							      		<div class="modal-footer">
							       			<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							        		<a href="{{ url('/delete-comment/'.$comment->id) }}" type="button" class="btn btn-danger">Eliminar</a>
							      		</div>
							    	</div>
							  	</div>
							</div>
							@endif
						</div>	
					</div>
				</div>

			

			@endforeach
		</div>
	@endif