<?php
	require_once('Variables_DB.php');
	if(isset($_POST['Peticion'])){
		$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
		$query="SELECT u.id, u.user, u.pass, u.nombre, u.fechaNacimiento, u.dni, ".
		"u.telefono, u.email, p.nombre as puesto FROM Usuarios u INNER JOIN puesto p ON u.idPuesto=p.id";
		$resultado=mysqli_query($dbc, $query);
		$lineas=mysqli_num_rows($resultado);
		$contador=0;
		echo '{"Empleados":[';
		while($row=mysqli_fetch_array($resultado)){
			$contador=$contador+1;
			echo '{"id":"'.$row['id'].'", "user":"'.$row['user'].'", "pass":"'.$row['pass'].
				'", "nombre":"'.$row['nombre'].'", "fechaNacimiento":"'.$row['fechaNacimiento'].
				'", "dni":"'.$row['dni'].'", "telefono":"'.$row['telefono'].
				'", "email":"'.$row['email'].'", "puesto":"'.$row['puesto'].'"}';
			if($lineas!=$contador)
				echo ', ';
		}
		echo ']}';
		mysqli_close($dbc);
	}
?>