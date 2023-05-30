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
        $titulo='Editar Puesto';
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
                        <h1 class="text-center">Editar un Puesto</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
        <?php
            require_once('clases/Variables_DB.php');
            if (isset($_POST['Enviar'])){
				$nombre=$_POST['Nombre'];
				$descripcion=$_POST['Descripcion'];
                $output_form = false;
				$query="UPDATE `puesto` SET `nombre`='$nombre',`descripcion`='$descripcion' WHERE `id`='".$_POST['id']."'";
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$resultado=mysqli_query($dbc, $query);
				mysqli_close($dbc);
				header('Location: listado_puestos.php?page=1');
            }else { 
                $output_form = true; 
            }
            if ($output_form){ 
				if(isset($_GET['id'])){
					$id=$_GET['id'];
					$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
					$query="SELECT * FROM puesto WHERE id='".$_GET['id']."'";
					$resultado=mysqli_query($dbc, $query);
                    $row=mysqli_fetch_array($resultado);
					if(empty($row['nombre'])){
						header('Location: ultimos_proyectos.php');	
					}
        ?> 
            <br />
            <div>
            <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                <label for="Nombre">Nombre del Puesto:</label>
                <br /> 
                <input id="Nombre" class="form-control" name="Nombre" type="text" size="30" 
                	value="<?php echo $row['nombre']; ?>" required autofocus/>
                <br /> 
                <label for="Descripcion">Descripcion del Puesto:</label>
                <br /> 
                <textarea id="Descripcion" name="Descripcion" type="text" size="30" class="form-control" 
                	value="<?php echo $row['descripcion']; ?>" required></textarea>
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