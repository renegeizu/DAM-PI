<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
?>
<html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php 
        $titulo='Detalles Proyectos';
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
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pag_anterior.'&id='
						.$_GET['id'].'">&laquo;</a></li>';
				}
				$cant=round($cantidad/5);
				if((5*$cant)<$cantidad)
					$cant=$cant+1;
				for ($i=1; $i<=$cant; $i++){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$i.'&id='.
						$_GET['id'].'">'.$i.'</a></li>';
				}
				if($pag_actual<$cant){
					echo '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pag_siguiente.'&id='
						.$_GET['id'].'">&raquo;</a></li>';
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
						<h1 class="text-center">Detalles del Proyecto</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
		<?php
			if(isset($_GET['id'])){
				require_once('clases/Variables_DB.php');
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$query="SELECT p.descripcion, p.fechaEntrega, p.prioridad, p.estado, c.nombre, c.empresa".
					" FROM proyectos p INNER JOIN clientes c ON p.idCliente=c.id WHERE p.id='".$_GET['id']."'";
				$resultado=mysqli_query($dbc, $query);
				while ($row=mysqli_fetch_array($resultado)) {
					echo '<div>';
					echo '<p>Nombre del Cliente: '.$row['nombre'].'</p>';
					echo '<p>Nombre de la Empresa: '.$row['empresa'].'</p>';
					echo '<p>Descripcion del Proyecto: '.$row['descripcion'].'</p>';
					echo '<p>Fecha de Entrega: '.$row['fechaEntrega'].'</p>';
					echo '<p>Prioridad del Proyecto: '.$row['prioridad'].'</p>';
					echo '<p>Estado del Proyecto: '.$row['estado'].'</p>';
					echo '</div>';
				}
				mysqli_close($dbc);
			}
			if(isset($_POST['Enviar'])){
				require_once('clases/Variables_DB.php');
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$fecha=date("d")."-".date("m")."-".date("Y");
				$usuario=$_POST['idUser'];
				$proyecto=$_POST['idProyecto'];
				$comentario=$_POST['Comentario'];
				
				$query="INSERT INTO `comentarios` (`idUser`, `idProyecto`, `comentario`, `fechaHora`)".
					" VALUES ('$usuario','$proyecto','$comentario','$fecha');";
				mysqli_query($dbc, $query);
				mysqli_close($dbc);
				header('Location: detalles_proyectos.php?id='.$proyecto);
			}
		?>
        			</div>
        		</div>
            </div>
        </div>
         <div class="container">
  			<div class="row">
            	<div class="col-md-10 col-md-offset-1 caja" style="margin-top:20px">
                	<div class="col-md-12">
						<h1 class="text-center" style="padding-bottom:20px">Comentarios del Proyecto</h1>
                    </div>
                	<?php
					if(isset($_GET['id'])){
						$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
						if(isset($_GET['page'])){
							$limite=$_GET['page'];
						}else{
							$limite=1;
						}
						if($limite==1){
							$numero=$limite*5;
							$query="SELECT u.user, c.fechaHora, c.comentario FROM comentarios c INNER JOIN usuarios u ON".
							" c.idUser=u.id WHERE c.idProyecto='".$_GET['id']."' ORDER BY fechaHora DESC, c.id DESC".
							" LIMIT ".$numero;
						}else{
							$numero=($limite-1)*5;
							$query="SELECT u.user, c.fechaHora, c.comentario FROM comentarios c INNER JOIN usuarios u ON".
							" c.idUser=u.id WHERE c.idProyecto='".$_GET['id']."' ORDER BY fechaHora DESC, c.id DESC".
							" LIMIT ".$numero.", 5";
						}
						$pagina_completa="SELECT u.user, c.fechaHora, c.comentario FROM comentarios c INNER JOIN usuarios u ON".
							" c.idUser=u.id WHERE c.idProyecto='".$_GET['id']."' ORDER BY fechaHora DESC, c.id DESC";
						$resultado=mysqli_query($dbc, $query);
						$pag_actual=mysqli_query($dbc, $pagina_completa);
						while ($row=mysqli_fetch_array($resultado)) {
							echo '<div class="col-md-12 comentario">';
							echo '<div class="col-md-3 contenido-comentario" style="border-right:3px solid black">';
							echo '<p>Usuario:</p><p class="col-md-offset-1">'.$row['user'].'</p>';
							echo '<p>Fecha:</p><p class="col-md-offset-1">'.$row['fechaHora'].'</p></div>';
							echo '<div class="col-md-8 col-md-offset-1 contenido-comentario"><p>'
								.$row['comentario'].'</p>';
							echo '</div>';
							echo '<div class="col-md-12" style="padding:1px;"></div></div>';
						}
						mysqli_close($dbc);
						$cantidad=mysqli_num_rows($pag_actual);
						if(isset($_GET['page'])){
							page_links($_GET['page'], $cantidad, $resultado);
						}else{
							page_links(1, $cantidad, $resultado);
						}
					}
					?>
                </div>
         	</div>
 		</div>
        <div class="container">
  			<div class="row">
            	<div class="col-md-10 col-md-offset-1 caja" style="margin-top:20px">
                	<div class="col-md-12">
						<h1 class="text-center" style="padding-bottom:20px">Agregar Comentario</h1>
                    </div>
                    <?php
						if(isset($_GET['id'])){
					?>
                    <div class="col-md-10 col-md-offset-1" style="padding-top:10px">
                        <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        	<input type="hidden" name="idProyecto" value="<?php echo $_GET['id']; ?>" />
                            <input type="hidden" name="idUser" value="<?php echo $_SESSION['Id']; ?>" /> 
                            <label for="Comentario">Comentario:</label>
                            <br /> 
                            <textarea class="form-control" id="Comentario" name="Comentario" type="text" 
                            	size="300" rows="4" required>
                            </textarea>
                            <br />
                            <input class="btn btn-primary" type="submit" name="Enviar" value="Enviar" /> 
                        </form> 
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