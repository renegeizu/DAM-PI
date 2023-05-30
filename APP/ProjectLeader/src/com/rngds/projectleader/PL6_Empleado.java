package com.rngds.projectleader;

	import com.rngds.projectleader.clases.ClaseEmpleados;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;
import android.app.Activity;
import android.content.Intent;

public class PL6_Empleado extends Activity {
	
	private ClaseEmpleados empleado;
	private TextView tvNombre, tvUser, tvFechaNacimiento, tvPuesto, tvTelefono, tvEmail;
	private Button btTelefono, btEmail;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pl6_empleado);
		Bundle b=getIntent().getExtras();
		empleado=(ClaseEmpleados) b.getSerializable("Empleado");
		tvNombre=(TextView) findViewById(R.id.PL6_tvNombre);
		tvNombre.setText("Empleado: "+empleado.getNombre());
		tvUser=(TextView) findViewById(R.id.PL6_tvUser);
		tvUser.setText("Usuario: "+empleado.getUser());
		tvFechaNacimiento=(TextView) findViewById(R.id.PL6_tvFechaNacimiento);
		tvFechaNacimiento.setText("Fecha Nacimiento: "+empleado.getFechaNacimiento());
		tvPuesto=(TextView) findViewById(R.id.PL6_tvPuesto);
		tvPuesto.setText("Puesto: "+empleado.getPuesto());
		tvTelefono=(TextView) findViewById(R.id.PL6_tvTelefono);
		tvTelefono.setText("Telefono: "+empleado.getTelefono());
		tvEmail=(TextView) findViewById(R.id.PL6_tvEmail);
		tvEmail.setText("Email: "+empleado.getEmail());
		btTelefono=(Button) findViewById(R.id.PL6_btTelefono);
		btEmail=(Button) findViewById(R.id.PL6_btEmail);
		hacerVisibles();
	}
	
	public void hacerLlamada(View v){
		try{
			Intent callIntent=new Intent(Intent.ACTION_DIAL);
			callIntent.setData(Uri.parse("tel:"+empleado.getTelefono()));
	        callIntent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
	        startActivity(callIntent);
		}catch(Exception e){
			mensaje("No puedes realizar llamadas");
		}
	}
	
	public void hacerVisibles(){
		tvNombre.setVisibility(View.VISIBLE);
		tvUser.setVisibility(View.VISIBLE);
		tvFechaNacimiento.setVisibility(View.VISIBLE);
		tvPuesto.setVisibility(View.VISIBLE);
		tvTelefono.setVisibility(View.VISIBLE);
		tvEmail.setVisibility(View.VISIBLE);
		btTelefono.setVisibility(View.VISIBLE);
		btEmail.setVisibility(View.VISIBLE);
	}
	
	public void mandarMail(View v){
		try{
			Intent intent=new Intent(Intent.ACTION_SEND);
			intent.setType("text/html");
			intent.putExtra(Intent.EXTRA_EMAIL, new String[]{empleado.getEmail()});
			startActivity(Intent.createChooser(intent, "Enviar el Email"));
		}catch(Exception e){
			mensaje("No dispones de una App de email");
		}
	}
	
	public void mensaje(String mensaje){
    	Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show();
    }

}
