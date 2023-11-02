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
import com.androidnetworking.interfaces.JSONObjectRequestListener;

import org.json.JSONException;
import org.json.JSONObject;

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

        String urlDestino = "http://172.20.10.11/bd/loginApp.php";
        JSONObject postData = new JSONObject();

        if (loginEmail.getText().toString().isEmpty()||loginContrasenia.getText().toString().isEmpty()){
            Toast.makeText(getApplicationContext(), "Campo nulo", Toast.LENGTH_SHORT).show();
        }else if(!loginEmail.getText().toString().contains("@")){
            Toast.makeText(getApplicationContext(), "El formato de correo es incorrecto", Toast.LENGTH_SHORT).show();
        }else {
            try {
                postData.put("emailTelefono", loginEmail.getText().toString());
                postData.put("contrasenia", loginContrasenia.getText().toString());

                AndroidNetworking.post(urlDestino)
                        .addHeaders("Content-Type", "application/json; charset=utf-8")
                        .addJSONObjectBody(postData)
                        .setTag("post_data")
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONObject(new JSONObjectRequestListener() {
                            //El servidor me ha respondido con un Json Object
                            @Override
                            public void onResponse(JSONObject response) {

                                if (response != null && response.length() > 0) {
                                    try {
                                        //Leo el mensaje que hay en dentro del response
                                        String success = response.getString("success");
                                        String message = response.getString("message");

                                        //Si success me responde con un 1, un toast con el message
                                        if ("1".equals(success)) {
                                            Log.d(ETIQUETA_LOG, "Login Correcto " + message);
                                            Toast.makeText(getApplicationContext(), message, Toast.LENGTH_SHORT).show();
                                            finish();
                                            startActivity(intentToMain);
                                        }
                                        //Si success me responde con un 0, un toast con el message
                                        else {
                                            Log.d(ETIQUETA_LOG, "Login Fallado: " + message);
                                            Toast.makeText(getApplicationContext(), message, Toast.LENGTH_SHORT).show();

                                        }
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }

                                } else {
                                    Toast.makeText(getApplicationContext(), "Sin respuesta", Toast.LENGTH_SHORT).show();
                                }
                            }
                            @Override
                            public void onError(ANError error) {

                                if (error != null) {
                                    Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage().toString());
                                }
                            }
                        });

            }catch (Exception e) {
                throw new RuntimeException(e);
            }
        }
    }
}

