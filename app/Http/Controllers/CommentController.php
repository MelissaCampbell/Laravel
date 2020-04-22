<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Comment; //para usar nuestro modelo

class CommentController extends Controller
{
    //una request para recoger los parametros que me llegan por post
    public function store (Request $request)
    {
    	$validate = $this->validate($request,[
    		'body'=> 'required'
    	]);
    	$comment = new Comment(); //para crear un nuevo comentario
    	$user = \Auth::user(); //para conseguir al usuario identificado
    	$comment->user_id = $user->id;
    	$comment->video_id = $request->input('video_id');
    	$comment->body = $request->input('body');

    	$comment->save();

    	return redirect()-> route('detailVideo', ['video_id'=> $comment->video_id ])-> with(array(
    		'message'=> 'Comentario añadido correctamente !! '));
    }

    public function delete ($comment_id)
    {
        $user= \Auth::user(); //se guarda el usuario identificado en una variable
        $comment= Comment::find($comment_id);

        if( ($user) && ( ($comment->user_id == $user->id) || ($comment->video->$user_id == $user->id) ) )
        {
            $comment->delete();
        }
        return redirect()-> route('detailVideo', ['video_id'=> $comment->video_id ])-> with(array(
            'message'=> 'Comentario eliminado correctamente !! '));
    }   
}
