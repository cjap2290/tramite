<div id="acceso">
	<form name="f1" method="post" action="validacion.php" onsubmit="valida();" >  			 
		<label></label>
		<br />
		<table align="center" width="57%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13%" class="Estilo21"><div align="center">(*)</div></td>
            <td width="29%" class="Estilo22"><div align="left">Usuario</div></td>
            <td width="4%" class="Estilo22"><div align="center">:</div></td>
            <td width="54%"><input type="text" name="usuario" /></td>
          </tr>
          <tr>
            <td width="13%" class="Estilo21"><div align="center">(*)</div></td>
            <td class="Estilo22" width="29%"><div align="left">Password</div></td>
            <td width="4%"class="Estilo22"><div align="center">:</div></td>
            <td width="54%"><input type="password" name="password" onkeypress="checkTheKey(event.keyCode)" /></td>
          </tr>
          <tr>
            <td width="13%">&nbsp;</td>
            <td width="29%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
            <td width="54%">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"><div align="center">
              <input type="submit" name="enviar" value="Ingresar" class="boton" />
            </div></td>
          </tr>
        </table>
		<br /> 
		<?php
if($error){ ?>
	<div class="error"><?php echo " ERROR: Usuario ó Password Incorrecto, Por favor ingrese de nuevo! ";?></div><?php
 }?>
	</form>
</div>
