package com.example.sprint_0_android;

import androidx.appcompat.app.AppCompatActivity;
import androidx.viewpager2.widget.ViewPager2;

import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.view.View;

import com.google.android.material.tabs.TabLayout;
import com.google.android.material.tabs.TabLayoutMediator;

public class InfoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);
        ViewPager2 viewPager = findViewById(R.id.viewPager);
        TabLayout tabLayout = findViewById(R.id.tabLayout);

        TabsAdapter tabsAdapter = new TabsAdapter(this);
        viewPager.setAdapter(tabsAdapter);

        new TabLayoutMediator(tabLayout, viewPager,
                (tab, position) -> {
                    switch (position) {
                        case 0:
                            tab.setText("Ozono - O3");
                            break;
                        case 1:
                            tab.setText("Monóxido de Carbono - CO2");
                            break;
                        case 2:
                            tab.setText("Dioxido de Azufre");
                            break;
                        default:
                            tab.setText("Tab " + (position + 1));
                            break;
                    }
                }
        ).attach();
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR); // Para texto oscuro
        } else {
            getWindow().setStatusBarColor(Color.BLACK); // Para fondos claros, usa un color de fondo oscuro para la barra de estado
        }


    }
}