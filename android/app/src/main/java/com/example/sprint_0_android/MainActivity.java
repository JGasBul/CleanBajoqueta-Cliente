package com.example.sprint_0_android;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothManager;
import android.bluetooth.le.BluetoothLeScanner;
import android.bluetooth.le.ScanCallback;
import android.bluetooth.le.ScanFilter;
import android.bluetooth.le.ScanResult;
import android.bluetooth.le.ScanSettings;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.media.AudioAttributes;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.app.NotificationCompat;
import androidx.core.content.ContextCompat;
import androidx.viewpager2.widget.ViewPager2;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;


import com.androidnetworking.AndroidNetworking;
import com.androidnetworking.common.Priority;
import com.androidnetworking.error.ANError;
import com.androidnetworking.interfaces.JSONObjectRequestListener;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;
import com.journeyapps.barcodescanner.CaptureActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.text.DecimalFormat;
import java.util.Locale;
import com.google.android.material.tabs.TabLayout;
import com.google.android.material.tabs.TabLayoutMediator;


public class MainActivity extends AppCompatActivity {

    private static final String ETIQUETA_LOG = ">>>>";
    private static final int CODIGO_PETICION_PERMISOS = 11223344;
    private BluetoothLeScanner elEscanner;
    private ScanCallback callbackDelEscaneo = null;
    private Intent elIntentDelServicio = null;
    private TextView salidaTexto;
    private Button btnQR;

    private Button btnEnviaMed;
    private TextView TextoMajor;
    private TextView TextoMinor;
    private TextView Textdist;

    private String uuidEscaneado ="";

    //Variables para notificaciones
    public FusedLocationProviderClient fusedLocationProviderClient;
    public String Lat,Long,address,city,country;
    public List<String> listaLocalizacion = new ArrayList<>();

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

        //TextoMajor.setText(String.valueOf(    Utilidades.bytesToInt(tib.getMajor())));
        //TextoMinor.setText(String.valueOf( Utilidades.bytesToInt(tib.getMinor())));

        //Distancia sonda movil
        Log.d(ETIQUETA_LOG, " distancia = " + rssi);
        //Textdist.setText(String.valueOf(rssi));
        //distanciasonda(rssi);



        Log.d(ETIQUETA_LOG, " minor  = " + Utilidades.bytesToHexString(tib.getMinor()) + "( "
                + Utilidades.bytesToInt(tib.getMinor()) + " ) ");
        Log.d(ETIQUETA_LOG, " txPower  = " + Integer.toHexString(tib.getTxPower()) + " ( " + tib.getTxPower() + " )");
        Log.d(ETIQUETA_LOG, " ****************************************************");

        //Enviar Medicion (Major=id_Contaminante, Minor=valor)
        int id_contaminante=Utilidades.bytesToInt(tib.getMajor());
        int valor = Utilidades.bytesToInt((tib.getMinor()));
        float limite = 50;

        if (valor>=limite){
            getLastLocation();

        }
        Log.d(ETIQUETA_LOG, "idcontaminante:" +id_contaminante +", Valor: " +valor );
        switch (id_contaminante){
            case 11:

                enviarMedicion(id_contaminante,valor);
        }

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
    public void botonBuscarNuestroDispositivoBTLEPulsado(String uuid) {
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

        if (uuid != "") {

            // aqui va el codigo para identificar la uudi_____________________________________________________________________
            this.buscarEsteDispositivoBTLE(uuid);
            //this.buscarEsteDispositivoBTLE("fistro");
        }else {
            Toast.makeText(this, "NO HAY NINGUNA SONDA VINCULADA", Toast.LENGTH_LONG).show();
        }

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
    @SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        ViewPager2 viewPager = findViewById(R.id.viewPagerMain);
        TabLayout tabLayout4 = findViewById(R.id.tabLayout4);

        TabsAdapterMain tabsAdapter = new TabsAdapterMain(this);
        viewPager.setAdapter(tabsAdapter);
        viewPager.setCurrentItem(1);

        new TabLayoutMediator(tabLayout4, viewPager,
                (tab, position) -> {
                    switch (position) {
                        case 0:
                            tab.setIcon(R.drawable.ajustes);
                            break;
                        case 1:
                            tab.setIcon(R.drawable.home);
                            break;
                        case 2:
                            tab.setIcon(R.drawable.map);
                            break;
                    }
                }
        ).attach();

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR); // Para texto oscuro
        } else {
            getWindow().setStatusBarColor(Color.BLACK); // Para fondos claros, usa un color de fondo oscuro para la barra de estado
        }

        /*
        ViewPager2 viewPager = findViewById(R.id.viewPager);
        TabLayout tabLayout = findViewById(R.id.tabLayout);


        // Configura el adaptador para ViewPager
        TabsAdapter tabsAdapter = new TabsAdapter(this);
        viewPager.setAdapter(tabsAdapter);

        // Conecta TabLayout con ViewPager2
        new TabLayoutMediator(tabLayout, viewPager,
                (tab, position) -> {
                    // Aquí puedes configurar el texto de cada pestaña
                    if (position == 0) {
                        tab.setText("Tab 1");
                    } else {
                        tab.setText("Tab 2");
                    }
                }
        ).attach();




        this.salidaTexto = (TextView) findViewById(R.id.salidaTexto);
        this.TextoMajor = (TextView) findViewById(R.id.TextoMajor);
        this.TextoMinor = (TextView) findViewById(R.id.TextoMinor);
        this.Textdist = (TextView) findViewById(R.id.textdist);



        Intent intent = getIntent();
        if (intent != null) {
            String nombreUsuario = intent.getStringExtra("nombreUsuario");
            String email = intent.getStringExtra("email");
            salidaTexto.setText("Bienvenido "+nombreUsuario);
        }


         */


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


        // QR SCAN

        /*
        Button btnQR = findViewById(R.id.btnQR);
        btnQR.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                iniciarEscaneo();
            }
        });

         */

        fusedLocationProviderClient= LocationServices.getFusedLocationProviderClient(this);

        //getLastLocation();






    }

    //----------------------------------------------------------------------------------------------
    // getLastLocation()
    // Descripción: Devuelve una lista, de manera asíncrona, con los siguientes parámetros:
    // Latitud, Longitud, Dirección, Ciudad y País
    //----------------------------------------------------------------------------------------------
    private void getLastLocation(){

        if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED){
            fusedLocationProviderClient.getLastLocation()
                    .addOnSuccessListener(new OnSuccessListener<Location>() {
                        @SuppressLint("SetTextI18n")
                        @Override
                        public void onSuccess(Location location) {
                            if (location != null){
                                try {
                                    DecimalFormat precision = new DecimalFormat("0.00");

                                    Geocoder geocoder = new Geocoder(MainActivity.this, Locale.getDefault());
                                    List<Address> addresses = geocoder.getFromLocation(location.getLatitude(), location.getLongitude(), 1);
                                    Lat=("Latitud: "+precision.format(addresses.get(0).getLatitude())+"º");
                                    Long=("Longitud: "+precision.format(addresses.get(0).getLongitude())+"º");
                                    address=("Dirección: "+addresses.get(0).getAddressLine(0));
                                    city=("Ciudad: "+addresses.get(0).getLocality());
                                    country=("País: "+addresses.get(0).getCountryName());

                                    listaLocalizacion.add(Lat);
                                    listaLocalizacion.add(Long);
                                    listaLocalizacion.add(address);
                                    listaLocalizacion.add(city);
                                    listaLocalizacion.add(country);

                                    for (int i=0; i<listaLocalizacion.size();i++){
                                        Log.d("listaLocalizacion", "listaLocalizacion: "+listaLocalizacion.get(i));
                                    }
                                    sendNotification();

                                } catch (IOException e) {
                                    e.printStackTrace();
                                }
                            }
                        }
                    });
        }else {
            askPermission();
        }
    }

    //----------------------------------------------------------------------------------------------
    // sendNotification() --> NotificationCompat
    // Descripción: Función que permite enviar una notificación con un audio en específico y una descripción.
    // En este caso, la descripción contendrá: Fecha y hora exacta del momento + localización GPS
    //----------------------------------------------------------------------------------------------
    @RequiresApi(api = Build.VERSION_CODES.M)
    private void sendNotification()
    {
        Uri sound = Uri.parse("android.resource://" + getApplicationContext().getPackageName() + "/raw/audio");
        NotificationCompat.Builder mBuilder = new NotificationCompat.Builder(MainActivity. this, "default_notification_channel_id" )
                .setSmallIcon(R.drawable. ic_launcher_foreground )
                .setContentTitle( "BlueSky-Danger Alert" )
                .setSound(sound)
                .setContentText(
                        "Expande para ver más detalles"
                )
                .setStyle(new NotificationCompat.BigTextStyle()
                        .bigText("Date: "+Utilidades.getActualTime()+" Localización: "+listaLocalizacion))
                .setStyle(new NotificationCompat.InboxStyle()
                        .addLine("Fecha: "+Utilidades.getActualTime())
                        .addLine("Localización")
                        .addLine(listaLocalizacion.get(0))
                        .addLine(listaLocalizacion.get(1))
                        .addLine(listaLocalizacion.get(2))
                        .addLine(listaLocalizacion.get(3))
                        .addLine(listaLocalizacion.get(4))
                        .addLine(""));
        NotificationManager mNotificationManager = (NotificationManager) getSystemService(Context. NOTIFICATION_SERVICE );
        if (android.os.Build.VERSION. SDK_INT >= android.os.Build.VERSION_CODES. O ) {
            AudioAttributes audioAttributes = new AudioAttributes.Builder()
                    .setContentType(AudioAttributes. CONTENT_TYPE_SONIFICATION )
                    .setUsage(AudioAttributes. USAGE_ALARM )
                    .build() ;
            int importance = NotificationManager. IMPORTANCE_HIGH ;
            NotificationChannel notificationChannel = new NotificationChannel( "NOTIFICATION_CHANNEL_ID" , "NOTIFICATION_CHANNEL_NAME" , importance) ;
            notificationChannel.enableLights( true ) ;
            notificationChannel.setLightColor(Color. RED ) ;
            notificationChannel.enableVibration( true ) ;
            notificationChannel.setVibrationPattern( new long []{ 100 , 200 , 300 , 400 , 500 , 400 , 300 , 200 , 400 }) ;
            notificationChannel.setSound(sound , audioAttributes) ;
            mBuilder.setChannelId( "NOTIFICATION_CHANNEL_ID" ) ;
            assert mNotificationManager != null;
            mNotificationManager.createNotificationChannel(notificationChannel) ;
        }
        assert mNotificationManager != null;
        mNotificationManager.notify(( int ) System. currentTimeMillis () ,
                mBuilder.build()) ;
    }

    //----------------------------------------------------------------------------------------------
    // askPermission()
    // Descripción: Función que pregunta por el permiso de Localización
    //----------------------------------------------------------------------------------------------
    private void askPermission() {
        ActivityCompat.requestPermissions(MainActivity.this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION},CODIGO_PETICION_PERMISOS);
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

                    getLastLocation();

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
        String urlComprobarComproDestino = "http://192.168.217.185/Sprint_0_Web/logica/comprobarenviomedicion.php";

        //Añado parametros y los envio al enlace correspondiente
        AndroidNetworking.get(urlComprobarComproDestino)
                .addQueryParameter("temperatura",  "")
                .addQueryParameter("co2", "")
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
    public void enviarMedicion (int idContaminante,float valor) {
        Log.d("clienterestandroid", "boton_enviar_pulsado_client");

            //Email de usuario
            Intent intent = getIntent();
            if (intent != null) {
                String email = intent.getStringExtra("email");

            //Url de destino
            String urlDestino = "http://192.168.1.106:8080/mediciones/guardar_mediciones";


            //Instante de tomar medicion
            String currentTime = Utilidades.getActualTime();
                Log.d(ETIQUETA_LOG, "enviarMedicion: " +currentTime);

            //Creo un objeto JSON e introducir valores
            JSONObject postData = new JSONObject();
            try {
                postData.put("idContaminante", idContaminante);
                postData.put("idSonda", 10);
                postData.put("valor", valor);
                postData.put("instante", currentTime);
                postData.put("emailUser",email );
                postData.put("latitud",4 );
                postData.put("longitud",3 );
                postData.put("temperatura",20 );

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
    //ESCANEO DE QR
    private void iniciarEscaneo() {
        IntentIntegrator integrator = new IntentIntegrator(this);
        integrator.setDesiredBarcodeFormats(IntentIntegrator.ALL_CODE_TYPES);
        integrator.setPrompt("Escanea un código");
        integrator.setCameraId(0);
        integrator.setBeepEnabled(false);
        integrator.setBarcodeImageEnabled(true);
        integrator.setCaptureActivity(CaptureActivity.class); // Utiliza la actividad de captura personalizada
        integrator.initiateScan();

        //Detener el escaneo si se esta haciendo
        if (this.elIntentDelServicio != null) {
            stopService(this.elIntentDelServicio);
            Log.d(ETIQUETA_LOG, " boton detener servicio Pulsado");
            this.elIntentDelServicio = null;
            Log.d(ETIQUETA_LOG, " boton detener busqueda dispositivos BTLE Pulsado");
        }


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
        this.detenerBusquedaDispositivosBTLE();
    }

    //Aqui es donde se obtiene la respuesta del analisis del codigo qr, se muestra en un toast


    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {

        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        if(result != null) {
            if(result.getContents() == null) {
                Toast.makeText(this, "Escaneo cancelado", Toast.LENGTH_LONG).show();
            } else {

                // AQUI ES DONDE ESTA LA INFORMACÓN ESCANEADA: result.getContents()
                Toast.makeText(this, "Se va a intentar contactar con la sonda: " + result.getContents(), Toast.LENGTH_LONG).show();
                uuidEscaneado = result.getContents(); //Asignar lo escaneado a la variable para poderse usar en otras partes del codigo
                asignarSonda();
                this.botonBuscarNuestroDispositivoBTLEPulsado(uuidEscaneado); //Iniciar el escaneo
                //Button btnQR = findViewById(R.id.btnQR); //Asignar el nombre de la sonda al boton
                //btnQR.setText(uuidEscaneado);

            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }

    }


    private void asignarSonda(){
        Intent intent = getIntent();
        if (intent != null) {
            String email = intent.getStringExtra("email");

            String urlDestino = "http://192.168.1.106/bd/asignarSondaUsuario.php";

            //Creo un objeto JSON e introducir valores
            JSONObject postData = new JSONObject();
            try {
            postData.put("email", email);
            }
            catch (JSONException e) {
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

    @Override
    public void onBackPressed() {
        //bloquear el botón de retroceso
    }
    public void distanciasonda(int distancia){
        if(distancia>=-45){
            Textdist.setText("La sonda está cerca");
        }else if(distancia>=-65){
            Textdist.setText("La sonda está lejos");
        }else if(distancia<-65){
            Textdist.setText("La sonda está muy lejos");
        }
    }
}