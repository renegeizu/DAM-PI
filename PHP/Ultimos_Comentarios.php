<?php
	require_once('Variables_DB.php');
	if(isset($_POST['Peticion'])){
		$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
		$query="SELECT u.user, c.comentario FROM comentarios c INNER JOIN usuarios u ON c.idUser=u.id WHERE idProyecto='".
		$_POST['Id']."' ORDER BY c.fechaHora DESC, c.id DESC";
		$resultado=mysqli_query($dbc, $query);
		$lineas=mysqli_num_rows($resultado);
		$contador=0;
		if($lineas==0){
			echo '{"Comentarios":[{"id":"-1", "nombre":"-1", "empresa":"-1", "telefono":"-1", "email":"-1"}]}';
		}else{
			echo '{"Comentarios":[';
			while($row=mysqli_fetch_array($resultado)){
				$contador=$contador+1;
				echo '{"user":"'.$row['user'].'", "comentario":"'.$row['comentario'].'"}';
				if($lineas!=$contador)
					echo ', ';
			}
			echo ']}';
		}
		mysqli_close($dbc);
	}
?>