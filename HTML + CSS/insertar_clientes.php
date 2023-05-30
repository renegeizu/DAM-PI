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
        $titulo='Insertar Cliente';
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
	        			<h1 class="text-center">Inserta un Nuevo Cliente</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
        <?php
            require_once('clases/Variables_DB.php');
            if (isset($_POST['Enviar'])){
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$nombre=$_POST['Nombre'];
				$empresa=$_POST['Empresa'];
				$telefono=$_POST['Telefono'];
				$email=$_POST['Email'];
                $output_form = false;
				$query="INSERT INTO `clientes`(`nombre`, `empresa`, `telefono`, `email`) VALUES".
					" ('$nombre','$empresa','$telefono','$email')";
				$resultado=mysqli_query($dbc, $query);
				mysqli_close($dbc);
				header('Location: listado_clientes.php?page=1&order=empresa');
            }else { 
                $output_form = true; 
            }
            if ($output_form){ 
        ?> 
                    <br />
                    <div>
                        <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                            <label for="Nombre">Nombre del Cliente:</label>
                            <br /> 
                            <input id="Nombre" name="Nombre" type="text" size="30" class="form-control" required autofocus/>
                            <br /> 
                            <label for="Empresa">Nombre de la Empresa:</label>
                            <br /> 
                            <input id="Empresa" name="Empresa" type="text" size="30" class="form-control" required />
                            <br />
                            <label for="Telefono">Tel&eacute;fono del Cliente:</label>
                            <br /> 
                            <input id="Telefono" name="Telefono" type="tel" size="30" class="form-control" required />
                            <br />
                            <label for="Email">Email del Cliente:</label>
                            <br /> 
                            <input id="Email" name="Email" type="text" size="30" class="form-control" required />
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