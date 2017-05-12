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
    <li><a href="{{url('/Cotizaciones')}}">Cotizaciones</a></li>
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
            <a href="#">
              <i class="fa fa-object-group" aria-hidden="true"></i>&nbsp;&nbsp;Agregar grupo
            </a>
          </li>
          <li>
            <a href="{{url('cotizacionPDF')}}/{{$cotizacion->id}}" target="_blank">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;&nbsp;Generar PDF
            </a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opciones <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Agregar grupo</a></li>
              <li><a href="{{url('cotizacionPDF')}}">Generar PDF</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{url('/cotizaciones')}}">Regresar</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-form navbar-left">
          <div class="form-group">
            <div class="left-inner-addon">
              <i class="fa fa-search"></i>
              <input ng-model="search" type="text"  class="form-control" placeholder="Buscar material">
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
             <% gc.grupo %>
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
                  <th class="text-center">Precio</th>
                  <th class="text-center">
                    <button id="btn-add" class="btn btn-info btn-xs" data-target="#" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>Agregar material</button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="gcm in gc.materiales | filter:search">
                  <td><% gcm.mat_nom %></td>
                  <td class="text-center"><% gcm.unidad %></td>
                  <td class="text-center"><% gcm.cantidad %></td>
                  <td class="text-center"><% gcm.precio | currency %></td>
                  <td class="text-center"><button type="button" class="btn btn-xs btn-danger" ng-click=""><i class="glyphicon glyphicon-remove"></i></button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop