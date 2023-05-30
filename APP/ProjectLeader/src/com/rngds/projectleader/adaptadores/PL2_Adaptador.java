package com.rngds.projectleader.adaptadores;

	import java.util.ArrayList;
	import com.rngds.projectleader.R;
	import com.rngds.projectleader.clases.ClaseProyectos;
	import android.content.Context;
	import android.view.LayoutInflater;
	import android.view.View;
	import android.view.ViewGroup;
	import android.widget.ArrayAdapter;
	import android.widget.TextView;

public class PL2_Adaptador extends ArrayAdapter<ClaseProyectos>{

	private Context contexto;
	private ArrayList<ClaseProyectos> listaProyectos;
	
	public PL2_Adaptador(Context contexto, ArrayList<ClaseProyectos> listaProyectos){
		super(contexto, R.layout.pl2_listview, listaProyectos);
		this.contexto=contexto;
		this.listaProyectos=listaProyectos;
	}
	
	@Override
	public View getView(int posicion, View vista, ViewGroup padre){
		if(vista==null){
			LayoutInflater i=(LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			vista=i.inflate(R.layout.pl2_listview, null);
		}
		TextView tvNombre=(TextView) vista.findViewById(R.id.PL2_tvNombre);
		TextView tvFechaEntrega=(TextView) vista.findViewById(R.id.PL2_tvFechaEntrega);
		TextView tvPrioridad=(TextView) vista.findViewById(R.id.PL2_tvPrioridad);
		TextView tvEstado=(TextView) vista.findViewById(R.id.PL2_tvEstado);
		tvNombre.setText(listaProyectos.get(posicion).getNombre());
		tvFechaEntrega.setText("Fecha Entrega: "+listaProyectos.get(posicion).getFechaEntrega());
		if(listaProyectos.get(posicion).getPrioridad().equals("1")==true){
			tvPrioridad.setText("Prioridad: Maxima");
		}else if(listaProyectos.get(posicion).getPrioridad().equals("2")==true){
			tvPrioridad.setText("Prioridad: Media");
		}else{
			tvPrioridad.setText("Prioridad: Baja");
		}
		tvEstado.setText("Estado: "+listaProyectos.get(posicion).getEstado());
		return vista;
	}
	
}