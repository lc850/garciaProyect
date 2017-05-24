@extends('master')

@section('titulo')
<h1>
    &nbsp;
</h1>
<ol class="breadcrumb">
    <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Datos de la empresa</li>
</ol>
@stop

@section('contenido')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Datos de la empresa</h3>
    </div>
    <div class="box-body">

        @if($datos==null)
        <form action="{{url('/guardarMisDatos')}}" method="POST">
        <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
    			<label for="Nombre">Nombre de la Empresa:</label>
                <input name="nombre" type="text" class="form-control" placeholder="Teclea el nombre de la empresa" required>
            </div>
            <div class="form-group">
                <label for="Direccion">Dirección:</label>
                <input name="direccion" type="text" class="form-control" placeholder="Teclea la dirección de la empresa" required>
            </div>
            <div class="form-group">
                <label for="Responsable">Responsable:</label>
                <input name="responsable" type="text" class="form-control" placeholder="Responsable de la empresa" required>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>&nbsp;&nbsp;
                <a href="{{url('/')}}" class="btn btn-danger">Cancerlar</a>
            </div>
        </form>
        @else
        @include('flash::message')
        <form action="{{url('/actualizarMisDatos')}}" method="POST">
        <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$datos->id}}">
            <div class="form-group">
                <label for="Nombre">Nombre de la Empresa:</label>
                <input name="nombre" type="text" class="form-control" placeholder="Teclea el nombre de la empresa" value="{{$datos->nombre}}" required>
            </div>
            <div class="form-group">
                <label for="Direccion">Dirección:</label>
                <input name="direccion" type="text" class="form-control" placeholder="Teclea la dirección de la empresa" value="{{$datos->direccion}}" required>
            </div>
            <div class="form-group">
                <label for="Responsable">Responsable:</label>
                <input name="responsable" type="text" class="form-control" placeholder="Responsable de la empresa" value="{{$datos->responsable}}" required>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>&nbsp;&nbsp;
                <a href="{{url('/')}}" class="btn btn-danger">Cancerlar</a>
            </div>
        </form>
        @endif
    </div>
</div>
<script type="text/javascript">
            setTimeout(function() {
                $(".alert").fadeOut(1500);
            },1500);
      </script>
@stop