package com.example.sprint_0_android;

public class DistanciaSonda {

    private static DistanciaSonda instance = new DistanciaSonda();



    private int data;

    private DistanciaSonda() {}

    public static DistanciaSonda getInstance() {
        return instance;
    }

    public int getData() {
        return data;
    }

    public void setData(int data) {
        this.data = data;
    }
}
