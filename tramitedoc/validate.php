<? 
require_once("includes.php");
require_once("cls/index.cls.php");
require_once("cls/validar.cls.php");
require_once("cls/session.cls.php");
$link= new Conexion();
$AuthVar['intentos'] = $AuthVar['intentos'] + 1;
if($_POST[control]||$_SESSION[acc][0]){
///nuevo
if(!empty($_POST[T1])&&!empty($_POST[T2])&&!empty($_POST[axo_ingreso])){
	$usu_ing=$_POST[T1]; $pass_ing=$_POST[T2]; $axo_ing=$_POST[axo_ingreso]; 
	$cod_mod=$_POST[cod];
	//$quin_ingreso=$_SESSION[acc][x];
}
else if(!empty($_SESSION[acc][1])&&!empty($_SESSION[acc][2])&&!empty($_SESSION[acc][3])){
	$usu_ing=$_SESSION[acc][1]; $pass_ing=$_SESSION[acc][2]; 
	$axo_ing=$_SESSION[acc][3];	$cod_mod=$_GET[cod]; //$quin_ingreso=$_SESSION[acc][x];
}
///
//if($cod_mod>5) $cod_mod=5; //////por mientras
////
	$ingreso=false;
	$AuthVar['Auth']==false;
	
	$ingreso=Validar::ValidarUsuario($usu_ing,$pass_ing);
	$AuthVar['Auth']=$ingreso;
		if ($AuthVar['Auth']==false){
			echo '
				<html>
				<head>';?>
				<script language="javascript" src="js/js.js"></script>						
				<link rel="stylesheet" type="text/css" href="style.css"><?
				echo '
				</head>
				<body onLoad="verificaru(';
					if ( $AuthVar['intentos'] >= 3 ){
						$AuthVar['intentos'] = 0 ;
						echo '1' ; 
					}else{
						echo '0';
					}
					echo '
				)">
				</body>
				</html>';	
				exit();
		}
	//echo $usu_ing."-".$pass_ing."-".$_POST[axo_ingreso]."-".$_POST[cod]."-".$_POST[control]; 
	$AuthVar['intentos'] = 0;
	$cod_mod=$cod_mod;
	$id_usuario=Validar::ValidarBuscarId($usu_ing);
	$id_mod=Validar::ValidarBuscarModulo($id_usuario);
	
	if(is_array($id_mod)){			?>
																																	
		<script language="JavaScript">
			var id_mod = new Array()
			var cod_mod = "<?=$cod_mod?>"
			var carpeta = new Array()
			var ID_usuarios="<?=$codi_user?>"
		</script>							<?		
																															
		for($c=0;$c<sizeof($id_mod);$c++){	?>	
																																			
			<script>
				id_mod['<?=$c?>']="<?=$id_mod[$c][id]?>"
				carpeta['<?=$c?>']="<?=$id_mod[$c][carpeta]?>"				
			</script>				<?																																				
		}			
	}else{							?>	
																													
		<script language="JavaScript">
			var id_mod = new Array()
			var cod_mod = "<?=$cod_mod?>"
			var carpeta = new Array()
		</script>		<?																																				
	 }					?>
	
																																			
	<script>
		var permiso=false
		var carpeta_actual=""
		for(x=0; x<id_mod.length; x++){
			if(id_mod[x] == cod_mod){
				carpeta_actual=carpeta[x];
				permiso=true; 
			}				
		}
		
		if(!permiso){		
			alert("Usted pertenece como usuario pero no tiene permiso a este modulo.\n Porfavor consulte con el Administrador")					
			top.close();						
		}else{

		}
	</script>	

<script language="javascript">
  screen_height = screen.height;
  screen_width = screen.width;
  left_y = parseInt(screen_width / 2) - parseInt(800 / 2); 
  top_x = parseInt(screen_height / 2) - parseInt(600 / 2); 
	window.moveTo(left_y,top_x);
	if (document.all){
		top.window.resizeTo(811,620);
	}else if (document.layers||document.getElementById) {
		if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
			top.window.outerWidth = 808;
			top.window.outerHeight = 634;
		}
	}
</script>
<script language='javascript' src='js/js.js'></script>
<?
$usuarios=Validar::ValidarListarUsuarios($id_usuario);
$_POST[carpeta]="../".$id_mod[$c][carpeta];

//$cod_mod=$cod_mod;
$id_axo_poa=trim($axo_ing);
$id=$usuarios[0][id_usuario];
$login=$usuarios[0][usuario];
$pass=$usuarios[0][password_usuario];
$nombre=$usuarios[0][nombre_usuario];
$apellido=$usuarios[0][apellido_usuario];
$rol=$usuarios[0][nombre_rol];
$correo=$usuarios[0][correo_usuario];
$idR=$usuarios[0][id_rol];
$titulo="Sistema de Empresarial Inrena 2006";
$AuthVar[modulo]=$cod_mod;
$AuthVar['idu']=$id;
$_SESSION[Module]=$cod_mod;
	if(is_array($usuarios)){
		
		eval( "\$inrena_$cod_mod [1] = \"$id\";" );
		eval( "\$inrena_$cod_mod [2] = \"$id_axo_poa\";" );
		eval( "\$inrena_$cod_mod [3] = \"$login\";" );
		eval( "\$inrena_$cod_mod [4] = \"$pass\";" );
		eval( "\$inrena_$cod_mod [5] = \"$nombre\";" );
		eval( "\$inrena_$cod_mod [6] = \"$apellido\";" );
		eval( "\$inrena_$cod_mod [7] = \"$titulo\";" );
		eval( "\$inrena_$cod_mod [8] = \"$rol\";" );
		eval( "\$inrena_$cod_mod [9] = \"$correo\";" );
		eval( "\$inrena_$cod_mod [R] = \"$idR\";" );
		//eval( "\$inrena_$cod_mod [Q] = \"$quin_ingreso\";" );
		
		if(session_is_registered('inrena_'.$cod_mod)){
			
			eval( "\$inrena_$cod_mod [1] = \"$id\";" );
			eval( "\$inrena_$cod_mod [2] = \"$id_axo_poa\";" );
			eval( "\$inrena_$cod_mod [3] = \"$login\";" );
			eval( "\$inrena_$cod_mod [4] = \"$pass\";" );
			eval( "\$inrena_$cod_mod [5] = \"$nombre\";" );
			eval( "\$inrena_$cod_mod [6] = \"$apellido\";" );
			eval( "\$inrena_$cod_mod [7] = \"$titulo\";" );
			eval( "\$inrena_$cod_mod [8] = \"$rol\";" );
			eval( "\$inrena_$cod_mod [9] = \"$correo\";" );
			eval( "\$inrena_$cod_mod [R] = \"$idR\";" );
			//eval( "\$inrena_$cod_mod [Q] = \"$quin_ingreso\";" );
			
		}else{
			session_register('inrena_'.$cod_mod);
		}
		///modificado
		?><script>
			cuerpo = centrar_popup(screen.availWidth,screen.availHeight);
			window.open(carpeta_actual,'_self',cuerpo);
			FullScreen();
		</script>
	<?	
	}else{
		?>
		<script>
		if(confirm("No se puede iniciar la session puesto que usted esta tratande ingresar en una forma inapropiada\nHaga click en aceptar para reinicar su PC.")){
			alert("Intruzo!!!!!")
		}else{alert("Intruzo!!!!!")}
			window.opener = "madre"
			cuerpo = centrar_popup(800,600);
 			window.open("error_ingreso.php",'inrena_<?=$_POST[cod_mod]?>',cuerpo);
			top.close();
		</script>
		<?
		exit;
	}
}
?>