package com.rngds.projectleader.clases;

	import java.io.Serializable;
	import org.json.JSONException;
	import org.json.JSONObject;

public class ClaseProyectos implements Serializable {

	private static final long serialVersionUID = 1L;
	private String id, idCliente, nombre, descripcion, fechaEntrega, prioridad, estado;
	
	public ClaseProyectos() {
		super();
	}

	public ClaseProyectos(String id, String idCliente, String nombre, String descripcion, String fechaEntrega, String prioridad, String estado) {
		super();
		this.id = id;
		this.idCliente = idCliente;
		this.nombre = nombre;
		this.descripcion = descripcion;
		this.fechaEntrega = fechaEntrega;
		this.prioridad = prioridad;
		this.estado = estado;
	}
	
	public ClaseProyectos (JSONObject json) throws JSONException{
		this (json.getString("id"), json.getString("idCliente"), json.getString("nombre"),
				json.getString("descripcion"), json.getString("fechaEntrega"), json.getString("prioridad"), 
				json.getString("estado"));
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getIdCliente() {
		return idCliente;
	}

	public void setIdCliente(String idCliente) {
		this.idCliente = idCliente;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public String getDescripcion() {
		return descripcion;
	}

	public void setDescripcion(String descripcion) {
		this.descripcion = descripcion;
	}

	public String getFechaEntrega() {
		return fechaEntrega;
	}

	public void setFechaEntrega(String fechaEntrega) {
		this.fechaEntrega = fechaEntrega;
	}

	public String getPrioridad() {
		return prioridad;
	}

	public void setPrioridad(String prioridad) {
		this.prioridad = prioridad;
	}

	public String getEstado() {
		return estado;
	}

	public void setEstado(String estado) {
		this.estado = estado;
	}

	@Override
	public String toString() {
		return "ClaseProyectos [id=" + id + ", idCliente=" + idCliente
				+ ", nombre=" + nombre + ", descripcion=" + descripcion
				+ ", fechaEntrega=" + fechaEntrega + ", prioridad=" + prioridad
				+ ", estado=" + estado + "]";
	}

}