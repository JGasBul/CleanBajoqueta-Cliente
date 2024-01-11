package com.example.sprint_0_android;

import android.content.Context;
import android.content.res.ColorStateList;
import android.graphics.PorterDuff;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONArrayRequestListener;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.time.Instant;
import java.time.LocalDateTime;
import java.time.ZoneId;
import java.util.ArrayList;
import java.util.List;

public class MainPage extends Fragment {
    private static final String ETIQUETA_LOG = ">>>>";
    private String email;

    private float mediaValor=0;
    private int mediaTemperatura=0;
    private float valor1;
    private float valor2;
    private float valor3;

    private int temperatura1;
    private int temperatura2;
    private int temperatura3;

    private String hora1;
    private String hora2;
    private String hora3;
    private TextView Salida_temperatura;
    private TextView Salida_calidad;
    private TextView Salida_valor;
    private TextView Salida_info;


    public static MainPage newInstance( String email) {
        MainPage fragment = new MainPage();
        Bundle args = new Bundle();
        args.putString("email", email);
        fragment.setArguments(args);
        return fragment;
    }
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.activity_main_page, container, false);
        RecyclerView recyclerView = view.findViewById(R.id.recycler_view);

        Salida_temperatura=view.findViewById(R.id.Salida_Temperatura);
        Salida_calidad=view.findViewById(R.id.Salida_Calidad);
        Salida_valor=view.findViewById(R.id.salida_valor);
        Salida_info=view.findViewById(R.id.salida_info);

        Bundle args = getArguments();
        if (args != null) {
            email=args.getString("email");
            Log.d(ETIQUETA_LOG, "onCreateView: "+args.getString("email"));
        }

        String urlDestino = "http://192.168.1.106:8080/mediciones/recuperar_medicions/100";
        String urlDestino2 = "http://192.168.1.106:8080/mediciones/ultima_medicion";

        AndroidNetworking.get(urlDestino)
                .addHeaders("Content-Type", "application/json; charset=utf-8")
                .addHeaders("email", email)
                .setTag("get_data")
                .setPriority(Priority.MEDIUM)
                .build()
                .getAsJSONArray(new JSONArrayRequestListener() {
                    //El servidor me ha respondido con un Json Array
                    List<Medicion> mediciones = new ArrayList<Medicion>();
                    @Override
                    public void onResponse(JSONArray response) {
                        if (response != null && response.length() > 0) {

                            JSONObject Elemento1 = null;
                            JSONObject Elemento2 = null;
                            JSONObject Elemento3 = null;
                            try {
                                Elemento1 = response.getJSONObject(response.length()-3);
                                Elemento2 = response.getJSONObject(response.length()-2);
                                Elemento3 = response.getJSONObject(response.length()-1);
                                valor1 = Elemento1.optInt("valor", 0);
                                valor2 = Elemento2.optInt("valor", 0);
                                valor3 = Elemento3.optInt("valor", 0);
                                temperatura1=Elemento1.optInt("temperatura",0);
                                temperatura2=Elemento2.optInt("temperatura",0);
                                temperatura3=Elemento3.optInt("temperatura",0);

                                hora1=Elemento1.optString("instante","");
                                hora2=Elemento2.optString("instante","");
                                hora3=Elemento3.optString("instante","");
                                Instant instant1 = Instant.parse(hora1);
                                Instant instant2 = Instant.parse(hora2);
                                Instant instant3 = Instant.parse(hora3);
                                LocalDateTime localDateTime1 = LocalDateTime.ofInstant(instant1, ZoneId.of("UTC"));
                                LocalDateTime localDateTime2 = LocalDateTime.ofInstant(instant2, ZoneId.of("UTC"));
                                LocalDateTime localDateTime3 = LocalDateTime.ofInstant(instant3, ZoneId.of("UTC"));

                                mediciones.add(new Medicion(+localDateTime1.getHour()+1+":"+localDateTime1.getMinute(),+temperatura1+"ºC",String.valueOf(valor1)));
                                mediciones.add(new Medicion(+localDateTime2.getHour()+1+":"+localDateTime2.getMinute(),+temperatura2+"ºC",String.valueOf(valor2)));
                                mediciones.add(new Medicion(+localDateTime3.getHour()+1+":"+localDateTime3.getMinute(),+temperatura3+"ºC",String.valueOf(valor3)));

                                for (int i=0;i<response.length();i++){
                                    JSONObject Elemento = null;
                                    try {
                                        Elemento = response.getJSONObject(i);
                                        int valor = Elemento.optInt("valor", 0);
                                        int valor2 = Elemento.optInt("temperatura",0);
                                        mediaValor+=valor;
                                        mediaTemperatura+=valor2;
                                        Log.d(ETIQUETA_LOG, "onResponse: "+valor);
                                    } catch (JSONException e) {
                                        throw new RuntimeException(e);
                                    }
                                }

                                ColorStateList verde = ColorStateList.valueOf(0xFF4CA157);
                                ColorStateList amarillo = ColorStateList.valueOf(0xFFB6A741);
                                ColorStateList rojo = ColorStateList.valueOf(0xFFE80B0B);

                                mediaValor=mediaValor/response.length();
                                mediaTemperatura=mediaTemperatura/response.length();
                                if (mediaValor>=0&&mediaValor<=50){

                                    Salida_calidad.setText("Excelente");
                                    Salida_calidad.setBackgroundTintList(verde);
                                    Salida_valor.setText(String.valueOf(mediaValor));
                                    Salida_valor.setTextColor(verde);
                                    Salida_info.setText("Peligro Escaso");
                                    Salida_info.setBackgroundTintList(verde);
                                    Salida_temperatura.setText(String.valueOf(mediaTemperatura)+"ºC");

                                }else if(mediaValor>=50&&mediaValor<=75){

                                    Salida_calidad.setText("Regular");
                                    Salida_calidad.setBackgroundTintList(amarillo);
                                    Salida_valor.setText(String.valueOf(mediaValor));
                                    Salida_valor.setTextColor(amarillo);
                                    Salida_info.setText("Peligro Moderado");
                                    Salida_info.setBackgroundTintList(amarillo);
                                    Salida_temperatura.setText(String.valueOf(mediaTemperatura)+"ºC");
                                }else {
                                    Salida_calidad.setText("Tóxico");
                                    Salida_calidad.setBackgroundTintList(rojo);
                                    Salida_valor.setText(String.valueOf(mediaValor));
                                    Salida_valor.setTextColor(rojo);
                                    Salida_info.setText("Peligro Elevado");
                                    Salida_info.setBackgroundTintList(rojo);
                                    Salida_temperatura.setText(String.valueOf(mediaTemperatura)+"ºC");
                                }

                            } catch (JSONException e) {
                                throw new RuntimeException(e);
                            }

                            recyclerView.setLayoutManager(new LinearLayoutManager(view.getContext()));
                            recyclerView.setAdapter(new AdapterRecyclerView(getActivity().getApplicationContext(), mediciones));
                        }
                    }
                    @Override
                    public void onError(ANError error) {
                        if (error != null) {
                            Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage());
                        }
                    }
                });

        return view;
    }
}

/*
 Log.d(ETIQUETA_LOG, "onResponse: "+response.length());
                            for (int i=0;i<response.length();i++){
                                JSONObject Elemento = null;
                                try {
                                    Elemento = response.getJSONObject(i);
                                    int valor = Elemento.optInt("valor", 0);
                                    media+=valor;
                                    Log.d(ETIQUETA_LOG, "onResponse: "+valor);
                                } catch (JSONException e) {
                                    throw new RuntimeException(e);
                                }

                            }
                            media=media/response.length();
                            Log.d(ETIQUETA_LOG, "onResponse: "+media);
 */