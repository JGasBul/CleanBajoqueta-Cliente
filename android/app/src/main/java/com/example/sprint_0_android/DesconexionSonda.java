package com.example.sprint_0_android;

public class DesconexionSonda {

        private static DesconexionSonda instance = new DesconexionSonda();



        private int data;

        private DesconexionSonda() {}

        public static DesconexionSonda getInstance() {
            return instance;
        }

        public int getData() {
            return data;
        }

        public void setData(int data) {
            this.data = data;
        }
}

