<?php
	if($_SESSION['Puesto']!='Jefe'){
		echo '<div class="container">';
    	echo '<div class="row">';
      	echo '<ul class="nav menu col-md-10 col-md-offset-1">';
        echo '<li class="col-md-3 text-center"><a href="ultimos_proyectos.php">Ultimos Proyectos</a></li>';
        echo '<li class="col-md-2 text-center"><a href="listado_clientes.php?page=1&order=empresa">Lista Clientes</a></li>';
        echo '<li class="col-md-3 text-center"><a href="listado_empleados.php?page=1&order=user">Lista Empleados</a></li>';
		echo '<li class="col-md-2 text-center"><a href="listado_proyectos.php?page=1&order=fechaEntrega">Lista Proyectos</a></li>';
        echo '<li class="col-md-2 text-center"><a href="logout.php">LogOut</a></li>';
      	echo '</ul>';
		echo '</div>';
		echo '</div>';
	}else{
		echo '<div class="container">';
    	echo '<div class="row">';
      	echo '<ul class="nav menu col-md-10 col-md-offset-1">';
        echo '<li class="col-md-2 text-center"><a href="ultimos_proyectos.php">Ultimos Proyect.</a></li>';
        echo '<li class="col-md-2 text-center"><a href="listado_clientes.php?page=1&order=empresa">Lista Clientes</a></li>';
        echo '<li class="col-md-2 text-center"><a href="listado_empleados.php?page=1&order=user">Empleados</a></li>';
		echo '<li class="col-md-2 text-center"><a href="listado_proyectos.php?page=1&order=fechaEntrega">Lista Proyectos</a></li>';
		echo '<li class="col-md-2 text-center"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Administracion</a>'.
			'<ul class="dropdown-menu text-left"><li><a href="insertar_empleados.php">Agregar Empleado</a></li>'.
			'<li><a href="insertar_clientes.php">Agregar Cliente</a></li>'.
			'<li><a href="insertar_proyectos.php">Agregar Proyecto</a></li>'.
			'<li><a href="listado_puestos.php">Lista Puestos</a></li>'.
			'</ul>'.'</li>';
        echo '<li class="col-md-2 text-center"><a href="logout.php">LogOut</a></li>';
      	echo '</ul>';
		echo '</div>';
		echo '</div>';
	}
?>