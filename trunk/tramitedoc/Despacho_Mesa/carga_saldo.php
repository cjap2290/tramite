<? 
	//session_start();
	include("includes.php");
	//require_once("../libs/lib.php");
	require_once("cls/acceso_registro.cls.php");
	$link=new Conexion();
	/*if($lectura){
		session_register('acceso');
		$_SESSION['acceso']['lectura']=$lectura;
		$_SESSION['acceso']['escritura']=$escritura;
	}*/

?>
<? 

					
 $sql_prioridad="SELECT t_prioridad.t_prioridad_id, t_prioridad.t_prioridad_descrip, t_prioridad.t_prioridad_tiemporespuesta
						FROM t_prioridad
						where 
						t_prioridad.t_prioridad_id='".$_GET['id_total']."'
						
						ORDER BY t_prioridad.t_prioridad_id ASC";
    	
					$d_prioridad=new Consulta($sql_prioridad);
					$dol_prio=$d_prioridad->ConsultaVerRegistro(); 
					
		
			///$saldo=number_format($sal_tot,2,".",",");
			 ?>
      <input name="saldo" type="text" bgcolor="#999999" value="<?=$dol_prio[2]?>" size="10" readonly="" id="saldo" />
