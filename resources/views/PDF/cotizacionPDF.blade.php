<html>
<head>
  <style>
    @page { margin: 100px 25px;}
    header { position: fixed; top: -60px; left: 25px; right: 25px;}
    footer { position: fixed; bottom: -40px; left: 0px; right: 0px; height: 30px; text-align: center; margin:0px;}
    section { margin: 0px 25px -10px 25px; position: relative; top:50px;}
    .info {
      color:black;
      text-align: right;
    }
    .datos{
      float: right;
      margin-top: 0px;
    }
    .logo{
      float: left;
    }
    .borde{
      border: 2px solid black;
    }
    .info{
      font-size: 13px;
      width: 245px;
      text-align: right;
      
    }
    .infocot{
      width: 200px;
      float:right;
    }
    .atn{
      width: 500px;
      float: left;
    }
    td, th {
      border-width: 1px;
      padding: 0.4em;
      text-align: left;
      border-radius: 5px;
      border-style: solid;
    }
    th {
      background: #d2d2d2;
      border-color: #d2d2d2;
    }
   td {
      border-color: #ddd;
    }
    table {
      font-size: 75%;
      border-collapse: separate;
      border-spacing: 2px;
    }
    .contenido{
      margin-top: 85px;
      page-break-after: avoid;
    }
    .division{
      margin-top: 100px;
      color: red;
    }
    .mensajes{
      font-size: 12.5px;
      margin: 0px;
    }
    .msg{
      margin: 0px;
    }
    .firma{
      position: absolute;
      bottom: 0;
      margin-top: 0px;
      margin-bottom: -10px;
      font-size: 12px;
      margin-left: 40%;
    }
    .centrado{
      text-align: center;
    }
    .image{
      margin: 0px;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/logopdf.jpeg" alt="" width="150px"><br><br>
    </div>
    <div class="datos">
    <p class="info">
      <u><b>GARCÍA ELECTRICIDAD</b></u><br>
      Instalaciones en alta y baja tensión líneas <br>
      aéreas y subterraneas subestaciones eléctricas <br>
      alumbrado público y asesoría eléctrica <br>
      Ing. Jaime García Cervantes <br>
    </p>
    </div>
    <hr class="division">
  </header>
  <footer><hr>
    <h6 style="margin: 2px;">
    @if(isset($datos))
      {{$datos->direccion}}
    @endif 
    TEL. 729-71-65 CEL. (667)751-60-71 CULIACÁN, SINALOA <br>
    www.garciaelectricidad.com.mx
    </h6>
  </footer>
  <main>
    <section>
    <div class="atn"><br>
      <div style="margin: 0;"><b style="font-size: 20px;">{{$listado[0]->clientes->nombre}}</b><br>AT'N: {{$listado[0]->clientes->representante}}<br>P r e s e n t e.-</div>
    </div>
    <div class="infocot">
    <table style="padding-left: 52px;">
          <tbody>
          <tr>
            <th style="text-align: right;">Folio: </th>
            <td align="left"># {{$cotizacion->folio}}</td>
          </tr>
          <tr>
            <th style="text-align: right;">Fecha: </th>
            <td align="left">{{$cotizacion->fecha_impresion}}</td>
          </tr>
          <tr>
            <th style="text-align: right;">Lugar: </th>
            <td align="left">Culiacán, Sin.&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          </tbody>
    </table>
    </div>
    <br>
    <div class="contenido">
    <div style="text-align: justify; margin: 0;">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por este conducto presentamos a su atenta consideración nuestro presupuesto correspondiente a: <i>{{$listado[0]->descripcion}}</i>.
    </div>
      <br>
      <table class="inventory" width="100%">
        <thead>
          <tr>
            <th width="10%">Nro.</th>
            <th width="68%">Descripcion</th>
            <th width="10%">Unidad</th>
            <th width="10%">Cant.</th>
            <th width="18%">P. Unitario</th>
            <th width="21%">Total</th>
          </tr>
        </thead>
        <tbody>
        @foreach($listado[0]->grupos as $gpo)
          <tr>
            <td class="centrado">{{$i=$i+1}}</td>
            <td>{{$gpo->descripcion}}</td>
            <td>{{$gpo->unidad}}</td>
            <td class="centrado">{{$gpo->pivot->cantidad}}</td>
            <td>$ {{number_format(($gpo->materialesDetalle->sum('cant_precio')+($gpo->materialesDetalle->sum('cant_precio')*($listado[0]->mensajes->indirecto/100))),2,'.',',')}}</td>
            <td>$ {{number_format($gpo->pivot->cantidad*($gpo->materialesDetalle->sum('cant_precio')+($gpo->materialesDetalle->sum('cant_precio')*($listado[0]->mensajes->indirecto/100))),2,'.',',')}}</td>
          </tr>
        @endforeach
        <tr>
          <td colspan="4" style="border: 0px;"></td>
          <td style="text-align: right; border: 0px;"><b> SUBTOTAL:</b></td>
          <td style="text-align: left;">$ {{number_format($total[0]->total+($total[0]->total*$listado[0]->mensajes->indirecto/100),2,'.',',')}}</td>
        </tr>
        <tr>
          <td colspan="4" style="border: 0px;"></td>
          <td style="text-align: right; border: 0px;"><b>IVA:</b></td>
          <td style="text-align: left;">$ {{number_format((($total[0]->total+($total[0]->total*$listado[0]->mensajes->indirecto/100))*0.16),2,'.',',')}}</td>
        </tr>
        <tr>
          <td colspan="4" style="border: 0px;"></td>
          <td style="text-align: right; border: 0px;"><b>TOTAL:</b></td>
          <td style="text-align: left;">$ {{number_format(($total[0]->total+($total[0]->total*$listado[0]->mensajes->indirecto/100)+($total[0]->total+($total[0]->total*$listado[0]->mensajes->indirecto/100))*0.16),2,'.',',')}}</td>
        </tr>
        </tbody>
      </table>
      <div class="mensajes">
        <p class="msg" align="justify">{{$listado[0]->mensajes->msg1}}</p>
        <p class="msg" align="justify">{{$listado[0]->mensajes->msg2}}</p>
        <p class="msg" align="justify">{{$listado[0]->mensajes->msg3}}</p>
        <p class="msg" align="justify">{{$listado[0]->mensajes->msg4}}</p>
        <p class="msg" align="justify">{{$listado[0]->mensajes->msg5}}</p>
      </div>
      <div class="firma" style="text-align: center;">
        <img class="image" src="images/firma.jpg"><br>
        <b>A T E N T A M E N T E </b><br>
          <strong style="margin: 0px;">
            @if(isset($datos))
              {{$datos->responsable}}
            @endif
          </strong>
      </div>

    </div>
    </section>
  </main>
</body>
</html>