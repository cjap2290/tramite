<?
class PresupuestoMensualPorPartidas extends SqlSelect {
var $md=false;
var $simbolomd=" S/. ";
var $sql;
var $ftefto;
var $APartidas;



	function PresupuestoMensualPorPartidas(){
	
	
	$this->SqlSelect($_SESSION['anp']['idanp'],$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1],$_POST["idmes"]);
		$sql="SELECT m.*
FROM
`programacion_partidas_meses` AS `ppm`
Inner Join `programacion_partidas` AS `pp` ON `ppm`.`id_programacion_partidas` = `pp`.`id_programacion_partidas`
Inner Join `asignacion_ff_anp_objetivos` AS `afao` ON `afao`.`id_asignacion_ff_anp_objetivos` = `pp`.`id_ff_anp_subactividad`
Inner Join `asignacion_anp_objetivos` AS `aao` ON `aao`.`id_asignacion_anp_objetivos` = `afao`.`id_asignacion_anp_objetivos`
Inner Join `presupuesto_anp` AS `pa` ON `pa`.`id_presupuesto_anp` = `afao`.`id_presupuesto_anp`
Inner Join `presupuesto_ff` AS `pf` ON `pf`.`id_presupuesto_ff` = `pa`.`id_presupuesto_ff`
Inner Join `fuente_financiamiento` AS `ff` ON `ff`.`id_ff` = `pf`.`id_ff`
Inner Join `anp_objetivo_especifico` AS `aoesp` ON `aoesp`.`id_anp_objetivo_especifico` = `aao`.`id_anp_objetivo_especifico`
Inner Join `tarea` AS `t` ON `t`.`id_tarea` = `aao`.`id_tarea`
Inner Join `anp_objetivo_estrategico` AS `aoest` ON `aoest`.`id_anp_objetivo_estrategico` = `aoesp`.`id_anp_objetivo_estrategico`
Inner Join `objetivo_estrategico` AS `oe` ON `oe`.`id_objetivo_estrategico` = `aoest`.`id_objetivo_estrategico`
Inner Join `mes` AS `m` ON `ppm`.`id_mes` = `m`.`id_mes`
WHERE
aao.id_anp =  '".$_SESSION['anp']['idanp']."' AND
aao.id_axo_poa =  '".$_SESSION["inrena_4"][2]."'

GROUP BY
`ppm`.`id_mes`";
$Q_m=new Consulta($sql);?>
					
			
	<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
body {
	background-color: #c0cccc;
}
body,td,th {
	color: #333300;
}
-->
    </style>
	
	
	<form name="mes" method="post" action="">
	<label>
  <div align="center"><span class="Estilo1">Seleccione el Mes</span><br />
    <select name="idmes" onchange="submit()">
      <option value="0">Elija el Mes</option>
	 <? 
			while($row_m=$Q_m->ConsultaVerRegistro()){
				if($_POST[idmes]==$row_m[0]) $select="selected"; else $select=""; ?>	
						<option value="<?=$row_m[0]?>" <?=$select?> ><?=$row_m[1]?></option><?				
			}	
		?> 
    </select>
  </div>
  </label>
  </form>
 	
	<?	}
	
	
	
 
	
	function mostrar_ff_k($fuente=''){
		
		$funcjs=" mostrar_presupuestmensualporpartidas";
		Verkff($funcjs,$this);	 
		
	}


	function setsql($sql=''){
		//$sqlmultiplicarxtc="/ pf.tipo_cambio_ff";
			$selmescampos="sum(monto_programacion_partidas_meses) as total_monto, id_partida";
		if ($this->md){
			$selmescampos="sum(monto_programacion_partidas_meses / tipo_cambio_ff) as total_monto, id_partida ";
		}
		
		$this->sql=$this->set_sql($selmescampos,$sql,"id_partida","id_partida");
		
		//die ($this->sql);
		//$selmescampos="sum(monto_programacion_partidas_meses) as total_monto,  id_mes, pf.tipo_cambio_ff ";
		//$this->sql=$this->set_sql($selmescampos,$sql,"id_mes,pf.id_ff","pf.id_ff,id_mes");
	
	
		
		
		return 	$selmescampos;
	}

	function ListarPartidas(){
		$sqlFfts=$this->SqlFtt($this->ftefto);
		$sqlPartidas=$this->set_sql("pp.id_partida",$sqlFfts,"pp.id_partida","partida.codigo_partida","partida");
		//die ($sqlPartidas);
		$query=new Consulta($sqlPartidas);
		while($row=$query->ConsultaVerRegistro()){
			$row_p=table_row($row[id_partida],"partida");
			$APartidas[]=array(id_partida=>$row_p[id_partida],codigo_partida=>$row_p[codigo_partida]);
		}
		$this->APartidas=$APartidas;
		return $APartidas;
	}

	function mostarSiglaFtt($idff){
		$row=table_row($idff,"fuente_financiamiento","id_ff");
		return $row[siglas_ff];
	}
	
	function mostrar_Presupuesto(){
		$gsqlp=$this->SqlFts;
		$sqlg=$gsqlp;
		$this->setsql($gsqlp);

			  //OBJ Estrat ///////////////////////////////////////////////////////////////////////
				//die ()
				$sqlprg=$this->set_sql("oe.*,m.*",$gsqlp,"oe.id_objetivo_estrategico","codigo_objetivo_estrategico");
				$query=new Consulta($sqlprg);
				while($row_prg=$query->ConsultaVerRegistro()){
					//$prg=table_row($row_prg[id_programa],"objetivo_estrategico");
					$prg[total_monto]=$row_prg[total_monto];
						$gsqlsp=$gsqlp." AND m.id_mes='".$_POST[idmes]."' and oe.id_objetivo_estrategico='".$row_prg[id_objetivo_estrategico]."'";
						$this->setsql($gsqlsp);
						
						$this->registro_programa($row_prg,$ftefto);
					
						//OBJETIVO ESPECIFICO///////////////////////////////////////////////////////////////////////
					$sql_sb=$this->set_sql("aoesp.*,m.*",$gsqlsp,"aoesp.id_anp_objetivo_especifico ","codigo_objetivo_especifico");
						$query_sb=new Consulta($sql_sb);
						while($row_sb=$query_sb->ConsultaVerRegistro()){ 
							//$sbprg=table_row($row_sb[id_subprograma],"subprograma");
							
							$gsqla=$gsqlsp." AND aoesp.id_anp_objetivo_especifico= '".$row_sb[id_anp_objetivo_especifico]."' AND m.id_mes='".$_POST[idmes]."'";
							$this->setsql($gsqla);
							
							//regitro sub programa
							$this->registro_subprograma($row_prg,$row_sb,$ftefto);
							
							//TAREA///////////////////////////////////////////////////////////////////////
								$sql_a=$this->set_sql("t.*,aao.*,afao.*,m.*", $gsqla, "t.id_tarea", "aao.nro_asignacion");
								$query_a=new Consulta($sql_a);
								while($row_a=$query_a->ConsultaVerRegistro()){ 
									//$actividad=table_row($row_a[id_actividad],"actividad");
									$gsqlsa=$gsqla."  AND t.id_tarea='".$row_a[id_tarea]."'  AND m.id_mes='".$_POST[idmes]."'";
									$this->setsql($gsqlsa);
									
									$this->registro_actividad($row_prg,$row_sb,$row_a,$ftefto);
								
								} // fin actividad
						} //fin sub programa
			  	}//fin programa
			
			$this->setsql($sqlg);
			$this->fin_de_registros($ftefto);
	}
	
	function fin_de_registros(){
		$cls="Estilo3"; 
		$td=$this->generar_td($cls);
		echo 	'<tr bgcolor=#999999>
				<td class="'.$cls.'" valign="top">&nbsp;</td>
				<td class="'.$cls.'" valign="top" align="center">TOTAL '.$this->simbolomd.' </td>	'.$td;
				
	}
	
	function registro_programa($prg,$ftefto){
						$cls="Estilo3"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#999999><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].'</td>
						<td class="'.$cls.'" valign="top" >'.$prg[nombre_objetivo_estrategico].'</td>
						'.$td;
						 
	}

	function registro_subprograma($prg,$sbprg,$ftefto){
						$cls="Estilo3"; 
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#cccccc><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].'</td>
						<td class="'.$cls.'" valign="top" >'.$sbprg[nombre_objetivo_especifico].'</td>
						'.$td;
	}


	function registro_actividad($prg,$sbprg,$actividad,$ftefto){
						//$cls="tdact";
						$cls="Estilo3";  
						$td=$this->generar_td($cls);
						echo '<tr bgcolor=#FFFFFF><td class="'.$cls.'" valign="top" >'.$prg[codigo_objetivo_estrategico].
							".".$sbprg[codigo_objetivo_especifico].".".$actividad[nro_asignacion].'</td>
						<td class="'.$cls.'" valign="top" >'.$actividad[nombre_tarea].'</td>
						'.$td;
	}

	/*function registro_subactividad($subactividad){
						$cls="tdsubact"; 
						$td=$this->generar_td($cls,$subactividad);
						echo '<tr><td class="'.$cls.'" valign="top" >'.$subactividad[codigo_completo_subactividad].'&nbsp;</td>
						<td class="'.$cls.'" valign="top" >'.$subactividad[nombre_subactividad].'&nbsp;</td> 
						'.$td;
	}*/


	function generar_td($cls){
			$monto=sumar_partidas_programado_tareas($this->sql);
			$td='';
			$Partidas=$this->APartidas;
			for ($i=0;$i<count($Partidas);$i++){
				$id=$Partidas[$i][id_partida];
					if ($monto[$id]==0){
						$monto[$id]="&nbsp;";
					}
					
					$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[$id].'</td>';
			}
			$td.='<td class="'.$cls.'" valign="top"  nowrap="nowrap" align="right">'.$monto[0].'</td>
					</tr>';
			return $td;
			
	}
	
	
	

}
?>

