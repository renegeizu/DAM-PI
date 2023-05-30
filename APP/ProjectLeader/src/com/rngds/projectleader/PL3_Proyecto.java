package com.rngds.projectleader;

	import java.io.File;
	import java.io.FileInputStream;
	import java.util.ArrayList;
	import java.util.Calendar;
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
	import org.xmlpull.v1.XmlPullParser;
	import com.rngds.projectleader.adaptadores.PL3_Adaptador;
	import com.rngds.projectleader.clases.ClaseComentarios;
	import com.rngds.projectleader.clases.ClaseConexion;
	import com.rngds.projectleader.clases.ClaseEmpleados;
	import com.rngds.projectleader.clases.ClaseProyectos;
	import android.os.AsyncTask;
	import android.os.Bundle;
	import android.util.Xml;
	import android.view.View;
	import android.view.View.OnClickListener;
	import android.widget.Button;
	import android.widget.EditText;
	import android.widget.ListView;
	import android.widget.ScrollView;
	import android.widget.TextView;
	import android.widget.Toast;
	import android.app.Activity;
	import android.app.Dialog;
	import android.content.Context;
	import android.content.Intent;

public class PL3_Proyecto extends Activity {
	
	ClaseProyectos proyecto;
	private TextView tvTitulo, tvDescripcion, tvComentarios;
	private ListView lvComentarios;
	private ScrollView sv;
	private Button btCliente, btComentario;
	boolean estado=false;
	private ArrayList<ClaseComentarios> listaComentarios=new ArrayList<ClaseComentarios>();
	private PL3_Adaptador adaptador;
	private Context contexto;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pl3_proyecto);
		Bundle b=getIntent().getExtras();
		proyecto=(ClaseProyectos) b.getSerializable("Proyecto");
		tvTitulo=(TextView) findViewById(R.id.PL3_tvTitulo);
		tvTitulo.setText(proyecto.getNombre());
		tvDescripcion=(TextView) findViewById(R.id.PL3_tvDescripcion);
		tvDescripcion.setText(proyecto.getDescripcion());
		tvComentarios=(TextView) findViewById(R.id.PL3_tvComentarios);
		lvComentarios=(ListView) findViewById(R.id.PL3_lvComentarios);
		sv=(ScrollView) findViewById(R.id.PL3_sv);
		btCliente=(Button) findViewById(R.id.PL3_btCliente);
		btComentario=(Button) findViewById(R.id.PL3_btComentario);
		contexto=this;
		new UltimosComentarios().execute(new String[] {new ClaseConexion().getUrlComentarios(), proyecto.getId()});
	}
	
	public void comentar(View v){
		final Dialog d=new Dialog(this);
		d.setContentView(R.layout.pl3_dialogo);
		d.setTitle("Comentar");
		final EditText et=(EditText) d.findViewById(R.id.PL3_etComentar);
		Button bt=(Button)d.findViewById(R.id.PL3_btEnviar);
		bt.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				String comentario=et.getText().toString();
				String fechaHora=generarNombre();
				if(comentario.equals("")!=true){
					new EnviarComentario().execute(new String[] {new ClaseConexion().getUrlComentar(),
							leerClave().getId(), proyecto.getId(), comentario, fechaHora});
					d.cancel();
					finish();
				}else{
					d.cancel();
					mensaje("Envio de Comentario Cancelado");
				}
			}
		});
		d.show();
	}
	
	private class EnviarComentario extends AsyncTask<String, Integer, String>{
		
		@Override
		protected String doInBackground(String... params) {
			String respuesta="";
			try {
				HttpClient httpclient=new DefaultHttpClient();
				HttpPost httppost=new HttpPost(params[0]);
		        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
		        nameValuePairs.add(new BasicNameValuePair("Peticion", "0"));
		        nameValuePairs.add(new BasicNameValuePair("idUser", params[1]));
		        nameValuePairs.add(new BasicNameValuePair("idProyecto", params[2]));
		        nameValuePairs.add(new BasicNameValuePair("comentario", params[3]));
		        nameValuePairs.add(new BasicNameValuePair("fechaHora", params[4]));
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
			if(result.contains("0")){
				mensaje("Error al Enviar Comentario");
			}else{
				mensaje("Comentario Enviado con Exito");
			}
		}
		
	}
	
	public String generarNombre(){
		Calendar c = Calendar.getInstance();
		String agno = c.get(Calendar.YEAR)+"";
		String mes = c.get(Calendar.MONTH)+1+"";
		if(Integer.parseInt(mes)<10){
			mes="0"+mes;
		}
		String dia = c.get(Calendar.DAY_OF_MONTH)+"";
		if(Integer.parseInt(dia)<10){
			dia="0"+dia;
		}
		return dia+"-"+mes+"-"+agno;
	}

	public void hacerVisibles(boolean estatus){
		if(estatus==true){
			tvTitulo.setVisibility(View.VISIBLE);
			tvDescripcion.setVisibility(View.VISIBLE);
			sv.setVisibility(View.VISIBLE);
			btCliente.setVisibility(View.VISIBLE);
			tvComentarios.setVisibility(View.GONE);
			lvComentarios.setVisibility(View.GONE);
			btComentario.setVisibility(View.VISIBLE);
		}else{
			tvTitulo.setVisibility(View.VISIBLE);
			tvDescripcion.setVisibility(View.VISIBLE);
			tvComentarios.setVisibility(View.VISIBLE);
			lvComentarios.setVisibility(View.VISIBLE);
			sv.setVisibility(View.VISIBLE);
			btCliente.setVisibility(View.VISIBLE);
			btComentario.setVisibility(View.VISIBLE);
		}
	}
	
	private ClaseEmpleados leerClave(){
	 	ClaseEmpleados ce=null;
		XmlPullParser lectorxml = Xml.newPullParser();
		try {
			lectorxml.setInput(new FileInputStream(new File(getExternalFilesDir(null),"projectLeader.xml")),"utf-8");
			int evento = lectorxml.getEventType();
			while (evento != XmlPullParser.END_DOCUMENT){
				if(evento == XmlPullParser.START_TAG){
					String etiqueta = lectorxml.getName();
					if(etiqueta.compareTo("empleado")==0){
							String id=lectorxml.getAttributeValue(null, "id");
							String user=lectorxml.getAttributeValue(null, "user");
							String pass=lectorxml.getAttributeValue(null, "pass");
							String puesto=lectorxml.getAttributeValue(null, "puesto");
							ce=new ClaseEmpleados(id, user, pass, puesto);
					}
				}
				evento = lectorxml.next();
			}
		} catch (Exception e) {
			ce=new ClaseEmpleados("-1", "", "", "");
		}
		return ce;
	}
	
	public void mensaje(String mensaje){
		Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show();
	}

	private class UltimosComentarios extends AsyncTask<String, Integer, String>{
		
		@Override
		protected String doInBackground(String... params) {
			String respuesta="";
			try {
				HttpClient httpclient=new DefaultHttpClient();
				HttpPost httppost=new HttpPost(params[0]);
		        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
		        nameValuePairs.add(new BasicNameValuePair("Peticion", "0"));
		        nameValuePairs.add(new BasicNameValuePair("Id", params[1]));
		        httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
		        HttpResponse response=httpclient.execute(httppost);
		        HttpEntity ent=response.getEntity();
		        respuesta=EntityUtils.toString(ent);
			}catch(Exception e){
				e.printStackTrace();
			}
			return respuesta;
		}
		
		@Override
		protected void onPostExecute(String result){
			super.onPostExecute(result);
			boolean estatus=false;
			if(estado==true)
				listaComentarios.clear();
			JSONTokener tokener = new JSONTokener(result);
			try{
				JSONObject raiz = new JSONObject(tokener);
				JSONArray lista=raiz.getJSONArray("Comentarios");
				for (int i = 0; i < lista.length(); i++) {
					JSONObject fila = lista.getJSONObject(i);
					listaComentarios.add(new ClaseComentarios(fila));
				}
			}catch(Exception e){
			}
			if(listaComentarios.isEmpty()==true){
				estatus=true;
			}else{
				estatus=false;
			}
			if(estado==false){
				adaptador=new PL3_Adaptador(contexto, listaComentarios);
				lvComentarios.setAdapter(adaptador);
				estado=true;
			}else{
				adaptador.notifyDataSetChanged();
			}
			hacerVisibles(estatus);
		}
		
	}
	
	public void verCliente(View v){
		Intent i = new Intent(contexto, PL4_Cliente.class);
		Bundle b = new Bundle();
		b.putSerializable("Proyecto", proyecto);
		i.putExtras(b);
		startActivity(i);
	}

}