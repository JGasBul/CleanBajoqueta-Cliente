package com.example.sprint_0_android;

import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.viewpager2.adapter.FragmentStateAdapter;

public class TabsAdapterMain extends FragmentStateAdapter {

    private String nombreUsuario;
    private String email;
    private String telefono;
    public TabsAdapterMain(FragmentActivity fa, String nombreusuario,String email, String telefono) {
        super(fa);
        this.nombreUsuario = nombreusuario;
        this.email = email;
        this.telefono = telefono;
    }

    @Override
    public Fragment createFragment(int position) {
        // Devuelve el fragmento correspondiente para cada posición
        if (position == 0) {
            return Ajuste.newInstance(nombreUsuario, email, telefono);
        } else if (position == 1){
            return new MainPage();
        } else if (position == 2) {
            return new MapaPage();

        }else{
        return null;
    }}

    @Override
    public int getItemCount() {
        // Total de pestañas
        return 3;
    }
}
