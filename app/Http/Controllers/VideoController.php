<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //para recoger los datos q nos llegan por el protocolo http
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; //subir archivos y guardarlos
use Symfony\Component\HttpFoundation\Response; //

//tenemos  importar los modelos
use App\Video;
use App\Comment;

class VideoController extends Controller
{
    public function createVideo()
    {
    	return view ('video.createVideo');
    }

    public function saveVideo(Request $request)
    {
    	//validar formulario. 'min' es el minmo de letras que tendra el título del vídeo
    	$validatedData= $this->validate($request, [
    		'title' => 'required|min:5', //asi no podrá tener menos de 5 letras
    		'description' => 'required',
    		'video' => 'mimes:mp4'

    	]);

    	$video= new video();
    	$user =\Auth::user();
    	$video->user_id = $user->id;
    	$video->title = $request->input('title');
    	$video->description= $request->input('description');


    	//subida de la miniatura
    	$image= $request->file('image');
    	if($image)
    	{
    		$image_path = time().$image -> getClientOriginalName(); // time(). para que nunca se suba una imagen con el mismo nombre, esto coloca la fecha y hora de subida
    		\Storage::disk('images') -> put($image_path, \File::get($image) ); //image se llama la carpeta donde se guadaran las imagenes aqui en laravel

    		$video -> image= $image_path;
    	}

        //subida del video
        $video_file= $request->file('video');
        if($video_file)
        {
            $video_path= time().$video_file -> getClientOriginalName();
            \Storage::disk('videos') -> put($video_path, \File::get($video_file) );

            $video -> video_path= $video_path;
        }

    	$video->save();

    	return redirect()->route('home')->with(array('message'=> 'El video se ha subido correctamente'));
    }

    public function getImage($filename)
    {
        $file= Storage::disk('images')->get($filename); //en la carpeta storage estan las imagenes
        return new Response($file, 200); //te devuelve la imagen

    }

    //esto es utilizando Eloquent, se utiliza la entidad y ::find
    public function getVideoDetail($video_id)
    {
        $video= Video::find($video_id);
        return view( 'video.detail',array('video'=> $video ));
    }

    public function getVideo($filename)
    {
        $file= Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    public function delete ($video_id)
    {
        $user= \Auth::user(); //
        $video= Video::find($video_id);
        $comments= Comment::where('video_id', $video_id)->get(); //todos los comentarios que tengan en id del video

        //si el usuario esta identicado/logeado Y el id del usuario del video(propietario) es IGUAL al id del usuario identificado entonces se puede borrar el video
        if($user && ( $video->user_id == $user->id) )
        {
            //pero la vaina no es solo eliminar el video y shaa ta, NO... hay q ....>
            //eliminar comentarios
               if( $comments && count($comments)>=1 )
            {
            //con el foreach se borra comentario por comentario, se recorre el array de objetos de comments y en cada iteracion se crea una variable comment que es el objeto solamente y a ese objeto se le hace un delete
                foreach ($comments as $comment )  
                {
                    $comment->delete();                
                }
            }

            //eliminar ficheros pero a nivel de disco fisico (la miniatura y los videos)
            Storage::disk('images')->delete($video->image); //plo plo a la imagen adjunta al video
            Storage::disk('videos')->delete($video->video_path);
            
            //eliminar video
            $video->delete();
            $message=array('message'=> 'Video eliminado correctamente');
        }else
        {
            $message=array('message'=> 'Upps! el video no se ha eliminado');
        }
        return redirect()->route('home')->with($message);
    }

    public function edit($video_id)
    {
        $user= \Auth::user();
        $video= Video::findOrFail($video_id); //findOrFail para que devuelva un error en caso de no exista el objeto (video)
        if($user && ( $video->user_id == $user->id) )
        {        
        return view('video.edit', array('video'=>$video) );
        }else
        {
            return redirect()->route('home');//en caso de que no fucione, retorna al home
        }
    }
//pasamos tambien la request para recibir los parametros que nos llegan por post
    public function update($video_id, Request $request)
    {
        //le pasamos las mismas reglas de validacion que usamos en la funcion saveVideo
        $validatedData= $this->validate($request, [
        'title' => 'required|min:5', 
        'description' => 'required',
        'video' => 'mimes:mp4'
        ]);
        $user =\Auth::user();
        $video = Video::findOrFail($video_id);
        $video->user_id = $user->id;
        $video->title= $request->input('title');
        $video->description= $request->input('description');

         //recogemos los ficheros de imagen y video para guardarlos en las BD y fisicamente en el disco duro

        //subida de la nueva miniatura
        $image= $request->file('image');//a la variable imagen le asignamos el valor del ficheo que nos llega por post
        if($image) //verficamos que la imagen no sea nula
        {
            $image_path = time().$image -> getClientOriginalName(); // time(). para que nunca se suba una imagen con el mismo nombre, esto coloca la fecha y hora de subida
            \Storage::disk('images') -> put($image_path, \File::get($image) ); //image se llama la carpeta donde se guadaran las imagenes aqui en laravel

            $video -> image= $image_path;//le asignamos a la propiedad imagen del objeto videos el valo que tenga image_path el cual es el nombre del fichero
        }

        //subida del nuevo video
        $video_file= $request->file('video');
        if($video_file)
        {
            $video_path= time().$video_file -> getClientOriginalName();
            //guardamos el video en laravel
            \Storage::disk('videos') -> put($video_path, \File::get($video_file) );
            //aqui lo borramos de laravel, del disco duro puej... 
            Storage::disk('videos')->delete($video->video_path);
            $video -> video_path= $video_path;
        }
        $video->update(); //hace el update en la BD
        return redirect()->route('home')-> with(array('message'=>'El video se ha actualizado correctamente !!'));

    }
//por defecto la busquedas será nula, porque puede que la url venga con o sin busqueda
    public function search($search = null, $filter=null)
    {
        if( is_null($search) )
        {
            //si el valor de search es null le paso lo q me llegue por la request
            $search= \Request::get('search');
            //esta pinga solo me funciona en la url y hace q el boton de buscar explote :(
            //return redirect()->route('videoSearch',array('search'=>$search)); 

            //resulta que este if es lo q faltaba para q funcionara #Dioxxx
            if ( is_null($search) )
            {
                return redirect()->route('home'); 
            }
            return redirect()->route('videoSearch',array('search'=>$search));
        } 


        if( (is_null($filter)) && ( \Request::get('filter') ) && (!is_null($search)) )
        {
            $filter=\Request::get('filter');
            
            return redirect()->route('videoSearch',array('search'=>$search, 'filter'=>$filter));
        }  
                      
        $column= 'id';
        $order ='desc';

         if(!is_null($filter))
        {
            if($filter == 'new')
            {
                $column= 'id';
                $order ='desc';
            }
            if($filter == 'old')
            {
                $column= 'id';
                $order = 'asc';
            }
            if ($filter == 'alfa')
            {
                $column= 'title';
                $order ='asc';  
            }
        }
        $videos= Video::where('title','LIKE','%'. $search . '%')
                            ->orderBy($column,$order)
                            ->paginate(5); 
       
        return view('video.search', array(
            'videos'=> $videos,
            'search'=> $search
        )); 
    }
}  