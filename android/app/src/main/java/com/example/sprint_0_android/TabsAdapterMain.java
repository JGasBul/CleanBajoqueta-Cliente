package com.example.sprint_0_android;

import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.viewpager2.adapter.FragmentStateAdapter;

public class TabsAdapterMain extends FragmentStateAdapter {
    public TabsAdapterMain(FragmentActivity fa) {
        super(fa);
    }

    @Override
    public Fragment createFragment(int position) {
        // Devuelve el fragmento correspondiente para cada posición
        if (position == 0) {
            return new Ajuste();
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
