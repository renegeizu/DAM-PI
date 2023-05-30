<?php
	require_once('Variables_DB.php');
	if(isset($_POST['User'])&&isset($_POST['Pass'])){
		$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
		$query="SELECT u.id, u.user, u.pass, p.nombre as 'puesto' FROM usuarios u INNER JOIN puesto p".
			" ON u.idPuesto=p.id WHERE u.user='".$_POST['User']."' AND pass=SHA('".$_POST['Pass']."')";
		$resultado=mysqli_query($dbc, $query);
		$lineas=mysqli_num_rows($resultado);
		$contador=0;
		if($lineas==0){
			echo '{"Empleados":[{"id":"-1", "user":"-1", "pass":"-1", "puesto":"-1"}]}';
		}else{
			echo '{"Empleados":[';
			while($row=mysqli_fetch_array($resultado)){
				$contador=$contador+1;
				echo '{"id":"'.$row['id'].'", "user":"'.$row['user'].'", "pass":"'.
					$row['pass'].'", "puesto":"'.$row['puesto'].'"}';
				if($lineas!=$contador)
					echo ', ';
			}
			echo ']}';
		}
		mysqli_close($dbc);
	}
?>