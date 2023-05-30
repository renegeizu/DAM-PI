package com.rngds.projectleader.clases;

	import java.io.Serializable;

import org.json.JSONException;
import org.json.JSONObject;

public class ClaseComentarios implements Serializable{

	private static final long serialVersionUID = 1L;
	String empleado, comentario;
	
	public ClaseComentarios() {
		super();
	}

	public ClaseComentarios(String empleado, String comentario) {
		super();
		this.empleado = empleado;
		this.comentario = comentario;
	}
	
	public ClaseComentarios(JSONObject json) throws JSONException{
		this (json.getString("user"), json.getString("comentario"));
	}

	public String getEmpleado() {
		return empleado;
	}

	public void setEmpleado(String empleado) {
		this.empleado = empleado;
	}

	public String getComentario() {
		return comentario;
	}

	public void setComentario(String comentario) {
		this.comentario = comentario;
	}

	@Override
	public String toString() {
		return "ClaseComentarios [empleado=" + empleado + ", comentario="
				+ comentario + "]";
	}
	
}