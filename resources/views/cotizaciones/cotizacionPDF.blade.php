@extends('master')

@section('titulo')
<h1>
    Ajustar datos de Cotización
    <small>{{$cotizacion->folio}}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/detalleCotizacion')}}/{{$cotizacion->id}}"><i class="fa fa-file"></i> Cotizacion {{$cotizacion->folio}}</a></li>
    <li class="active">Detalle PDF</li>
</ol>
@stop

@section('contenido')
<div class="box box-default">
    <div class="box-header with-border">
      	<div class="panel panel-default">
	    	<div class="panel-heading" role="tab" id="headingOne">
	      		<h4 class="panel-title">
	        		<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	          		Mensajes de la Cotización {{$cotizacion->folio}}
	        		</a>
	      		</h4>
	    	</div>
	    	<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
	      	<div class="panel-body">
	      		<form action="{{url('/guardarMensajes')}}/{{$cotizacion->id}}" method="POST">
	      		<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
	      		<input id="id_msg" type="hidden" name="id_msg" value="{{ $cotizacion->mensajes->id }}">
		        <div class="row">
					<div class="col-md-4 col-xs-12">
			        	<div class="form-group">
			        		<label for="msg1">Mensaje #1</label>
			        		<textarea name="msg1" type="text" class="form-control" placeholder="Teclee mensaje #1" rows="3">{{$cotizacion->mensajes->msg1}}</textarea> 
			        	</div>
		        	</div>
		        	<div class="col-md-4 col-xs-12">
		        		<div class="form-group">
			        		<label for="msg2">Mensaje #2</label>
			        		<textarea name="msg2" type="text" class="form-control" placeholder="Teclee mensaje #2" rows="3">{{$cotizacion->mensajes->msg2}}</textarea> 
			        	</div>
		        	</div>
		        	<div class="col-md-4 col-xs-12">
		        		<div class="form-group">
			        		<label for="msg3">Mensaje #3</label>
			        		<textarea name="msg3" type="text" class="form-control" placeholder="Teclee mensaje #3" rows="3">{{$cotizacion->mensajes->msg3}}</textarea> 
			        	</div>
		        	</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-xs-12">
			        	<div class="form-group">
			        		<label for="msg4">Mensaje #4</label>
			        		<textarea name="msg4" type="text" class="form-control" placeholder="Teclee mensaje #4" rows="3">{{$cotizacion->mensajes->msg4}}</textarea> 
			        	</div>
		        	</div>
		        	<div class="col-md-4 col-xs-12">
		        		<div class="form-group">
			        		<label for="msg5">Mensaje #5</label>
			        		<textarea name="msg5" type="text" class="form-control" placeholder="Teclee mensaje #5" rows="3">{{$cotizacion->mensajes->msg5}}</textarea> 
			        	</div>
		        	</div>
		        	<div class="col-md-4 col-xs-12">
		        		<div class="form-group">
		                  <label for="fecha_impresion">Fecha de Impresión:</label>
		                  <div class="left-inner-addon">
		                    <i class="fa fa-calendar"></i>
		                    <input class="form-control" name="fecha_impresion" type="text" id="datepicker"  required placeholder="Fecha de impresión" value="{{$cotizacion->fecha_impresion}}">
		                  </div> 
		                </div>
		        	</div>
				</div><hr>
				<div class="row">
					<div class="col-xs-12 text-center">
						<button type="submit" class="btn btn-primary">Guardar</button>&nbsp;&nbsp;&nbsp;
						<a href="{{url('/detalleCotizacion')}}/{{$cotizacion->id}}" class="btn btn-danger">Regresar</a>
					</div>
				</div>
	    	</form>
	    	</div>
  		</div>
    </div>
    <div class="box-body">
    	<iframe src="{{url('cotizacionPDF')}}/{{$cotizacion->id}}" frameborder="0" width="100%"  scrolling="auto" height="1150"></iframe>
    </div>
</div>
</div>
<script>
  $(document).ready(function() {
      //Date picker
        var f = new Date();
          $( "#datepicker").datepicker({
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