// CalculadoraMilan.js
class CalculadoraMilan{

    constructor() {
        this.guardarMemoria = "";
        this.operacion = "";
        this.operando1 = "0";
        this.operando2 = "0";
        this.inicializado = true;
        this.final = false;
    }

    digitos(x) {
        if (this.final==true) {
            this.operacion = "";
            this.operando1 = "0";
            this.operando2 = "0";
            this.final = false;
            this.inicializado = true;
        }
        if (this.inicializado || this.operando1=="0") {
            document.querySelector('input[type=text]').value = Number(x);
            this.operando1 = String(x);
        } else {
            document.querySelector('input[type=text]').value += Number(x);
            this.operando1 += String(x);
        }
        this.inicializado = false;
    }

    porcentaje() {
        this.operando1 = String(Number(this.operando2)*(Number(this.operando1)/100));
        document.querySelector('input[type=text]').value = this.operando1;
    }

    sqrt() {
        document.querySelector('input[type=text]').value = Math.sqrt(Number(this.operando1));
        this.operando1 = Math.sqrt(Number(this.operando1));   
    }

    punto() {
        let str = String(this.operando1)
        if (!str.includes(".")) {
            document.querySelector('input[type=text]').value += ".";
            this.operando1 += ".";
        }
    }

    suma() {
        if (! this.final) {
            this.igual();
            this.operando2 = this.operando1;
        }
        this.inicializado = true;
        this.final = false;
        this.operacion = "+";
    }

    resta() {
        if (! this.final) {
            this.igual();
            this.operando2 = this.operando1;
        }
        this.inicializado = true;
        this.final = false;
        this.operacion = "-";
    }

    multiplicacion() {
        if (! this.final) {
            this.igual();
            this.operando2 = this.operando1;
        }
        this.inicializado = true;
        this.final = false;
        this.operacion = "*";
    }
    
    division() {
        if (! this.final) {
            this.igual();
            this.operando2 = this.operando1;
        }
        this.inicializado = true;
        this.final = false;
        this.operacion = "/";
    }

    mrc() {
        this.operando1 = this.guardarMemoria;
        document.querySelector('input[type=text]').value = this.operando1;
    }

    mMenos() {
        this.guardarMemoria = eval(this.guardarMemoria + "-" + document.querySelector('input[type=text]').value);
    }

    mMas() {
        this.guardarMemoria = eval(this.guardarMemoria + "+" + document.querySelector('input[type=text]').value);
    }

    cambiarSigno() {
        this.operando1 = Number(document.querySelector('input[type=text]').value) * -1;
        document.querySelector('input[type=text]').value = this.operando1;
    }

    borrar() {
        document.querySelector('input[type=text]').value = "";
        this.operando1 = "";
        this.operando2 = "";
        this.operacion = "";
        this.guardarMemoria = "";
    }

    ce() {
        this.operando1 = "";
        document.querySelector('input[type=text]').value = "";
    }

    igual() {
        try {
            if (this.operacion=="") {
                document.querySelector('input[type=text]').value = this.operando1;
            } else {
                let res = Number(this.operando2) + this.operacion + Number(this.operando1);
                let solucion = Number(eval(res));
                document.querySelector('input[type=text]').value = solucion;
                this.inicializado = false;
                this.operando2 = solucion;
                this.final = true;
            }
        } catch (err) {
            document.querySelector('input[type=text]').value = "Error";
        }
        
    }

    pulsacionTeclado(event) {
        if (event === '+') {
            this.suma();
        }
        else if (event === '.') {
            this.punto();
        }
        else if (event === '-') {
            this.resta();
        }
        else if (event === '/') {
            this.division();
        }
        else if (event === '*') {
            this.multiplicacion();
        }
        else if(event >= '0' && event <= '9'){
            this.digitos(Number(event));
        }
        else if(event === 'm' || event === 'M'){
            this.mrc();
        }
        else if(event === 's' || event === 'S'){
            this.mMas();
        }
        else if(event === 'r' || event === 'R'){
            this.mMenos();
        }
        else if(event === 'Escape'){
            this.borrar();
        }
        else if(event === 'i' || event === 'I'){
            this.cambiarSigno();
        }
        else if(event === 'f' || event === 'F'){
            this.sqrt();
        }
        else if(event === 'Enter'){
            this.igual();
        }
        else if(event === 'c' || event === 'C'){
            this.ce();
        }
        else if(event === '%'){
            this.porcentaje();
        }        
    }
}

calculadora = new CalculadoraMilan();

document.addEventListener('keydown', function (event) {
    event.preventDefault();
    calculadora.pulsacionTeclado(event.key);
});