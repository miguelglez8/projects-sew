// CalculadoraCientifica.js
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

  class CalculadoraCientifica extends CalculadoraMilan {

    constructor() {
        super();
        this.enGrados = true; // no está en radianes
        this.notacionCientifica = false;
        this.modoA = false; // funcion arcsen, arccos y arctan
        this.modoH = false; // funcion senh, cosh, tanh
    }

    borrar() {
        document.querySelector('input[type=text]').value = "";
        this.operando1 = "";
        this.operando2 = "";
        this.operacion = "";
        this.guardarMemoria = "";
        this.enGrados = true; // no está en radianes
        this.notacionCientifica = false;
        this.modoA = false; // funcion arcsen, arccos y arctan
        this.modoH = false; // funcion senh, cosh, tanh
        document.querySelector("body > form > input[type=button]:nth-child(13)").value = 'sin';
        document.querySelector("body > form > input[type=button]:nth-child(14)").value = 'cos';
        document.querySelector("body > form > input[type=button]:nth-child(15)").value = 'tan';
        document.querySelector("body > form > input[type=button]:nth-child(3)").value = 'DEG';
    }

    digitos(x) {
        document.querySelector('input[type=text]').value += Number(x);
    }

    suma() { 
        document.querySelector('input[type=text][name=pantalla]').value += "+";
    }

    resta() { 
        document.querySelector('input[type=text][name=pantalla]').value += "-";
    }

    multiplicacion() { 
        document.querySelector('input[type=text][name=pantalla]').value += "*";
    }
    
    division() { 
        document.querySelector('input[type=text][name=pantalla]').value += "/";
    }

    activar() {
        if (this.modoA==true) {
            document.querySelector("body > form > input[type=button]:nth-child(13)").value = 'sin';
            document.querySelector("body > form > input[type=button]:nth-child(14)").value = 'cos';
            document.querySelector("body > form > input[type=button]:nth-child(15)").value = 'tan';
            this.modoA=false;
        } else {
            document.querySelector("body > form > input[type=button]:nth-child(13)").value = 'arcsin';
            document.querySelector("body > form > input[type=button]:nth-child(14)").value = 'arccos';
            document.querySelector("body > form > input[type=button]:nth-child(15)").value = 'arctan';
            this.modoA=true;
        }
    }

    deg(){ 
        if(this.enGrados == true) {
            this.enGrados = false;
            document.querySelector("body > form > input[type=button]:nth-child(3)").value = 'RAD';
        } else{
            this.enGrados = true;
            document.querySelector("body > form > input[type=button]:nth-child(3)").value = 'DEG';
        }
    }

    fe() { 
        if (this.notacionCientifica==true) {
            this.notacionCientifica = false;
        } else {
            this.notacionCientifica = true;
        }
    }

    hyp() {
        if (this.modoH==true) {
            document.querySelector("body > form > input[type=button]:nth-child(13)").value = 'sin';
            document.querySelector("body > form > input[type=button]:nth-child(14)").value = 'cos';
            document.querySelector("body > form > input[type=button]:nth-child(15)").value = 'tan';
            this.modoH=false;
        } else {
            document.querySelector("body > form > input[type=button]:nth-child(13)").value = 'sinh';
            document.querySelector("body > form > input[type=button]:nth-child(14)").value = 'cosh';
            document.querySelector("body > form > input[type=button]:nth-child(15)").value = 'tanh';
            this.modoH=true;
        }
    }

    mr(){ 
        document.querySelector('input[type=text][name=pantalla]').value = this.guardarMemoria;
    }

    ms(){ 
        this.guardarMemoria = eval(document.querySelector('input[type=text][name=pantalla]').value);
    }

    mc(){ 
        this.guardarMemoria = "";
    }

    abrirParentesis() {
        document.querySelector('input[type=text][name=pantalla]').value += "(";
    }

    cerrarParentesis() {
        document.querySelector('input[type=text][name=pantalla]').value += ")";
    }

    pi() {
        document.querySelector('input[type=text][name=pantalla]').value += Math.PI;
    }

    pow() {
        document.querySelector('input[type=text][name=pantalla]').value += "**";
    }

    pow2() { 
        try {
            document.querySelector('input[type=text][name=pantalla]').value = Math.pow(eval(document.querySelector('input[type=text][name=pantalla]').value),2);
        } catch (err) {
            document.querySelector('input[type=text]').value = "Error de sintaxis";
        }
    }

    sqrt() {
        try {
            document.querySelector('input[type=text][name=pantalla]').value = Math.sqrt(eval(document.querySelector('input[type=text][name=pantalla]').value));
        } catch (err) {
            document.querySelector('input[type=text]').value = "Error de sintaxis";
        }
    }

    baseten() { 
        try {
            document.querySelector('input[type=text][name=pantalla]').value = Math.pow(10, eval(document.querySelector('input[type=text][name=pantalla]').value));
        } catch (err) {
            document.querySelector('input[type=text]').value = "Error de sintaxis";
        }
    }
    
    log() {
        try {
            document.querySelector('input[type=text][name=pantalla]').value = Math.log10(eval(document.querySelector('input[type=text][name=pantalla]').value));
        } catch (err) {
            document.querySelector('input[type=text]').value = "Error de sintaxis";
        }
    }

    exp() { 
        document.querySelector('input[type=text][name=pantalla]').value = Math.exp(Number(document.querySelector('input[type=text][name=pantalla]').value));
    }

    mod() { 
        document.querySelector('input[type=text][name=pantalla]').value += "%";
    }

    borrarUltimo() {
        var aux = document.querySelector('input[type=text][name=pantalla]').value;
        document.querySelector('input[type=text][name=pantalla]').value = aux.slice(0, -1);
    }

    factorial() {
        var number = parseInt(eval(document.querySelector('input[type=text][name=pantalla]').value));
        var result = 0;
        try {
            result = this.recursiveFactorial(number);
        } catch(err) {
            document.querySelector('input[type=text]').value = "El numero es muy grande";
        }
        document.querySelector('input[type=text][name=pantalla]').value = result;
    }

    recursiveFactorial(number) {
        if (number == 1 || number == 0) {
            return 1;
        }
        return number * this.recursiveFactorial(number - 1);
    }

    sin() {
        if (this.enGrados) {
            if (this.modoA==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.asin(eval(num));
            } else if(this.modoH==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.sinh(eval(num));
            } else {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.sin(eval(num));            
            }
        } else {
            if (this.modoA==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.asin(num);
            } else if(this.modoH==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.sinh(num);
            } else {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.sin(num);            
            }
        }
    }

    cos() { 
        if (this.enGrados) {
            if (this.modoA==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.acos(eval(num));
            } else if(this.modoH==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.cosh(eval(num));
            } else {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.cos(eval(num));
            }
        } else {
            if (this.modoA==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.acos(num);
            } else if(this.modoH==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.cosh(num);
            } else {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.cos(num);            
            }
        }
    }

    tan() { 
        if (this.enGrados) {
            if (this.modoA==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.atan(eval(num));
            } else if(this.modoH==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.tanh(eval(num));
            } else {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value) * Math.PI/180;
                document.querySelector('input[type=text][name=pantalla]').value = Math.tan(eval(num));
            }
        } else {
            if (this.modoA==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.atan(num);
            } else if(this.modoH==true) {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.tanh(num);
            } else {
                var num = eval(document.querySelector('input[type=text][name=pantalla]').value);
                document.querySelector('input[type=text][name=pantalla]').value = Math.tan(num);            
            }
        }
    }

    igual() { 
        try {
            var evalu = document.querySelector('input[type=text][name=pantalla]').value;
            document.querySelector('input[type=text][name=pantalla]').value = eval(evalu);
        } catch (err) {
             document.querySelector('input[type=text][name=pantalla]').value = "Error de sintaxis";
        }       
    }

    pulsacionTeclado(event) { 
        super.pulsacionTeclado(event);
        if (event === '('){
            this.abrirParentesis();
        }
        else if(event === ')'){
            this.cerrarParentesis();
        }
        else if(event === 'Backspace') {
            this.borrarUltimo();
        }
        else if(event === 'a' || event === 'A') {
            this.factorial();
        }
        else if(event === 'ArrowUp') {
            this.activar();
        }
        else if(event === 'ArrowDown') {
            this.hyp();
        }
        else if(event === 'o' || event === 'O') {
            this.mod();
        }
        else if(event === 'p' || event === 'P') {
            this.pi();
        }
        else if(event === 'e' || event === 'E') {
            this.exp();
        }
        else if(event === 'l' || event === 'L') {
            this.log();
        }
        else if(event === 'b' || event === 'B') {
            this.baseten();
        }
        else if(event === 'u' || event === 'U') {
            this.pow();
        }
        else if(event === 'y' || event === 'Y') {
            this.pow2();
        }
        else if(event === 'h' || event === 'H') {
            this.fe();
        }
        else if(event === 'w' || event === 'W') {
            this.cos();
        }
        else if(event === 'z' || event === 'Z') {
            this.tan();
        }
        else if(event === 't' || event === 'T') {
            this.enGrados();
        }
        else if(event === 'j' || event === 'J') {
            this.sin();
        }
        else if(event === 'Shift') {
            this.mr();
        }
        else if(event === 'F2') {
            this.mc();
        }
        else if(event === 'F4') {
            this.ms();
        }
        else if(event === 'F6') {
            this.deg();
        }
    }
}

calculadora = new CalculadoraCientifica();


document.addEventListener('keydown', function (event) {
    event.preventDefault();
    calculadora.pulsacionTeclado(event.key);
});


