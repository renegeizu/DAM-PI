package com.rngds.projectleader.adaptadores;

	import java.util.ArrayList;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.rngds.projectleader.R;
import com.rngds.projectleader.clases.ClaseComentarios;

public class PL3_Adaptador extends ArrayAdapter<ClaseComentarios>{

	private Context contexto;
	private ArrayList<ClaseComentarios> listaComentarios;
	
	public PL3_Adaptador(Context contexto, ArrayList<ClaseComentarios> listaComentarios){
		super(contexto, R.layout.pl3_listview, listaComentarios);
		this.contexto=contexto;
		this.listaComentarios=listaComentarios;
	}
	
	@Override
	public View getView(int posicion, View vista, ViewGroup padre){
		if(vista==null){
			LayoutInflater i=(LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			vista=i.inflate(R.layout.pl3_listview, null);
		}
		TextView tvEmpleado=(TextView) vista.findViewById(R.id.PL3_tvEmpleado);
		tvEmpleado.setText("Empleado: "+listaComentarios.get(posicion).getEmpleado());
		TextView tvComentario=(TextView) vista.findViewById(R.id.PL3_tvComentario);
		tvComentario.setText(listaComentarios.get(posicion).getComentario());
		return vista;
	}
	
}
