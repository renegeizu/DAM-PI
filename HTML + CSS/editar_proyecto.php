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
        $titulo='Editar Proyecto';
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
                        <h1 class="text-center">Editar un Proyecto</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
        <?php
            require_once('clases/Variables_DB.php');
            if (isset($_POST['Enviar'])){
				$idCliente=$_POST['Cliente'];
				$nombre=$_POST['Nombre'];
				$descripcion=$_POST['Descripcion'];
				$fecha=$_POST['Fecha'];
				$prioridad=$_POST['Prioridad'];
				$estado=$_POST['Estado'];
                $output_form = false;
				$query="UPDATE `proyectos` SET `idCliente`='$idCliente',`nombre`='$nombre',".	
				"`descripcion`='$descripcion',`fechaEntrega`='$fecha',`prioridad`='$prioridad',`estado`='$estado'".
				" WHERE `id`='".$_POST['id']."'";
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$resultado=mysqli_query($dbc, $query);
				mysqli_close($dbc);
				header('Location: listado_proyectos.php?page=1&order=fechaEntrega');
            }else { 
                $output_form = true; 
            }
            if ($output_form){ 
				if(isset($_GET['id'])){
					$id=$_GET['id'];
					$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
					$query="SELECT * FROM proyectos WHERE id='".$id."'";
                    $resultado=mysqli_query($dbc, $query);
                    $row=mysqli_fetch_array($resultado);
					if(empty($row['nombre'])){
						header('Location: ultimos_proyectos.php');	
					}
					$query="SELECT id, nombre, empresa FROM clientes";
					$result=mysqli_query($dbc, $query);
        ?> 
                        <br />
                        <div>
                        <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                            <label for="Cliente">Cliente:</label>
                            <br /> 
                            <?php
                                $combo='<SELECT class="form-control" NAME="Cliente" SIZE=1>';
                                while ($row1=mysqli_fetch_array($result)){
									if($row1['id']==$row['idCliente']){
										$combo=$combo.'<OPTION VALUE="'.$row1['id'].'" selected>'.$row1['nombre'].
											" - ".$row1['empresa'].'</OPTION>';
									}else{
										$combo=$combo.'<OPTION VALUE="'.$row1['id'].'">'.$row1['nombre'].
											" - ".$row1['empresa'].'</OPTION>';
	
									}
                                }
                                echo $combo.'</SELECT>';
                            ?>
                            <br />
                            <label for="Nombre">Nombre del Proyecto:</label>
                            <br /> 
                            <input class="form-control" id="Nombre" name="Nombre" type="text" size="30" 
                            	value="<?php echo $row['nombre']; ?>" required autofocus />
                            <br />
                            <label for="Descripcion">Descripcion del Proyecto:</label>
                            <br /> 
                            <textarea class="form-control" id="Descripcion" name="Descripcion" type="text" 
                            	size="300" rows="3" required><?php echo $row['descripcion']; ?></textarea>
                            <br />
                            <label for="Fecha">Fecha de Entrega:</label>
                            <br /> 
                            <input id="Fecha" name="Fecha" type="date" size="30" class="form-control"  
                            	value="<?php echo $row['fechaEntrega']; ?>" required />
                            <br />
                            <label for="Prioridad">Prioridad del Proyecto:</label>
                            <br /> 
                            <select class="form-control" name="Prioridad" size="1">
                                <?php
                                    $opciones="";
                                    if($row['prioridad']==1){
                                        $opciones=$opciones.'<option value="1" selected>Maxima</option>';
                                    }else{
                                        $opciones=$opciones.'<option value="1">Maxima</option>';
                                    }
                                    if($row['prioridad']==2){
                                        $opciones=$opciones.'<option value="2" selected>Media</option>';
                                    }else{
                                        $opciones=$opciones.'<option value="2">Media</option>';
                                    }
                                    if($row['prioridad']==3){
                                        $opciones=$opciones.'<option value="3" selected>Baja</option>';
                                    }else{
                                        $opciones=$opciones.'<option value="3">Baja</option>';
                                    }
                                    echo $opciones;
                                ?>
                            </select>
                            <br />
                            <label for="Estado">Estado Actual del Proyecto:</label>
                            <br /> 
                            <select class="form-control"  name="Estado" size="1">
                                <?php
                                    $opciones="";
                                    if($row['estado']=='Activo'){
                                        $opciones=$opciones.'<option value="Activo" selected>Proyecto Activo</option>';
                                    }else{
                                        $opciones=$opciones.'<option value="Activo">Proyecto Activo</option>';
                                    }
                                    if($row['estado']=='Desactivo'){
                                        $opciones=$opciones.'<option value="Desactivo" selected>Proyecto Desactivado</option>';
                                    }else{
                                        $opciones=$opciones.'<option value="Desactivo">Proyecto Desactivado</option>';
                                    }
                                    echo $opciones;
                                ?>
                            </select>
                            <br />
                            <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id" />
                            <input class="btn btn-primary" type="submit" name="Enviar" value="Enviar" /> 
                        </form> 
        <?php 
				}
			}
			echo '</div></div></div></div></div>';
            require_once('clases/footer.php');
        ?>
	</body>
</html>