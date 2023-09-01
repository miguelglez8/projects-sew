<?php
session_start();
class CalculadoraMilan{

    protected $pantalla;
    protected $guardarMemoria;
    private $operaciones;
    private $operando1;
    private $operando2;
    private $inicializado;
    private $final;

    public function __construct() {
        $this->pantalla = "";
        $this->guardarMemoria = "";
        $this->operaciones = "";
        $this->operando1 = "0";
        $this->operando2 = "0";
        $this->inicializado = true;
        $this->final = false;
    }

    public function digitos($x) {
        if ($this->final==true) {
            $this->operaciones = "";
            $this->operando1 = "";
            $this->operando2 = "";
            $this->final = false;
            $this->inicializado = true;
        }
        if ($this->inicializado || $this->operando1=="0") {
            $this->pantalla = $x;
            $this->operando1 = $x;
        } else {
            $this->pantalla .= $x;
            $this->operando1 .= $x;
        }
        $this->inicializado = false;
    }

    public function porcentaje() {
        try{
            $this->operando1 = $this->operando2*($this->operando1/100);
            $this->pantalla = $this->operando1;
        }catch(Exception $error){
            $this->pantalla = "Operación no válida";
        }catch(Error $err){
            $this->pantalla = "Operación no válida";
        }
    }

    public function sqrt() {
        $this->pantalla = sqrt(eval("return $this->operando1;"));
        $this->operando1 = sqrt(eval("return $this->operando1;"));
    }

    public function punto() {
        if (!str_contains($this->operando1,".")) {
            $this->pantalla .= ".";
            $this->operando1 .= ".";
        }
    }

    public function suma() {
        if (! $this->final) {
            $this->igual();
            $this->operando2 = eval("return $this->pantalla;");
        }
        $this->inicializado = true;
        $this->final = false;
        $this->operaciones = "+";
    }

    public function resta() {
        if (! $this->final) {
            $this->igual();
            $this->operando2 = eval("return $this->pantalla;");
        }
        $this->inicializado = true;
        $this->final = false;
        $this->operaciones = "-";
    }

    public function multiplicacion() {
        if (! $this->final) {
            $this->igual();
            $this->operando2 = eval("return $this->pantalla;");
        }
        $this->inicializado = true;
        $this->final = false;
        $this->operaciones = "*";
    }
    
    public function division() {
        if (! $this->final) {
            $this->igual();
            $this->operando2 = eval("return $this->pantalla;");
        }
        $this->inicializado = true;
        $this->final = false;
        $this->operaciones = "/";
    }

    public function mrc() {
        $this->operando1 = $this->guardarMemoria;
        $this->pantalla = $this->operando1;
    }

    public function mMenos() {
        try{
            $this->guardarMemoria = eval("return $this->guardarMemoria;") - eval("return $this->pantalla;");
        }catch(Exception $error){
            $this->pantalla = "Operación no válida";
        }catch(Error $e){
            $this->pantalla = "Operación no válida";
        }    }

    public function mMas() {
        try{
            $this->guardarMemoria = eval("return $this->guardarMemoria;") + eval("return $this->pantalla;");
        }catch(Exception $error){
            $this->pantalla = "Operación no válida";
        }catch(Error $e){
            $this->pantalla = "Operación no válida";
        }
    }

    public function cambiarSigno() {
        $this->operando1 = eval("return $this->pantalla;") * -1;
        $this->pantalla = $this->operando1;
    }

    public function borrar() {
        $this->pantalla = "";
        $this->operando1 = "";
        $this->operando2 = "";
        $this->operaciones = "";
        $this->guardarMemoria = "";
    }

    public function ce() {
        $this->operando1 = "";
        $this->pantalla = "";
    }

    public function getPantalla(){
        return $this->pantalla;
    }

    public function igual() {
        try{
            if ($this->operaciones=="") {
                $this->pantalla = $this->operando1;
            } else {
                $res = $this->operando2.$this->operaciones.$this->operando1;
                $solucion = eval("return $res;");
                $this->pantalla = $solucion;
                $this->inicializado = false;
                $this->operando2 = $solucion;
                $this->final = true;
            }
        }catch(Exception | Error){
            $this->pantalla = "Operación no válida";
        }
    }
}

if( isset( $_SESSION['operaciones'] ) ) {
    $operaciones = $_SESSION['operaciones'];
}else {
    $operaciones = new CalculadoraMilan();
    $_SESSION['operaciones'] = $operaciones;
}

$resultado = "";

if (count($_POST)>0) 
    {  
        if(isset($_POST['ON/C'])) $operaciones->borrar();
        if(isset($_POST['CE'])) $operaciones->ce();
        if(isset($_POST['+/-'])) $operaciones->cambiarSigno();
        if(isset($_POST['√'])) $operaciones->sqrt();
        if(isset($_POST['%'])) $operaciones->porcentaje();
        if(isset($_POST['MRC'])) $operaciones->mrc();
        if(isset($_POST['M+'])) $operaciones->mMas();
        if(isset($_POST['M-'])) $operaciones->mMenos();
        if(isset($_POST['='])) $operaciones->igual();
        if(isset($_POST['÷'])) $operaciones->division();
        if(isset($_POST['X'])) $operaciones->multiplicacion();
        if(isset($_POST['+'])) $operaciones->suma();
        if(isset($_POST['-'])) $operaciones->resta();
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
        
        $resultado = $operaciones->getPantalla();
    }

echo "
<!DOCTYPE HTML>

<html lang='es'>
<head>
    <!-- Datos que describen el documento -->
    <meta charset='UTF-8' />
    <title>Calculadora Milan</title>
    
    <!--Metadatos de los documentos HTML5-->
    <meta name ='author' content ='Miguel González Navarro' />
    <meta name ='description' content ='Ejercicio 1 PHP' />
    <meta name ='keywords' content ='PHP, Calculadora Milan' />

    <!--Definición de la ventana gráfica-->
    <meta name ='viewport' content ='width=device-width, initial-scale=1.0' />
    <link rel='stylesheet' type='text/css' href='CalculadoraMilan.css' />
</head>

<body>
    <h1>CALCULADORA MILAN</h1>
    <form action='#' method='post'>
        <label for='pantalla'>nata by MILAN</label>
        <input type='text' name='pantalla' id='pantalla' value='$resultado' lang='es' readonly disabled>
        <!--Primera fila-->
        <input type='submit' title='Encender' value='ON/C' name='ON/C' />
        <input type='submit' title='Borrar' value='CE' name='CE' />
        <input type='submit' title='masMenos' value='+/-' name='+/-' />
        <input type='submit' title='Raiz cuadrada' value='√' name='√' />
        <input type='submit' title='Porcentage' value='%' name='%'  />
        <!--Segunda fila-->
        <input type='submit' title='Siete' value='7' name='7' />
        <input type='submit' title='Ocho' value='8' name='8' />
        <input type='submit' title='Nueve' value='9' name='9' />
        <input type='submit' title='Por' value='X' name='X' />
        <input type='submit' title='Entre' value='÷' name='÷' />
        <!--Tercera fila-->
        <input type='submit' title='Cuatro' value='4' name='4' />
        <input type='submit' title='Cinco' value='5' name='5' />
        <input type='submit' title='Seis' value='6' name='6' />
        <input type='submit' title='Menos' value='-' name='-' />
        <input type='submit' title='Muestra memoria' value='MRC' name='MRC' />
        <!--Cuarta fila-->
        <input type='submit' title='Uno' value='1' name='1' />
        <input type='submit' title='Dos' value='2' name='2' />
        <input type='submit' title='Tres' value='3' name='3' />
        <input type='submit' title='Mas' value='+' name='+' />
        <input type='submit' title='Resta memoria' value='M-' name='M-' />
        <!--Quinta fila-->
        <input type='submit' title='Cero' value='0' name='0' />
        <input type='submit' title='Punto' value='.' name='punto' />
        <input type='submit' title='Igual' value='=' name='=' />
        <input type='submit' title='Suma Memoria' value='M+' name='M+' />
    </form>    
</body>
</html>";
    
?>