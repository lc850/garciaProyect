@extends('master')

@push('scripts')
	<script src="{{ asset("app/controllers/serviciosController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Administración de Servicios
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i>Inicio</a></li>
    <li class="active">Servicios</li>
</ol>
@stop

@section('contenido')
<div class="box box-default" ng-controller="serviciosController" ng-init="cargaInicial()">
    <div class="box-header with-border">
    <div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">
  			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  		</span>
  		<input ng-model="search" type="text"  class="form-control" placeholder="Buscar servicios" aria-describedby="basic-addon1">
	</div>
    	<div class="table-responsive ng-cloak">
    	<table class="table table-hover">
    		<thead>
    			<th class="text-center">Código</th>
    			<th class="text-center">Descripción</th>
          <th class="text-center">Unidad</th>
    			<th class="text-center">Precio</th>
    			<th class="text-center">
    				<button id="btn-add" class="btn btn-primary btn-xs" data-target="#dataRegister" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Nuevo Servicio</button>
    			</th>
    		</thead>
    		<tbody>
	    		<tr ng-repeat="g in filteredservicios | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
	    			<td class="text-center"><% g.codigo %></td>
	    			<td class="text-center"><% g.nombre %></td>
            <td class="text-center"><% g.unidad %></td>
	    			<td class="text-center"><% g.precio %></td>
	    			<td class="text-center">
	    				<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<%g.id%>" data-codigo="<% g.codigo %>" data-nombre="<% g.nombre %>" data-unidad="<% g.unidad %>" data-precio="<% g.precio %>"><i class="glyphicon glyphicon-edit"></i></button>
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
    <!-- Nuevo Servicio -->
	<div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Nuevo Servicio</h4>
	      </div>
	      <form ng-submit="submitRegisterServicio()">
	      <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="codigo">Código:</label>
                  <input type="text" class="form-control" ng-model="formServicios.codigoServicio" name="codigoServicio" id="codigoServicio"  placeholder="Código del servicio" required>
                  <input type="hidden" name="ultimoCodigo" id="ultimoCodigo">
                  <p id="lastcode"> </p>
                  <p id="errorCodigo"> </p>
                </div>
                <div class="form-group">
                  <label for="descripcion">Descripción:</label>
                  <input type="text" class="form-control" ng-model="formServicios.nombre" name="nombre" id="nombre" placeholder="Descripción del servicio" ng-blur="validaDescripcion()" required>
                  <p id="error" style="color: red;">&nbsp;&nbsp;</p>       
                </div>
                <div class="form-group">
                  <label for="unidad">Unidad:</label><br>
                    <select  name="unidad" id="unidad" class="form-control" ng-model="formServicios.unidad" required>
                      <option selected value="">Seleccione una unidad</option>
                      <option value="PZA">PZA</option>
                      <option value="MTS">MTS</option>
                      <option value="ML">ML</option>
                      <option value="TMO">TMO</option>
                      <option value="LOTE">LOTE</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="precio">Precio:</label>
                  <input type="text" class="form-control" name="precio", id="precio" onkeypress="return check_digit(event,this,20,2);" ng-model="formServicios.precio" placeholder="Precio" required>
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
	      <form ng-submit="submitUpdateServicio()">
	      <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="desc">Código:</label>
                  <input type="text" class="form-control" id="codigoServicio1" placeholder="Código del material" disabled required>
                  <input type="hidden" name="codigoServicio1" id="codigoServicio1">
                </div>  
                <div class="form-group">
                  <label for="descripcion">Descripción:</label>
                  <input type="text" class="form-control" name="nombre1" id="nombre1" placeholder="Descripción del servicio" required>     
                </div>
                <div class="form-group">
                  <label for="unidad">Unidad:</label><br>
                    <select  name="unidad1" id="unidad1" class="form-control" required>
                      <option value="PZA">PZA</option>
                      <option value="MTS">MTS</option>
                      <option value="ML">ML</option>
                      <option value="TMO">TMO</option>
                      <option value="LOTE">LOTE</option>
                      <option value="KG">KG</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="precio">Precio:</label>
                  <input type="text" class="form-control" name="precio1" id="precio1" placeholder="Precio" onkeypress="return check_digit(event,this,20,2);" required>
                </div>
              </div>
              <input type="hidden" name="id" id="ids">
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
        $("#codigoServicio").click(function() {
          var codigo=3;
          var url5 = '{{url('/lastcodeServicio')}}';
            $.ajax({
              url: url5,
              headers: {'X-CSRF-TOKEN': token},
              type: "POST",
              //dataType: 'json',
              data: {codigo:codigo, _token:token},
              success: function(datos){
                document.getElementById('lastcode').innerHTML ="Último código insertado: " + datos;
                var codigoFinal=parseInt(datos)+1;
                $("#ultimoCodigo").val(codigoFinal);
                $("#codigoServicio").val(codigoFinal);
                //asignarle valor al ng-model desde jquery
                jQuery('#codigoServicio').trigger('input');
              },
              error: function(datos){
                swal({ title: "Error!",   text: "Ocurrio un error inténtelo de nuevo",   type: "error",   confirmButtonText: "Regresar" });
              },

            });
    
          });
      });
</script>
<script>
  $(document).ready(function() {
        var token = $("#token").val();

        $('#dataUpdate').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Botón que activó el modal
            var id = button.data('id')  // Extraer la información de atributos de datos
            var codigoServicio = button.data('codigo')  // Extraer la información de atributos de datos
            var nombre = button.data('nombre') // Extraer la información de atributos de datos
            var unidad = button.data('unidad') // Extraer la información de atributos de datos
            var precio = button.data('precio') // Extraer la información de atributos de datos
            var modal = $(this)
            modal.find('.modal-body #ids').val(id)
            modal.find('.modal-body #codigoServicio1').val(codigoServicio)
            modal.find('.modal-body #nombre1').val(nombre)
            modal.find('.modal-body #unidad1').val(unidad)
            //modal.find('.modal-body #opcion1').html(unidad)
            modal.find('.modal-body #precio1').val(precio)
        })

    });

function check_digit(e,obj,intsize,deczize) {
    var keycode;

    if (window.event) keycode = window.event.keyCode;
    else if (e) { keycode = e.which; }
    else { return true; }

    var fieldval= (obj.value),
        dots = fieldval.split(".").length;
        
    if ( keycode == 241 || keycode == 209 || keycode == 191 || keycode == 161 || keycode == 176 || keycode == 172
      || keycode == 168 || keycode == 180){
      return false; 
      } 

    if(keycode == 46) {
        return dots <= 1;
    }
    if(keycode == 8 || keycode == 9 || keycode == 46 || keycode == 13 ) {
        // back space, tab, delete, enter 
        return true;
    }          
    if((keycode>=32 && keycode <=45) || keycode==47 || (keycode>=58 && keycode<=127)) {
         return false;
    }
    if(fieldval == "0" && keycode == 48 ) {
        return false;
    }
    if(fieldval.indexOf(".") != -1) { 
        if(keycode == 46) {
            return false;
        }
        var splitfield = fieldval.split(".");
        if(splitfield[1].length >= deczize && keycode != 8 && keycode != 0 )
            return false;
        }else if(fieldval.length >= intsize && keycode != 46) {
            return false;
        }else {
            return true;
        }
    }
</script>
@stop