package com.example.sprint_0_android;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;
import java.util.List;

public class MainPage extends Fragment {
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {

        List<Medicion> mediciones = new ArrayList<Medicion>();
        mediciones.add(new Medicion("12:34","24ºC","74%"));
        mediciones.add(new Medicion("12:53","32ºC","31%"));
        mediciones.add(new Medicion("13:21","27ºC","59%"));

        View view = inflater.inflate(R.layout.activity_main_page, container, false);
        RecyclerView recyclerView = view.findViewById(R.id.recycler_view);
        recyclerView.setLayoutManager(new LinearLayoutManager(view.getContext()));

        recyclerView.setAdapter(new AdapterRecyclerView(getActivity().getApplicationContext(), mediciones));
        return view;
    }
}
