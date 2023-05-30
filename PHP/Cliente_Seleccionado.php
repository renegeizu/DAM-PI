<?php
	require_once('Variables_DB.php');
	if(isset($_POST['Peticion'])){
		$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
		$query="SELECT * FROM Clientes WHERE id='".$_POST['idCliente']."'";
		$resultado=mysqli_query($dbc, $query);
		$lineas=mysqli_num_rows($resultado);
		$contador=0;
		echo '{"Clientes":[';
		while($row=mysqli_fetch_array($resultado)){
			$contador=$contador+1;
			echo '{"id":"'.$row['id'].'", "nombre":"'.$row['nombre'].'", "empresa":"'.
				$row['empresa'].'", "telefono":"'.$row['telefono'].'", "email":"'.$row['email'].'"}';
			if($lineas!=$contador)
				echo ', ';
		}
		echo ']}';
		mysqli_close($dbc);
	}
?>