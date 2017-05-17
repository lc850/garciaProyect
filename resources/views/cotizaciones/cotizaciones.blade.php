@extends('master')

@push('scripts')
	<script src="{{ asset("app/controllers/cotizacionesController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Cotizaciones
    
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i>Inicio</a></li>
    <li class="active">Cotizaciones</li>
</ol>
@stop

@section('contenido')
<div class="box box-primary" ng-controller="cotizacionesController" ng-init="cargaInicial()">
    <div class="box-header with-border">
    <div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">
  			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  		</span>
  		<input ng-model="search" type="text"  class="form-control" placeholder="Buscar cotizaciones" aria-describedby="basic-addon1">
	  </div>
    	<div class="table-responsive ng-cloak">
    	<table class="table table-hover">
    		<thead>
    			<th class="text-center">Folio</th>
    			<th class="text-center">Descripción</th>
    			<th class="text-center">Cliente</th>
          <th class="text-center">Fecha de elaboración</th>
          <th class="text-center">Fecha de impresión</th>
    			<th class="text-center">
    				<button id="btn-add" class="btn btn-primary btn-xs" data-target="#dataRegister" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Nueva Cotización</button>
    			</th>
    		</thead>
    		<tbody>
	    		<tr ng-repeat="c in filteredcotizaciones | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
	    			<td class="text-center"><% c.folio %></td>
	    			<td class="text-center"><% c.descripcion %></td>
            <td class="text-center"><% c.nombre %></td>
	    			<td class="text-center"><% c.fecha %></td>
            <td class="text-center"><% c.fecha_impresion %></td>
	    			<td class="text-center">
              <a class="btn btn-xs btn-success" href="{{url('/detalleCotizacion')}}/<%c.id%>"><i class="glyphicon glyphicon-wrench"></i></a>
	    				<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<% c.id %>" data-descripcion="<% c.descripcion %>" data-cliente="<% c.nombre %>" data-fecha="<% c.fecha %>" data-fechaimpresion="<% c.fecha_impresion %>" data-idcliente="<% c.id_cliente %>"><i class="glyphicon glyphicon-edit"></i></button>
              <button type="button" class="btn btn-xs btn-danger" ng-click="borrar(c.id)"><i class="glyphicon glyphicon-remove"></i></button>
              <a class="btn btn-xs btn-default" href="{{url('cotizacionPDF')}}/<%c.id%>" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
	    			</td>
	    		</tr>
    		</tbody>
    	</table>
    	</div>
    	<div class="text-center">
    		<uib-pagination total-items="filteredcotizaciones.length" items-per-page="pageSize" ng-model="currentPage" max-size="5" class="pagination-md"></uib-pagination>
    	</div>
    </div>
    <!-- Nuevo grupo -->
	<div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Nueva Cotización</h4>
	      </div>
	      <form ng-submit="submitRegisterCotizacion()">
	      <div class="modal-body">
                <div class="box-body">
                <div class="form-group">
                  <label for="descripcion">Descripción:</label>
                  <textarea type="text" class="form-control" ng-model="formRegister.descripcion" name="descripcion" id="descripcion" placeholder="Descripción de la cotización" required></textarea>
                </div>
                <div class="form-group">
                <label for="tipo">Cliente:</label>
                    <select name="cliente" id="cliente" class="form-control" ng-model="formRegister.cliente" required>
                      <option selected value="">Seleccione un cliente</option>
                      <option ng-repeat="cte in clientes" value="<% cte.id %>"><% cte.nombre %></option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="fecha">Fecha de elaboración:</label>
                  <div class="left-inner-addon">
                    <i class="fa fa-calendar"></i>
                    <input class="form-control" name="fecha" type="text" id="datepicker" ng-model="formRegister.fecha" required placeholder="Fecha de elaboración">
                  </div> 
                </div>
                <div class="form-group">
                  <label for="fecha_impresion">Fecha de Impresión:</label>
                  <div class="left-inner-addon">
                    <i class="fa fa-calendar"></i>
                    <input class="form-control" name="fecha_impresion" type="text" id="datepicker2" ng-model="formRegister.fecha_impresion" required placeholder="Fecha de impresión">
                  </div> 
                </div>
              </div>
	      </div>
	      <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Guardar</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
	<!-- Fin Nuevo Material -->

	<!-- Actualizar Material -->
	<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Editar Datos de Cotización</h4>
	      </div>
	      <form ng-submit="submitUpdateCotizacion()">
        <div class="modal-body">
                <div class="box-body">
                <div class="form-group">
                  <label for="descripcion">Descripción:</label>
                  <textarea type="text" class="form-control" name="descripcion1" id="descripcion1" placeholder="Descripción de la cotización" required></textarea>
                </div>
                <div class="form-group">
                <label for="tipo">Cliente:</label>
                    <select name="cliente1" id="cliente1" class="form-control" required>
                      <option selected id="opcion1">Seleccione un cliente</option>
                      <option ng-repeat="cte in clientes" value="<% cte.id %>"><% cte.nombre %></option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="fecha">Fecha de elaboración:</label>
                  <div class="left-inner-addon">
                    <i class="fa fa-calendar"></i>
                    <input class="form-control" name="fecha1" type="text" id="datepicker3" required placeholder="Fecha de elaboración">
                  </div> 
                </div>
                <div class="form-group">
                  <label for="fecha">Fecha de Impresión:</label>
                  <div class="left-inner-addon">
                    <i class="fa fa-calendar"></i>
                    <input class="form-control" name="fecha_impresion1" type="text" id="datepicker4" required placeholder="Fecha de impresión">
                  </div> 
                </div>
              </div>
              <input type="hidden" name="id" id="id">
        </div>
        <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        </form>
	    </div>
	  </div>
	</div>
	<!-- Fin Actualizar Material -->
</div>
<script>
  $(document).ready(function() {
        var token = $("#token").val();
        $('#dataUpdate').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Botón que activó el modal
            var id = button.data('id')  // Extraer la información de atributos de datos
            var descripcion = button.data('descripcion') // Extraer la información de atributos de datos
            var cliente = button.data('cliente');
            var id_cliente = button.data('idcliente');
            var fecha = button.data('fecha') // Extraer la información de atributos de datos
            var fecha_impresion = button.data('fechaimpresion') // Extraer la información de atributos de datos

            var modal = $(this)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #descripcion1').val(descripcion)
            modal.find('.modal-body #opcion1').val(id_cliente)
            modal.find('.modal-body #opcion1').html(cliente)
            $('#datepicker3').datepicker("setDate", fecha );
            $('#datepicker4').datepicker("setDate", fecha_impresion );
        })
      //Date picker
        var f = new Date();
          $( "#datepicker, #datepicker2, #datepicker3, #datepicker4").datepicker({
            dateFormat: "yy-mm-dd",
            monthNames: ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'],
            monthNamesShort: ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'],
            dayNames: ['domingo','lunes','martes','miercoles','jueves','viernes','sabado'],
            dayNamesShort: ['do','lu', 'ma','mi','ju','vi','sa'],
            dayNamesMin: ['do','lu', 'ma','mi','ju','vi','sa'],
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: '1950:'+ new Date(f.getFullYear(),f.getMonth(),f.getDate()),
          }).attr('readonly', 'true');
        });
</script>
@stop