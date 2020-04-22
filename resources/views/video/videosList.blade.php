<div class="container">
    @if( count($videos)>=1 )
    <div class="row  align-items-center ">
        @foreach($videos as $video)
            <div class="col col-lg-4 mb-3 p-4"   >
                <!-- Imagen del video-->
                @if (Storage::disk('images') -> has($video->image))
                    <div class=" video-image-thumb">
                        <div class="video-image-mask rounded float-left ml-5">
                            <img src="{{  url('/miniatura/'.$video->image) }}" class="video-image ml-2 " alt="...">  
                        </div>     
                    </div>        
                @endif                
            </div>

            <div class="col col-lg-8 mb-3 p-4 ">
                <h4 class="video-title">
                    <a href="{{ route('detailVideo' , ['video_id' => $video->id ]) }}" class="font-weight-bold text-dark "> {{$video->title}}  
                    </a>
                    <p class="h5 text-capitalize"> 
                        <a href="{{route('channel', ['user_id'=>$video->user->id])}}"> {{ $video->user->name. ' '.$video->user->surname}}
                        </a> 
                        <p5 class="text-muted"> {{ \FormatTime::LongTimeFilter($video->created_at) }} </p5>
                    </p>
                </h4> 
                <!-- Botones de Accion--> 
                <a href="{{ route('detailVideo' , ['video_id' => $video->id ])}}" class="btn btn-success">Ver</a>
                <!-- este boton sólo se mostrara si el usuario esta identificado y es el dueño del video--> 
                @if ( Auth::check() && Auth::user()->id == $video->user->id )
                <a href="{{ route('videoEdit' , ['video_id' => $video->id ])}}" class="btn btn-warning">Editar</a>
                
                <!-- Botón en HTML (lanza el modal en Bootstrap) -->         
                    <a href="#eliminarvideoModal{{$video->id}}" role="button" class="btn btn-danger" data-toggle="modal">Eliminar</a>
                    
                    <div id="eliminarvideoModal{{$video->id}}" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">¿Estás seguro?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Seguro que quieres borrar este video?</p>
                                    <p><small>{{$video->title}}</small> </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <a href="{{ url('/delete-video/'.$video->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>                 
        @endforeach
    </div>
    
    @else
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            No hay videos actualmente
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif 

    {{$videos->links()}} <!--paginacion--> 
</div> 