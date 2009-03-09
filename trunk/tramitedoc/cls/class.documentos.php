<?php
require_once('cls/class.acciones.php');
class Documentos{
	function Documentos(){	}
	function DocumentosPorUusuario($id_usuario){
		$return;
		$sql = "SELECT * FROM documentos WHERE id_usuario = '".$id_usuario."' ";
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' 		=> $row['id_usuario'],
				'codigo' 	=> $row['codigo_usuario'],
				'tipo' 		=> $row['id_tipo_documento'],
				'numero' 	=> $row['numero_documento'],
				'referencia'=> $row['referencia_documento'],
				'anexo' 	=> $row['anexo_documento'],
				'numero_folio' => $row['numero_folio_documento'],
				'fecha' 	=> $row['fecha_documento'],
				'asunto' 	=> $row['asunto_documento'],
				'fecha_registro' => $row['fecha_registro_documento'],
				'observacion' => $row['observacion_documento'],
				'prioridad' => $row['prioridad_documento'],
				'destino' 	=> $row['destino_documento'],
				'remitente' => $row['id_remitente'],
				'estado' 	=> $row['id_estado']
			);
		}
		return $return;
	}

	function HistorialDocumentosPorUusuario($id_usuario){
		$return;
		$sql = "SELECT * FROM historial_documentos WHERE id_usuario = '".$id_usuario."' ";
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$return[] = array(
				'id' 		=>	$row['id_historial_documento'],
				'documento'	=>	new Documento($row['id_documento']),
				'remitente' =>	new Remitente($row['id_remitente']),
				'destino' 	=>	new Usuario($row['id_usuario_destino']),
				'fecha' 	=>	$row['fecha_historial_documento'] ,
				'original'	=>	$row['original_historial_documento'] ,
				'accion' 	=>	new Accion($row['id_accion']) ,
				'estado' 	=>	new Estado($row['id_estado']),
				'usuario' 		=>	new Usuario($row['id_usuario'])
			);
		}
		return $return;
	}

	function listarDocumentosPorUsuario( $usuario ){
		if(isset($_POST['campo']) && isset($_POST['valor']) && !empty($_POST['campo']) && !empty($_POST['valor'])){
		 	$docs = $usuario->getIdAtencionPorFiltro($_POST['campo'], $_POST['valor']);
		}else{
			$docs = $usuario->getIdAtencion();
		}
		 ?>
		<table width="100%" cellpadding="1" cellspacing="1"  id="mantenimiento">
			<tr class="subtit">
				<td><div align="center">Reg. N&ordm;</div></td>
				<td><div align="center">Remitente</div></td>
				<td><div align="center">Documento</div></td>
				<td><div align="center">Fecha de Registro </div></td>
				<td><div align="center">Estado</div></td>
				<td><div align="center">Cat.</div></td>
</tr> <?php
			for($d=0; $d < count($docs); $d++ ){
				$doc[$d] = new Documento($docs[$d]['id']);
                $estado = $doc[$d]->getEstado()->getId();
            ?>

			<tr <?echo ($estado==12)?"style='background-color:#ffffcc'":"class='filas'";?>>
				<td onmouseover="toolTips('<?php echo $doc[$d]->getAsunto(); ?>',this)" >
					<?php if($estado != 12){ ?>
                    <a href="atencion_acceso_registro.php?opcion=detalle&id=<?php echo $doc[$d]->getId()?>"><?php echo $doc[$d]->getCodigo()?></a>
                    <?}
                    else{
                        echo $doc[$d]->getCodigo();
                    }
                    ?>
				</td>
				<td align="left"><?php $dtd = $doc[$d]->getRemitente(); echo $dtd->getNombre();?></td>
				<td align="left"><?php echo $doc[$d]->getNumero();?></td>
				<td><?php echo $doc[$d]->getFechaRegistro(); ?> </td>
				<td><?php $est = $doc[$d]->getEstado(); echo $est->getAbreviatura(); ?></td>
				<td><?php $cat = $docs[$d]['original']; echo ($cat == 1)?"O":"C"; ?></td>
			</tr>
			<!--<tr>
			  	<td bgcolor="#FFFFFF">  </td>
				<td colspan="10" style="padding:0px;margin:0px">
					<table width="100%" cellpadding="1" cellspacing="1" id="mantenimiento">
						<tr class="subtit">
							<td>Fecha</td>
							<td>Original</td>
							<td>Destino</td>
							<td>Accion</td>
							<td>Estado</td>
						</tr><?php
						$his = $doc[$d]->getHistorialAtencion();
						$tthis = count($his);
						for( $h = 0; $h < $tthis; $h++ ){ ?>
						<tr class="filas">
							<td><?php echo $his[$h]['fecha'] ?></td>
							<td><?php echo $doc[$d]->isOriginalCopia($his[$h]['original']);?></td>
							<td><?php echo $his[$h]['usuario']->GetNombre()?></td>
							<td><?php echo $his[$h]['accion']->GetNombre() ?></td>
							<td><?php echo $his[$h]['estado']->GetNombre() ?></td>
						</tr><?php
						} ?>
</table>
				</td>
			  </tr>-->  <?php
		}?>
		<table width="100%" border="1" id="mantenimiento"><?php
	}

	function detalleDocumentosPorUsuario( $usuario,  $documento ){
	  $doc = $documento; ?>
		  <fieldset><legend>DATOS DEL DOCUMENTO</legend>
		  <table border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">
			<tr>
			  <td class="Estilo22"><div align="left">Registro Nro </div></td>
			  <td  class="Estilo22"><div align="center">:</div></td>
			  <td width="265"  ><div align="left">  <?php echo $doc->getCodigo() ?>
			    </div>
			    <div align="left"></div>
	          <div align="left"></div></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="2"  >&nbsp;</td>
			  <td >&nbsp;</td>
			</tr>
			<tr>
			  <td width="171" class="Estilo22" ><div align="left">Instituci&oacute;n </div></td>
			  <td width="10" class="Estilo22"><div align="center">:</div></td>
			  <td ><div align="left"><?php echo $usuario->getNombreCompleto()  ?></div></td>
			  <td width="132" >&nbsp;</td>
			  <td width="92" >&nbsp;</td>
			  <td width="104" class="Estilo22" ><div align="left">Nro de Folios </div></td>
			  <td width="15" class="Estilo22">:</td>
			  <td width="127"><div align="left"><?php echo $doc->getNumeroFolio() ?></div></td>
			</tr>
			<tr>
			  <td class="Estilo22" ><div align="left">Tipo de Documento </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td colspan="3" ><div align="left">
			    <?php $dtd = $doc->getTipoDocumento(); echo $dtd->getNombre(); ?>
			  </div>		      </td>
			  <td  class="Estilo22"><div align="left">Fecha de Doc</div></td>
			  <td class="Estilo22"  >:</td>
			  <td ><div align="left">
                <?php  echo $doc->getFecha() ?>
              </div></td>
		    </tr>
			<tr>
			  <td class="Estilo22" ><div align="left">Nro. Doc </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td colspan="3" ><div align="left"><?php echo $doc->getNumero() ?></div></td>
			  <td colspan="2"  ><span class="Estilo32"></td>
			  <td >&nbsp;</td>
			</tr>
			<tr>
			  <td class="Estilo22" ><div align="left">Referencia </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td colspan="6" ><div align="left">
			    <?php  echo $doc->getReferencia() ?>
		      </div></td>
			</tr>
			<tr>
			  <td class="Estilo22"><div align="left">Anexos </div></td>
			  <td class="Estilo22"><div align="center">:</div></td>
			  <td colspan="6" ><div align="left"><?php echo $doc->getAnexo() ?> </div></td>
			</tr>

			<tr>
			  <td class="Estilo22"><div align="left">Fecha y Hora de Registro</div></td>
			  <td height="21" class="Estilo22"><div align="center">:</div></td>
			  <td colspan="6" ><div align="left">
                <?php  echo $doc->getFechaRegistro()." ".$doc->getHoraRegistro()?>
              </div></td>
		    </tr>

			<tr>
			  <td class="Estilo22"><div align="left">Documento Digitalizado</div></td>
			  <td height="21" class="Estilo22"> <div align="center">: </div></td>
			  <td colspan="6" ><div align="left">
			  <span class="Estilo7">
	      		<?
					$escaneo = "SELECT *
								from documentos_escaneados de
								where de.id_documento = ".$doc->getId();

					$qescaneo = new Consulta($escaneo);

			  		$index = 1;

					while($row_reg = $qescaneo->ConsultaVerRegistro()){?>
						<a href="Escaneo/<?=$row_reg['nombre_documento_escaneado']?>"
						id="<?=$row_reg["id_documento_escaneado"]?>" target="_blank">
						<?=$index?>
						</a>
					<?
						$index++;
            		}
				  	?>
    		  </span>
			  </div>			  </td>
			</tr>
		  </table>
		  <p align="left"><a href="javascript:verDetalleDoc()" id = "control" class="v" >Ver Detalles </a></p>
		 <div id="detalle_documento" style="display:none">
		  <table height="101" border="0" align="center" bordercolor="#000000" bgcolor="#ffffff">
            <tr>
              <td width="161" class="Estilo22"><div align="left">Asunto </div></td>
              <td width="7"  class="Estilo22"><div align="center">:</div></td>
              <td colspan="7"><div align="left">
                <?php   echo $doc->getAsunto() ?>
              </div></td>
            </tr>
            <tr>
              <td class="Estilo22"><div align="left">Observaci&oacute;n de Registro </div></td>
              <td  class="Estilo22"><div align="center">:</div></td>
              <td colspan="7"><div align="left">
                <?php   echo $doc->getObservacion()?>
              </div></td>
            </tr>
            <tr>
              <td  class="Estilo22"><div align="left">Observaci&oacute;n de Despacho</div></td>
              <td  class="Estilo22"><div  align="center">:</div></td>
              <td colspan="7"><div align="left">
                <?php
                     $historial=$doc->getHistorial();
                     foreach($historial as $reg){
                        $area = $reg["area"];
                        if($area->getId()==$_SESSION['session'][5])
                            echo $reg["observacion"];
                     }
                ?>
              </div></td>
            </tr>
            <tr>
              <td class="Estilo22" ><div align="left">Prioridad </div></td>
              <td height="21" class="Estilo22"><div align="center">:</div></td>
              <td width="77" ><div align="left">
                  <?php $pri = $doc->getPrioridad(); echo $pri->getNombre() ?>
              </div></td>
              <td width="176"  class="Estilo22"><div align="left">Tiempo de Respuesta : </div></td>
              <td width="135" ><div align="left"><?php echo $pri->getTiempoHorasRespuesta() ?>horas</div></td>
              <td colspan="3"  class="Estilo22" ><div align="left">Fecha Estimada de Respuesta : </div></td>
              <td width="106" ><div align="left"><?php echo $doc->getFechaRespuesta() ?></div></td>
            </tr>
          </table>
		</div>
	  </fieldset>

		<fieldset>
			<legend >ELABORAR BORRADOR DE RESPUESTA</legend>
            <form method="post" id="form_finalizar_documento" name="form_finalizar_documento" action="atencion_acceso_registro.php?opcion=fin&id=<?php echo $doc->getId()?>">
        <table align="center" width="96%" cellpadding="1" cellspacing="1" id="mantenimientod">
              <?php
              $esOriginal =  $usuario->getIdAtencionPorFiltro($campo);
			$respuestas = $doc->getBorradoresRespuesta();
			$tresp = count($respuestas);

			if(is_array($respuestas) && $tresp > 0){
				for($b = 0; $b < $tresp; $b++ ){ ?>
              <tr>
                <td width="15%" align="left"><a href="javascript:mostrarDetalle(<?=$b?>)" id="controlador">+ </a><?php echo $respuestas[$b]['usuario']->getNombreCompleto();  ?> </td>
                <td width="79%" align="left" ><div id="borrador<?=$b?>"><?php echo substr($respuestas[$b]['descripcion'],0,20)."..."?></div>
                    <div id="detalle<?=$b?>" style="display:none"><?php echo nl2br($respuestas[$b]['descripcion'])  ?> </div></td>
                <? if($_SESSION['session'][6]&&$esOriginal){?>
                <td width="6%" align="left" ><label> </label>
                    <div align="center">
                      <input name="borrador" type="radio" value="<?=$respuestas[$b]['id']?>" />
                  </div></td>
                <? } ?>
              </tr>
              <?php
				  }
			}  ?>
              <?
				if($_SESSION['session'][6]&&$esOriginal){?>
              <tr>
                <td colspan="3"><label>
                  <script>javascript:habilitar_finalizar();</script>
                  </label>
                    <div align="right">
                      <input type="button" name="finalizar" id = "finalizar" value="Finalizar" class="boton" onclick="validar_finalizar();"/>
                  </div></td>
              </tr>
              <? } ?>
            </table>

			</form>

		<form id="form_borrador_respuesta" name="f1" method="post" action="javascript: validar_historial_atencion(<?php echo $doc->getId()?>)" >
		  <table width="910" border="0" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF" id="mantenimientod">
            <tr>
              <td width="13%" class="Estilo22" ><div align="left">Escribir Respuesta</div></td>
              <td width="2%" > <div align="center">: </div></td>
              <td colspan="5"><textarea name="comentario" cols="100" wrap="physical"></textarea></td>
            </tr>
            <tr>
              <td width="13%" class="Estilo22"><div align="left">Pase a</div></td>
              <td width="2%" class="Estilo22"><div align="center">:</div></td>
              <td colspan="2" ><div align="left">
              <?php

		  $area = new Area($_SESSION['session'][5]);

		  $usuarios = $area->getUsuarios();

		  $tusuarios = sizeof($usuarios);	 ?>

        <select name="usuario" style="width:200px">
          <option value="">--Seleccione un Usuario--</option><?php
		  for($u = 0; $u < $tusuarios; $u++){ ?>
		  	 <option value="<?php echo $usuarios[$u]['id']?>"><?php echo $usuarios[$u]['nombre'].' '.$usuarios[$u]['apellidos'] ?></option>
	<?php
	  }
	?>
        </select>
		<input type="hidden" name="area" value="<?php echo $_SESSION['session'][5] ?>" />
		<input type="hidden" name="user" value="<?php echo $_SESSION['session'][0] ?>" />			  </td>
              <td width="3%" align="left" class="22"><label>
                <div align="center">
                  <input name="categoria" type="radio" value="0" id="0"/>
                </div>
              </label>
                <label></label></td>
              <td width="10%" align="left" class="Estilo22"><div align="left">Original</div></td>
              <td width="31%" >&nbsp;</td>
            </tr>
            <tr>
              <td class="Estilo22" ><div align="left">Acci&oacute;n</div></td>
              <td class="Estilo22"><div align="center">:</div></td>
              <td width="24%" ><div align="left">
                  <?php
		  $acciones = new Acciones();
		  $accions = $acciones->getAcciones();
		  $tacciones = sizeof($accions);	 ?>
                  <select name="accion" style="width:200px">
                    <option value="">--Seleccione Accion--</option>
                    <?php
		  for($u = 0; $u < $tacciones; $u++){ ?>
                    <option value="<?php echo $accions[$u]['id']?>"><?php echo $accions[$u]['nombre']?></option>
                    <?php
		  }?>
                  </select>
              </div></td>
              <td width="17%">&nbsp;</td>
              <td align="left"><div align="center"><span class="22">
                <input name="categoria" type="radio" value="1" id="1"/>
              </span></div></td>
              <td align="left" class="Estilo22"><div align="left"><span >Copia</span></div></td>
              <td ><div align="right">
                <input type="submit" name="guarda_historial" value="Agregar" class="boton" />
              </div></td>
            </tr>
          </table>
		  <table align="center" width="95%" cellpadding="1" cellspacing="1"  id="lista_borradores" class="formularios">
    <tr >
      <td width="6%" height="25" > <div align="center" class="msgok1">Borrador</div> </td>
      <td width="15%" >ORIGEN</td>
      <td width="19%">DESTINO </td>
      <td width="16%" >Fecha y Hora </td>
      <td width="18%">Acci&oacute;n</td>
      <td width="11%" >Categor&iacute;a</td>
      <td width="15%">Opciones </td>
    </tr>
	<?php
		$his = $doc->getHistorialAtencion();
		$tthis = count($his);
        $hayOriginal = 0;

		for( $h = 0; $h < $tthis; $h++ ){  ?>
		<tr class="filas">
		  <td><?php echo $h + 1 ?></td>
		  <td><?php echo $his[$h]['usuario']->GetNombre() ?></td>
		  <td><?php echo $his[$h]['destino']->GetNombre() ?></td>
		  <td><?php echo $his[$h]['fecha'] ?></td>
		  <td><?php echo $his[$h]['accion']->GetNombre() ?></td>
		  <td><?php if($his[$h]['original']==0){$hayOriginal++; echo "original";}else{echo "copia";}?></td>
		  <td><!-- <a href="#"><img src="public_root/imgs/b_view.png" alt="Ver" width="16" height="16" border="0" /></a> &nbsp; <a href="#"><img src="public_root/imgs/b_drop.png" alt="eliminar" width="16" height="16" border="0" /></a> --></td>
		</tr>  	<?php
		}
        if($hayOriginal >0){?>
            <script>javascript:deshabilitado();</script>
        <?
        }
        ?>
  </table>
   	</form>
</fieldset>

		<?php
	}

	function getDocumentosConFiltro(){

		$where = $campo != "" ? " AND d.$campo like '%$valor%' " : ""  ;

		$sql = " SELECT * FROM documentos  ";
		$query = new Consulta($sql);


	}


}
?>