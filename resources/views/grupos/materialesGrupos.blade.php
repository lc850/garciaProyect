@extends('master')

@push('scripts')
	<script src="{{ asset("app/controllers/gruposController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Detalle de {{$grupo->descripcion}}
    <a class="btn btn-success btn-sm" href="{{url('/grupos')}}"><i class="fa fa-undo"></i> Regresar</a>
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="{{url('/grupos')}}">Grupos</a></li>
    <li class="active">Detalle materiales</li>
</ol>
@stop

@section('contenido')
<div class="box box-primary" ng-controller="gruposController" ng-init="materialesGrupo({{$grupo->id}})">
    <div class="box-header with-border">
    	<div class="input-group">
  			<span class="input-group-addon" id="basic-addon1">
  				<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  			</span>
  			<input ng-model="search2" type="text"  class="form-control" placeholder="Buscar material" aria-describedby="basic-addon1">
		</div>
    	<div class="table-responsive ng-cloak">
    		<table class="table table-hover">
    			<thead>
    				<tr>
    					<th class="text-center">Código</th>
    					<th class="text-center">Descripción</th>
    					<th class="text-center">Cantidad</th>
    					<th class="text-center">Precio</th>
    					<th class="text-center">Unidad</th>
    					<th class="text-center">Clasificación</th>
    					<th class="text-center">
    						<button type="button" class="btn btn-xs btn-primary" ng-click=""><i class="glyphicon glyphicon-plus"></i>Agregar</button>
    					</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr ng-repeat="mg in mats_gpo | filter:search2">
    					<td class="text-center"><% mg.codigo %></td>
	    				<td class="text-center"><% mg.descripcion %></td>
	    				<td class="text-center"><% mg.cantidad %></td>
	    				<td class="text-center"><% mg.precio | currency %></td>
	    				<td class="text-center"><% mg.unidad %></td>
	    				<td class="text-center">
	    					<span ng-if="mg.clasificacion==1">Baja</span>
	    					<span ng-if="mg.clasificacion==2">Media</span>
	    					<span ng-if="mg.clasificacion==3">Alta</span>
    					</td>
    					<td class="text-center">
    						<button type="button" class="btn btn-xs btn-danger" ng-click=""><i class="glyphicon glyphicon-remove"></i>Quitar</button>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    </div>
</div>
@stop