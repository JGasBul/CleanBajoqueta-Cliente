package com.example.sprint_0_android;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONArrayRequestListener;
import com.androidnetworking.interfaces.JSONObjectRequestListener;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class FragmentUsuario extends Fragment {

    private static final String ETIQUETA_LOG = ">>>>";
    private  EditText contraVieja;
    private EditText  contraNueva;
    private EditText inputnombre;
    private EditText inputtelefono;

    private String nombreUsuario ;
    private String userEmail;
    private String userTelefono;

    private TextView nombre;
    private TextView email;
    private TextView telefono;



    public static FragmentUsuario newInstance(String nombreUsuario, String email, String telefono) {
        FragmentUsuario fragment = new FragmentUsuario();
        Bundle args = new Bundle();
        args.putString("nombreUsuario", nombreUsuario);
        args.putString("email", email);
        args.putString("telefono", telefono);
        fragment.setArguments(args);
        return fragment;
    }


    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        // Usa el archivo layout fragment_fragment1.xml para este fragmento
        View view = inflater.inflate(R.layout.fragment_usuario, container, false);
        Button cerrar_sesion = view.findViewById(R.id.button_cerrar_sesion);
        Button cambia_contrasenya=view.findViewById(R.id.button_cambiar_contrasenya);
        Button cambiar_perfil = view.findViewById(R.id.button_cambiar_perfil);
        inputnombre=view.findViewById(R.id.input_cambia_nombre);
        inputtelefono=view.findViewById(R.id.input_cambiar_telefono);

        contraVieja = view.findViewById(R.id.input_cambia_contrasenya1);
        contraNueva = view.findViewById(R.id.input_cambiar_contrasenya2);

        this.nombre=view.findViewById(R.id.text_nombre);
        this.email=view.findViewById(R.id.text_email);
        this.telefono=view.findViewById(R.id.text_telefono);



        Bundle args = getArguments();

        if (args != null) {
            // Extrae los valores de los argumentos

            this.nombreUsuario = args.getString("nombreUsuario", "");
            this.userEmail = args.getString("email", "");
            this.userTelefono = args.getString("telefono", "");

            // Asigna los valores a las vistas
            this.nombre.setText("Nombre: " + this.nombreUsuario);
            this.email.setText("Email: " + this.userEmail);
            this.telefono.setText("Telefono: " +this.userTelefono);


            cerrar_sesion.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intentToMainPage = new Intent(getContext(), ActivityInicio.class);
                    startActivity(intentToMainPage);
                    Toast.makeText(getContext(), "Sesión Cerrado", Toast.LENGTH_SHORT).show();
                    getActivity().finish();
                }
            });

            cambia_contrasenya.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    cambiar_contrasenya();
                    Log.d(ETIQUETA_LOG, "onClick: cambia contraseña");

                }
            });
            cambiar_perfil.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    cambiar_Perfil();
                    Log.d(ETIQUETA_LOG, "onClick: cambia perfil");
                }
            });
        }

        return view;
    }

    public void cambiar_contrasenya(){
        JSONObject postData = new JSONObject();
        String urlDestino = "http://192.168.1.106:8080/user/getUserByEmail";
        String urlDestino2 = "http://192.168.1.106:8080/user/updateUserByEmail";

        if(this.contraNueva.getText().toString().isEmpty()||this.contraVieja.getText().toString().isEmpty()){
            Toast.makeText(getContext(), "Campo sin rellenar", Toast.LENGTH_SHORT).show();
        }
        else {
            try {
                CifrarDescifrarAES cifrador = new CifrarDescifrarAES();
                String contraViejaEncriptado = cifrador.encriptar(this.contraVieja.getText().toString());
                String contraNuevaEncriptado = cifrador.encriptar(this.contraNueva.getText().toString());

                AndroidNetworking.get(urlDestino)
                        .addHeaders("Content-Type", "application/json; charset=utf-8")
                        .addHeaders("email", this.userEmail)
                        .setTag("get_data")
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONArray(new JSONArrayRequestListener(){
                            @Override
                            public void onResponse(JSONArray response) {

                                if (response != null && response.length() > 0) {
                                    try {
                                        JSONObject primerElemento = response.getJSONObject(0);
                                        String cVieja = primerElemento.optString("contraseña", "");

                                        if (!cVieja.equals(contraViejaEncriptado)){
                                            Toast.makeText(getContext(), "Contraseña vieja incorrecta", Toast.LENGTH_SHORT).show();
                                            contraVieja.setText("");
                                            contraNueva.setText("");

                                        }else {
                                            postData.put("email", userEmail);
                                            postData.put("contraseña", contraNuevaEncriptado);

                                            AndroidNetworking.put(urlDestino2)
                                                    .addHeaders("Content-Type", "application/json; charset=utf-8")
                                                    .addHeaders("email",userEmail)
                                                    .addJSONObjectBody(postData)
                                                    .setTag("post_data")
                                                    .setPriority(Priority.MEDIUM)
                                                    .build()
                                                    .getAsJSONObject(new JSONObjectRequestListener(){
                                                        @Override
                                                        public void onResponse(JSONObject response) {

                                                            if (response != null && response.length() > 0) {
                                                                contraVieja.setText("");
                                                                contraNueva.setText("");
                                                                Toast.makeText(getContext(), "Contraseña cambiada correctamente", Toast.LENGTH_SHORT).show();

                                                            } else {
                                                                Toast.makeText(getContext(), "No ha podido cambiar", Toast.LENGTH_SHORT).show();
                                                            }
                                                        }

                                                        @Override
                                                        public void onError(ANError error) {
                                                            if (error != null) {
                                                                Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage());
                                                            }
                                                        }
                                                    });
                                        }

                                    } catch (JSONException e) {
                                        throw new RuntimeException(e);
                                    }

                                } else {
                                    Toast.makeText(getContext(), "No ha podido cambiar", Toast.LENGTH_SHORT).show();
                                }
                            }

                            @Override
                            public void onError(ANError error) {
                                if (error != null) {
                                    Log.d(ETIQUETA_LOG, "Mensaje de error 1: " + error.getMessage());

                                }
                            }
                        });
            } catch (Exception e) {
                throw new RuntimeException(e);
            }



        }
    }

    public void cambiar_Perfil(){
        JSONObject postData = new JSONObject();
        String urlDestino = "http://192.168.1.106:8080/user/updateUserByEmail";

        try {
            if (this.inputnombre.getText().toString().isEmpty()&&this.inputtelefono.getText().toString().isEmpty()){
                Toast.makeText(getContext(), "Datos nulos", Toast.LENGTH_SHORT).show();
            }else {
                if(!this.inputnombre.getText().toString().isEmpty()&&!this.inputtelefono.getText().toString().isEmpty()){
                    postData.put("nombreApellido", this.inputnombre.getText().toString());
                    postData.put("telefono", this.inputtelefono.getText().toString());

                }else if(!this.inputnombre.getText().toString().isEmpty()){
                    postData.put("nombreApellido", this.inputnombre.getText().toString());
                }else {
                    postData.put("telefono", this.inputtelefono.getText().toString());
                }

                AndroidNetworking.put(urlDestino)
                        .addHeaders("Content-Type", "application/json; charset=utf-8")
                        .addHeaders("email", this.userEmail)
                        .addJSONObjectBody(postData)
                        .setTag("post_data")
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONObject(new JSONObjectRequestListener(){

                            @Override
                            public void onResponse(JSONObject response) {

                                if (response != null && response.length() > 0) {
                                    if (!inputnombre.getText().toString().isEmpty()&&!inputtelefono.getText().toString().isEmpty()){
                                        nombreUsuario=inputnombre.getText().toString();
                                        userTelefono=inputtelefono.getText().toString();
                                        nombre.setText(nombreUsuario);
                                        telefono.setText(userTelefono);
                                    }else if (!inputnombre.getText().toString().isEmpty()){
                                        nombreUsuario=inputnombre.getText().toString();
                                        nombre.setText(nombreUsuario);
                                    }else {
                                        userTelefono=inputtelefono.getText().toString();
                                        telefono.setText(userTelefono);
                                    }
                                    inputnombre.setText("");
                                    inputtelefono.setText("");
                                    Toast.makeText(getContext(), "Perfil cambiada correctamente", Toast.LENGTH_SHORT).show();

                                } else {
                                    Toast.makeText(getContext(), "No ha podido cambiar", Toast.LENGTH_SHORT).show();
                                }
                            }

                            @Override
                            public void onError(ANError error) {
                                if (error != null) {
                                    Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage());

                                }
                            }
                        });
            }

        } catch (Exception e) {
            throw new RuntimeException(e);
        }


    }


}
