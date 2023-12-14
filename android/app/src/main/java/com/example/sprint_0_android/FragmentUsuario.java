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
    private  EditText input1;
    private EditText  input2;

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

        input1 = view.findViewById(R.id.input_cambia_contrasenya1);
        input2 = view.findViewById(R.id.input_cambiar_contrasenya2);

        TextView nombre=view.findViewById(R.id.text_nombre);
        TextView email=view.findViewById(R.id.text_email);
        TextView telefono=view.findViewById(R.id.text_telefono);

        Bundle args = getArguments();

        if (args != null) {
            // Extrae los valores de los argumentos
            String nombreUsuario = args.getString("nombreUsuario", "");
            String userEmail = args.getString("email", "");
            String userTelefono = args.getString("telefono", "");

            // Asigna los valores a las vistas
            nombre.setText("Nombre: " + nombreUsuario);
            email.setText("Email: " + userEmail);
            telefono.setText("Telefono: " + userTelefono);


            cerrar_sesion.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intentToMainPage = new Intent(getContext(), ActivityInicio.class);
                    startActivity(intentToMainPage);
                    Toast.makeText(getContext(), "Sesión Cerrado", Toast.LENGTH_SHORT).show();
                }
            });

            cambia_contrasenya.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    cambiar_contrasenya(userEmail);
                        Log.d(ETIQUETA_LOG, "onClick: cambia contraseña");

                }
            });
        }

        return view;
    }

    public void cambiar_contrasenya(String email){


        JSONObject postData = new JSONObject();
        String urlDestino = "http://192.168.1.106:8080/user/updateUserByEmail";

        if (!this.input1.getText().toString().equals(this.input2.getText().toString())){

            Toast.makeText(getContext(), "Contraseña no son iguales", Toast.LENGTH_SHORT).show();
        }else {
            try {

                CifrarDescifrarAES cifrador = new CifrarDescifrarAES();
                String textoEncriptado = cifrador.encriptar(this.input1.getText().toString());

                postData.put("email", email);
                postData.put("contraseña", textoEncriptado);

                AndroidNetworking.put(urlDestino)
                        .addHeaders("Content-Type", "application/json; charset=utf-8")
                        .addHeaders("email", email)
                        .addJSONObjectBody(postData)
                        .setTag("post_data")
                        .setPriority(Priority.MEDIUM)
                        .build()
                        .getAsJSONObject(new JSONObjectRequestListener(){

                            @Override
                            public void onResponse(JSONObject response) {

                                if (response != null && response.length() > 0) {
                                    input1.setText("");
                                    input2.setText("");
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
            } catch (Exception e) {
                throw new RuntimeException(e);
            }

        }


    }


}
