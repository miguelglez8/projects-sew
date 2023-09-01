// CalculadoraEspecializada.js
class Pila {
    constructor(){
        this.contenido = [];
        this.indice = -1;
    }

    push(elemento) {
        this.contenido.push(elemento);
        this.indice += 1;
    }

    pop(){
        if(!this.estaVacia()){
            this.indice -= 1;
            return this.contenido.pop();
        }
       
    }

    obtenerElemento(x){
        return this.contenido[x];
    }

    tamaño(){
        return this.indice+1;
    }

    estaVacia(){
        return this.indice == -1;
    }

    imprimeContenidoPila(s)
    {
        if (s.estaVacia()) // esta vacía
            return;
        
        var copiaPila = [];
        let res = "";

        let i = 0;
        var elemento;

        var elemento;

        for(i = this.tamaño()-1; i >= 0;i--){
            res += (i+1)+": \t\t" + this.obtenerElemento(i) +"\n";
        }

        for(i = 0;i<this.tamaño();i++){
            elemento = this.contenido.pop();
            copiaPila.push(elemento);
        }

        for(i = 0; i<this.tamaño();i++){
            elemento = copiaPila.pop();
            this.contenido.push(elemento);
        }

        return res;
    }

    vaciar(){
        let i = 0;
        for(i = 0; i<this.tamaño();i++){
            this.contenido.pop();
        }
        this.indice = -1;
    }
}

  class CalculadoraRPN {

    constructor(pila) {
        this.pila=pila;
    }

    actualizar(){
        if(!this.pila.estaVacia()){
            document.querySelector('textarea[name="pantalla"]').innerHTML = this.pila.imprimeContenidoPila(this.pila);   
        }
    }

    digito(x){
       document.querySelector('input[type=text]').value += x; 
    }

    punto(){
        document.querySelector('input[type=text]').value += "."; 
     }

    suma(){
        if(this.pila.tamaño() >= 2){
            this.pila.push(this.pila.pop()+this.pila.pop());
            this.actualizar();
        }
    }

    resta(){
        if(this.pila.tamaño() >= 2){
            let elementoA = this.pila.pop();
            let elementoB = this.pila.pop();
            this.pila.push(elementoB-elementoA);
            this.actualizar();
        }
    }


    multiplicacion(){

        if(this.pila.tamaño() >= 2){
            this.pila.push(this.pila.pop()*this.pila.pop());
            this.actualizar();
        }
    }

    division(){

        if(this.pila.tamaño() >= 2){
            let elementoA = this.pila.pop();
            let elementoB = this.pila.pop();
            this.pila.push(elementoB/elementoA);
            this.actualizar();
        }
    }

    pow(){

        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.pow(this.pila.pop(), 2));
            this.actualizar();
        }
    }

    sqrt() {

        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.sqrt(this.pila.pop()));
            this.actualizar();
        }
    }

    sin(){

        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.sin(this.pila.pop()));
            this.actualizar();
        }
    }

    cos(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.cos(this.pila.pop()));
            this.actualizar();
        }
    }

    tan(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.tan(this.pila.pop()));
            this.actualizar();
        }
    }

    arcsin(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.asin(this.pila.pop()));
            this.actualizar();
        }
    }

    arctan(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.atan(this.pila.pop()));
            this.actualizar();
        }
    }

    arccos(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.acos(this.pila.pop()));
            this.actualizar();
        }
    }

    ln(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.log(this.pila.pop()));
            this.actualizar();
        }
    }

    log(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(Math.log10(this.pila.pop()));
            this.actualizar();
        }
    }

    on(){
        this.pila.vaciar();
        document.querySelector('input[type=text]').value = "";
        document.querySelector('textarea[name="pantalla"]').innerHTML = "";
    }

    cambioSigno(){
        if(this.pila.tamaño() >= 1){
            this.pila.push(this.pila.pop() * (-1));
            this.actualizar();
        }
    }

    enter(){
        if (document.querySelector('input[type=text]').value == "." || document.querySelector('input[type=text]').value == "") {
            document.querySelector('input[type=text]').value = "";
        } else {
            this.pila.push(Number(document.querySelector('input[type=text]').value));
            document.querySelector('input[type=text]').value = "";
            this.actualizar();
        }
    }

    desplegarAyuda() {
        document.querySelector('span').hidden = !document.querySelector('span').hidden;
    }

    pulsacionTeclado(event) {
        if (event === '+') {
            this.suma();
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
        else if (event === '.') {
            this.punto();
        }
        else if (event === 's' || event === 'S') {
            this.sin();
        }
        else if (event === 'c' || event === 'C') {
            this.cos();
        }
        else if (event === 't' || event === 'T') {
            this.tan();
        }
        else if (event === 'r' || event === 'R') {
            this.sqrt();
        }
        else if (event === 'e' || event === 'E') {
            this.pow();
        }
        else if (event === 'l' || event === 'L') {
            this.ln();
        }
        else if (event === 'o' || event === 'O') {
            this.log();
        }
        else if (event === 'w' || event === 'W') {
            this.cambioSigno();
        }
        else if (event === 'a' || event === 'A') {
            this.arcsin();
        }
        else if (event === 'z' || event === 'Z') {
            this.arccos();
        }
        else if (event === 'q' || event === 'Q') {
            this.arctan();
        }
        else if(event >= '0' && event <= '9'){
            this.digito(Number(event));
        }
        else if(event === 'Enter'){
            this.enter();
        }
        else if(event === 'Escape'){
            this.on();
        }
    }

}

// como peculiaridad en una calculadora estadística, esta funciona igual que una calculadora RPN en cuanto a sus operaciones básicas
// (suma, resta, division, etc), pero respecto a las operaciones EXTRA, lo que hace es vaciar la pila, operar cada método con todos los valores de
// la pila, realizar el cálculo correspondiente y apilar ese resultado en la pila, de manera que solo quedaría un elemento en la pila al ejecutar
// cada operación, y se correspondería con la media, o el mínimo, ... (o la tecla que hayamos seleccionado)
class CalculadoraEspecializada extends CalculadoraRPN {
    constructor(pila) {
        super(pila);
    }

    // devuelve la media aritmética
    media() {
        if(! pila.estaVacia()){
            let suma = 0;
            let i = 0;
            while(! pila.estaVacia()) {
                suma += pila.pop();
                i++;
            }
            pila.vaciar();
            pila.push(suma/i);
            super.actualizar();
        }
    }

    // devuelve la mediana de la pila, ordena la pila y después devuelve el resultado
    mediana() {
        if(! pila.estaVacia()){
            if (pila.tamaño()==1) {
                return;
            }
            var arr = new Array;
            for (let i=0; i < pila.tamaño(); i++) {
                arr[i] = pila.obtenerElemento(i);
            }
            arr.sort((a,b) => a-b);
            const l=arr.length;
            pila.vaciar();
            pila.push(l%2==0 ? arr.slice(l/2-1, l/2+1).reduce((a,b) => a+b)/2 : arr.slice((l/2), l/2+1)[0]);
            super.actualizar();
        }
    }

    // devuelve la moda de los elementos, en caso de empate, aquel que lleve más tiempo en la pila
    moda() {
        if(! pila.estaVacia()){
            let maximoNumRepeticiones= 0;
            let moda= 0;

            for(let i=0; i<pila.tamaño(); i++)
            {
                let numRepeticiones= 0;
                for(let j=0; j<pila.tamaño(); j++)
                {
                    if(pila.obtenerElemento(i)
                        ==pila.obtenerElemento(j))
                    {
                        numRepeticiones++;
                    }   
                    if(numRepeticiones>maximoNumRepeticiones)
                    {
                        moda = pila.obtenerElemento(i);
                        maximoNumRepeticiones = numRepeticiones;
                    }       
                }
            }   
            pila.vaciar();
            pila.push(moda);
            super.actualizar();
        }
    }

    // calcula la varianza de los elementos de la pila, siempre que haya como mínimo dos
    varianza() {
        if(! pila.estaVacia() && pila.tamaño()>=2){
            let suma = 0;
            let i = 0;
            while(i < pila.tamaño()) {
                suma += pila.obtenerElemento(i);
                i++;
            }
            let media = suma/i;
            let varianza = 0;
            for (let j=0; j < i; j++) {
                varianza += Math.pow((pila.obtenerElemento(j)-media), 2);
            }
            let num = pila.tamaño();
            pila.vaciar();
            pila.push(varianza/num);
            super.actualizar();
        }
    }

    // devuelve la raiz de la varianza, siempre que haya dos como mínimo
    desvTipica() {
        if(! pila.estaVacia() && pila.tamaño()>=2){
            let suma = 0;
            let i = 0;
            while(i < pila.tamaño()) {
                suma += pila.obtenerElemento(i);
                i++;
            }
            let media = suma/i;
            let varianza = 0;
            for (let j=0; j < i; j++) {
                varianza += Math.pow((pila.obtenerElemento(j)-media), 2);
            }
            let num = pila.tamaño();
            pila.vaciar();
            pila.push(Math.sqrt(varianza/num));
            super.actualizar();
        }
    }

    // cociente en valor absoluto entre la desviación típica y la media, siempre que haya dos como mínimo
    coefVariacion() {
        if(! pila.estaVacia() && pila.tamaño()>=2) {
            let suma = 0;
            let i = 0;
            while(i < pila.tamaño()) {
                suma += pila.obtenerElemento(i);
                i++;
            }
            let media = suma/i;
            let varianza = 0;
            for (let j=0; j < i; j++) {
                varianza += Math.pow((pila.obtenerElemento(j)-media), 2);
            }
            let num = pila.tamaño();
            pila.vaciar();
            pila.push(Math.abs(Math.sqrt(varianza/num) / media));
            super.actualizar();
        }
    }

    // el valor mínimo de la pila, en caso de empate el último valor más bajo que se introduzca
    minimo() {
        if(! pila.estaVacia()){
            let minimo;
            let i = 0;
            while(i < pila.tamaño()) {
                if (i==0) {
                    minimo = pila.obtenerElemento(i);
                } else {
                    if (pila.obtenerElemento(i) <= minimo) {
                        minimo = pila.obtenerElemento(i);
                    }
                }
                i++;
            }
            pila.vaciar();
            pila.push(minimo);
            super.actualizar();
        }
    }

    // el valor máximo de la pila, en caso de empate el último valor más alto que se introduzca
    maximo() {
        if(! pila.estaVacia()){
            let maximo = 0;
            let i = 0;
            while(i < pila.tamaño()) {
                if (i==0) {
                    maximo = pila.obtenerElemento(Number(i));
                } else {
                    if (pila.obtenerElemento(i) >= maximo) {
                        maximo = pila.obtenerElemento(Number(i));
                    }
                }
                i++;
            }
            pila.vaciar();
            pila.push(maximo);
            super.actualizar();
        }
    }

    // número de elementos de la pila
    numElementos() {
        if(! pila.estaVacia()){
            let num = pila.tamaño();
            pila.vaciar();
            pila.push(num);
            super.actualizar();
        }
    }

    // sumatorio de los elementos de la pila
    sumatorio() {
        if(! pila.estaVacia()){
            let suma = 0;
            let i = 0;
            while(! pila.estaVacia()) {
                suma += pila.pop();
                i++;
            }
            pila.push(suma);
            super.actualizar();
        }
    }

    // sumatorio del cuadrado de los elementos de la pila
    sumatorioCuadrado() {
        if(! pila.estaVacia()){
            let suma = 0;
            let i = 0;
            while(! pila.estaVacia()) {
                suma += Math.pow(pila.pop(),2);
                i++;
            }
            pila.push(suma);
            super.actualizar();
        }
    }

    pulsacionTeclado(event) {
        super.pulsacionTeclado(event);
        if (event === 'm' || event === 'M') {
            this.media();
        }
        else if (event === 'j' || event === 'J') {
            this.mediana();
        }  
        else if (event === 'k' || event === 'K') { 
            this.moda();
        }
        else if (event === 'f' || event === 'F') { 
            this.sumatorio();
        }
        else if (event === 'g' || event === 'G') { 
            this.sumatorioCuadrado();
        }
        else if (event === 'x' || event === 'X') { 
            this.varianza();
        }
        else if (event === 'd' || event === 'D') { 
            this.desvTipica();
        }
        else if (event === 'v' || event === 'V') { 
            this.coefVariacion();
        }
        else if (event === 'p' || event === 'P') { 
            this.minimo();
        }
        else if (event === 'b' || event === 'B') {
            this.maximo(); 
        }
        else if (event === 'n' || event === 'N') { 
            this.numElementos();
        }
    }
}

var pila = new Pila();
calculadoraEstadistica = new CalculadoraEspecializada(pila);

document.addEventListener('keydown', function (event) {
    event.preventDefault();
    calculadoraEstadistica.pulsacionTeclado(event.key);
});

