package com.example.sprint_0_android;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;

import androidx.appcompat.app.AppCompatActivity;


public class ActivityInicio extends AppCompatActivity {

    private ImageButton directAccessButton;
    private Button buttonRegistro;
    private Button buttonInicioSesion;


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio);

        directAccessButton = findViewById(R.id.imageButtonInfo);
        buttonRegistro = findViewById(R.id.buttonReg);
        buttonInicioSesion = findViewById(R.id.btnQR);

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
    }

}
