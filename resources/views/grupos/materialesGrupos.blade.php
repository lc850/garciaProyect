@extends('master')

@push('scripts')
	<script src="{{ asset("app/controllers/gruposController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    {{$grupo->descripcion}}&nbsp;&nbsp;
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
    						<button id="btn-add" class="btn btn-primary btn-xs" data-target="#agregarMateriales" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
    					</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr ng-repeat="mg in mats_gpo | filter:search2">
    					<td class="text-center"><% mg.codigo %></td>
	    				<td class="text-center"><% mg.descripcion %></td>
	    				<td class="text-center"><% mg.mat_cant %></td>
	    				<td class="text-center"><% mg.precio | currency %></td>
	    				<td class="text-center"><% mg.unidad %></td>
	    				<td class="text-center">
	    					<span ng-if="mg.clasificacion==1">Baja</span>
	    					<span ng-if="mg.clasificacion==2">Media</span>
	    					<span ng-if="mg.clasificacion==3">Alta</span>
    					</td>
    					<td class="text-center">
    						<button type="button" class="btn btn-xs btn-danger" ng-click="borrarMaterial(mg.id_mat_gpo, {{$grupo->id}})"><i class="glyphicon glyphicon-remove"></i>Quitar</button>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    </div>
<!-- añadir materiales -->
	<div class="modal fade" id="agregarMateriales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Añadir materiales</h4>
	      </div>
	      <div class="modal-body">
          	<div class="box-body">
          		<div class="input-group">
  					<span class="input-group-addon" id="basic-addon1">
  						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  					</span>
  					<input ng-model="searchMats" type="text"  class="form-control" placeholder="Buscar material" aria-describedby="basic-addon1">
				</div>
          		<div class="table-responsive ng-cloak">
          			<table class="table">
          				<thead>
          					<tr>
          						<th class="text-center">Código</th>
    							<th class="text-center">Descripción</th>
    							<th class="text-center">Unidad</th>
    							<th class="text-center">Clasificación</th>
    							<th class="text-center">Opción</th>
          					</tr>
          				</thead>
          				<tbody>
          					<tr ng-repeat="m in filteredmateriales | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
				    			<td class="text-center"><% m.codigo %></td>
				    			<td class="text-center"><% m.descripcion %></td>
				    			<td class="text-center"><% m.unidad %></td>
				    			<td class="text-center">
				    				<span ng-if="m.clasificacion==1">Baja</span>
				    				<span ng-if="m.clasificacion==2">Media</span>
				    				<span ng-if="m.clasificacion==3">Alta</span>
			    				</td>
				    			<td class="text-center">
			               <button type="button" class="btn btn-xs btn-success" ng-click="agregarMaterialGrupo(m.id,{{$grupo->id}}, m.descripcion, m.unidad)">Agregar</button>
				    			</td>
	    					</tr>
          				</tbody>
          			</table>
          		</div>
          		<div class="text-center">
    			<uib-pagination total-items="filteredmateriales.length" items-per-page="pageSize" ng-model="currentPage" max-size="10" class="pagination-sm"></uib-pagination>
    	</div>
		  	</div>
	      </div>
	      <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
<!-- Fin Añadir materiales -->
</div>
<script>
  $(document).ready(function() {
    $('#agregarMateriales').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });
  });
</script>
@stop