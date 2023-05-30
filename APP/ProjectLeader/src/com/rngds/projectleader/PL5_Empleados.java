package com.rngds.projectleader;

	import java.util.ArrayList;
	import java.util.List;
	import org.apache.http.HttpEntity;
	import org.apache.http.HttpResponse;
	import org.apache.http.NameValuePair;
	import org.apache.http.client.HttpClient;
	import org.apache.http.client.entity.UrlEncodedFormEntity;
	import org.apache.http.client.methods.HttpPost;
	import org.apache.http.impl.client.DefaultHttpClient;
	import org.apache.http.message.BasicNameValuePair;
	import org.apache.http.util.EntityUtils;
	import org.json.JSONArray;
	import org.json.JSONObject;
	import org.json.JSONTokener;
	import com.rngds.projectleader.adaptadores.PL5_Adaptador;
	import com.rngds.projectleader.clases.ClaseConexion;
	import com.rngds.projectleader.clases.ClaseEmpleados;
	import android.os.AsyncTask;
	import android.os.Bundle;
	import android.app.Activity;
	import android.content.Context;
	import android.content.Intent;
	import android.view.View;
	import android.widget.AdapterView;
	import android.widget.ListView;
	import android.widget.Toast;
	import android.widget.AdapterView.OnItemClickListener;

public class PL5_Empleados extends Activity {
	
	private ArrayList<ClaseEmpleados> listaEmpleados=new ArrayList<ClaseEmpleados>();
	private ListView lvEmpleados;
	private Context contexto;
	private boolean estado=false;
	private PL5_Adaptador adaptador;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pl5_empleados);
		contexto=this;
		lvEmpleados=(ListView) findViewById(R.id.PL5_lvEmpleados);
		new Empleados().execute(new String[] {new ClaseConexion().getUrlEmpleados()});
		
	}
	
	private class Empleados extends AsyncTask<String, Integer, String>{
		
		@Override
		protected String doInBackground(String... params) {
			String respuesta="";
			try {
				HttpClient httpclient=new DefaultHttpClient();
				HttpPost httppost=new HttpPost(params[0]);
		        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
		        nameValuePairs.add(new BasicNameValuePair("Peticion", "0"));
		        httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
		        HttpResponse response=httpclient.execute(httppost);
		        HttpEntity ent=response.getEntity();
		        respuesta=EntityUtils.toString(ent);
			}catch(Exception e){
			}
			return respuesta;
		}
		
		@Override
		protected void onPostExecute(String result){
			super.onPostExecute(result);
			if(estado==true){
				listaEmpleados.clear();
			}
			JSONTokener tokener = new JSONTokener(result);
			try{
				JSONObject raiz = new JSONObject(tokener);
				JSONArray lista=raiz.getJSONArray("Empleados");
				for (int i = 0; i < lista.length(); i++) {
					JSONObject fila = lista.getJSONObject(i);
					listaEmpleados.add(new ClaseEmpleados(fila, ""));
				}
			}catch(Exception e){
			}
			if(estado==false){
				adaptador=new PL5_Adaptador(contexto, listaEmpleados);
				lvEmpleados.setAdapter(adaptador);
				estado=true;
				lvEmpleados.setOnItemClickListener(new OnItemClickListener() {
					@Override
					public void onItemClick(AdapterView<?> av, View v, int pos, long id) {
						Intent i = new Intent(contexto, PL6_Empleado.class);
						Bundle b = new Bundle();
						b.putSerializable("Empleado", listaEmpleados.get(pos));
						i.putExtras(b);
						startActivity(i);
					}
				});
			}else{
				adaptador.notifyDataSetChanged();
			}
		}
		
	}

	public void mensaje(String mensaje){
    	Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show();
    }
	
	@Override
	protected void onResume() {
		try{
			if(estado==true)
				new Empleados().execute(new String[] {new ClaseConexion().getUrlEmpleados()});
		}catch(Exception e){}
		super.onResume();
	}

}