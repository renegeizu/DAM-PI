package com.rngds.projectleader.clases;

	import java.io.Serializable;
	import org.json.JSONException;
	import org.json.JSONObject;

public class ClaseEmpleados implements Serializable{

	private static final long serialVersionUID = 1L;
	private String id, user, pass, nombre, fechaNacimiento, dni, telefono, email, puesto;
	
	public ClaseEmpleados() {
		super();
	}
	
	public ClaseEmpleados(String id, String user, String pass, String puesto) {
		super();
		this.id = id;
		this.user = user;
		this.pass = pass;
		this.puesto = puesto;
	}

	public ClaseEmpleados(String id, String user, String pass, String nombre, String fechaNacimiento, String dni, String telefono, String email, String puesto) {
		super();
		this.id = id;
		this.user = user;
		this.pass = pass;
		this.nombre = nombre;
		this.fechaNacimiento = fechaNacimiento;
		this.dni = dni;
		this.telefono = telefono;
		this.email = email;
		this.puesto = puesto;
	}
	
	public ClaseEmpleados (JSONObject json) throws JSONException{
		this (json.getString("id"), json.getString("user"), json.getString("pass"),
				json.getString("puesto"));
	}
	
	public ClaseEmpleados (JSONObject json, String vacio) throws JSONException{
		this (json.getString("id"), json.getString("user"), json.getString("pass"),
				json.getString("nombre"), json.getString("fechaNacimiento"),
				json.getString("dni"), json.getString("telefono"), json.getString("email"),
				json.getString("puesto"));
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getUser() {
		return user;
	}

	public void setUser(String user) {
		this.user = user;
	}

	public String getPass() {
		return pass;
	}

	public void setPass(String pass) {
		this.pass = pass;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public String getFechaNacimiento() {
		return fechaNacimiento;
	}

	public void setFechaNacimiento(String fechaNacimiento) {
		this.fechaNacimiento = fechaNacimiento;
	}

	public String getDni() {
		return dni;
	}

	public void setDni(String dni) {
		this.dni = dni;
	}

	public String getTelefono() {
		return telefono;
	}

	public void setTelefono(String telefono) {
		this.telefono = telefono;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public String getPuesto() {
		return puesto;
	}

	public void setPuesto(String puesto) {
		this.puesto = puesto;
	}

	@Override
	public String toString() {
		return "ClaseEmpleados [id=" + id + ", user=" + user + ", pass=" + pass
				+ ", nombre=" + nombre + ", fechaNacimiento=" + fechaNacimiento
				+ ", dni=" + dni + ", telefono=" + telefono + ", email="
				+ email + ", puesto=" + puesto + "]";
	}

}