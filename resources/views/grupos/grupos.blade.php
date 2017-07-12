@extends('master')

@push('scripts')
	<script src="{{ asset("app/controllers/gruposController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Administración de Grupos
    
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i>Inicio</a></li>
    <li class="active">Grupos</li>
</ol>
@stop

@section('contenido')
<div class="box box-default" ng-controller="gruposController" ng-init="cargaInicial()">
    <div class="box-header with-border">
    <div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">
  			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  		</span>
  		<input ng-model="search" type="text"  class="form-control" placeholder="Buscar grupos" aria-describedby="basic-addon1">
	</div>
    	<div class="table-responsive ng-cloak">
    	<table class="table table-hover">
    		<thead>
    			<th class="text-center">ID</th>
    			<th class="text-center">Descripción</th>
          <th class="text-center">Unidad</th>
    			<th class="text-center">Tipo</th>
    			<th class="text-center">
    				<button id="btn-add" class="btn btn-primary btn-xs" data-target="#dataRegister" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Nuevo Grupo</button>
    			</th>
    		</thead>
    		<tbody>
	    		<tr ng-repeat="g in filteredgrupos | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
	    			<td class="text-center"><% g.id %></td>
	    			<td class="text-center"><% g.descripcion %></td>
            <td class="text-center"><% g.unidad %></td>
	    			<td class="text-center"><% g.tipo_desc %></td>
	    			<td class="text-center">
              <a class="btn btn-xs btn-success" href="{{url('materialesGrupo')}}/<%g.id%>"><i class="glyphicon glyphicon-wrench"></i></a>
	    				<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<% g.id %>" data-descripcion="<% g.descripcion %>" data-tipo="<% g.tipo_desc %>" data-idtipo="<% g.id_tipo %>" data-unidadg="<% g.unidad %>"><i class="glyphicon glyphicon-edit"></i></button>
              <button type="button" class="btn btn-xs btn-danger" ng-click="borrar(g.id)"><i class="glyphicon glyphicon-remove"></i></button>
	    			</td>
	    		</tr>
    		</tbody>
    	</table>
    	</div>
    	<div class="text-center">
    		<uib-pagination total-items="filteredgrupos.length" items-per-page="pageSize" ng-model="currentPage" max-size="5" class="pagination-md"></uib-pagination>
    	</div>
    </div>
    <!-- Nuevo grupo -->
	<div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Nuevo Grupo</h4>
	      </div>
	      <form ng-submit="submitRegisterGrupo()">
	      <div class="modal-body">
                <div class="box-body">
                <div class="form-group">
                  <label for="descripcion">Descripción:</label>
                  <input type="text" class="form-control" ng-model="formRegister.descripcion" name="descripcion" id="descripcion" placeholder="Descripción del grupo" ng-blur="validaDescripcion()" required>
                  <p id="error" style="color: red;"> &nbsp;&nbsp;</p>       
                </div>
                <div class="form-group">
                <label for="tipo">Tipo:</label>
                    <select name="tipo" id="tipo" class="form-control" ng-model="formRegister.tipo" required>
                      <option selected value="">Seleccione una tipo</option>
                      <option ng-repeat="t in tipos" value="<% t.id %>"><% t.descripcion %></option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="unidad">Unidad:</label><br>
                    <select  name="unidad" id="unidad" class="form-control" ng-model="formRegister.unidad" required>
                      <option selected value="">Seleccione una unidad</option>
                      <option value="PZA">PZA</option>
                      <option value="MTS">MTS</option>
                      <option value="ML">ML</option>
                      <option value="TMO">TMO</option>
                      <option value="LOTE">LOTE</option>
                    </select>
                </div>
              </div>
	      </div>
	      <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="submit" class="btn btn-primary" id="submit" disabled="true">Guardar</button>
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
	        <h4 class="modal-title" id="myModalLabel">Editar Grupo</h4>
	      </div>
	      <form ng-submit="submitUpdateGrupo()">
	      <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="desc">Descripción:</label>
                  <input type="text" class="form-control" name="descripcion1" id="descripcion1" placeholder="Descripción" required>
                </div>
                <div class="form-group">
                <label for="clasf">Clasificación:</label><br>
                    <select  name="tipo1" id="tipo1" class="form-control" required>
                      <option selected id="opcion1"></option>
                      <option ng-repeat="t in tipos" value="<% t.id %>"><% t.descripcion %></option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="unidad">Unidad:</label><br>
                    <select  name="unidad1" id="unidad1" class="form-control" required>
                      <option selected id="optunidad"></option>
                      <option value="PZA">PZA</option>
                      <option value="MTS">MTS</option>
                      <option value="ML">ML</option>
                      <option value="TMO">TMO</option>
                      <option value="LOTE">LOTE</option>
                    </select>
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
	<!-- Fin Actualizar Material -->
</div>
<script>
  $(document).ready(function() {
        var token = $("#token").val();

        $('#dataUpdate').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Botón que activó el modal
            var id = button.data('id')  // Extraer la información de atributos de datos
            var descripcion = button.data('descripcion') // Extraer la información de atributos de datos
            var tipo = button.data('tipo') // Extraer la información de atributos de datos
            var id_tipo = button.data('idtipo') // Extraer la información de atributos de datos
            var unidadg = button.data('unidadg') // Extraer la información de atributos de datos
            
            var modal = $(this)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #descripcion1').val(descripcion)
            modal.find('.modal-body #opcion1').val(id_tipo)
            modal.find('.modal-body #opcion1').html(tipo)
            modal.find('.modal-body #optunidad').val(unidadg)
            modal.find('.modal-body #optunidad').html(unidadg)
        })

    });
</script>
@stop