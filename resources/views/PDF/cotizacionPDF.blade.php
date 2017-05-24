<!DOCTYPE html>
<html lang="es">
<head>
  <style>
    .header, .footer {
        width: 100%;
        text-align: center;
        position: fixed;
    }
    .header {
        top: 0px;
    }
    .footer {
        bottom: 20px;
    }
    hr{
      line-height: 5px;
      background-color: black;
      border-color: black;
      width: 100%;
    }
    #div-largo {
      position:fixed;
      top:23%;
      width: 100%;
    }
    #div-b {
      position:absolute;
      top:0;
      right:0;
      width:415px;
    }
    #div-a {
    position:absolute;
    top:0;
    left:0;
    width:250px;
    }
    #info {
      color:black;
      margin: 0;
      text-align: right;
    }
    #info2 {
      color:black;
      margin: 0;
      text-align: center;
    }
    #footer{
    position : absolute;
    bottom : 0;
    width: 100%;
    }
    #nom{
    position : absolute;
    bottom : 15px;
    width: 100%;
    }
    #contenedor{
      height: 1000px;
    }
    #datos{
      position:fixed;
      top:10%%;
      width: 100%;
    }
    .celda_en{
      background-color: gray;
      border-radius: 0.25em;
    }
    table {
      font-size: 75%;
      table-layout: fixed;
      width: 100%;
      border-collapse: separate;
      border-spacing: 2px;
    }
    table.inventory th {
      font-weight: bold;
      text-align: center;
    }
    td, th {
      border-width: 0.5px;
      padding: 0.5em;
      position: relative;
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
  .noborde{
    border-width: 0px;
  }
  table.meta {
    margin: 0 0 3em;
    float: right;
    width: 20%;
  }
  .cliente{
    font-style: 30px !important;
  }
  table.balance {
    float: right;
    width: 32%;
  }
  .whatever { page-break-after: always; }
  .centrado{
    text-align: center;
  }
  </style>
  <meta charset="UTF-8">
  <title>Cotización número</title>
</head>
<body>
  <div class="header">
    <div id="div-b" align="right">
      <h3 id="info">GARCÍA ELECTRICIDAD</h3>
      <hr>
      <h5 id="info">Instalaciones en alta y baja tensión líneas</h5>
      <h5 id="info">aéreas y subterraneas subestaciones eléctricas</h5>
      <h5 id="info">alumbrado público y asesoría eléctrica</h5>
      <h6 id="info">Ing. Jaime García Cervantes</h6>
    </div>
    <div id="div-a">
        <img src="images/torres.jpeg" width="200px">
    </div>
  </div>
  <table id="datos" width="100%">
    <tr>
      <td  class="noborde" width="70%"></td>
      <td rowspan="2" style="text-align: right;" class="noborde">
        <table>
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
            <td align="left">Culiacán, Sin.</td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td class="noborde cliente">
        <h3>{{$cotizacion->clientes->nombre}}<br><strong>AT'N: {{$cotizacion->clientes->representante}}<br>P R E S E N T E.-</strong></h3>
      </td>
    </tr>
  </table>
    <div id="div-largo">
      <p style="text-align: justify; margin-top: 9%px;">Por este conducto presentamos a su atenta consideración nuestro presupuesto correspondiente a: {{$cotizacion->descripcion}}.</p>
      <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      A continuación detallamos nuestro presupuesto:</strong></p>
      <table class="inventory">
        <thead>
          <tr>
            <th width="10%">Nro.</th>
            <th width="70%">Descripcion</th>
            <th width="10%">Cant.</th>
            <th width="20%">P. Unitario</th>
            <th width="25%">Total</th>
          </tr>
        </thead>
        <tbody>
        @foreach($listado[0]->grupos as $gpo)
          <tr>
            <td class="centrado">{{$i=$i+1}}</td>
            <td>{{$gpo->descripcion}}</td>
            <td class="centrado">{{$gpo->pivot->cantidad}}</td>
            <td class="centrado">Pendiente</td>
            <td class="centrado">Pendiente$ {{number_format($gpo->total,2,'.',',')}}</td>
          </tr>
        @endforeach
        </tbody>
      </table><br>
      <table class="balance">
        <tbody>
          <tr>
            <th style="text-align: right;">Subtotal:</th>
            <td align="left" width="57%">$ {{number_format($total[0]->total,2,'.',',')}}</td>
          </tr>
          <tr>
            <th style="text-align: right;">IVA:</th>
            <td align="left">$ {{number_format(($total[0]->total*0.16),2,'.',',')}}</td>
          </tr>
          <tr>
            <th style="text-align: right;">Total:</th>
            <td align="left">$ {{number_format(((($total[0]->total)+($total[0]->total*0.16))),2,'.',',')}}</td>
          </tr>
        </tbody>
      </table>
      <br><br><br><br>
      <p align="justify">{{$cotizacion->mensajes->msg1}}</p>
      <p align="justify">{{$cotizacion->mensajes->msg2}}</p>
      <p align="justify">{{$cotizacion->mensajes->msg3}}</p>
      <p align="justify">{{$cotizacion->mensajes->msg4}}</p>
      <p align="justify">{{$cotizacion->mensajes->msg5}}</p>
    </div>

    <div id="nom">
        <p align="center">
        <img src="images/firma.jpg" alt=""><br>
          <strong>A T E N T A M E N T E</strong><br>
          <strong>
            @if(isset($datos))
              {{$datos->responsable}}
            @endif
          </strong>
        </p>
    </div>

  <div class="footer">
    <hr><h6 id="info2">
    @if(isset($datos))
      {{$datos->direccion}}
    @endif 
    , Culiacán, Sin.
    TELS. 717-46-42 Y 715-37-98 CEL. (667)751-60-71 CULIACÁN, SINALOA.
    www.garciaelectricidad.com.mx
    </h6>
  </div>

  

</body>
</html>