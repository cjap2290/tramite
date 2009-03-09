<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Mas trucos y scripts en http://www.javascript.com.mx -->
<style>
<!--
.styling{
background-color:black;
color:lime;
font: bold 15px MS Sans Serif;
padding: 3px;
}
-->
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; }
.Estilo19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; color: #000000; }
.Estilo21 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000; }
.Estilo23 {font-size: x-small; color: #000000; }
.Estilo24 {color: #000000}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: medium; font-weight: bold; color: #FF0000; }
-->
</style>
</head>

<body>
<p align="center" class="Estilo9"><img src="file:///D|/Compartido/BORRADOR STD SERNANP/CABEZERA.JPG" width="921" height="78" /></p>
<table width="100%" border="0">
  <tr>
    <td width="54%" class="Estilo9"><a href="http://www.minam.gob.pe/" class="pathway">SERNANP</a> &gt;<a href="http://www.minam.gob.pe/" class="pathway">Sistema de Tr&aacute;mite Documentario</a>&gt; Registrar Documentos </td>
    <td width="46%"><div align="right" class="Estilo9">Usuario del Sistema: JuanGabriel</div></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td><span class="Estilo9">INGRESO DE DATOS </span></td>
    <td><div align="right"><!-- Mas trucos y scripts en http://www.javascript.com.mx -->
<style>
<!--
.styling{
background-color:black;
color:lime;
font: bold 15px MS Sans Serif;
padding: 3px;
}
-->
</style>
<span id="digitalclock" class="styling"></span>

<script>
var alternate=0
var standardbrowser=!document.all&&!document.getElementById

if (standardbrowser)
document.write('<form name="tick"><input type="text" name="tock" size="6"></form>')

function show(){
if (!standardbrowser)
var clockobj=document.getElementById? document.getElementById("digitalclock") : document.all.digitalclock
var Digital=new Date()
var hours=Digital.getHours()
var minutes=Digital.getMinutes()
var dn="AM"

if (hours==12) dn="PM" 
if (hours>12){
dn="PM"
hours=hours-12
}
if (hours==0) hours=12
if (hours.toString().length==1)
hours="0"+hours
if (minutes<=9)
minutes="0"+minutes

if (standardbrowser){
if (alternate==0)
document.tick.tock.value=hours+" : "+minutes+" "+dn
else
document.tick.tock.value=hours+"   "+minutes+" "+dn
}
else{
if (alternate==0)
clockobj.innerHTML=hours+"<font color='lime'> : </font>"+minutes+" "+"<sup style='font-size:1px'>"+dn+"</sup>"
else
clockobj.innerHTML=hours+"<font color='black'> : </font>"+minutes+" "+"<sup style='font-size:1px'>"+dn+"</sup>"
}
alternate=(alternate==0)? 1 : 0
setTimeout("show()",1000)
}
window.onload=show

//-->
</script>
</div></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="file:///D|/Compartido/BORRADOR STD SERNANP/escanearlistado.html">
  <fieldset>
  <legend></legend><table width="90%" border="0" align="center" bordercolor="#000000" bgcolor="#FFFFFF">
    <tr>
      <td width="88" bgcolor="#FFFFFF"><div align="right"><span class="Estilo19">Instituci&oacute;n</span></div></td>
      <td width="421" bgcolor="#FFFFFF"><span class="Estilo21">
        <select name="select">
          <option>asdasdasdasdasdasdsasdasdasds</option>
        </select>
        <input type="button" name="Submit4" value="Agregar" />
      </span></td>
      <td width="77" bgcolor="#FFFFFF" class="Estilo9">Tipo de Documento </td>
      <td width="123" bgcolor="#FFFFFF"><select name="select5">
        <option>Carta</option>
        <option>MEMORANDUM</option>
      </select>      </td>
      <td width="155" bgcolor="#FFFFFF"><div align="right"><span class="Estilo19">Nro de Folios</span></div></td>
      <td width="69"><span class="Estilo23">
        <input name="textfield7" type="text" size="5" />
      </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo19">Nro. Doc</span></div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo23">
        <input name="textfield2" type="text" value="001-0002" size="50" />
      </span></td>
      <td bgcolor="#FFFFFF" class="Estilo9">&nbsp;</td>
      <td class="Estilo9">&nbsp;</td>
      <td bgcolor="#FFFFFF" class="Estilo9"><div align="right"><span class="Estilo23">Fecha de Doc </span></div></td>
      <td><input name="textfield9" type="text" size="10" /></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo19">Referencia</span></div></td>
      <td colspan="5"><span class="Estilo23">
        <input name="textfield52" type="text" size="100" />
      </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo19">Anexos</span></div></td>
      <td colspan="3"><span class="Estilo23">
        <input name="textfield22" type="text" size="70" />
      </span></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="Estilo9"><div align="right">Observacion</div></td>
      <td colspan="5"><textarea name="textarea"></textarea></td>
    </tr>
    <tr>
      <td colspan="6"><div align="center" class="Estilo24"><strong>
        <input type="button" name="Submit" value="Guardar" />
        <input type="submit" name="Submit22" value="Imprimir" />
      </strong></div></td>
    </tr>
  </table></fieldset>
  <p align="center" class="Estilo25">Este documento ya existe con el siguiente registro <a href="#">XXX </a></p>
  <p align="center" class="Estilo25">
    <input type="button" name="Submit2" value="Limpiar" />
    <input type="button" name="Submit3" value="Salir" />
  </p>
</form>
</body>
</html>
