@extends('master')

@push('scripts')
  <script src="{{ asset("app/controllers/cotizacionesController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Detalle de cotización
    <small>{{$cotizacion->folio}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="{{url('/cotizaciones')}}">Cotizaciones</a></li>
    <li class="active">Detalle cotización</li>
</ol>
@stop

@section('contenido')
<style>
  .margen{
    margin-left: 10px;
    margin-right: 10px;
  }
</style>
<div class="box box-default" ng-controller="cotizacionesController" ng-init="gruposCotizacion({{$cotizacion->id}})">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Cotización {{$cotizacion->folio}}</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <!-- <li><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
          <li>
            <a data-toggle="modal" href="#agregarGrupos">
              <i class="fa fa-object-group" aria-hidden="true"></i>&nbsp;&nbsp;Agregar grupo
            </a>
          </li>
          <li>
            <a href="{{url('ajusteCotizacion')}}/{{$cotizacion->id}}">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;Detalle PDF
            </a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opciones <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a data-toggle="modal" href="#agregarGrupos">Agregar grupo</a></li>
              <li><a href="{{url('cotizacionPDF')}}/{{$cotizacion->id}}" target="_blank">Generar PDF</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{url('/cotizaciones')}}">Regresar</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-form navbar-left">
          <div class="form-group">
            <div class="left-inner-addon">
              <i class="fa fa-search" style="z-index:0;"></i>
              <input ng-model="search" type="text"  class="form-control" placeholder="Buscar grupo">
            </div> 
          </div>
        </form>
            <a class="btn btn-default navbar-btn margen" href="{{url('/cotizaciones')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Regresar</a>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="box-header">
  <div class="alert alert-danger ng-cloak" ng-if="gruposCotizacion.length==0">No contiene grupos</div>
    <div class="panel panel-default ng-cloak" ng-repeat="gc in gruposCotizacion | filter:search">
      <div class="panel-heading" role="tab" id="heading<%gc.id%>">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<%gc.id%>" aria-expanded="true" aria-controls="collapse<%gc.id%>">
             <% gc.grupo %> --- <b>Cantidad:</b> <% gc.cant_gpo %>--- <b>Total:</b> <% gc.total | currency %>
          </a>
          <span class="btn btn-default btn-xs pull-right" ng-click="eliminarGrupoCotizacion({{$cotizacion->id}}, gc.id)"><i class="glyphicon glyphicon-remove"></i>Eliminar grupo</span>
        </h4>
      </div>
      <div id="collapse<%gc.id%>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<%gc.id%>">
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Descripción</th>
                  <th class="text-center">Unidad</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Precio U</th>
                  <th class="text-center">Total</th>
                  <th class="text-center">
                    <button id="btn-add" class="btn btn-info btn-xs" data-target="#agregarMateriales" data-toggle="modal" ng-click="cargaDatos({{$cotizacion->id}}, gc.id, gc.cant_gpo)"><span class="glyphicon glyphicon-plus"></span>Agregar material</button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="gcm in gc.materiales | filter:search">
                  <td><% gcm.mat_nom %></td>
                  <td class="text-center"><% gcm.unidad %></td>
                  <td class="text-center"><% gcm.cantidad %></td>
                  <td class="text-center"><% gcm.precio | currency %></td>
                  <td class="text-center"><% gcm.precio*gcm.cantidad | currency %></td>
                  <td class="text-center"><button type="button" class="btn btn-xs btn-danger" ng-click="borrarMaterial(gcm.id, {{$cotizacion->id}})"><i class="glyphicon glyphicon-remove"></i></button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- añadir grupos -->
	<div class="modal fade" id="agregarGrupos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Añadir Grupos</h4>
	      </div>
	      <div class="modal-body">
          	<div class="box-body">
          		<div class="input-group">
  					<span class="input-group-addon" id="basic-addon1">
  						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  					</span>
  					<input ng-model="search3" type="text"  class="form-control" placeholder="Buscar grupos" aria-describedby="basic-addon1">
				</div>
          	<div class="table-responsive ng-cloak">
          		<table class="table table-hover">
    		        <thead>
    			          <th class="text-center">ID</th>
    		          	<th class="text-center">Descripción</th>
    			          <th class="text-center">Opción</th>
    		        </thead>
                <tbody>
                  <tr ng-repeat="g in filteredgpoNoCot | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
                    <td class="text-center"><% g.id %></td>
                    <td class="text-center"><% g.descripcion %></td>
                    <td class="text-center">
			               <button id="btn-add" class="btn btn-success btn-xs" ng-click="agregarGrupoCotizacion({{$cotizacion->id}}, g.id, g.descripcion)"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
				    			  </td>
                  </tr>
                </tbody>
    	         </table>
          		</div>
          		<div class="text-center">
    			<uib-pagination total-items="filteredgpoNoCot.length" items-per-page="pageSize" ng-model="currentPage" max-size="8" class="pagination-sm"></uib-pagination>
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
<!-- Fin Añadir Grupos -->
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
                     <button type="button" class="btn btn-xs btn-success" ng-click="agregarMaterialGrupoCotizacion(m)">Agregar</button>
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
    $('#agregarMateriales, #agregarGrupos').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });
  });
</script>
@stop