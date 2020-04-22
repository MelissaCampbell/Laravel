<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $table= 'videos'; //hace referencia a la tabla videos 
    
    //relación de uno a muchos, array de objetos con todos los comentarios
    //dentro de un video puede haber muchos comentarios
    public function comments()
    {
    	return $this->hasMany('App\Comment')->orderBy('id','desc'); //la entidad a la cual tiene q hacer la relación

    }

    //relación muchos a uno
    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    //para hacer una relacon uno a uno se usa hasOne
}
