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
        $titulo='Listado Puestos';
        require_once('clases/header.php');
		function page_links($pag_actual, $cantidad, $resultado){
				echo '<div class="col-md-8 col-md-offset-4" style="padding-top:20px">';
				$pag_siguiente=$pag_actual+1;
				$pag_anterior=$pag_actual-1;
				echo '<ul class="pagination">';
				if($pag_actual>1){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pag_anterior.'">&laquo;</a></li>';
				}
				$cant=round($cantidad/5);
				if((5*$cant)<$cantidad)
					$cant=$cant+1;
				for ($i=1; $i<=$cant; $i++){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$i.'">'.$i.'</a></li>';
				}
				if($pag_actual<$cant){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pag_siguiente.'">&raquo;</a></li>';
				}
				echo '</ul>';
				echo '</div>';
			} 
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
    					<h1 class="text-center">Listado Puestos</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
                    	<form method="get" class="col-md-3 col-md-offset-9" action="insertar_puestos.php">
                            <input class="btn btn-primary" type="submit" value="Agregar" /> 
                        </form> 
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
		<?php
			$query="";
			if(isset($_GET['page'])){
				$limite=$_GET['page'];
			}else{
				$limite=1;	
			}
			if($limite==1){
				$numero=$limite*5;
				$query="SELECT id, nombre FROM puesto WHERE nombre!='Jefe' ORDER BY nombre LIMIT ".$numero;
			}else{
				$numero=($limite-1)*5;
				$query="SELECT id, nombre FROM puesto WHERE nombre!='Jefe' ORDER BY nombre LIMIT ".$numero.", 5";
			}
			$pagina_completa="SELECT id, nombre FROM puesto WHERE nombre!='Jefe' ORDER BY nombre";
			require_once('clases/Variables_DB.php');
			$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
            $resultado=mysqli_query($dbc, $query);
			$pag_actual=mysqli_query($dbc, $pagina_completa);
			if($_SESSION['Puesto']=='Jefe'){
				echo '<table class="table table-striped table-hover">'.'<tr><th>Puesto</th>'.
					'<th>Detalles</th><th>Edicion</th><th>Borrado</th></tr>';
			}else{
				echo '<table class="table table-striped table-hover">'.'<tr><th>Puesto</th>'.
					'<th>Detalles</th></tr>';
			}
			while ($row=mysqli_fetch_array($resultado)) {
				if($_SESSION['Puesto']=='Jefe'){
					echo '<tr><td>'.$row['nombre'].'</td>';
					echo '<td><a href="'."detalles_puestos.php?id=".$row['id'].
						'"><img src="imagenes/detalles.png"/></a></td>';
					echo '<td><a href="'."editar_puestos.php?id=".$row['id'].
					'"><img src="imagenes/edicion.png"/></a></td>';
					echo '<td><a href="'."borrar_puestos.php?id=".$row['id'].
					'" onclick="return confirmar()"><img src="imagenes/borrado.png"/></a></td></tr>';
				}else{
					echo '<tr><td>'.$row['nombre'].'</td>';
					echo '<td><a href="'."detalles_puestos.php?id=".$row['id'].
						'"><img src="imagenes/detalles.png"/></a></td></tr>';
				}
			}
			echo '</table>';
			$cantidad=mysqli_num_rows($pag_actual);
			if(isset($_GET['page'])){
				page_links($_GET['page'], $cantidad, $resultado);
			}else{
				page_links(1, $cantidad, $resultado);
			}
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