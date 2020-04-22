<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //para recoger los datos q nos llegan por el protocolo http
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; //subir archivos y guardarlos
use Symfony\Component\HttpFoundation\Response; //

//importar los modelos
use App\User;
use App\Video;
use App\Comment;

class UserController extends Controller
{
    //metodo para sacar el canal de usuario
    //capturamos toda la info de usuario que nos llegue por un parametro de la url
    public function channel($user_id)
    {
    	$user= User::find($user_id);

    	if( !is_object($user) )
    	{
    		return redirect()->route('home');
    	}
    	$videos=Video::where('user_id', $user_id)->paginate(5);
    	return view('user.channel', array(
    			'user'=>$user,
    			'videos'=>$videos
    				));
    }
}
