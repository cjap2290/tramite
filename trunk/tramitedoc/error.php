<?
if (empty($_GET[x])){
header("Location: {$_SERVER['PHP_SELF']}?x=1");
exit();
}
?>
	<script>
		top.location="../error_ingreso.php"
	</script>


