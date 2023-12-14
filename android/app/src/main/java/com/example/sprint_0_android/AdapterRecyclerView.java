package com.example.sprint_0_android;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public class AdapterRecyclerView extends RecyclerView.Adapter<ViewHolder> {

    Context context;
    List<Medicion> medicionList;

    public AdapterRecyclerView(Context context, List<Medicion> medicionList) {
        this.context = context;
        this.medicionList = medicionList;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

        return new ViewHolder(LayoutInflater.from(context).inflate(R.layout.activity_medicion,parent,false));
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        holder.hora.setText(medicionList.get(position).getHora());
        holder.temperatura.setText(medicionList.get(position).getTemperatura());
        holder.concentracion.setText(medicionList.get(position).getConcentracion());

    }

    @Override
    public int getItemCount() {
        return 3;
    }
}
