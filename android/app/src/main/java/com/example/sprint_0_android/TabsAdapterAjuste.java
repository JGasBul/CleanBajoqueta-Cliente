package com.example.sprint_0_android;

import androidx.fragment.app.Fragment;
import androidx.viewpager2.adapter.FragmentStateAdapter;

public class TabsAdapterAjuste extends FragmentStateAdapter {
    public TabsAdapterAjuste(Ajuste fa) {
        super(fa);
    }

    @Override
    public Fragment createFragment(int position) {
        // Devuelve el fragmento correspondiente para cada posición
        if (position == 0) {
            return new FragmentAplicacion();
        } else if (position == 1){
            return new FragmentSonda();
        } else if (position == 2) {
            return new FragmentUsuario();
        }else{
        return null;
    }}

    @Override
    public int getItemCount() {
        // Total de pestañas
        return 3;
    }
}
