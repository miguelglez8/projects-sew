<?php
session_start();

class PilaRPN {
    private $contenido;
    private $tamaño;

    public function __construct(){
        $this->contenido = array();
        $this->tamaño = 0;
    }

    public function push($elemento) {
        $this->contenido[$this->tamaño] = $elemento;
        $this->tamaño += 1;
    }

    public function pop(){
        if($this->tamaño > 0){
            $this->tamaño -= 1;
            return $this->contenido[$this->tamaño];
        }
    }

    public function tamaño(){
        return $this->tamaño;
    }

    public function estaVacia(){
        return $this->tamaño == 0;
    }

    public function imprimeContenido()
    {
        $res = "";
        
        for ($i = $this->tamaño - 1; $i >= 0 ; $i--) {
            $res .= "Valor " . floatval($i+1) . ":" . $this->contenido[$i] . "\n";
        } 

        return $res;
    }

    public function vaciar(){
        $this->tamaño = 0;
        $this->contenido = array();
    }
}

  class CalculadoraRPN {
    private $content;
    private $pantalla;

    public function __construct() {
        $this->content=new PilaRPN();
        $this->pantalla="";
    }

    private function pop(){
        return $this->content->pop();
    }

    private function push($value){
        try{
            $value = floatval($value);
            $this->content->push($value);
        }catch(Exception | Error ){
            $this->pantalla='Error al calcular';
        }
    }

    public function digitos($x){
        $this->pantalla .= $x; 
    }

    public function punto(){
        $this->pantalla .= ".";  
     }

    public function suma(){
        if($this->content->tamaño() >= 2){
            $this->push($this->pop()+$this->pop());
        }
    }

    public function resta(){
        if($this->content->tamaño() >= 2){
            $elementoA = $this->content->pop();
            $elementoB = $this->content->pop();
            $this->push($elementoB-$elementoA);
        }
    }


    public function multiplicacion(){

        if($this->content->tamaño() >= 2){
            $this->push($this->pop()*$this->pop());
        }
    }

    public function division(){

        if($this->content->tamaño() >= 2){
            $elementoA = $this->content->pop();
            $elementoB = $this->content->pop();
            $this->push($elementoB/$elementoA);
        }
    }

    public function pow(){

        if($this->content->tamaño() >= 1){
            $this->push(pow($this->pop(), 2));
        }
    }

    public function sqrt() {

        if($this->content->tamaño() >= 1){
            $this->push(sqrt($this->pop()));
        }
    }

    public function sin(){

        if($this->content->tamaño() >= 1){
            $this->push(sin($this->pop()));
        }
    }

    public function cos(){
        if($this->content->tamaño() >= 1){
            $this->push(cos($this->pop()));
        }
    }

    public function tan(){
        if($this->content->tamaño() >= 1){
            $this->push(tan($this->pop()));
        }
    }

    public function arcsin(){
        if($this->content->tamaño() >= 1){
            $this->push(asin($this->pop()));
        }
    }

    public function arctan(){
        if($this->content->tamaño() >= 1){
            $this->push(atan($this->pop()));
        }
    }

    public function arccos(){
        if($this->content->tamaño() >= 1){
            $this->push(acos($this->pop()));
        }
    }

    public function ln(){
        if($this->content->tamaño() >= 1){
            $this->push(log($this->pop()));
        }
    }

    public function log(){
        if($this->content->tamaño() >= 1){
            $this->push(log10($this->pop()));
        }
    }

    public function on(){
        $this->pantalla='';
        $this->content->vaciar();
    }

    public function cambioSigno(){
        if($this->content->tamaño() >= 1){
            $this->push($this->pop() * (-1));
        }
    }

    public function enter(){
        $value = $this->pantalla;
        $this->push($value);
        $this->pantalla="";
    }

    public function getPantalla() {
        return $this->pantalla;
    }

    public function imprimeContenido() {
        return $this->content->imprimeContenido();
    }
}

if( isset( $_SESSION['operacionesRPN'] ) ) {
    $operaciones = $_SESSION['operacionesRPN'];
}else {
    $operaciones = new CalculadoraRPN();
    $_SESSION['operacionesRPN'] = $operaciones;
}

$resultado = "";
$pila = "";

if (count($_POST)>0) 
    {   
        if(isset($_POST['ON'])) $operaciones->on();
        if(isset($_POST['Enter'])) $operaciones->enter();
        if(isset($_POST['÷'])) $operaciones->division();
        if(isset($_POST['X'])) $operaciones->multiplicacion();
        if(isset($_POST['+'])) $operaciones->suma();
        if(isset($_POST['-'])) $operaciones->resta();
        if(isset($_POST['+/-'])) $operaciones->cambioSigno();
        if(isset($_POST['punto'])) $operaciones->punto();
        if(isset($_POST['0'])) $operaciones->digitos('0');
        if(isset($_POST['1'])) $operaciones->digitos('1');
        if(isset($_POST['2'])) $operaciones->digitos('2');
        if(isset($_POST['3'])) $operaciones->digitos('3');
        if(isset($_POST['4'])) $operaciones->digitos('4');
        if(isset($_POST['5'])) $operaciones->digitos('5');
        if(isset($_POST['6'])) $operaciones->digitos('6');
        if(isset($_POST['7'])) $operaciones->digitos('7');
        if(isset($_POST['8'])) $operaciones->digitos('8');
        if(isset($_POST['9'])) $operaciones->digitos('9');
        if(isset($_POST['ARCSIN'])) $operaciones->arcsin();
        if(isset($_POST['ARCCOS'])) $operaciones->arccos();
        if(isset($_POST['ARCTAN'])) $operaciones->arctan();
        if(isset($_POST['SIN'])) $operaciones->sin();
        if(isset($_POST['COS'])) $operaciones->cos();
        if(isset($_POST['TAN'])) $operaciones->tan();
        if(isset($_POST['LN'])) $operaciones->ln();
        if(isset($_POST['LOG'])) $operaciones->log();
        if(isset($_POST['√'])) $operaciones->sqrt();
        if(isset($_POST['X²'])) $operaciones->pow();

        $resultado = $operaciones->getPantalla();
        $pila = $operaciones->imprimeContenido();
    }

echo "

<!DOCTYPE HTML>

<html lang='es'>
<head>
    <!-- Datos que describen el documento -->
    <meta charset='UTF-8' />
    <title>Calculadora RPN</title>
    
    <!--Metadatos de los documentos HTML5-->
    <meta name ='author' content ='Miguel González Navarro' />
    <meta name ='description' content ='Ejercicio 3 PHP' />
    <meta name ='keywords' content ='PHP, Calculadora RPN' />

    <!--Definición de la ventana gráfica-->
    <meta name ='viewport' content ='width=device-width, initial-scale=1.0' />
    <link rel='stylesheet' type='text/css' href='CalculadoraRPN.css' />
</head>

<body>
    <form action='#' method='post'>
        <label for='pantalla'>Calculadora RPN</label>
        <input type='submit' title='Encender/vaciar calculadora' value='ON' name='ON'>
        <textarea id='pantalla' rows='10' name='pantalla' lang='es' disabled>$pila</textarea>
        
        <label for='numero'>Numero</label>
        <input type='text' name='numero' id='numero' value='$resultado' lang='es' disabled>
        
        <input type='submit' title='Seno' value='SIN' name='SIN' />
        <input type='submit' title='Coseno' value='COS' name='COS' />
        <input type='submit' title='Tangente' value='TAN' name='TAN' />
        <input type='submit' title='Elevado al cuadrado' value='X²'  name='X²' />

        <input type='submit' title='Arcoseno' value='ARCSIN' name='ARCSIN' />
        <input type='submit' title='Arcocoseno' value='ARCCOS' name='ARCCOS' />
        <input type='submit' title='Arcotangente' value='ARCTAN' name='ARCTAN' />
        <input type='submit' title='Raiz' value='√' name='√' />
        
        <input type='submit' title='Logaritmo neperiano' value='LN' name='LN' />
        <input type='submit' title='Logaritmo base 10' value='LOG' name='LOG' />
        <input type='submit' title='Cambio de signo' value='+/-' name='+/-' />
        <input type='submit' title='Enter' value='Enter' name='Enter' />

        <input type='submit' title='Siete' value='7' name='7' />
        <input type='submit' title='Ocho' value='8' name='8' />
        <input type='submit' title='Nueve' value='9' name='9'  />
        <input type='submit' title='Entre' value='÷'  name='÷' />

        <input type='submit' title='Cuatro' value='4' name='4' />
        <input type='submit' title='Cinco' value='5' name='5' />
        <input type='submit' title='Seis' value='6' name='6' />
        <input type='submit' title='Por' value='X' name='X' />

        <input type='submit' title='Uno' value='1' name='1' />
        <input type='submit' title='Dos' value='2' name='2' />
        <input type='submit' title='Tres' value='3'  name='3' />
        <input type='submit' title='Menos' value='-' name='-' />

        <input type='submit' title='Cero' value='0' name='0' />
        <input type='submit' title='punto' value='.' name='punto' />
        <input type='submit' title='Mas' value='+' name='+' />

    </form>

</body>
</html>";

?>