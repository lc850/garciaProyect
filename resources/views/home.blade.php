@extends('master')

@section('titulo')
<h1>
    Sistema Administrativo
    <small>Principal</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Principal</a></li>
    <li class="active">Home</li>
</ol>
@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$prueba[0]}}</h3>
              <p>Materiales</p>
            </div>
            <div class="icon">
              <i class="fa fa-wrench"></i>
            </div>
            <a href="{{url('/materiales')}}" class="small-box-footer">Administrar materiales  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$prueba[1]}}</h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{url('/clientes')}}" class="small-box-footer">Administrar clientes <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$prueba[2]}}</h3>

              <p>Cotizaciones</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text-o"></i>
            </div>
            <a href="{{url('/cotizaciones')}}" class="small-box-footer">Administrar cotizaciones <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$prueba[3]}}</h3>

              <p>Grupos</p>
            </div>
            <div class="icon">
              <i class="fa fa-object-group"></i>
            </div>
            <a href="{{url('/grupos')}}" class="small-box-footer">Administrar grupos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
@stop
