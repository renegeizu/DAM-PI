package com.rngds.projectleader;

	import java.io.File;
	import android.net.ConnectivityManager;
	import android.net.NetworkInfo;
	import android.os.Bundle;
	import android.view.animation.Animation;
	import android.view.animation.Animation.AnimationListener;
	import android.view.animation.AnimationUtils;
	import android.widget.ImageView;
	import android.widget.Toast;
	import android.app.Activity;
	import android.content.Context;
	import android.content.Intent;

public class PL0_Portada extends Activity {
	
	private static final int ID=7;
	private ImageView ivLogo;
	private Animation transparencia;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.pl0_portada);
        try{
        	File file=new File(getExternalFilesDir(null),"projectLeader.xml");
			file.delete();
        }catch(Exception e){
        }
        ivLogo=(ImageView) findViewById(R.id.PL0_ivLogo);
        transparencia=AnimationUtils.loadAnimation(this, R.anim.efecto_carga);
        transparencia.reset();
        transparencia.setAnimationListener(new AnimationListener(){
        	
			@Override
			public void onAnimationEnd(Animation arg0){
				if(comprobarConexion()==true)
					conexion();
				else
					mensaje("No Tienes Conexion");
					finish();
			}

			@Override
			public void onAnimationRepeat(Animation animation){	
				
			}

			@Override
			public void onAnimationStart(Animation animation){
				
			}
			
		});
		ivLogo.startAnimation(transparencia);
    }
    
    @Override
	public void onActivityResult(int pet, int res, Intent data){
		if (pet==ID){
			File file=new File(getExternalFilesDir(null),"projectLeader.xml");
			file.delete();
			finish();
		}
	}

	private void conexion(){
    	try{
    		startActivityForResult(new Intent(this, PL1_Conexion.class), ID);
    	}catch(Exception e){
    		mensaje("La Aplicación Ha Sufrido Un Error");
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

	public void mensaje(String mensaje){
    	Toast.makeText(this, mensaje, Toast.LENGTH_SHORT).show();
    }
    
}