package com.example.sprint_0_android;



import android.Manifest;
import android.annotation.SuppressLint;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.le.BluetoothLeScanner;
import android.bluetooth.le.ScanCallback;
import android.bluetooth.le.ScanFilter;
import android.bluetooth.le.ScanResult;
import android.bluetooth.le.ScanSettings;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import android.app.Activity;
import android.content.Intent;

import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.fragment.app.Fragment;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;

import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;
import com.journeyapps.barcodescanner.CaptureActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Collections;
import java.util.List;

public class FragmentSonda extends Fragment {

    private Intent elIntentDelServicio = null;
    private static final int CODIGO_PETICION_PERMISOS = 11223344;
    private static final String ETIQUETA_LOG = ">>>>";
    private BluetoothLeScanner elEscanner;
    private String uuidEscaneado ="";
    private TextView Textdist;
    private ScanCallback callbackDelEscaneo = null;

    private Handler handler = new Handler();
    private Runnable runnable;


    private int dist;


    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {

        Log.d(ETIQUETA_LOG, " distancia = " + dist);
        View view = inflater.inflate(R.layout.fragment_sonda, container, false);
        Textdist = view.findViewById(R.id.dist);


        // Si necesitas actualizar un TextView con este valor

        Spinner spinner = view.findViewById(R.id.spinner2);
        String[] array = {"Ahorro de energía", "Uso de energia medio","Alto rendimiento"};
        ArrayAdapter<String> adapter = new ArrayAdapter<>(getContext(), android.R.layout.simple_spinner_item, array);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);


        Button btnQR = view.findViewById(R.id.btnQR);
        btnQR.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                iniciarEscaneo();
                Log.d(ETIQUETA_LOG, "onClick: dado");

            }
        });

        runnable = new Runnable() {
            @Override
            public void run() {
                actualizarVistaConNuevoValor(DistanciaSonda.getInstance().getData());
                // Volver a ejecutar el Runnable después de un intervalo
                handler.postDelayed(this, 1000); // Actualiza cada segundo
            }
        };

        // Iniciar el proceso
        handler.post(runnable);


        return view;
    }

    private void iniciarEscaneo() {
        IntentIntegrator integrator = new IntentIntegrator(getActivity());
        integrator.setDesiredBarcodeFormats(IntentIntegrator.ALL_CODE_TYPES);
        integrator.setPrompt("Escanea un código");
        integrator.setCameraId(0);
        integrator.setBeepEnabled(false);
        integrator.setBarcodeImageEnabled(true);
        integrator.setCaptureActivity(CaptureActivity.class);
        integrator.initiateScan();

        if (
                ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.BLUETOOTH) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.BLUETOOTH_ADMIN) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.BLUETOOTH_CONNECT) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.BLUETOOTH_SCAN) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(requireContext(), Manifest.permission.INTERNET) != PackageManager.PERMISSION_GRANTED
        )
        {
            ActivityCompat.requestPermissions(
                    requireActivity(),
                    new String[]{Manifest.permission.BLUETOOTH,Manifest.permission.BLUETOOTH_ADMIN,Manifest.permission.ACCESS_FINE_LOCATION,Manifest.permission.ACCESS_COARSE_LOCATION,
                            Manifest.permission.BLUETOOTH_CONNECT,Manifest.permission.BLUETOOTH_SCAN,Manifest.permission.INTERNET},
                    CODIGO_PETICION_PERMISOS);
        }
    }

    private void actualizarVistaConNuevoValor(int distancia) {
        if(distancia>=-45){
            Textdist.setText("La sonda está cerca");
        }else if(distancia>=-65){
            Textdist.setText("La sonda está lejos");
        }else if(distancia<-65){
            Textdist.setText("La sonda está muy lejos");
        }
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        // Detener el Handler cuando la actividad se destruya
        handler.removeCallbacks(runnable);
    }
    @Override
    public void onResume() {
        super.onResume();
        // Iniciar el Runnable cuando el fragmento se reanude
        iniciarActualizacion();
    }

    @Override
    public void onPause() {
        super.onPause();
        // Detener el Runnable cuando el fragmento se pause
        handler.removeCallbacks(runnable);
    }
    private void iniciarActualizacion() {
        if (runnable == null) {
            runnable = new Runnable() {
                @Override
                public void run() {
                    actualizarVistaConNuevoValor(DistanciaSonda.getInstance().getData());
                    handler.postDelayed(this, 1000); // Repetir cada segundo
                }
            };
        }
        handler.post(runnable);
    }


}
