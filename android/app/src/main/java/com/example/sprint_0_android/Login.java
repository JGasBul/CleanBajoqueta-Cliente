package com.example.sprint_0_android;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;


import androidx.appcompat.app.AppCompatActivity;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONArrayRequestListener;
import com.androidnetworking.interfaces.JSONObjectRequestListener;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.Map;

public class Login extends AppCompatActivity {
    private Button elBotonRegistrar;
    private Button elBotonAceptar;
    private EditText loginEmail;
    private EditText loginContrasenia;
    private static final String ETIQUETA_LOG = ">>>>";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        this.elBotonRegistrar= (Button) findViewById(R.id.buttonToSignUp);
        this.elBotonAceptar= (Button) findViewById(R.id.buttonLogin);
        this.loginEmail = (EditText) findViewById(R.id.inputEmailTelefonoLogin);
        this.loginContrasenia = (EditText) findViewById(R.id.inputContraseniaLogin);


    }
    public void boton_sign_up(View v) {
        Intent intent = new Intent(this, SignUp.class);
        startActivity(intent);
    }

    public void boton_login_aceptar(View v){
        Intent intentToMain = new Intent(this, MainActivity.class);

        String urlDestino = "http://192.168.1.106:8080/user/getUserByEmail";
        JSONObject postData = new JSONObject();

        //Check si hay algún campo nulo
        if (loginEmail.getText().toString().isEmpty()||loginContrasenia.getText().toString().isEmpty()){
            Toast.makeText(getApplicationContext(), "Campo nulo", Toast.LENGTH_SHORT).show();
        }
        //Verificar el formato de correo
        else if(!loginEmail.getText().toString().contains("@")){
            Toast.makeText(getApplicationContext(), "El formato de correo es incorrecto", Toast.LENGTH_SHORT).show();
        }else {
            //Si todos estan correcto, envio la peticion
            try {
                /*
                postData.put("emailTelefono", loginEmail.getText().toString());
                postData.put("contrasenia", loginContrasenia.getText().toString());
                */
                AndroidNetworking.get(urlDestino)
                        .addHeaders("Content-Type", "application/json; charset=utf-8")
                        .addHeaders("email", loginEmail.getText().toString())
                        .setTag("post_data")
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONArray(new JSONArrayRequestListener() {
                            //El servidor me ha respondido con un Json Array
                            @Override
                            public void onResponse(JSONArray response) {

                                if (response != null && response.length() > 0) {
                                    try {
                                        JSONObject responseJSON = new JSONObject(String.valueOf(response.get(0)));
                                        CifrarDescifrarAES cifrado = new CifrarDescifrarAES();
                                        String contraseñaDesencriptada = cifrado.desencriptar(responseJSON.getString("contraseña"));
                                        if (contraseñaDesencriptada.equals(loginContrasenia.getText().toString())) {
                                            Log.d(ETIQUETA_LOG, "Login Correcto ");
                                            Toast.makeText(getApplicationContext(), "Login correcto", Toast.LENGTH_SHORT).show();
                                            //finish();
                                            intentToMain.putExtra("nombreUsuario",responseJSON.getString("nombreApellido"));
                                            intentToMain.putExtra("email",responseJSON.getString("email"));
                                            intentToMain.putExtra("telefono",responseJSON.getString("telefono"));
                                            startActivity(intentToMain);
                                        }
                                        //Si success me responde con un 0, un toast con el message
                                        else {
                                            Log.d(ETIQUETA_LOG, "onResponse: "+contraseñaDesencriptada);
                                            Toast.makeText(getApplicationContext(), "Login fallido", Toast.LENGTH_SHORT).show();
                                        }
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }

                                } else {
                                    Toast.makeText(getApplicationContext(), "El usuario no existe", Toast.LENGTH_SHORT).show();
                                }
                            }
                            @Override
                            public void onError(ANError error) {
                                if (error != null) {
                                    Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage());
                                }
                            }
                        });
            }catch (Exception e) {
                throw new RuntimeException(e);
            }
        }
    }
}

