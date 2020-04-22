@extends('layouts.app')

@section('content')
	<div class="container">
	 	<div class="col-md-4">
	 	
		<h5>
			Mostrando resultados de: <strong> {{$search}}</strong>
		</h5>
		<br/>
	 	</div>

		<form>
		<div class="form-group col-md-3 float-right" action="{{url('/buscar/'.$search)}}" method="GET">
		    <label for="filter">Ordenar</label>
			    <select name="filter" class="form-control" >
				    <option value="new">Mas nuevos primero</option>
				    <option value="old">Mas antiguos primero</option>
				    <option value="alfa">de la A a la Z</option>
			    </select>
			    <input type="submit" value="ordenar" class="btn btn-sm btn-primary"/>
	  	</div>
	  	</form>
	 	<div class="clearfix"></div>
	    @include('video.videosList')
	</div>
@endsection