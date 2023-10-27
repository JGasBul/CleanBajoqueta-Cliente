package com.example.sprint_0_android;

import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.bluetooth.BluetoothManager;
import android.bluetooth.le.ScanSettings;
import android.content.Context;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;

import android.Manifest;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.le.BluetoothLeScanner;
import android.bluetooth.le.ScanCallback;
import android.bluetooth.le.ScanFilter;
import android.bluetooth.le.ScanResult;
import android.content.pm.PackageManager;
import android.os.ParcelUuid;
import android.util.Log;
import android.view.View;

import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import java.util.UUID;

import android.content.Intent;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import android.widget.TextView;


import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONArrayRequestListener;
import com.androidnetworking.interfaces.JSONObjectRequestListener;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class MainActivity extends AppCompatActivity {

    private static final String ETIQUETA_LOG = ">>>>";
    private static final int CODIGO_PETICION_PERMISOS = 11223344;
    private BluetoothLeScanner elEscanner;
    private ScanCallback callbackDelEscaneo = null;
    private Intent elIntentDelServicio = null;
    private TextView elTextoMinor;
    private TextView elTextoMajor;
    private TextView salidaTexto;
    private EditText temperaturaInput;
    private EditText co2Input;
    private Button elBotonEnviar;

    private Button elBotonPrueba;

    // _______________________________________________________________
    // Diseño: buscarTodosLosDispositivosBTLE()
    // Descripción:Empieza el scanner y se establece un callback para
    // diferentes caso, si obtiene resultado, lo muestra en logcat
    // _______________________________________________________________
    @SuppressLint("MissingPermission")
    private void buscarTodosLosDispositivosBTLE() {
        this.callbackDelEscaneo = new ScanCallback() {
            @Override
            public void onScanResult(int callbackType, ScanResult resultado) {
                super.onScanResult(callbackType, resultado);
                Log.d(ETIQUETA_LOG, " buscarTodosLosDispositivosBTL(): onScanResult() ");

                mostrarInformacionDispositivoBTLE(resultado);
            }
            @Override
            public void onBatchScanResults(List<ScanResult> results) {
                super.onBatchScanResults(results);
                Log.d(ETIQUETA_LOG, " buscarTodosLosDispositivosBTL(): onBatchScanResults() ");

            }
            @Override
            public void onScanFailed(int errorCode) {
                super.onScanFailed(errorCode);
                Log.d(ETIQUETA_LOG, " buscarTodosLosDispositivosBTL(): onScanFailed() ");

            }
        };
        Log.d(ETIQUETA_LOG, " buscarTodosLosDispositivosBTL(): empezamos a escanear ");
        //Empieza el escanner a escanear, si obtiene resultado, llama el callback del escaneo
        this.elEscanner.startScan(this.callbackDelEscaneo);
    }

    // _______________________________________________________________
    // Diseño: ScanResult ---> mostrarInformacionDispositivosBTLE()
    // Descripción: Recibe un objeto de tipo ScanResult y muestra datos
    // en el logcat
    // _______________________________________________________________
    @SuppressLint("MissingPermission")
    private void mostrarInformacionDispositivoBTLE(ScanResult resultado) {

        BluetoothDevice bluetoothDevice = resultado.getDevice();
        byte[] bytes = resultado.getScanRecord().getBytes();
        int rssi = resultado.getRssi();

        Log.d(ETIQUETA_LOG, " ****************************************************");
        Log.d(ETIQUETA_LOG, " ****** DISPOSITIVO DETECTADO BTLE ****************** ");
        Log.d(ETIQUETA_LOG, " ****************************************************");
        Log.d(ETIQUETA_LOG, " nombre = " + bluetoothDevice.getName());
        Log.d(ETIQUETA_LOG, " toString = " + bluetoothDevice.toString());

        Log.d(ETIQUETA_LOG, " dirección = " + bluetoothDevice.getAddress());
        Log.d(ETIQUETA_LOG, " rssi = " + rssi);

        Log.d(ETIQUETA_LOG, " bytes = " + new String(bytes));
        Log.d(ETIQUETA_LOG, " bytes (" + bytes.length + ") = " + Utilidades.bytesToHexString(bytes));

        TramaIBeacon tib = new TramaIBeacon(bytes);

        Log.d(ETIQUETA_LOG, " ----------------------------------------------------");
        Log.d(ETIQUETA_LOG, " prefijo  = " + Utilidades.bytesToHexString(tib.getPrefijo()));
        Log.d(ETIQUETA_LOG, "          advFlags = " + Utilidades.bytesToHexString(tib.getAdvFlags()));
        Log.d(ETIQUETA_LOG, "          advHeader = " + Utilidades.bytesToHexString(tib.getAdvHeader()));
        Log.d(ETIQUETA_LOG, "          companyID = " + Utilidades.bytesToHexString(tib.getCompanyID()));
        Log.d(ETIQUETA_LOG, "          iBeacon type = " + Integer.toHexString(tib.getiBeaconType()));
        Log.d(ETIQUETA_LOG, "          iBeacon length 0x = " + Integer.toHexString(tib.getiBeaconLength()) + " ( "
                + tib.getiBeaconLength() + " ) ");
        Log.d(ETIQUETA_LOG, " uuid  = " + Utilidades.bytesToHexString(tib.getUUID()));
        Log.d(ETIQUETA_LOG, " uuid  = " + Utilidades.bytesToString(tib.getUUID()));
        Log.d(ETIQUETA_LOG, " major  = " + Utilidades.bytesToHexString(tib.getMajor()) + "( "
                + Utilidades.bytesToInt(tib.getMajor()) + " ) ");
        elTextoMajor.setText ("Major: "  + Utilidades.bytesToInt(tib.getMajor()) );
        Log.d(ETIQUETA_LOG, " minor  = " + Utilidades.bytesToHexString(tib.getMinor()) + "( "
                + Utilidades.bytesToInt(tib.getMinor()) + " ) ");
        elTextoMinor.setText ("Minor: "  + Utilidades.bytesToInt(tib.getMinor()) );
        Log.d(ETIQUETA_LOG, " txPower  = " + Integer.toHexString(tib.getTxPower()) + " ( " + tib.getTxPower() + " )");
        Log.d(ETIQUETA_LOG, " ****************************************************");

    }

    // _______________________________________________________________
    // Diseño: String --->buscarEsteDispositivoBTLE()
    // Descripción: Recibe el nombre de dispositivo que quiere buscar
    // y se filtra en los resultados
    // _______________________________________________________________
    @SuppressLint("MissingPermission")
    private void buscarEsteDispositivoBTLE(final String dispositivoBuscado) {

        if(this.elEscanner==null){
            Log.d(ETIQUETA_LOG, "buscarEsteDispositivoBTLE: No existe el scanner");
            return;
        }
        this.callbackDelEscaneo = new ScanCallback() {
            @Override
            public void onScanResult(int callbackType, ScanResult resultado) {
                super.onScanResult(callbackType, resultado);
                Log.d(ETIQUETA_LOG, "  buscarEsteDispositivoBTLE(): onScanResult() ");

                mostrarInformacionDispositivoBTLE(resultado);
            }
            @Override
            public void onBatchScanResults(List<ScanResult> results) {
                super.onBatchScanResults(results);
                Log.d(ETIQUETA_LOG, "  buscarEsteDispositivoBTLE(): onBatchScanResults() ");

            }
            @Override
            public void onScanFailed(int errorCode) {
                super.onScanFailed(errorCode);
                Log.d(ETIQUETA_LOG, "  buscarEsteDispositivoBTLE(): onScanFailed() ");
            }
        };

        Log.d(ETIQUETA_LOG, "  buscarEsteDispositivoBTLE(): empezamos a escanear buscando: " + dispositivoBuscado);

        //Crea un scanfilter y añade el nombre de dispositivo
        ScanFilter scanFilter = new ScanFilter.Builder()
                .setDeviceName(dispositivoBuscado)
                .build();

        //Configurar el setting del scanner
        ScanSettings scanSettings = new ScanSettings.Builder()
                .setScanMode(ScanSettings.SCAN_MODE_LOW_LATENCY)
                .build();

        //Empieza el escaneo con el filtro
        this.elEscanner.startScan(Collections.singletonList(scanFilter), scanSettings, this.callbackDelEscaneo);

    }

    // _______________________________________________________________
    // Diseño: detenerBusquedaDispositivosBTLE()
    // Descripción: Parar la busqueda
    // _______________________________________________________________
    @SuppressLint("MissingPermission")
    private void detenerBusquedaDispositivosBTLE() {

        //Parar el escanner y anular el callback del escaneo
        if (this.callbackDelEscaneo == null) {
            return;
        }else {

            this.elEscanner.stopScan(this.callbackDelEscaneo);
            this.callbackDelEscaneo = null;
        }

    }

    // --------------------------BOTON--------------------------------

    public void botonBuscarDispositivosBTLEPulsado(View v) {

        Log.d(ETIQUETA_LOG, " boton arrancar servicio Pulsado" );

        if ( this.elIntentDelServicio != null ) {
            // ya estaba arrancado
            return;
        }

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH_SCAN) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.

            return;
        }

        Log.d(ETIQUETA_LOG, " MainActivity.constructor : voy a arrancar el servicio");
        this.elIntentDelServicio = new Intent(this, ServicioEscuharBeacons.class);
        this.elIntentDelServicio.putExtra("tiempoDeEspera", (long) 5000);
        startService( this.elIntentDelServicio );

        Log.d(ETIQUETA_LOG, " boton buscar dispositivos BTLE Pulsado");
        this.buscarTodosLosDispositivosBTLE();
    }

    // _______________________________________________________________
    public void botonBuscarNuestroDispositivoBTLEPulsado(View v) {
        Log.d(ETIQUETA_LOG, " boton nuestro dispositivo BTLE Pulsado");
        //this.buscarEsteDispositivoBTLE( Utilidades.stringToUUID( "EPSG-GTI-PROY-3A" ) );

        if ( this.elIntentDelServicio != null ) {
            // ya estaba arrancado
            return;
        }

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH_SCAN) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.

            return;
        }

        Log.d(ETIQUETA_LOG, " MainActivity.constructor : voy a arrancar el servicio");
        this.elIntentDelServicio = new Intent(this, ServicioEscuharBeacons.class);
        this.elIntentDelServicio.putExtra("tiempoDeEspera", (long) 5000);
        startService( this.elIntentDelServicio );

        Log.d(ETIQUETA_LOG, " iniciamos la buscaqueda epsg-gti" );
        this.buscarEsteDispositivoBTLE( "GTI-3A_CHEN" );
        //this.buscarEsteDispositivoBTLE("fistro");

    }

    // _______________________________________________________________
    public void botonDetenerBusquedaDispositivosBTLEPulsado(View v) {

        if ( this.elIntentDelServicio == null ) {
            // no estaba arrancado
            return;
        }

        stopService( this.elIntentDelServicio );
        Log.d(ETIQUETA_LOG, " boton detener servicio Pulsado" );

        this.elIntentDelServicio = null;
        Log.d(ETIQUETA_LOG, " boton detener busqueda dispositivos BTLE Pulsado");

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH_SCAN) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.

            return;
        }
        this.detenerBusquedaDispositivosBTLE();
    }

    // _______________________________________________________________
    // Diseño: inicializarBlueTooth()
    // Descripción: Pedir los permisos de BLUETOOTH y lo enciende
    // _______________________________________________________________
    @SuppressLint("MissingPermission")
    private void inicializarBlueTooth() {
        Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): obtenemos adaptador BT ");
        //Coger el bluetooth manager del servicio BLUETOOTH_SERVICE
        BluetoothManager bluetoothManager = (BluetoothManager) getSystemService(Context.BLUETOOTH_SERVICE);

        Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): habilitamos adaptador BT ");
        //Coger el adapter desde el manager del bluetooth y lo enciende
        BluetoothAdapter bta = bluetoothManager.getAdapter();
        bta.enable();

        Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): habilitado =  " + bta.isEnabled() );
        Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): estado =  " + bta.getState() );

        Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): obtenemos escaner btle ");
        this.elEscanner = bta.getBluetoothLeScanner();

        if ( this.elEscanner == null ) {
            Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): Socorro: NO hemos obtenido escaner btle  !!!!");
            return;
        }

        Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): voy a perdir permisos (si no los tuviera) !!!!");
        //Check si tengo todos los permisos necesarios, si no los tengo, pido todas las permisiones necesarias
        if (
                ContextCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH_ADMIN) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH_CONNECT) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH_SCAN) != PackageManager.PERMISSION_GRANTED
                        || ContextCompat.checkSelfPermission(this, Manifest.permission.INTERNET) != PackageManager.PERMISSION_GRANTED
        )
        {
            ActivityCompat.requestPermissions(
                    MainActivity.this,
                    new String[]{Manifest.permission.BLUETOOTH,Manifest.permission.BLUETOOTH_ADMIN,Manifest.permission.ACCESS_FINE_LOCATION,Manifest.permission.ACCESS_COARSE_LOCATION,
                            Manifest.permission.BLUETOOTH_CONNECT,Manifest.permission.BLUETOOTH_SCAN,Manifest.permission.INTERNET},
                    CODIGO_PETICION_PERMISOS);
        }
        else {
            Log.d(ETIQUETA_LOG, " inicializarBlueTooth(): parece que YA tengo los permisos necesarios !!!!");
        }
    }

    // _______________________________________________________________
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        this.elBotonEnviar =(Button) findViewById(R.id.elBotonEnviar);
        this.elBotonPrueba =(Button) findViewById(R.id.elBotonPrueba);
        this.elTextoMinor = (TextView) findViewById(R.id.elTextoMinor);
        this.elTextoMajor =(TextView) findViewById(R.id.elTextoMajor);
        this.salidaTexto = (TextView) findViewById(R.id.salidaTexto);

        this.temperaturaInput = (EditText) findViewById(R.id.temperaturaInput);
        this.co2Input = (EditText) findViewById(R.id.co2Input);

        ActivityCompat.requestPermissions(MainActivity.this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 1);

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED)
        {
            ActivityCompat.requestPermissions(MainActivity.this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 1);

            return;
        }else {

            Toast.makeText(getApplicationContext(),"GPS Activado",Toast.LENGTH_SHORT).show();
        }

        Log.d(ETIQUETA_LOG, " onCreate(): empieza ");

        inicializarBlueTooth();

        Log.d(ETIQUETA_LOG, " onCreate(): termina ");

        Log.d("clienterestandroid", "fin onCreate()");
    }

    // _______________________________________________________________
    public void onRequestPermissionsResult(int requestCode, String[] permissions,
                                           int[] grantResults) {
        super.onRequestPermissionsResult( requestCode, permissions, grantResults);

        switch (requestCode) {
            case CODIGO_PETICION_PERMISOS:
                // If request is cancelled, the result arrays are empty.
                if (grantResults.length > 0 &&
                        grantResults[0] == PackageManager.PERMISSION_GRANTED) {

                    Log.d(ETIQUETA_LOG, " onRequestPermissionResult(): permisos concedidos  !!!!");
                    // Permission is granted. Continue the action or workflow
                    // in your app.

                }  else {

                    Log.d(ETIQUETA_LOG, " onRequestPermissionResult(): Socorro: permisos NO concedidos  !!!!");
                }
                return;
        }

    }

    // _______________________________________________________________
    public void boton_prueba_pulsado (View quien) {
        Log.d("clienterestandroid", "boton_prueba_pulsado");

        //Url de destino
        String urlComprobarComproDestino = "http://192.168.1.106/Sprint_0_Web/logica/comprobarenviomedicion.php";

        //Añado parametros y los envio al enlace correspondiente
        AndroidNetworking.get(urlComprobarComproDestino)
                .addQueryParameter("temperatura",  temperaturaInput.getText().toString())
                .addQueryParameter("co2", co2Input.getText().toString())
                .setPriority(Priority.MEDIUM)
                .build()
                .getAsJSONObject(new JSONObjectRequestListener() {
                    //El servidor me ha respondido con un Json Object
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            //Leo el mensaje que hay en dentro del response
                            String success = response.getString("success");
                            String message = response.getString("message");

                            //Pongo los mensajes en la salida de texto
                            if ("success".equals(success)) {
                                salidaTexto.setText(message);
                            } else {
                                // Aquí puedes manejar la respuesta que no es un éxito
                                salidaTexto.setText(message);
                            }
                        } catch (JSONException e) {
                            // Manejo cualquier error que ocurra al analizar la respuesta JSON
                            e.printStackTrace();
                        }
                    }
                    @Override
                    public void onError(ANError error) {
                        // Tengo error, lo imprimo en logcat
                        if (error != null) {
                            Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage());
                        }
                    }
                });
    }

    // _______________________________________________________________
    public void boton_enviar_pulsado_client (View quien) {
        Log.d("clienterestandroid", "boton_enviar_pulsado_client");

            LocationManager locManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
            @SuppressLint("MissingPermission") Location loc = locManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);

            //Url de destino
            String urlDestino = "http://192.168.1.106/Sprint_0_Web/logica/insertarmedicion.php";

            //Creo un objeto JSON e introducir valores
            JSONObject postData = new JSONObject();
            try {
                postData.put("id", "");
                postData.put("temperatura", temperaturaInput.getText().toString());
                postData.put("co2", co2Input.getText().toString());
                postData.put("latitud",String.valueOf(loc.getLongitude()));
                postData.put("longitud", String.valueOf(loc.getLongitude()));

            } catch (JSONException e) {
                e.printStackTrace();
            }

            //Envío el objeto JSON a tal url de destino
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
                                Log.d(ETIQUETA_LOG, "Datos guardados incorrectamente ");
                            }
                        }

                        @Override
                        public void onError(ANError error) {

                            if (error != null) {
                                Log.d(ETIQUETA_LOG, "Mensaje de error: " + error.getMessage().toString());
                            }
                        }
                    });


    }
}