package com.example.sprint_0_android;

import android.content.Intent;
import android.os.Bundle;
import android.os.PersistableBundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

public class PrivacyPolicy extends AppCompatActivity {
    private static final String ETIQUETA_LOG = ">>>>";
    private Button aceptarPrivacidad;
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_privacypolicy);

        this.aceptarPrivacidad=(Button) findViewById(R.id.buttonAceptarPolitica);
        aceptarPrivacidad.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                finish();
            }
        });

    }
    //----------------------------------------------------------------------------------------------
    // onclick --> buttonAceptar()
    // Descripción: Cuando el usuario acepte la política de privacidad, esta función se activará.
    // Cuando lo haga, registrará al usuario y lo redireccionará a la landing page
    // Funciona como un paso extra importante para el Registro
    //----------------------------------------------------------------------------------------------
    private void buttonAceptar(){
        //Cuando acepte --> Registrar usuario --> Redireccionar a la página inicial (landing page)

        //---------
        // Lo que se me ocurre es:
        // Cuando le des a Registrar en el formulario, que lo lleve a la actividad de activity_privacyPolicy.xml
        // Luego controlar mediante un callback o como quieras si le da a Aceptar o no.
        // Si le da a aceptar, volver a la clase SignUp.class y seguir con el procedimiento habitual del registro
        //
        // De esta manera, nos evitamos mover tod0 el registro
        //---------
    }
}
