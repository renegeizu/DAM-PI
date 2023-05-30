<?php
	require_once('clases/startsession.php');
	require_once('clases/cabeceras.php');
?>
<html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php 
        $titulo='Project Leader';
        require_once('clases/header.php'); 
		$estado=1;
    ?>
    	<div class="container">
  			<div class="row">
    			<div class="encabezado col-md-10 col-md-offset-1">
    			</div>
  			</div>
		</div>
        <div class="container">
  			<div class="row">
    			<div class="col-md-10 col-md-offset-1" style="padding-top:10px; padding-bottom:10px;">
    			</div>
  			</div>
		</div>
        <div class="container">
  			<div class="row">
            	<div class="col-md-10 col-md-offset-1 caja">
                    <div class="col-md-12">
                        <h1 class="text-center">Accede a Project Leader</h1>
                    </div>
        <?php
            require_once('clases/Variables_DB.php');
            if (isset($_POST['Enviar'])){
				$dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB);
                $user=mysqli_real_escape_string($dbc, $_POST['User']);
                $pass=mysqli_real_escape_string($dbc, $_POST['Pass']);
                $output_form = false;	 
                if (!empty($user) && !empty($pass)){
                    $query="SELECT u.id, p.nombre FROM usuarios u INNER JOIN puesto p ON u.idPuesto=p.id".
                        " WHERE user='$user' AND pass=SHA('$pass')";
                    $resultado=mysqli_query($dbc, $query);
					$relleno=mysqli_num_rows($resultado);
                    if($relleno!='0'){
                        $row=mysqli_fetch_array($resultado);
                        $_SESSION['Id']=$row['id'];
                        $_SESSION['User']=$user;
                        $_SESSION['Puesto']=$row['nombre'];
                        $_SESSION['IP']=$_SERVER['REMOTE_ADDR'];
                        $_SESSION['Agent']=$_SERVER['HTTP_USER_AGENT'];
						mysqli_close($dbc);
                        header('Location: ultimos_proyectos.php');
                    }else{
						$estado=2;
                        $output_form=true;
                    }
                    mysqli_close($dbc);
                } 
            }else { 
                $output_form = true; 
            }
            if ($output_form) { 
        ?> 
        			<?php
					if($estado=='2'){
						echo '<div class="col-md-10 col-md-offset-1" style="padding-top:20px">';
						echo '<h4 style="color:red">El nombre de usuario o contraseña no son validos</h4>';
						echo '</div>';
					}
					?>
                    <br />
                    <div class="col-md-10 col-md-offset-1" style="padding-top:30px">
                        <form method="post" class="col-md-5 col-md-offset-3" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                            <label for="User">Usuario:</label>
                            <br /> 
                            <input class="form-control" id="User" name="User" type="text" size="30" required autofocus/>
                            <br />
                            <label for="Pass">Contrase&ntilde;a:</label>
                            <br /> 
                            <input class="form-control" id="Pass" name="Pass" type="password" size="30" required />
                            <br />
                            <input class="btn btn-primary" type="submit" name="Enviar" value="Enviar" /> 
                        </form> 
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