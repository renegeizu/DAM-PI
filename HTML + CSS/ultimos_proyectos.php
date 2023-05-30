<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
	if(!isset($_SESSION['User'])){
		header('Location: index.php');	
	}
?>
<html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php 
        $titulo='Ultimos Proyectos';
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
                        <h1 class="text-center">Ultimos Proyectos</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
		<?php
			require_once('clases/Variables_DB.php');
			$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
            $query="SELECT id, nombre, fechaEntrega, prioridad, estado FROM proyectos WHERE estado='Activo'".
				" ORDER BY fechaEntrega ASC LIMIT 5";
            $resultado=mysqli_query($dbc, $query);
			if($_SESSION['Puesto']=='Jefe'){
				echo '<table class="table table-striped table-hover">'.'<tr>'.'<th>Nombre</th>'.'<th>Fecha Entrega</th>'.
				'<th>Prioridad</th>'.'<th>Estado</th><th>Detalles</th><th>Edicion</th><th>Borrado</th></tr>';
			}else{
				echo '<table class="table table-striped table-hover">'.'<tr>'.'<th>Nombre</th>'.'<th>Fecha Entrega</th>'.
				'<th>Prioridad</th>'.'<th>Estado</th><th>Detalles</th></tr>';
			}
			while ($row=mysqli_fetch_array($resultado)) {
				if($_SESSION['Puesto']=='Jefe'){
					echo '<tr><td>'.$row['nombre'].'</td>';
					echo '<td>'.$row['fechaEntrega'].'</td>';
					echo '<td>';
					if($row['prioridad']==1){
						echo 'Maxima';
					}else if($row['prioridad']==2){
						echo 'Media';
					}else{
						echo 'Baja';
					}
					echo '</td>';
					echo '<td>'.$row['estado'].'</td>';
					echo '<td><a href="'."detalles_proyectos.php?id=".$row['id'].
						'"><img src="imagenes/detalles.png"/></a></td>';
					echo '<td><a href="'."editar_proyecto.php?id=".$row['id'].
					'"><img src="imagenes/edicion.png"/></a></td>';
					echo '<td><a href="'."borrar_proyecto.php?from="."1"."&id=".$row['id'].
					'" onclick="return confirmar()"><img src="imagenes/borrado.png"/></a></td></tr>';
				}else{
					echo '<tr><td>'.$row['nombre'].'</td>';
					echo '<td>'.$row['fechaEntrega'].'</td>';
					echo '<td>';
					if($row['prioridad']==1){
						echo 'Maxima';
					}else if($row['prioridad']==2){
						echo 'Media';
					}else{
						echo 'Baja';
					}
					echo '</td>';
					echo '<td>'.$row['estado'].'</td>';
					echo '<td><a href="'."detalles_proyectos.php?id=".$row['id'].
						'"><img src="imagenes/detalles.png"/></a></td></tr>';	
				}
			}
			echo '</table>';
			mysqli_close($dbc);
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