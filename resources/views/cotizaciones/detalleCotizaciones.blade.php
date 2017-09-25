@extends('master')

@push('scripts')
  <script src="{{ asset("app/controllers/cotizacionesController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Detalle de cotización
    <small>{{$cotizacion->folio}}.- {{$cotizacion->descripcion}}</small>
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
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;
             Agregar
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a data-toggle="modal" href="#agregarGrupos">Agregar grupo</a></li>
              <li><a data-toggle="modal" href="#agregarIndividuales">Agregar Materiales</a></li>
              <li><a data-toggle="modal" href="#agregarServicios">Agregar Servicio</a></li>
            </ul>
          </li>
          <li>
            <a href="{{url('ajusteCotizacion')}}/{{$cotizacion->id}}">             
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
              General PDF
            </a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;
             Detalle PDF
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a data-toggle="modal" href="{{url('detalladoPDF2')}}/{{$cotizacion->id}}">Con detalle</a></li>
              <li><a data-toggle="modal" href="{{url('detalladoPDF')}}/{{$cotizacion->id}}">Sin detalle</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opciones <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a data-toggle="modal" href="#agregarGrupos">Agregar grupo</a></li>
              <li><a href="{{url('ajusteCotizacion')}}/{{$cotizacion->id}}" target="_blank">General PDF</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{url('/cotizaciones')}}">Regresar</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-form navbar-right">
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
           <span class="label label-primary" style="font-size: 14px; font-weight: normal;"><% gc.grupo %></span>&nbsp;&nbsp;&nbsp;
           <span class="btn btn-default btn-xs pull-right" ng-click="eliminarGrupoCotizacion({{$cotizacion->id}}, gc.id)"><i class="glyphicon glyphicon-remove"></i>Eliminar grupo</span>
           <br><br><span class="label label-primary" style="font-size: 14px; font-weight: normal;">TOTAL UNITARIO : <% gc.total | currency %></span> 
          </a>
          &nbsp;&nbsp;&nbsp;Cantidad: <input ng-init="nuevaCantidad=gc.cant_gpo" type="number" size="3" value="<%gc.cant_gpo%>" ng-model="nuevaCantidad" id="nuevaCantidad<%gc.id%>">
          <button class="btn btn-default btn-xs" ng-click="actualizaCantidad({{$cotizacion->id}}, gc.id)">Guardar</button>
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
                  <td class="text-center">
                    <input value="<% gcm.cantidad %>" size="4"  ng-init="nuevaCantidadDetalle=gcm.cantidad" ng-model="nuevaCantidadDetalle" id="nuevaCantidadDetalle<%gcm.id%>" onkeypress="return justNumbers(event);" required>
                    <button ng-click="actualizaCantidadU(gcm.id, {{$cotizacion->id}})">OK</button>
                  </td>
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

<!--   Panel de servicios-->  
<div class="panel panel-default ng-cloak"" ng-if="serviciosCotizacion.length>0">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Servicios de la cotización {{$cotizacion->folio}}
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
          <tr>
            <th class="text-center">Código</th>
            <th>Descripción</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Precio</th>
            <th class="text-center">Unidad</th>
            <th class="text-center">Opciones</th>
          </tr>
          </thead>
          <tbody>
          <tr ng-repeat="s in serviciosCotizacion">
            <td class="text-center"><% s.codigo %></td>
            <td><% s.nombre %></td>
            <td class="text-center"><% s.cantidad %></td>
            <td class="text-center"><% s.c_precio %></td>
            <td class="text-center"><% s.unidad %></td>
            <td class="text-center">
              <a ng-click="eliminarServicioCotizacion({{$cotizacion->id}}, s.id)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!--   Panel de Materiales individuales-->  
<div class="panel panel-default ng-cloak"" ng-if="individuales.length>0">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          Materiales de la cotización {{$cotizacion->folio}}
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
           <tr>
              <th>Código</th>
              <th>Descripción</th>
              <th class="text-center">Unidad</th>
              <th class="text-center">Cantidad</th>
              <th class="text-center">Precio U</th>
              <th class="text-center">Total</th>
              <th class="text-center">Eliminar</th>
            </tr>
          </thead>
          <tbody>
          <tr ng-repeat="i in individuales">
            <td><% i.codigo %></td>
            <td><% i.descripcion %></td>
            <td class="text-center"><% i.unidad %></td>
            <td class="text-center"><% i.cantidad %></td>
            <td class="text-center"><% i.c_precio | currency %></td>
            <td class="text-center"><% i.c_precio*i.cantidad | currency %></td>
            <td class="text-center">
              <a ng-click="eliminarIndividualCotizacion({{$cotizacion->id}}, i.id)" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
          </tr>
          </tbody>
        </table>
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

<!-- añadir individuales -->
<div class="modal fade" id="agregarIndividuales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Añadir materiales individuales</h4>
        </div>
        <div class="modal-body">
            <div class="box-body">
              <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </span>
            <input ng-model="searchNoIndividuales" type="text"  class="form-control" placeholder="Buscar material" aria-describedby="basic-addon1">
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
                    <tr ng-repeat="ni in filteredNoIndividuales | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
                  <td class="text-center"><% ni.codigo %></td>
                  <td class="text-center"><% ni.descripcion %></td>
                  <td class="text-center"><% ni.unidad %></td>
                  <td class="text-center">
                    <span ng-if="ni.clasificacion==1">Baja</span>
                    <span ng-if="ni.clasificacion==2">Media</span>
                    <span ng-if="ni.clasificacion==3">Alta</span>
                  </td>
                  <td class="text-center">
                     <button type="button" class="btn btn-xs btn-success" ng-click="agregarIndividualCotizacion(ni.id, {{$cotizacion->id}}, ni.descripcion, ni.precio)">Agregar</button>
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
<!-- Fin Añadir individuales -->

<!-- añadir servicios -->
<div class="modal fade" id="agregarServicios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Añadir Servicios</h4>
        </div>
        <div class="modal-body">
            <div class="box-body">
              <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </span>
            <input ng-model="searchServicios" type="text"  class="form-control" placeholder="Buscar Servicios" aria-describedby="basic-addon1">
            </div>
            
            <div class="table-responsive ng-cloak">
              <table class="table table-hover">
                <thead>
                  <th class="text-center">Código</th>
                  <th class="text-center">Descripción</th>
                  <th class="text-center">Unidad</th>
                  <th class="text-center">Precio</th>
                  <th class="text-center">Opción</th>
                </thead>
                <tbody>
                  <tr ng-repeat="g in filteredservicios | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
                    <td class="text-center"><% g.codigo %></td>
                    <td class="text-center"><% g.nombre %></td>
                    <td class="text-center"><% g.unidad %></td>
                    <td class="text-center"><% g.precio %></td>
                    <td class="text-center">
                     <button type="button" class="btn btn-xs btn-success" ng-click="agregarServicioCotizacion(g.id, {{$cotizacion->id}}, g.nombre, g.precio)">Agregar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="text-center">
              <uib-pagination total-items="filteredservicios.length" items-per-page="pageSize" ng-model="currentPage" max-size="10" class="pagination-sm"></uib-pagination>
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
<!-- Fin Añadir servicios -->
</div>
<script>
  $(document).ready(function() {
    $('#agregarMateriales, #agregarGrupos, #agregarServicios, #agregarIndividuales').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });
  });
  function justNumbers(e)
       {
       var keynum = window.event ? window.event.keyCode : e.which;
       if ((keynum == 8) || (keynum == 46)) //46 es el punto y 8 el delete
       return true;
         
       return /\d/.test(String.fromCharCode(keynum));
       }
</script>
@stop