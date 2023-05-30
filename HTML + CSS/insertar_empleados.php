<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
	if($_SESSION['Puesto']!='Jefe'){
		header('Location: ultimos_proyectos.php');
	}
?>
<html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php 
        $titulo='Insertar Empleados';
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
        				<h1 class="text-center">Inserta un Nuevo Empleado</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
        <?php
            require_once('clases/Variables_DB.php');
            if (isset($_POST['Enviar'])){
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$user=$_POST['User'];
				$pass=$_POST['Pass'];
				$nombre=$_POST['Nombre'];
				$fecha=$_POST['Fecha'];
				$dni=$_POST['DNI'];
				$telefono=$_POST['Telefono'];
				$email=$_POST['Email'];
				$puesto=$_POST['Puesto'];
                $output_form = false;
				$query="INSERT INTO `usuarios`(`user`, `pass`, `nombre`, `fechaNacimiento`, `dni`, `telefono`, `email`,".
					" `idPuesto`) VALUES ('$user',SHA('$pass'),'$nombre','$fecha','dni',".
					"'$telefono','$email','$puesto')";
				$resultado=mysqli_query($dbc, $query);
				mysqli_close($dbc);
				header('Location: listado_empleados.php?page=1&order=user');
            }else { 
                $output_form = true; 
            }
            if ($output_form){ 
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$query="SELECT id, nombre FROM puesto";
				$resultado=mysqli_query($dbc, $query);
        ?> 
                    <br />
                    <div>
                        <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                            <label for="User">Usuario:</label>
                            <br /> 
                            <input id="User" name="User" type="text" size="30" class="form-control" required autofocus />
                            <br /> 
                            <label for="Pass">Contrase&ntilde;a:</label>
                            <br /> 
                            <input id="Pass" name="Pass" type="password" size="30" class="form-control" required />
                            <br />
                            <label for="Nombre">Nombre del Empleado:</label>
                            <br /> 
                            <input id="Nombre" name="Nombre" type="text" size="30" class="form-control" required />
                            <br />
                            <label for="Fecha">Fecha de Nacimiento:</label>
                            <br /> 
                            <input id="Fecha" name="Fecha" type="date" size="30" class="form-control" required />
                            <br />
                            <label for="DNI">DNI del Empleado:</label>
                            <br /> 
                            <input id="DNI" name="DNI" type="text" size="30" class="form-control" required />
                            <br />
                            <label for="Telefono">Tel&eacute;fono del Empleado:</label>
                            <br /> 
                            <input id="Telefono" name="Telefono" type="tel" size="30" class="form-control" required />
                            <br />
                            <label for="Email">Email del Empleado:</label>
                            <br /> 
                            <input id="Email" name="Email" type="email" size="30" class="form-control" required />
                            <br />
                            <label for="Puesto">Puesto:</label>
                            <br /> 
                            <?php
                                $combo='<SELECT class="form-control" NAME="Puesto" SIZE=1>';
                                while ($row=mysqli_fetch_array($resultado)){
                                    $combo=$combo.'<OPTION VALUE="'.$row['id'].'">'.$row['nombre'].'</OPTION>';
                                }
                                echo $combo.'</SELECT>';
                            ?>
                            <br />
                            <input class="btn btn-primary" type="submit" name="Enviar" value="Enviar" /> 
                        </form> 
                    </div>
              	</div>
            </div>
        </div>
    </div>
        <?php 
            }
            require_once('clases/footer.php');
        ?>
	</body>
</html>