<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
?>
<html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php 
        $titulo='Listado Empleados';
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
			function page_links($pag_actual, $cantidad, $resultado){
				echo '<div class="col-md-8 col-md-offset-4" style="padding-top:20px">';
				$pag_siguiente=$pag_actual+1;
				$pag_anterior=$pag_actual-1;
				echo '<ul class="pagination">';
				if($pag_actual>1){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pag_anterior.'&order='
						.$_GET['order'].'">&laquo;</a></li>';
				}
				$cant=round($cantidad/5);
				if((5*$cant)<$cantidad)
					$cant=$cant+1;
				for ($i=1; $i<=$cant; $i++){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$i.'&order='.
						$_GET['order'].'">'.$i.'</a></li>';
				}
				if($pag_actual<$cant){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pag_siguiente.'&order='
						.$_GET['order'].'">&raquo;</a></li>';
				}
				echo '</ul>';
				echo '</div>';
			}
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
    					<h1 class="text-center">Listado Empleados</h1>
                    </div>
                    <?php
						if(isset($_GET['order'])&&isset($_GET['page'])){
					?>
                    <div class="col-md-12" style="padding-top:20px">
                    	<form method="get" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                            <label for="order">Ordenar Por:</label>
                            <div style="margin-top:10px"></div>
                           	<input type="hidden" value="1" name="page" />
							<SELECT class="form-control" NAME="order" SIZE=1>
                            	<?php
									if($_GET['order']=='user'){
										echo '<OPTION VALUE="user" selected>Usuario</OPTION>';
										echo '<OPTION VALUE="nombre">Nombre</OPTION>';
										echo '<OPTION VALUE="puesto">Puesto</OPTION>';
									}else if($_GET['order']=='nombre'){
										echo '<OPTION VALUE="user">Usuario</OPTION>';
										echo '<OPTION VALUE="nombre" selected>Nombre</OPTION>';
										echo '<OPTION VALUE="puesto">Puesto</OPTION>';
									}else{
										echo '<OPTION VALUE="user">Usuario</OPTION>';
										echo '<OPTION VALUE="nombre">Nombre</OPTION>';
										echo '<OPTION VALUE="puesto" selected>Puesto</OPTION>';
									}
								?>
                            </SELECT>
                            <div style="margin-top:10px"></div>
                            <input class="btn btn-primary" type="submit" value="Enviar" /> 
                        </form> 
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
		<?php
			$query="";
			$limite=$_GET['page'];
			if($limite==1){
				$numero=$limite*5;
				$query="SELECT u.id, u.user, u.nombre, p.nombre AS 'puesto' FROM usuarios u INNER JOIN puesto p ON".
					" u.idPuesto=p.id ORDER BY ".$_GET['order']." LIMIT ".$numero;
			}else{
				$numero=($limite-1)*5;
				$query="SELECT u.id, u.user, u.nombre, p.nombre AS 'puesto' FROM usuarios u INNER JOIN puesto p ON".
					" u.idPuesto=p.id ORDER BY ".$_GET['order']." LIMIT ".$numero.", 5";
			}
			$pagina_completa="SELECT u.id, u.user, u.nombre, p.nombre AS 'puesto' FROM usuarios u INNER JOIN puesto p ON".
					" u.idPuesto=p.id ORDER BY ".$_GET['order'];
			require_once('clases/Variables_DB.php');
			$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
            $resultado=mysqli_query($dbc, $query);
			$pag_actual=mysqli_query($dbc, $pagina_completa);
			if($_SESSION['Puesto']=='Jefe'){
				echo '<table class="table table-striped table-hover">'.'<tr><th>Usuario</th>'.'<th>Nombre</th>'.
					'<th>Puesto</th>'.'<th>Detalles</th><th>Edicion</th><th>Borrado</th></tr>';
			}else{
				echo '<table class="table table-striped table-hover">'.'<tr><th>Usuario</th>'.'<th>Nombre</th>'.
					'<th>Puesto</th>'.'<th>Detalles</th></tr>';
			}
			while ($row=mysqli_fetch_array($resultado)) {
				if($_SESSION['Puesto']=='Jefe'){
					echo '<tr><td>'.$row['user'].'</td>';
					echo '<td>'.$row['nombre'].'</td>';
					echo '<td>'.$row['puesto'].'</td>';
					echo '<td><a href="'."detalles_empleados.php?id=".$row['id'].
						'"><img src="imagenes/detalles.png"/></a></td>';
					echo '<td><a href="'."editar_empleados.php?id=".$row['id'].
					'"><img src="imagenes/edicion.png"/></a></td>';
					echo '<td><a href="'."borrar_empleado.php?id=".$row['id'].
					'" onclick="return confirmar()"><img src="imagenes/borrado.png"/></a></td></tr>';
				}else{
					echo '<tr><td>'.$row['user'].'</td>';
					echo '<td>'.$row['nombre'].'</td>';
					echo '<td>'.$row['puesto'].'</td>';
					echo '<td><a href="'."detalles_empleados.php?id=".$row['id'].
						'"><img src="imagenes/detalles.png"/></a></td></tr>';
				}
			}
			echo '</table>';
			$cantidad=mysqli_num_rows($pag_actual);
			page_links($_GET['page'], $cantidad, $resultado);
			mysqli_close($dbc);
		?>
        			</div>
                    <?php
						}
					?>
        		</div>
            </div>
        </div>
        <?php
			require_once('clases/footer.php');
		?>
	</body>
</html>