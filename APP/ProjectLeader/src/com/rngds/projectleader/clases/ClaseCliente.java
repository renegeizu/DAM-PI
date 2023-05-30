package com.rngds.projectleader.clases;

	import java.io.Serializable;
	import org.json.JSONException;
	import org.json.JSONObject;

public class ClaseCliente implements Serializable{
	
	private static final long serialVersionUID = 1L;
	private String id, nombre, empresa, telefono, email;
	
	public ClaseCliente() {
		super();
	}

	public ClaseCliente(String id, String nombre, String empresa, String telefono, String email) {
		super();
		this.id = id;
		this.nombre = nombre;
		this.empresa = empresa;
		this.telefono = telefono;
		this.email = email;
	}
	
	public ClaseCliente (JSONObject json) throws JSONException{
		this (json.getString("id"), json.getString("nombre"), json.getString("empresa"),
				json.getString("telefono"), json.getString("email"));
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public String getEmpresa() {
		return empresa;
	}

	public void setEmpresa(String empresa) {
		this.empresa = empresa;
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

	@Override
	public String toString() {
		return "ClaseCliente [id=" + id + ", nombre=" + nombre + ", empresa="
				+ empresa + ", telefono=" + telefono + ", email=" + email + "]";
	}

}