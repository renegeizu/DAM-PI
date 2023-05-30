package com.rngds.projectleader.adaptadores;

	import java.util.ArrayList;
	import com.rngds.projectleader.R;
	import com.rngds.projectleader.clases.ClaseEmpleados;
	import android.content.Context;
	import android.view.LayoutInflater;
	import android.view.View;
	import android.view.ViewGroup;
	import android.widget.ArrayAdapter;
	import android.widget.TextView;

public class PL5_Adaptador extends ArrayAdapter<ClaseEmpleados>{

	private Context contexto;
	private ArrayList<ClaseEmpleados> listaEmpleados;
	
	public PL5_Adaptador(Context contexto, ArrayList<ClaseEmpleados> listaEmpleados){
		super(contexto, R.layout.pl5_listview, listaEmpleados);
		this.contexto=contexto;
		this.listaEmpleados=listaEmpleados;
	}
	
	@Override
	public View getView(int posicion, View vista, ViewGroup padre){
		if(vista==null){
			LayoutInflater i=(LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			vista=i.inflate(R.layout.pl5_listview, null);
		}
		TextView tvNombre=(TextView) vista.findViewById(R.id.PL5_tvNombre);
		tvNombre.setText("Empleado: "+listaEmpleados.get(posicion).getNombre());
		TextView tvUser=(TextView) vista.findViewById(R.id.PL5_tvUser);
		tvUser.setText("Usuario: "+listaEmpleados.get(posicion).getUser());
		TextView tvPuesto=(TextView) vista.findViewById(R.id.PL5_tvPuesto);
		tvPuesto.setText("Puesto: "+listaEmpleados.get(posicion).getPuesto());
		return vista;
	}
	
}