package com.rngds.projectleader.clases;

	import java.io.Serializable;

public class ClaseConexion implements Serializable{
	
	private static final long serialVersionUID = 1L;
	private String urlLogin="Conectarse.php";
	private String urlUltimos="Ultimos_Proyectos.php";
	private String urlClientes="Cliente_Seleccionado.php";
	private String urlComentarios="Ultimos_Comentarios.php";
	private String urlEmpleados="Empleados.php";
	private String urlComentar="Insertar_Comentario.php";
	private String raiz="http://192.168.1.34/projectleader/php/";
	
	public ClaseConexion() {
		super();
	}

	public String getUrlLogin() {
		return raiz+urlLogin;
	}

	public String getUrlUltimos() {
		return raiz+urlUltimos;
	}
	
	public String getUrlClientes() {
		return raiz+urlClientes;
	}
	
	public String getUrlComentarios() {
		return raiz+urlComentarios;
	}
	
	public String getUrlComentar() {
		return raiz+urlComentar;
	}
	
	public String getUrlEmpleados() {
		return raiz+urlEmpleados;
	}
	
}