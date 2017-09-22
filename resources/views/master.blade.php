<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>García Electricidad</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset("css/all.css")}}">
  <script src="{{ asset("js/jquery-2.2.3.min.js") }}"></script>
  <script src="{{ asset("js/moment.min.js") }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <link rel="stylesheet" href="{{ asset("css/jquery-ui.css") }}">
  <script src="{{ asset("js/jquery-ui.min.js") }}"></script>
<style type="text/css">
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, x-ng-cloak, .ng-hide {
        display:none !important;
    }
  </style>
</head>
<body class="hold-transition skin-red-light fixed sidebar-mini" ng-app="principalBase">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>G</b>E</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>García</b> Electricidad</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Avisos</li>
              <li> -->
                <!-- inner menu: contains the actual data -->
                <!-- <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> Promoción de cumpleaños
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> 
                      Ejemplo de otro aviso o notificación
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> Vence en 3 días
                      </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> Promociones
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> Nuevos productos
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li> -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset("images/user.png")}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset("images/user.png")}}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}
                  <small>Usuario desde {{ date("M", strtotime(Auth::user()->created_at)) }}, {{ date("Y", strtotime(Auth::user()->created_at)) }}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfíl</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    class="btn btn-default btn-flat">Cerrar sesión
                  </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset("images/user.png")}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }} </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENÚ PRINCIPAL</li>
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Menú TIPO 1</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="{{url('blank')}}"><i class="fa fa-circle-o"></i>Blanco</a></li>
            <li><a href="{{url('blankPrimary')}}"><i class="fa fa-circle-o"></i> Blanco Primary</a></li>
          </ul>
        </li> -->
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Menú TIPO 2</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('formularioGeneral')}}"><i class="fa fa-circle-o"></i> Form General</a></li>
            <li><a href="{{url('tablaDatos')}}"><i class="fa fa-circle-o"></i>Tabla Datos</a></li>
          </ul>
        </li> -->
        <li>
          <a href="{{url('/misDatos')}}">
            <i class="fa fa-list-alt"></i> <span>Mis datos</span>
          </a>
        </li>
        <li>
          <a href="{{url('/materiales')}}">
            <i class="fa fa-wrench"></i> <span>Materiales</span>
          </a>
        </li>
        <li>
          <a href="{{url('/grupos')}}">
            <i class="fa fa-object-group"></i> <span>Grupos</span>
          </a>
        </li>
        <li>
          <a href="{{url('/servicios')}}">
            <i class="fa fa-cogs"></i> <span>Servicios</span>
          </a>
        </li>
        <li>
          <a href="{{url('/clientes')}}">
            <i class="fa fa-users"></i> <span>Clientes</span>
          </a>
        </li>
        <li>
          <a href="{{url('/cotizaciones')}}">
            <i class="fa fa-file-text-o"></i> <span>Cotizaciones</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> <span>Salir</span></a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('titulo')
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('contenido')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Versión</b> 1.0
    </div>
    <strong>Copyright &copy; 2017 <a href="{{url('/')}}">García Electricidad</a>.</strong> Todos los Derechos Reservados.
  </footer>
</div>
<script src="{{ asset("js/all.js") }}"></script>
<script src="{{ asset("app/app.js") }}"></script>
<script src="{{ asset("js/moment.min.js") }}"></script>
<script src="{{ asset("js/daterangepicker.js") }}"></script>
<!-- datepicker -->
<script src="{{ asset("js/ui-bootstrap-tpls.min.js") }}"></script>
<script src="{{ asset("js/angular-aria.min.js") }}"></script>
<script src="{{ asset("js/angular-animate.min.js") }}"></script>
<script src="{{ asset("js/angular-material.min.js") }}"></script>
<script src="{{ asset('js/mask.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
@stack('scripts')
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
</body>
</html>
