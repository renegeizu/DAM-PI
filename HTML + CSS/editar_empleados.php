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
        $titulo='Editar Empleado';
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
                     	<h1 class="text-center">Editar un Empleado</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
        <?php
            require_once('clases/Variables_DB.php');
            if (isset($_POST['Enviar'])){
				$user=$_POST['User'];
				$pass=$_POST['Pass'];
				$nombre=$_POST['Nombre'];
				$fecha=$_POST['Fecha'];
				$dni=$_POST['DNI'];
				$telefono=$_POST['Telefono'];
				$email=$_POST['Email'];
				$puesto=$_POST['Puesto'];
                $output_form = false;
				if($pass=='******'){
					$query="UPDATE `usuarios` SET `user`='$user',`nombre`='$nombre',".
					"`fechaNacimiento`='$fecha',`dni`='$dni',`telefono`='$telefono',`email`='$email',".
					"`idPuesto`='$puesto' WHERE `id`='".$_POST['id']."'";
				}else{
					$query="UPDATE `usuarios` SET `user`='$user',`pass`=SHA('$pass'),`nombre`='$nombre',".
					"`fechaNacimiento`='$fecha',`dni`='$dni',`telefono`='$telefono',`email`='$email',".
					"`idPuesto`='$puesto' WHERE `id`='".$_POST['id']."'";
				}
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$resultado=mysqli_query($dbc, $query);
				mysqli_close($dbc);
				header('Location: listado_empleados.php?page=1&order=user');
            }else { 
                $output_form = true; 
            }
            if ($output_form){ 
				if(isset($_GET['id'])){
					$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
					$query="SELECT * FROM usuarios WHERE id='".$_GET['id']."'";
					$resultado=mysqli_query($dbc, $query);
                    $row=mysqli_fetch_array($resultado);
					if(empty($row['nombre'])){
						header('Location: ultimos_proyectos.php');	
					}
        ?> 
            <br />
            <div>
            <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                <label for="User">Usuario:</label>
                <br /> 
                <input id="User" name="User" type="text" size="30" class="form-control"  
                	value="<?php echo $row['user']; ?>" required autofocus />
                <br /> 
                <label for="Pass">Contrase&ntilde;a:</label>
                <br /> 
                <input id="Pass" name="Pass" type="password" class="form-control"  size="30" value="******" required />
                <br />
                <label for="Nombre">Nombre del Empleado:</label>
                <br /> 
                <input id="Nombre" name="Nombre" type="text" class="form-control" size="30" 
                	value="<?php echo $row['nombre']; ?>" required />
                <br />
                <label for="Fecha">Fecha de Nacimiento:</label>
                <br /> 
                <input id="Fecha" name="Fecha" type="date" size="30" class="form-control" 
                	value="<?php echo $row['fechaNacimiento']; ?>" required />
                <br />
                <label for="DNI">DNI del Empleado:</label>
                <br /> 
                <input id="DNI" name="DNI" type="text" size="30" class="form-control" 
                	value="<?php echo $row['dni']; ?>" required />
                <br />
                <label for="Telefono">Tel&eacute;fono del Empleado:</label>
                <br /> 
                <input id="Telefono" name="Telefono" type="tel" size="30" class="form-control" 
                	value="<?php echo $row['telefono']; ?>" required />
                <br />
                <label for="Email">Email del Empleado:</label>
                <br /> 
                <input id="Email" name="Email" type="email" size="30" class="form-control" 
                	value="<?php echo $row['email']; ?>" required />
                <br />
                <label for="Puesto">Puesto:</label>
                <br /> 
                <?php
					$id=$row['idPuesto'];
					$query="SELECT id, nombre FROM puesto";
					$resultado=mysqli_query($dbc, $query);
					$combo='<SELECT class="form-control" NAME="Puesto" SIZE=1>';
					while ($row=mysqli_fetch_array($resultado)){
						if($id==$row['id']){
							$combo=$combo.'<OPTION VALUE="'.$row['id'].'" SELECTED>'.$row['nombre'].'</OPTION>';
						}else{
							$combo=$combo.'<OPTION VALUE="'.$row['id'].'">'.$row['nombre'].'</OPTION>';
						}
					}
					echo $combo.'</SELECT>';
				?>
                <br />
                <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id" />
                <input class="btn btn-primary" type="submit" name="Enviar" value="Enviar" /> 
            </form> 
            </div>
        <?php 
				}
            }
			echo '</div></div></div></div></div>';
            require_once('clases/footer.php');
        ?>
	</body>
</html>