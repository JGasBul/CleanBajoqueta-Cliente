package com.example.sprint_0_android;

public class Medicion {
    String hora;
    String Temperatura;
    String Concentracion;

    public Medicion(String hora, String temperatura, String concentracion) {
        this.hora = hora;
        Temperatura = temperatura;
        Concentracion = concentracion;
    }

    public String getHora() {
        return hora;
    }

    public void setHora(String hora) {
        this.hora = hora;
    }

    public String getTemperatura() {
        return Temperatura;
    }

    public void setTemperatura(String temperatura) {
        Temperatura = temperatura;
    }

    public String getConcentracion() {
        return Concentracion;
    }

    public void setConcentracion(String concentracion) {
        Concentracion = concentracion;
    }
}
