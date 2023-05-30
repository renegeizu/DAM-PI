package com.rngds.projectleader;

	import java.io.File;
	import java.io.FileOutputStream;
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
	import org.xmlpull.v1.XmlSerializer;
	import com.rngds.projectleader.clases.ClaseConexion;
	import com.rngds.projectleader.clases.ClaseEmpleados;
	import android.net.ConnectivityManager;
	import android.net.NetworkInfo;
	import android.os.AsyncTask;
	import android.os.Bundle;
	import android.util.Xml;
	import android.view.View;
	import android.widget.EditText;
	import android.widget.Toast;
	import android.app.Activity;
	import android.content.Context;
	import android.content.Intent;

public class PL1_Conexion extends Activity {
	
	private EditText etLogin, etPass;
	private ClaseEmpleados empleado;
	private static final int ID=7;
	private Context contexto;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pl1_conexion);
		etLogin=(EditText) findViewById(R.id.PL1_etLogin);
		etPass=(EditText) findViewById(R.id.PL1_etPass);
		contexto=this;
	}
	
	@Override
	public void onActivityResult(int pet, int res, Intent data){
		if (pet==ID){
			finish();
		}
	}

	public boolean comprobarConexion(){
		boolean estado=false;
		ConnectivityManager gesCon=(ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo redwifi=gesCon.getNetworkInfo(ConnectivityManager.TYPE_WIFI);
		NetworkInfo red3g = gesCon.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);
		if(gesCon!=null){
			if(redwifi!=null&&estado==false){
				if(redwifi.isAvailable()==true)
					estado=redwifi.getState()==NetworkInfo.State.CONNECTED;
			}
			if(red3g!=null&&estado==false){
				if(red3g.isAvailable()==true)
					estado=red3g.getState()==NetworkInfo.State.CONNECTED;
			}
		}
		return estado;
	}

	private class ComprobarLogin extends AsyncTask<String, Integer, String>{
		
		@Override
		protected String doInBackground(String... params) {
			String respuesta="";
			try {
				HttpClient httpclient=new DefaultHttpClient();
				HttpPost httppost=new HttpPost(params[0]);
		        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
		        nameValuePairs.add(new BasicNameValuePair("User", params[1]));
		        nameValuePairs.add(new BasicNameValuePair("Pass", params[2]));
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
				JSONArray lista=raiz.getJSONArray("Empleados");
				for (int i = 0; i < lista.length(); i++) {
					JSONObject fila = lista.getJSONObject(i);
					empleado=new ClaseEmpleados(fila);
				}
			}catch(Exception e){
				empleado=new ClaseEmpleados();
			}
			if(empleado.getId().equals("-1")){
				mensaje("Usuario o Contraseña Incorrectos");
			}else if(empleado.getId().equals(null)){
				mensaje("Error en la Conexion");
			}else{
				guardarClave(empleado.getId(), empleado.getUser(), empleado.getPass(), empleado.getPuesto());
		    	startActivityForResult(new Intent(contexto, PL2_Ultimos.class), ID);
			}
		}
		
	}

	public void conectarse(View v){
		if(etLogin.getText().equals("")!=true&&etPass.getText().equals("")!=true)
			new ComprobarLogin().execute(new String[] {new ClaseConexion().getUrlLogin(), 
					etLogin.getText().toString().trim(), etPass.getText().toString().trim()});
		else
			mensaje("El Usuario o la Contraseña no son Correctos");
	}

	private void guardarClave(String id, String user, String pass, String puesto){
		try {
			FileOutputStream fosxml = new FileOutputStream(new File(getExternalFilesDir(null),"projectLeader.xml"));
			XmlSerializer docxml = Xml.newSerializer();
			docxml.setOutput(fosxml, "UTF-8");
			docxml.startDocument(null, Boolean.valueOf(true));
			docxml.setFeature("http://xmlpull.org/v1/doc/features.html#indent-output", true);
			docxml.startTag(null, "empleados");
			docxml.startTag(null, "empleado");
			docxml.attribute(null, "id", id);
			docxml.attribute(null, "user", user);
			docxml.attribute(null, "pass", pass);
			docxml.attribute(null, "puesto", puesto);
			docxml.endTag(null, "empleado");
			docxml.endDocument();
			docxml.flush();
			fosxml.close();
		} catch (Exception e) {
		}
	}

	public void mensaje(String mensaje){
    	Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show();
    }

}