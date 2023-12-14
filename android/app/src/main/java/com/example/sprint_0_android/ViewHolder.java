package com.example.sprint_0_android;

import android.view.View;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import org.w3c.dom.Text;

public class ViewHolder extends RecyclerView.ViewHolder {

    TextView hora;
    TextView temperatura;
    TextView concentracion;

    public ViewHolder(@NonNull View itemView) {
        super(itemView);
        hora= itemView.findViewById(R.id.hora);
        temperatura=itemView.findViewById(R.id.temperatura);
        concentracion=itemView.findViewById(R.id.concentracion);


    }
}
