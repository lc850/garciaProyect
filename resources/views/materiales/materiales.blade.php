@extends('master')

@push('scripts')
	<script src="{{ asset("app/controllers/materialesController.js") }}"></script>
@endpush

@section('titulo')
<h1>
    Administración de Materiales
    
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i>Inicio</a></li>
    <li class="active">Materiales</li>
</ol>
@stop

@section('contenido')
<div class="box box-primary" ng-controller="materialesController" ng-init="cargaInicial()">
    <div class="box-header with-border">
    <div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">
  			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  		</span>
  		<input ng-model="search" type="text"  class="form-control" placeholder="Buscar material" aria-describedby="basic-addon1">
	</div>
    	<div class="table-responsive ng-cloak">
    	<table class="table table-hover">
    		<thead>
    			<th class="text-center">Código</th>
    			<th class="text-center">Descripción</th>
    			<th class="text-center">Cantidad</th>
    			<th class="text-center">Precio</th>
    			<th class="text-center">Unidad</th>
    			<th class="text-center">Clasificación</th>
    			<th class="text-center">
    				<button id="btn-add" class="btn btn-primary btn-xs" data-target="#dataRegister" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Nuevo material</button>
    			</th>
    		</thead>
    		<tbody>
	    		<tr ng-repeat="m in filteredmateriales | startFrom:(currentPage-1)*pageSize | limitTo:pageSize">
	    			<td class="text-center"><% m.codigo %></td>
	    			<td class="text-center"><% m.descripcion %></td>
	    			<td class="text-center"><% m.cantidad %></td>
	    			<td class="text-center"><% m.precio | currency %></td>
	    			<td class="text-center"><% m.unidad %></td>
	    			<td class="text-center">
	    				<span ng-if="m.clasificacion==1">Baja</span>
	    				<span ng-if="m.clasificacion==2">Media</span>
	    				<span ng-if="m.clasificacion==3">Alta</span>
    				</td>
	    			<td class="text-center">
	    				<button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#dataUpdate" data-id="<% m.id %>" data-codigo="<% m.codigo %>" data-descripcion="<% m.descripcion %>" data-precio="<% m.precio %>" data-cantidad="<% m.cantidad %>" data-unidad="<% m.unidad %>" data-clasificacion="<% m.clasificacion %>"><i class="glyphicon glyphicon-edit"></i></button>
                        <button type="button" class="btn btn-xs btn-danger" ng-click="borrar(m.id)"><i class="glyphicon glyphicon-remove"></i></button>
	    			</td>
	    		</tr>
    		</tbody>
    	</table>
    	</div>
    	<div class="text-center">
    		<uib-pagination total-items="filteredmateriales.length" items-per-page="pageSize" ng-model="currentPage" max-size="5" class="pagination-md"></uib-pagination>
    	</div>
    </div>
    <!-- Nuevo Material -->
	<div class="modal fade" id="dataRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Nuevo Material</h4>
	      </div>
	      <form ng-submit="submitRegister()">
	      <div class="modal-body">
                <div class="box-body">
                <div class="form-group">
                  <label for="descripcion">Descripción:</label>
                  <input type="text" class="form-control" ng-model="formRegister.descripcion" name="descripcion" id="descripcion" placeholder="Descripción del material" required>
                </div>
                <div class="form-group">
                <label for="clasificacion">Clasificación:</label>
                    <select name="clasificacion" id="clasificacion" class="form-control" ng-model="formRegister.clasificacion" required>
                      <option selected value="">Seleccione una tensión</option>
                      <option value="3">Alta</option>
                      <option value="2">Media</option>
                      <option value="1">Baja</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="codigo">Código:</label>
                  <input type="text" class="form-control" name="codigoMaterial" id="codigoMaterial" ng-model="formRegister.codigoMaterial" placeholder="Código del material" required>
                  <input type="hidden" name="ultimoCodigo" id="ultimoCodigo">
                  <p id="lastcode"> </p>
                  <p id="errorCodigo"> </p>
                </div>
                <div class="form-group">
                  <label for="cantidad">Cantidad:</label>
                  <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" ng-model="formRegister.cantidad" onkeypress="return justQuantity(event);" required>
                </div>
                <div class="form-group">
                  <label for="precio">Precio:</label>
                  <input type="text" class="form-control" name="precio", id="precio" onkeypress="return check_digit(event,this,20,2);" ng-model="formRegister.precio" placeholder="Precio" required>
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
	        <h4 class="modal-title" id="myModalLabel">Editar Material</h4>
	      </div>
	      <form ng-submit="submitUpdate()">
	      <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="desc">Descripción:</label>
                  <input type="text" class="form-control" name="descripcion1" id="descripcion1" placeholder="Descripción" required>
                </div>       
                <div class="form-group">
                <label for="clasf">Clasificación:</label><br>
                    <select  name="clasificacion1" id="clasificacion1" class="form-control" required>
                      <option selected id="opcion1"></option>
                      <option value="3">Alta</option>
                      <option value="2">Media</option>
                      <option value="1">Baja</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="desc">Código:</label>
                  <input type="text" class="form-control" id="codigo1" placeholder="Código del material" disabled required>
                  <input type="hidden" name="codigo1" id="codigo1">
                </div>  
                <div class="form-group">
                  <label for="cantidad">Cantidad:</label>
                  <input type="text" class="form-control" name="cantidad1" id="cantidad1" placeholder="Cantidad" onkeypress="return justQuantity(event);" required>
                </div>
                <div class="form-group">
                  <label for="precio">Precio:</label>
                  <input type="text" class="form-control" name="precio1" id="precio1" placeholder="Precio" onkeypress="return justNumbers(event);" required>
                </div>
                <div class="form-group">
                <label for="unidad">Unidad:</label><br>
                    <select  name="unidad1" id="unidad1" class="form-control" required>
                      <option selected id="opcion2"></option>
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
        $("#clasificacion").change(function() {
          var codigo=document.getElementById("clasificacion").value;
          var url5 = '{{url('/lastcode')}}';
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
                $("#codigoMaterial").val(codigoFinal);
                //asignarle valor al ng-model desde jquery
                jQuery('#codigoMaterial').trigger('input');
              },
              error: function(datos){
                swal({ title: "Error!",   text: "Ocurrio un error inténtelo de nuevo",   type: "error",   confirmButtonText: "Regresar" });
              },

            });
    
          });

        $('#dataUpdate').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Botón que activó el modal
            var id = button.data('id')  // Extraer la información de atributos de datos
            var codigo = button.data('codigo')
            var descripcion = button.data('descripcion') // Extraer la información de atributos de datos
            var unidad = button.data('unidad')
            var clasificacion = button.data('clasificacion') // Extraer la información de atributos de datos
            var cantidad = button.data('cantidad') // Extraer la información de atributos de datos
            var precio = button.data('precio') // Extraer la información de atributos de datos
            
            var modal = $(this)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #codigo1').val(codigo)
            modal.find('.modal-body #descripcion1').val(descripcion)
            modal.find('.modal-body #cantidad1').val(cantidad)
            modal.find('.modal-body #precio1').val(precio)
            modal.find('.modal-body #unidad1').val(unidad)
            modal.find('.modal-body #opcion2').html(unidad)
            if(clasificacion==3){
              modal.find('.modal-body #opcion1').val(clasificacion)
              modal.find('.modal-body #opcion1').html("Alta")
            }
            else if(clasificacion==2){
              modal.find('.modal-body #opcion1').val(clasificacion)
              modal.find('.modal-body #opcion1').html("Media")
            }
            else if(clasificacion==1){
              modal.find('.modal-body #opcion1').val(clasificacion)
              modal.find('.modal-body #opcion1').html("Baja")
            }
            else
              modal.find('.modal-body #opcion1').html("Sin Tension")
        })

    });
    function justQuantity(e)
       {
       var keynum = window.event ? window.event.keyCode : e.which;
       if (keynum == 8 || keynum == 46) 
       return true;
         
       return /\d/.test(String.fromCharCode(keynum));
    }

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
    function justNumbers(e)
       {
       var keynum = window.event ? window.event.keyCode : e.which;
       if ((keynum == 8) || (keynum == 46)) //46 es el punto y 8 el delete
       return true;
         
       return /\d/.test(String.fromCharCode(keynum));
       }
</script>
@stop