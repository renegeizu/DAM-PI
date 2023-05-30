<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
?>
<html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php 
        $titulo='Detalles Puestos';
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
						<h1 class="text-center">Detalles del Puesto</h1>
                    </div>
                    <div class="col-md-12" style="padding-top:20px">
		<?php
			if(isset($_GET['id'])){
				require_once('clases/Variables_DB.php');
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
				$query="SELECT nombre, descripcion FROM puesto WHERE id='".$_GET['id']."'";
				$resultado=mysqli_query($dbc, $query);
				while ($row=mysqli_fetch_array($resultado)) {
					echo '<div>';
					echo '<p>Nombre del Puesto: '.$row['nombre'].'</p>';
					echo '<p>Descripcion del Puesto: '.$row['descripcion'].'</p>';
					echo '</div>';
				}
				mysqli_close($dbc);
			}
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