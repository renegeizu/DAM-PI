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
	import com.rngds.projectleader.adaptadores.PL2_Adaptador;
	import com.rngds.projectleader.clases.ClaseConexion;
	import com.rngds.projectleader.clases.ClaseProyectos;
	import android.os.AsyncTask;
	import android.os.Bundle;
	import android.app.Activity;
	import android.content.Context;
	import android.content.Intent;
	import android.view.Menu;
	import android.view.MenuItem;
	import android.view.View;
	import android.widget.AdapterView;
	import android.widget.AdapterView.OnItemClickListener;
	import android.widget.ListView;
	import android.widget.Toast;

public class PL2_Ultimos extends Activity {
	
	private ArrayList<ClaseProyectos> listaProyectos=new ArrayList<ClaseProyectos>();
	private ListView lvProyectos;
	private Context contexto;
	private boolean estado=false;
	private PL2_Adaptador adaptador;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pl2_ultimos);
		contexto=this;
		lvProyectos=(ListView) findViewById(R.id.PL2_lvUltimos);
		new UltimosProyectos().execute(new String[] {new ClaseConexion().getUrlUltimos()});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.menu, menu);
		return true;
	}
	
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		switch(item.getItemId()){
		case R.id.action_buscarEmpleados:
			startActivity(new Intent(this, PL5_Empleados.class));
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	public void mensaje(String mensaje){
    	Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show();
    }
	
	@Override
	protected void onResume() {
		try{
			new UltimosProyectos().execute(new String[] {new ClaseConexion().getUrlUltimos()});
		}catch(Exception e){}
		super.onResume();
	}

	private class UltimosProyectos extends AsyncTask<String, Integer, String>{
		
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
			if(estado==true)
				listaProyectos.clear();
			JSONTokener tokener = new JSONTokener(result);
			try{
				JSONObject raiz = new JSONObject(tokener);
				JSONArray lista=raiz.getJSONArray("Proyectos");
				for (int i = 0; i < lista.length(); i++) {
					JSONObject fila = lista.getJSONObject(i);
					listaProyectos.add(new ClaseProyectos(fila));
				}
			}catch(Exception e){
			}
			if(estado==false){
				adaptador=new PL2_Adaptador(contexto, listaProyectos);
				lvProyectos.setAdapter(adaptador);
				estado=true;
				lvProyectos.setOnItemClickListener(new OnItemClickListener() {
					@Override
					public void onItemClick(AdapterView<?> av, View v, int pos, long id) {
						Intent i = new Intent(contexto, PL3_Proyecto.class);
						Bundle b = new Bundle();
						b.putSerializable("Proyecto", listaProyectos.get(pos));
						i.putExtras(b);
						startActivity(i);
					}
				});
			}else{
				adaptador.notifyDataSetChanged();
			}
		}
		
	}

}