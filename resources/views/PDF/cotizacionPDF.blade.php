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
      background-color: #0D1975;
      border-color: #0D1975;
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
      color:#0D1975;
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
    bottom : 40px;
    width: 100%;
    }
    #contenedor{
      height: 1000px;
    }
    #datos{
      position:fixed;
      top:15%;
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
    th {
      background: #e5f1f9;
      border-color: #cbe3f2;
    }
    td, th {
      border-width: 0.5px;
      padding: 0.5em;
      position: relative;
      text-align: left;
      border-radius: 0.30em;
      border-style: solid;
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
  </style>
  <meta charset="UTF-8">
  <title>Cotización número</title>
</head>
<body>
  <div class="header">
    <div id="div-b">
      <h1 id="info">GARCIA ELECTRICIDAD</h1>
      <hr>
      <h4 id="info">Instalaciones en alta y baja tensión líneas</h4>
      <h4 id="info">Aéreas y subterraneas subestaciones eléctricas</h4>
      <h4 id="info">Alumbrado público y asesoría eléctrica</h4>
      <h3 id="info">Ing. Jaime García Cervantes</h3>
    </div>
    <div id="div-a">
        <img src="images/torres.jpg" width="240px">
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
        <h3><strong><u>AT'N: {{$cotizacion->cliente}}</u><br>P R E S E N T E.-</strong></h3>
      </td>
    </tr>
  </table>
    <div id="div-largo">
      <p style="text-align: justify; margin-top: 40px;">Por este conducto presentamos a su atenta consideración nuestro presupuesto correspondiente a: {{$cotizacion->descripcion}}.</p>
      <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      A continuación detallamos nuestro presupuesto:</strong></p>
      <table class="inventory">
        <thead>
          <tr>
            <th width="10%">Nro.</th>
            <th width="70%">Descripcion</th>
            <th width="20%">Total</th>
          </tr>
        </thead>
        <tbody>
        @foreach($listado as $gpo)
          <tr>
            <td style="text-align: center;">{{$i=$i+1}}</td>
            <td>{{$gpo->descripcion}}</td>
            <td>$ {{number_format($gpo->total,2,'.',',')}}</td>
          </tr>
        @endforeach
        </tbody>
      </table><br>
      <table class="balance">
        <tbody>
          <tr>
            <th style="text-align: right;">Subtotal:</th>
            <td align="left" width="62.5%">$ {{number_format($total[0]->total,2,'.',',')}}</td>
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
      <br><br><br><br><br><br>
      <p><strong>Nota: este presupuesto no incluye pagos ante C.F.E.</strong></p>
      <p align="justify">Este presupuesto esta sujeto a cambios de acuerdo a la variación de precios que surjan en el mercado
         <br><br>Sin mas por el momento nos despedimos de usted con un cordial saludo esperando su pronta respuesta</p>
      <br><br><br>
    </div>

    <div id="nom">
        <p align="center">
          <strong>A T E N T A M E N T E</strong><br>
          <strong>ING. JAIME GARCÍA CERVANTES</strong>
        </p>
    </div>

  <div class="footer">
    <hr><h6 id="info">BAHÍA DE ALTATA #1478 COL. NUEVO CULIACÁN TELS. 717-46-42 Y 715-37-98 CEL. (667)751-60-71 CULIACÁN, SINALOA.</h6>
  </div>

  

</body>
</html>