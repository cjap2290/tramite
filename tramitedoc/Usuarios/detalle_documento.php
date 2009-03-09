<?php 
require_once("../includes.php");
session_start();
$link = new Conexion();
$sql_listado = " SELECT * FROM  t_historialtramite  ";
$query_listado = new Consulta($sql_listado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; }
.Estilo21 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000; }
.Estilo28 {color: #FFFFFF}
.Estilo29 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; color: #FFFFFF; }
.Estilo31 {color: #000000}
.Estilo32 {font-size: x-small}
.Estilo33 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; color: #000000; }
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; }
.Estilo34 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p align="center" class="Estilo9"><img src="CABEZERA.JPG" alt="a" width="921" height="78" /></p>
<table width="100%" border="0">
  <tr>
    <td width="71%" class="Estilo9"><a href="http://www.minam.gob.pe/" class="pathway">SERNANP</a> &gt;<a href="http://www.minam.gob.pe/" class="pathway">Sistema de Tr&aacute;mite Documentario</a>&gt;<span class="breadcrumbs pathway">Elaborar Borrador de Respuesta </span></td>
    <td width="29%"><div align="right" class="Estilo9">Usuario del Sistema: JuanGabriel</div></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="escanear.htm">
  <fieldset><legend><span class="Estilo9">DATOS DEL DOCUMENTO</span></legend>
  <table border="0" align="center" bordercolor="#000000" bgcolor="#FFFFFF">
    <tr>
      <td bgcolor="#FFFFFF" class="Estilo9"><div align="right">Registro Nro </div></td>
      <td colspan="2" bgcolor="#FFFFFF" class="Estilo7">006</td>
      <td bordercolor="#D6D3CE" bgcolor="#FFFFFF" class="Estilo33">&nbsp;</td>
      <td bgcolor="#FFFFFF" class="Estilo7">&nbsp;</td>
      <td bordercolor="#D6D3CE" bgcolor="#FFFFFF">&nbsp;</td>
      <td class="Estilo7">&nbsp;</td>
    </tr>
    <tr>
      <td width="123" bgcolor="#FFFFFF"><div align="right" class="Estilo31">
        <div align="right"><span class="Estilo9">Instituci&oacute;n</span></div>
      </div></td>
      <td colspan="2" bgcolor="#FFFFFF" class="Estilo7">Jos&eacute; Denegri Sisnieguez </td>
      <td width="152" bordercolor="#D6D3CE" bgcolor="#FFFFFF" class="Estilo33">Tipo de Documento </td>
      <td width="106" bgcolor="#FFFFFF" class="Estilo7">INFORME</td>
      <td width="151" bordercolor="#D6D3CE" bgcolor="#FFFFFF"><div align="right" class="Estilo31"><span class="Estilo9">Nro de Folios</span></div></td>
      <td width="181" class="Estilo7">1</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="right" class="Estilo31"><span class="Estilo9">Nro. Doc</span></div></td>
      <td colspan="2" bgcolor="#FFFFFF" class="Estilo7">015-11-2008-JD</td>
      <td bgcolor="#FFFFFF" class="Estilo9">&nbsp;</td>
      <td class="Estilo9">&nbsp;</td>
      <td bordercolor="#D6D3CE" bgcolor="#FFFFFF" class="Estilo9"><div align="right" class="Estilo31"><span class="Estilo32">Fecha de Doc </span></div></td>
      <td class="Estilo7">14/05/08</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="right" class="Estilo31"><span class="Estilo9">Referencia</span></div></td>
      <td colspan="6" class="Estilo7">Contrato de Consultoria ADDENDUM N&ordm; 1 PRFNP-C-CON-010-2008-PAN </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="right" class="Estilo31"><span class="Estilo9">Anexos</span></div></td>
      <td colspan="6" class="Estilo7">Factura N&ordm; 0001-000097 y un CD. </td>
    </tr>
    <tr>
      <td height="28" bgcolor="#FFFFFF" class="Estilo9"><div align="right" class="Estilo31">Registrado por </div></td>
      <td colspan="2" class="Estilo7"> Fulanito de tal y pascual </td>
      <td bordercolor="#D6D3CE" bgcolor="#FFFFFF"><div align="right" class="Estilo31"><span class="Estilo9">Fecha de Registro </span></div></td>
      <td class="Estilo7">15/05/08</td>
      <td bordercolor="#D6D3CE" bgcolor="#FFFFFF"><div align="right" class="Estilo31"><span class="Estilo9">Hora de Registro </span></div></td>
      <td class="Estilo7">10:36am</td>
    </tr>
    <tr>
      <td height="28" bgcolor="#FFFFFF" class="Estilo9"><div align="right" class="Estilo31">Documento Digitalizado </div></td>
      <td colspan="6" class="Estilo7"><a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">8</a> <a href="#">9 </a></td>
    </tr>
    <tr>
      <td height="28" bgcolor="#FFFFFF" class="Estilo9"><div align="right">Asunto</div></td>
      <td colspan="6" class="Estilo7"><p>REMITE INFORME DE TRABAJOS REALIZADOS SEGUN CONTRATO DE  CONSULTORIA ADDENMUN N&ordm; 1 PRRNP-C-CON-010-2008-PAN</p></td>
    </tr>
    <tr>
      <td height="28" bgcolor="#FFFFFF" class="Estilo9"><div align="right">Prioridad</div></td>
      <td width="84" class="Estilo7">ALTA/URGENTE</td>
      <td width="74" class="Estilo7"><div align="right"><strong>Tiempo de Respuesta</strong></div></td>
      <td class="Estilo7">24 horas</td>
      <td class="Estilo9"><div align="right">Fecha Estimada de Respuesta </div></td>
      <td class="Estilo7">16/05/08 10:36am </td>
      <td class="Estilo7">&nbsp;</td>
    </tr>
  </table>
  </fieldset>
</form>
  <fieldset>
<legend class="Estilo9">ELABORAR BORRADOR DE RESPUESTA</legend>
<table width="100%" border="1">
  <tr>
    <td width="9%" class="Estilo9">Borrador 1  </td>
    <td width="91%" class="Estilo7">Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta. Este es texto de un borrador de respuesta.</td>
  </tr>
</table>
  <table width="100%" border="1">
    <tr>
      <td width="9%" class="Estilo9">Borrador 2 </td>
      <td width="91%"><textarea name="textarea2" cols="140" wrap="physical">Segundo Borrador. Segundo Borrador. Segundo Borrador. Segundo Borrador. Segundo Borrador. Segundo BorraSegundo Borrador. Segundo Borrador. Segundo Borrador. Segundo Borrador. </textarea></td>
    </tr>
  </table>
</fieldset>
  <form action="areaXXX.html" method="post" enctype="multipart/form-data" name="form2" id="form2"><fieldset>
  <legend class="Estilo9">DERIVAR  BORRADOR DE RESPUESTA </legend>
  <table width="100%" border="0" align="center">
    <tr>
      <td width="6%" ><div align="right"><span class="Estilo9">PASE A:</span></div></td>
      <td width="16%" ><span class="Estilo9">
        <select name="select4">
          <option>SubCoordinador PAN</option>
          <option>Director PAN</option>
        </select>
      </span></td>
      <td width="8%"><div align="right"><span class="Estilo9">Acci&oacute;n: </span></div></td>
      <td width="42%"><span class="Estilo9">
        <select name="select5">
          <option>Evaluar Borrador de Respuesta</option>
        </select>
        <span class="Estilo21">
          <input type="button" name="Submit4" value="Agregar" />
      </span></span></td>
      <td width="10%" class="Estilo9">&nbsp;</td>
      <td width="8%">&nbsp;</td>
      <td width="10%"><div align="center">
        <input type="button" name="Submit2" value="Cargar a lista" />
      </div></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#003300">
    <tr>
      <td width="6%" height="25" class="Estilo9"><div align="center" class="Estilo28">Borrador </div></td>
      <td width="15%" class="Estilo29"><div align="center">ORIGEN</div></td>
      <td width="19%"><div align="center" class="Estilo29">DESTINO </div></td>
      <td width="16%" class="Estilo29"><div align="center">Fecha y Hora </div></td>
      <td width="18%"><div align="center" class="Estilo28"><span class="Estilo9">Acci&oacute;n</span></div></td>
      <td width="11%" class="Estilo9 Estilo28"><div align="center">Categor&iacute;a</div></td>
      <td width="15%"><div align="center" class="Estilo28"><span class="Estilo9">Opciones </span></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="center" class="Estilo31"><span class="Estilo7">1ro</span></div></td>
      <td bgcolor="#FFFFFF" class="Estilo7">Coordinador de PAN </td>
      <td bgcolor="#FFFFFF" class="Estilo7">Director PAN </td>
      <td bgcolor="#FFFFFF" class="Estilo7"><div align="center">01/12/2008 13:00pm </div></td>
      <td bgcolor="#FFFFFF" class="Estilo21">Evaluar Borrador de Respuesta </td>
      <td bgcolor="#FFFFFF" class="Estilo21"><div align="center"> Original</div></td>
      <td bgcolor="#FFFFFF"><div align="center" class="Estilo31"><a href="#"><img src="b_view.png" alt="ASD" width="16" height="16" border="0" /></a> &nbsp; <a href="#"><img src="b_drop.png" alt="ASD" width="16" height="16" border="0" /></a></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="center" class="Estilo31"><span class="Estilo7">2do</span></div></td>
      <td bgcolor="#FFFFFF" class="Estilo7">Director PAN </td>
      <td bgcolor="#FFFFFF" class="Estilo7">Coordinador de PAN </td>
      <td bgcolor="#FFFFFF" class="Estilo7"><div align="center">01/12/2008 15:00pm </div></td>
      <td bgcolor="#FFFFFF" class="Estilo21">Corregir Borrador de Respuesta </td>
      <td bgcolor="#FFFFFF" class="Estilo21"><div align="center"> Original</div></td>
      <td bgcolor="#FFFFFF"><div align="center" class="Estilo31"><a href="#"><img src="b_view.png" alt="ASD" width="16" height="16" border="0" /></a> &nbsp; <a href="#"><img src="b_drop.png" alt="ASD" width="16" height="16" border="0" /></a></div></td>
    </tr>
    <tr>
      <td colspan="7" bgcolor="#FFFFFF"><div align="center">
        <p class="Estilo28">
          <input type="submit" name="Submit" value="Derivar Borrador" /> &nbsp; &nbsp; &nbsp;
          <input type="submit" name="Submit3" value="Aprobar Respuesta" />
        </p>
      </div></td>
    </tr>
  </table>
  </fieldset>
</form>
<p align="center" class="Estilo34">Est&aacute; seguro de aprobar la respuesta <a href="ImprimirRespuesta.htm">S&iacute;</a> <a href="#">No</a> </p>
</body>
</html>
