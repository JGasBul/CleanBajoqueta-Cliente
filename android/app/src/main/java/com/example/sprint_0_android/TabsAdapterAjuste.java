package com.example.sprint_0_android;

import androidx.fragment.app.Fragment;
import androidx.viewpager2.adapter.FragmentStateAdapter;

public class TabsAdapterAjuste extends FragmentStateAdapter {
    private String nombreUsuario;
    private String email;
    private String telefono;
    public TabsAdapterAjuste(Ajuste fa,String nombreUsuario,String email,String telefono) {
        super(fa);
        this.nombreUsuario = nombreUsuario;
        this.email = email;
        this.telefono = telefono;
    }

    @Override
    public Fragment createFragment(int position) {
        // Devuelve el fragmento correspondiente para cada posición
        if (position == 0) {
            return new FragmentAplicacion();
        } else if (position == 1){
            return new FragmentSonda();
        } else if (position == 2) {
            FragmentUsuario fragmentUsuario = FragmentUsuario.newInstance(nombreUsuario, email, telefono);
            return fragmentUsuario;
        }else{
        return null;
    }}

    @Override
    public int getItemCount() {
        // Total de pestañas
        return 3;
    }
}
