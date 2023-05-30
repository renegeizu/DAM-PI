<?php
	require_once('Variables_DB.php');
	if(isset($_POST['Peticion'])){
		$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
		$query="INSERT INTO comentarios (idUser, idProyecto, comentario, fechaHora) VALUES (".
			$_POST['idUser'].",".$_POST['idProyecto'].",".$_POST['comentario'].",".
			$_POST['fechaHora'].")";
		$result=mysqli_query($dbc, $query) or die ("0");
		mysqli_close($dbc);
	}
?>