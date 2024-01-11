package com.example.sprint_0_android;


import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.GeolocationPermissions;
import android.webkit.WebChromeClient;
import android.webkit.WebResourceError;
import android.webkit.WebResourceRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.ImageButton;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;


public class ActivityInicio extends AppCompatActivity {

    private ImageButton directAccessButton;
    private Button buttonRegistro;
    private Button buttonInicioSesion;
    private WebView WebView_Public;
    private static final int CODIGO_PERMISO_UBICACION = 1;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio);

        directAccessButton = findViewById(R.id.imageButtonInfo);
        buttonRegistro = findViewById(R.id.buttonReg);
        buttonInicioSesion = findViewById(R.id.btnQR);
        WebView_Public = findViewById(R.id.webView_Publico);
        directAccessButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ActivityInicio.this, InfoActivity.class);
                startActivity(intent);
            }
        });

        buttonRegistro.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ActivityInicio.this, SignUp.class);
                startActivity(intent);
            }
        });

        buttonInicioSesion.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(ActivityInicio.this, Login.class);
                startActivity(intent);
            }
        });

        if (tienePermisoUbicacion()) {
            configurarWebView();
        } else {
            solicitarPermisoUbicacion();
        }

    }

    private void configurarWebView() {
        WebSettings webSettings = WebView_Public.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setGeolocationEnabled(true);
        webSettings.setDomStorageEnabled(true);
        WebView_Public.setWebViewClient(new WebViewClient() {
            @Override
            public void onReceivedError(WebView view, WebResourceRequest request, WebResourceError error) {
                super.onReceivedError(view, request, error);
                Log.d("WebViewError", "Error: " + error.getDescription());
            }
        });

        WebView_Public.setWebChromeClient(new WebChromeClient() {
            @Override
            public void onGeolocationPermissionsShowPrompt(String origin, GeolocationPermissions.Callback callback) {
                // Solicitar permiso de geolocalización
                callback.invoke(origin, true, false);
            }
        });

        WebView_Public.loadUrl("file:///android_asset/mapaPublico.html");
    }

    private boolean tienePermisoUbicacion() {
        // Verificar si el permiso de ubicación está concedido
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            return ActivityCompat.checkSelfPermission(
                    this, android.Manifest.permission.ACCESS_FINE_LOCATION) ==
                    PackageManager.PERMISSION_GRANTED;
        }
        return true;
    }

    private void solicitarPermisoUbicacion() {
        // Solicitar el permiso de ubicación
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            requestPermissions(new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                    CODIGO_PERMISO_UBICACION);
        }
    }

}
