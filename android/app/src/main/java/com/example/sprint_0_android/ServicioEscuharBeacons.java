package com.example.sprint_0_android;

import android.app.IntentService;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Build;
import android.util.Log;

import androidx.core.app.ActivityCompat;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;

// -------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------

public class ServicioEscuharBeacons extends IntentService {

    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    private static final String ETIQUETA_LOG = ">>>>";

    private long tiempoDeEspera = 1000;

    private boolean seguir = true;

    public int contador = 1;

    public int contadorSonda;

    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    public ServicioEscuharBeacons() {
        super("ServicioEscucharBeacons");

        Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.constructor: termina");
    }

    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    /*
    @Override
    public int onStartCommand( Intent elIntent, int losFlags, int startId) {

        // creo que este método no es necesario usarlo. Lo ejecuta el thread principal !!!
        super.onStartCommand( elIntent, losFlags, startId );

        this.tiempoDeEspera = elIntent.getLongExtra("tiempoDeEspera", 50000);

        Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onStartCommand : empieza: thread=" + Thread.currentThread().getId() );

        return Service.START_CONTINUATION_MASK | Service.START_STICKY;
    } // ()

     */

    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    public void parar() {

        Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.parar() ");


        if (this.seguir == false) {
            return;
        }

        this.seguir = false;
        this.stopSelf();

        Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.parar() : acaba ");

    }

    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------
    public void onDestroy() {

        Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onDestroy() ");


        this.parar(); // posiblemente no haga falta, si stopService() ya se carga el servicio y su worker thread
    }

    // ---------------------------------------------------------------------------------------------
    // ---------------------------------------------------------------------------------------------

    /**
     * The IntentService calls this method from the default worker thread with
     * the intent that started the service. When this method returns, IntentService
     * stops the service, as appropriate.
     */
    @Override
    protected void onHandleIntent(Intent intent) {

        contadorSonda= DesconexionSonda.getInstance().getData();

        this.tiempoDeEspera = intent.getLongExtra("tiempoDeEspera", /* default */ 50000);
        this.seguir = true;

        // esto lo ejecuta un WORKER THREAD !


        Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onHandleIntent: empieza : thread=" + Thread.currentThread().getId());

        try {

            while (this.seguir) {

                contadorSonda= DesconexionSonda.getInstance().getData();
                Thread.sleep(tiempoDeEspera);
                //Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onHandleIntent: tras la espera:  " + contador);
                Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onHandleIntent: tras la espera:  " + contadorSonda);

                DesconexionSonda.getInstance().setData(DesconexionSonda.getInstance().getData()+1);

                contador++;

                //Notificación desconexión
                //Cambiar el 10 segundos a cualquier tiempo
                if (DesconexionSonda.getInstance().getData() == 10) {
                    Log.d(ETIQUETA_LOG, " alerta desconexion");
                    // Crear y registrar un canal de notificaciones para Android 8.0 y versiones posteriores
                    if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
                        CharSequence name = "Desconexion sonda"; // Nombre del canal
                        String description = "Alerta desconexión"; // Descripción del canal
                        int importance = NotificationManager.IMPORTANCE_DEFAULT;
                        NotificationChannel channel = new NotificationChannel("YOUR_CHANNEL_ID", name, importance);
                        channel.setDescription(description);
                        NotificationManager notificationManager = getSystemService(NotificationManager.class);
                        notificationManager.createNotificationChannel(channel);
                    }

                    // Crear y mostrar una notificación
                    NotificationCompat.Builder builder = new NotificationCompat.Builder(this, "YOUR_CHANNEL_ID")
                            .setSmallIcon(R.drawable.logo) // Ícono de la notificación
                            .setContentTitle("Alerta desconexión sonda") // Título de la notificación
                            .setContentText("La sonda lleva tiempo sin emitir mediciones, revise su batería o si está dañada.") // Texto de la notificación
                            .setPriority(NotificationCompat.PRIORITY_DEFAULT);

                    NotificationManagerCompat notificationManager = NotificationManagerCompat.from(this);
                    int notificationId = 1; // Identificador único para la notificación
                    if (ActivityCompat.checkSelfPermission(this, android.Manifest.permission.POST_NOTIFICATIONS) != PackageManager.PERMISSION_GRANTED) {
                        // TODO: Consider calling
                        //    ActivityCompat#requestPermissions
                        // here to request the missing permissions, and then overriding
                        //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
                        //                                          int[] grantResults)
                        // to handle the case where the user grants the permission. See the documentation
                        // for ActivityCompat#requestPermissions for more details.
                        return;
                    }
                    notificationManager.notify(notificationId, builder.build());

                    contador=0;
                }
            }

            Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onHandleIntent : tarea terminada ( tras while(true) )" );
            contador=0;

        } catch (InterruptedException e) {
            // Restore interrupt status.
            Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onHandleItent: problema con el thread");

            Thread.currentThread().interrupt();
        }

        Log.d(ETIQUETA_LOG, " ServicioEscucharBeacons.onHandleItent: termina");
        contador=0;

    }
} // class
// -------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------