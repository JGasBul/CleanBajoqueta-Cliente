package com.example.sprint_0_android;

import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.viewpager2.widget.ViewPager2;

import com.google.android.material.tabs.TabLayout;
import com.google.android.material.tabs.TabLayoutMediator;

public class Ajuste extends Fragment {
    private String nombreUsuario;
    private String email;
    private String telefono;

    public static Ajuste newInstance(String nombreUsuario, String email, String telefono) {
        Ajuste fragment = new Ajuste();
        Bundle args = new Bundle();
        args.putString("nombreUsuario", nombreUsuario);
        args.putString("email", email);
        args.putString("telefono", telefono);
        fragment.setArguments(args);
        return fragment;
    }
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        // Usa el archivo layout fragment_fragment1.xml para este fragmento
        View view = inflater.inflate(R.layout.activity_ajuste, container, false);


        Bundle args = getArguments();
        if (args != null) {
            nombreUsuario = args.getString("nombreUsuario", "");
            email = args.getString("email", "");
            telefono = args.getString("telefono", "");
            Log.d("prueba", "onCreateView: " + nombreUsuario + "" + email + "" + telefono);


            ViewPager2 viewPager2 = view.findViewById(R.id.viewPager2);
            TabLayout tabLayout2 = view.findViewById(R.id.tabLayout2);

            TabsAdapterAjuste tabsAdapter2 = new TabsAdapterAjuste(this,nombreUsuario,email,telefono);
            viewPager2.setAdapter(tabsAdapter2);

            new TabLayoutMediator(tabLayout2, viewPager2,
                    (tab, position) -> {
                        switch (position) {
                            case 0:
                                tab.setText("Aplicación");
                                break;
                            case 1:
                                tab.setText("Sonda");
                                break;
                            case 2:
                                tab.setText("Usuario");
                                break;
                            default:
                                tab.setText("Tab " + (position + 1));
                                break;
                        }
                    }
            ).attach();


        }
        return view;
    }


}

