package com.example.sprint_0_android;

public class Medicion {
    String Hora;
    String Temperatura;
    String Valor;

    public Medicion(String hora, String temperatura, String valor) {
        this.Hora = hora;
        this.Temperatura = temperatura;
        this.Valor = valor;
    }

    public String getHora() {
        return Hora;
    }

    public void setHora(String hora) {
        Hora = hora;
    }

    public String getTemperatura() {
        return Temperatura;
    }

    public void setTemperatura(String temperatura) {
        Temperatura = temperatura;
    }

    public String getValor() {
        return Valor;
    }

    public void setValor(String valor) {
        Valor = valor;
    }
}
