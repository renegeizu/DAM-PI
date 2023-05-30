<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
	if(!isset($_SESSION['User'])){
		header('Location: index.php');	
	}
	if($_GET['id']){
		require_once('clases/Variables_DB.php');
		$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
		$query="DELETE FROM `puesto` WHERE id='".$_GET['id']."'";
		mysqli_query($dbc, $query);
		mysqli_close($dbc);
	}
	header('Location: listado_puestos.php?page=1');
?>