@extends('master')

@push('scripts')
	<script src="{{ asset("app/controllers/clientesController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Lista de clientes
    
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i>Inicio</a></li>
    <li class="active">Clientes</li>
</ol>
@stop

@section('contenido')
<div class="box box-primary" ng-controller="clientesController" ng-init="cargaInicial()">
    <div class="box-header with-border">
    <div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">
  			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  		</span>
  		<input ng-model="search" type="text"  class="form-control" placeholder="Buscar clientes" aria-describedby="basic-addon1">
	</div>
    	<div class="table-responsive ng-cloak">
    	<table class="table table-hover">
    		<thead>
    			<th class="text-center">ID</th>
    			<th class="text-center">Nombre</th>
    			<th class="text-center">Correo</th>
          <th class="text-center">Teléfono</th>
    			<th class="text-center">
    				<button id="btn-add" class="btn btn-primary btn-xs" data-target="#dataRegister" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Nuevo Cliente</button>
    			</th>
    		</thead>
    		<tbody>
	    		<tr ng-repeat="c in filteredclientes | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
	    			<td class="text-center"><% c.id %></td>
	    			<td class="text-center"><% c.nombre %></td>
	    			<td class="text-center"><% c.email %></td>
            <td class="text-center">
              <span ng-if="c.telefono==null">(Sin Datos)</span>
              <% c.telefono %>
            </td>
	    			<td class="text-center">
	    				<button type="button" class="btn btn-xs btn-info" data-target="#dataUpdate"data-toggle="modal" data-id="<% c.id %>" data-nombre="<% c.nombre %>" data-email="<% c.email %>" data-telefono="<% c.telefono %>"><i class="glyphicon glyphicon-edit"></i></button>
              <button type="button" class="btn btn-xs btn-danger" ng-click="borrar(c.id)"><i class="glyphicon glyphicon-remove"></i></button>
	    			</td>
	    		</tr>
    		</tbody>
    	</table>
    	</div>
    	<div class="text-center">
    		<uib-pagination total-items="filteredclientes.length" items-per-page="pageSize" ng-model="currentPage" max-size="5" class="pagination-md"></uib-pagination>
    	</div>
    </div>

  <!-- Nuevo Cliente -->
	<div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Registrar Cliente</h4>
	      </div>
	      <form ng-submit="submitRegisterCliente()">
	      <div class="modal-body">
                <div class="box-body">
                <div class="form-group">
                  <label for="nombre">Nombre:</label>
                  <input type="text" class="form-control" ng-model="formRegister.nombre" name="nombre" id="nombre" placeholder="Nombre del cliente" required>
                </div>
                <div class="form-group">
                  <label for="nombre">Correo:</label>
                  <input type="email" class="form-control" ng-model="formRegister.correo" name="correo" id="correo" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                  <label for="telefono">Teléfono:</label>
                  <input type="text" class="form-control" ng-model="formRegister.telefono" placeholder="Teléfono" id="telefono" name="telefono" type="tel">
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
	<!-- Fin Nuevo Cliente -->
	<!-- Actualizar Cliente -->
	<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Editar Cliente</h4>
	      </div>
	      <form ng-submit="submitUpdateCliente()">
	      <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="nombre">Nombre:</label>
                  <input type="text" class="form-control" name="nombre1" id="nombre1" placeholder="Nombre del cliente" required>
                </div>
                <div class="form-group">
                  <label for="nombre">Correo:</label>
                  <input type="email" class="form-control" name="correo1" id="correo1" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                  <label for="telefono">Teléfono:</label>
                  <input type="text" class="form-control" placeholder="Teléfono" id="telefono1" name="telefono1" type="tel">
                </div>
              </div>
              <input type="hidden" name="id" id="id">
	      </div>
	      <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary">Actualizar</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
	<!-- Fin Actualizar Cliente -->
</div>
<script>
  $(document).ready(function() {
    $("#telefono").mask("(999) 9-99-99-99");
    $("#telefono1").mask("(999) 9-99-99-99");
        var token = $("#token").val();

        $('#dataUpdate').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Botón que activó el modal
            var id = button.data('id')  // Extraer la información de atributos de datos
            var nombre = button.data('nombre') // Extraer la información de atributos de datos
            var email = button.data('email') // Extraer la información de atributos de datos
            var telefono = button.data('telefono') // Extraer la información de atributos de datos
            var modal = $(this)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #nombre1').val(nombre)
            modal.find('.modal-body #correo1').val(email)
            modal.find('.modal-body #telefono1').val(telefono)
        })

    });
</script>
@stop