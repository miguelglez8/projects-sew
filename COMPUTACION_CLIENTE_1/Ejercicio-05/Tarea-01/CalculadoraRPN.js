// CalculadoraRPN.js

// Pila LIFO (Last input first output), los elementos se van acumulando encima de otros, 
// siendo el último que introduzcamos aquel que esté en la cima de la pila
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

// Las calculadora utiliza el sistema de entrada de datos RPN, este sistema difiere del algebraico normal en el orden en que se introducen 
// los números con los que se quiere operar y el operador. El sistema RPN funciona de esta forma: primero se introduce un número, se pulsa ENTER para separarlo del segundo, se introduce el 
// segundo y se pulsa ENTER y finalmente se pulsa el operador “+”: 5 ENTER 4 ENTER +
// Y el resultado es 9. Para las operaciones como la raíz o las trigonométricas los resultados se aplicarán sobre los elementos de la cima
// de la pila, y si se trata de una operación básica como la suma se aplicará sobre los dos elementos de la cima de la pila (los etiquetados con los dos índices más grandes en la pantalla).
// La calculadora trabaja con una pila LIFO, esto quiere decir que los elemento se van apilando en el orden de entrada, es decir, si tecleo 1 ENTER 2 ENTER 3 ENTER,
// el primer elemento de la pila va a ser el 3, luego el 2 y así sucesivamente. Una pila no es más que una lista ordenada o estructura de datos que permite almacenar y recuperar datos,
// en nuestro caso, números para hacer operaciones.

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

var pila = new Pila();
var calculadoraRPN = new CalculadoraRPN(pila);


document.addEventListener('keydown', function (event) {
    event.preventDefault();
    calculadoraRPN.pulsacionTeclado(event.key);
});

