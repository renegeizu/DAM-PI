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
	import com.rngds.projectleader.clases.ClaseCliente;
	import com.rngds.projectleader.clases.ClaseConexion;
	import com.rngds.projectleader.clases.ClaseProyectos;
	import android.net.Uri;
	import android.os.AsyncTask;
	import android.os.Bundle;
	import android.view.View;
	import android.widget.Button;
	import android.widget.TextView;
	import android.widget.Toast;
	import android.app.Activity;
	import android.content.Intent;

public class PL4_Cliente extends Activity {

	private ClaseProyectos proyecto;
	private TextView tvNombre, tvEmpresa, tvTelefono, tvEmail;
	private Button btTelefono, btEmail;
	private ClaseCliente cliente;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pl4_cliente);
		Bundle b=getIntent().getExtras();
		tvNombre=(TextView) findViewById(R.id.PL4_tvNombre);
		tvEmpresa=(TextView) findViewById(R.id.PL4_tvEmpresa);
		tvTelefono=(TextView) findViewById(R.id.PL4_tvTelefono);
		tvEmail=(TextView) findViewById(R.id.PL4_tvEmail);
		btTelefono=(Button) findViewById(R.id.PL4_btTelefono);
		btEmail=(Button) findViewById(R.id.PL4_btEmail);
		proyecto=(ClaseProyectos) b.getSerializable("Proyecto");
		new ClienteSeleccionado().execute(new String[] {new ClaseConexion().getUrlClientes(), proyecto.getIdCliente()});
	}
	
	private class ClienteSeleccionado extends AsyncTask<String, Integer, String>{
		
		@Override
		protected String doInBackground(String... params) {
			String respuesta="";
			try {
				HttpClient httpclient=new DefaultHttpClient();
				HttpPost httppost=new HttpPost(params[0]);
		        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
		        nameValuePairs.add(new BasicNameValuePair("Peticion", "0"));
		        nameValuePairs.add(new BasicNameValuePair("idCliente", params[1]));
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
			JSONTokener tokener = new JSONTokener(result);
			try{
				JSONObject raiz = new JSONObject(tokener);
				JSONArray lista=raiz.getJSONArray("Clientes");
				for (int i = 0; i < lista.length(); i++) {
					JSONObject fila = lista.getJSONObject(i);
					cliente=new ClaseCliente(fila);
				}
			}catch(Exception e){
			}
			tvNombre.setText("Cliente: "+cliente.getNombre());
			tvEmpresa.setText("Empresa: "+cliente.getEmpresa());
			tvTelefono.setText("Telefono: "+cliente.getTelefono());
			tvEmail.setText("Email: "+cliente.getEmail());
			hacerVisibles();
		}
		
	}
	
	public void hacerLlamada(View v){
		try{
			Intent callIntent=new Intent(Intent.ACTION_DIAL);
			callIntent.setData(Uri.parse("tel:"+cliente.getTelefono()));
	        callIntent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
	        startActivity(callIntent);
		}catch(Exception e){
			mensaje("No puedes realizar llamadas");
		}
	}
	
	public void hacerVisibles(){
		tvNombre.setVisibility(View.VISIBLE);
		tvEmpresa.setVisibility(View.VISIBLE);
		tvTelefono.setVisibility(View.VISIBLE);
		tvEmail.setVisibility(View.VISIBLE);
		btTelefono.setVisibility(View.VISIBLE);
		btEmail.setVisibility(View.VISIBLE);
	}
	
	public void mandarMail(View v){
		try{
			Intent intent=new Intent(Intent.ACTION_SEND);
			intent.setType("text/html");
			intent.putExtra(Intent.EXTRA_EMAIL, new String[]{cliente.getEmail()});
			startActivity(Intent.createChooser(intent, "Enviar el Email"));
		}catch(Exception e){
			mensaje("No dispones de una App de email");
		}
	}
	
	public void mensaje(String mensaje){
    	Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show();
    }

}