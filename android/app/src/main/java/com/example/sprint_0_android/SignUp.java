package com.example.sprint_0_android;

import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import java.util.regex.Pattern;
import java.util.regex.Matcher;
import java.security.MessageDigest;
import javax.crypto.Cipher;
import javax.crypto.spec.SecretKeySpec;

import androidx.appcompat.app.AppCompatActivity;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;

import org.json.JSONException;
import org.json.JSONObject;

public class SignUp extends AppCompatActivity {
    private static final String ETIQUETA_LOG = ">>>>";
    private EditText nombreApellido;
    private EditText correo;
    private EditText telefono;
    private EditText contrasenia;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);

        this.nombreApellido=(EditText) findViewById(R.id.inputNombreApellido);
        this.correo=(EditText) findViewById(R.id.inputCorreo);
        this.telefono=(EditText) findViewById(R.id.inputTelefono);
        this.contrasenia=(EditText) findViewById(R.id.inputContrasenia);

    }
    public void boton_registrar(View v){
        //URL de destino para mandar
        String urlDestino = "http://172.20.10.11/bd/registroApp.php";

        //Objecto JSON para enviar
        JSONObject postData = new JSONObject();

        byte[] datosCifrados;

        //Comprobacion si algún campo esta nulo
        if (nombreApellido.getText().toString().isEmpty()
                ||correo.getText().toString().isEmpty()
                ||telefono.getText().toString().isEmpty()
                ||contrasenia.getText().toString().isEmpty())
        {
            //Si algun campo esta nulo, un mensaje de error
            Toast.makeText(getApplicationContext(), "Campo nulo", Toast.LENGTH_SHORT).show();
        }else if (correo.getText().toString().contains("@")==false)
        {
            //Si el correo no lleva "@"
            Toast.makeText(getApplicationContext(), "El formato de correo es incorrecto", Toast.LENGTH_SHORT).show();
        }else {
            try {

                CifrarDescifrarAES cifrador = new CifrarDescifrarAES(contrasenia.getText().toString());
                String textoEncriptado = cifrador.encriptar(contrasenia.getText().toString());
                String textoDencriptado = cifrador.desencriptar(textoEncriptado);
                Log.d(ETIQUETA_LOG, "encriptado= "+textoEncriptado);
                Log.d(ETIQUETA_LOG, "dencriptado= "+textoDencriptado);

                //Si no hay campo nulo, guarda valor en objeto JSON
                postData.put("nombreApellido", nombreApellido.getText().toString());
                postData.put("email", correo.getText().toString());
                postData.put("telefono", formatearTelefono(telefono.getText().toString()));
                postData.put("contraseña",textoEncriptado);

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
                                            Log.d(ETIQUETA_LOG, "Datos guardados correctamente: " + message);
                                            finish();
                                            Toast.makeText(getApplicationContext(), message, Toast.LENGTH_SHORT).show();

                                        }
                                        //Si success me responde con un 0, un toast con el message
                                        else {
                                            Log.d(ETIQUETA_LOG, "Datos guardados incorrectamente: " + message);
                                            Toast.makeText(getApplicationContext(), message, Toast.LENGTH_SHORT).show();

                                        }
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }

                                } else {
                                    Toast.makeText(getApplicationContext(), "Datos guardados incorrectamente", Toast.LENGTH_SHORT).show();
                                }
                            }
                            @Override
                            public void onError(ANError error) {

                                if (error != null) {
                                    Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage().toString());
                                }
                            }
                        });

                } catch (JSONException e) {
                    e.printStackTrace();
                }
                catch (Exception e) {
                    throw new RuntimeException(e);
            }
        }
    }

    //Funcion para seguir el formato de telefono
    public static String formatearTelefono(String numero) {
        // Utilizar una expresión regular para dividir el número en grupos
        Pattern patron = Pattern.compile("(\\d{3})(\\d{2})(\\d{2})(\\d{2})");
        Matcher matcher = patron.matcher(numero);

        if (matcher.matches()) {
            // Formatear el número utilizando los grupos capturados
            String numeroFormateado = matcher.group(1) + "-" + matcher.group(2) + "-" + matcher.group(3) + "-" + matcher.group(4);
            return numeroFormateado;
        } else {
            // Si el número no coincide con el formato esperado, simplemente devuelve el número original
            return numero;
        }
    }

}
