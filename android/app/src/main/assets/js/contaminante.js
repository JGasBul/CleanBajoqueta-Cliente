
//Clase contaminante

class Contaminante {

    //campos
    tipo = null;
    valor = null;
    punto = null;

    constructor(tipo, valor, punto) {
        this.tipo = tipo;
        this.valor = valor;
        this.punto = punto;
    }

    getTipo(){
        return this.tipo;
    }
    getValor(){
        return this.valor;
    }
    getPunto(){
        return this.punto;
    }

}


