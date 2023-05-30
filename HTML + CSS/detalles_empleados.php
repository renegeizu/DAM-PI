<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
?>
<html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php 
        $titulo='Detalles Empleados';
        require_once('clases/header.php'); 
    ?>
    <div class="container">
        <div class="row">
            <div class="encabezado col-md-10 col-md-offset-1">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" style="padding-top:5px; padding-bottom:5px;">
            </div>
        </div>
    </div>
    <?php
		require_once('clases/navigation.php');
	?>
    <div class="container">
            <div class="row">
              	<div class="col-md-10 col-md-offset-1" style="padding-top:5px; padding-bottom:5px;">
          		</div>
          	</div>
        </div>
        <div class="container">
  			<div class="row">
            	<div class="col-md-10 col-md-offset-1 caja">
                    <div class="col-md-12">
						<h1 class="text-center">Detalles del Empleado</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
		<?php
			if(isset($_GET['id'])){
				require_once('clases/Variables_DB.php');
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$query="SELECT u.user, u.nombre, u.fechaNacimiento, u.dni, u.telefono, u.email, p.nombre AS 'puesto'".
					" FROM usuarios u INNER JOIN puesto p ON u.idPuesto=p.id WHERE u.id='".$_GET['id']."'";
				$resultado=mysqli_query($dbc, $query);
				while ($row=mysqli_fetch_array($resultado)) {
					echo '<div>';
					echo '<p>Nickname del Empleado: '.$row['user'].'</p>';
					echo '<p>Nombre del Empleado: '.$row['nombre'].'</p>';
					echo '<p>Fecha de Nacimiento: '.$row['fechaNacimiento'].'</p>';
					echo '<p>DNI del Empleado: '.$row['dni'].'</p>';
					echo '<p>Telefono del Empleado: '.$row['telefono'].'</p>';
					echo '<p>Email del Empleado: '.$row['email'].'</p>';
					echo '<p>Puesto del Empleado: '.$row['puesto'].'</p>';
					echo '</div>';
				}
				mysqli_close($dbc);
			}
		?>
        			</div>
        		</div>
            </div>
        </div>
        <?php
			require_once('clases/footer.php');
		?>
	</body>
</html>