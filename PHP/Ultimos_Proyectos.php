<?php
	require_once('Variables_DB.php');
	if(isset($_POST['Peticion'])){
		$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
		$query="SELECT * FROM proyectos WHERE estado='Activo' ORDER BY prioridad ASC";
		$resultado=mysqli_query($dbc, $query);
		$lineas=mysqli_num_rows($resultado);
		$contador=0;
		echo '{"Proyectos":[';
		while($row=mysqli_fetch_array($resultado)){
			$contador=$contador+1;
			echo '{"id":"'.$row['id'].'", "idCliente":"'.$row['idCliente'].'", "nombre":"'.
				$row['nombre'].'", "descripcion":"'.$row['descripcion'].'", "fechaEntrega":"'.
				$row['fechaEntrega'].'", "prioridad":"'.$row['prioridad'].'", "estado":"'.
				$row['estado'].'"}';
			if($lineas!=$contador)
				echo ', ';
		}
		echo ']}';
		mysqli_close($dbc);
	}
?>