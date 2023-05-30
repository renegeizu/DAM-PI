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
        $titulo='Insertar Proyecto';
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
						<h1 class="text-center">Inserta un Nuevo Proyecto</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
        <?php
            require_once('clases/Variables_DB.php');
            if (isset($_POST['Enviar'])){
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$idCliente=$_POST['Cliente'];
				$nombre=$_POST['Nombre'];
				$descripcion=$_POST['Descripcion'];
				$fecha=$_POST['Fecha'];
				$prioridad=$_POST['Prioridad'];
				$estado=$_POST['Estado'];
                $output_form = false;
				$query="INSERT INTO `proyectos`(`idCliente`, `nombre`, `descripcion`, `fechaEntrega`, `prioridad`,".
					" `estado`) VALUES ('$idCliente','$nombre','$descripcion','$fecha','$prioridad','$estado')";
				$resultado=mysqli_query($dbc, $query);
				mysqli_close($dbc);
				header('Location: listado_proyectos.php?page=1&order=fechaEntrega');
            }else { 
                $output_form = true; 
            }
            if ($output_form){ 
        ?> 
                    <br />
                    <div>
                        <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                            <label for="Cliente">Cliente:</label>
                            <br /> 
                            <?php
                                $dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
                                $query="SELECT id, nombre, empresa FROM clientes";
                                $resultado=mysqli_query($dbc, $query);
                                $combo='<SELECT class="form-control" NAME="Cliente" SIZE=1>';
                                while ($row=mysqli_fetch_array($resultado)){
                                    $combo=$combo.'<OPTION VALUE="'.$row['id'].'">'.$row['nombre']." - ".$row['empresa'].
										'</OPTION>';
                                }
                                echo $combo.'</SELECT>';
                            ?>
                            <br /> 
                            <label for="Nombre">Nombre del Proyecto:</label>
                            <br /> 
                            <input id="Nombre" name="Nombre" type="text" class="form-control"  size="30" required autofocus/>
                            <br />
                            <label for="Descripcion">Descripcion del Proyecto:</label>
                            <br /> 
                            <textarea id="Descripcion" name="Descripcion" class="form-control" 
                            	type="text" size="300" rows="3" required></textarea>
                            <br />
                            <label for="Fecha">Fecha de Entrega:</label>
                            <br /> 
                            <input id="Fecha" name="Fecha" type="date" size="30" class="form-control" required />
                            <br />
                            <label for="Prioridad">Prioridad del Proyecto:</label>
                            <br /> 
                            <select class="form-control" name="Prioridad" size="1">
                                <option value="1">Maxima</option>
                                <option value="2">Media</option>
                                <option value="3">Baja</option>
                            </select>
                            <br />
                            <label for="Estado">Estado Actual del Proyecto:</label>
                            <br /> 
                            <select class="form-control" name="Estado" size="1">
                                <option value="Activo">Proyecto Activo</option>
                                <option value="Desactivo">Proyecto Desactivado</option>
                            </select>
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