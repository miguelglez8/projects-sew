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
  class CalculadoraCientifica extends CalculadoraMilan {
    private $enGrados;
    private $modoA;
    private $modoH;
    private $notacionCientifica;

    public function __construct() {
        parent::__construct();
        $this->enGrados = true; // no está en radianes
        $this->modoA = false; // funcion arcsen, arccos y arctan
        $this->modoH = false; // funcion senh, cosh, tanh
        $this->notacionCientifica = false; // no está en notación científica
    }

    public function borrar() {
        $this->pantalla = "";
        $this->guardarMemoria = "";
        $this->notacionCientifica = false;
        $this->enGrados = true; // no está en radianes
        $this->modoA = false; // funcion arcsen, arccos y arctan
        $this->modoH = false; // funcion senh, cosh, tanh
    }

    public function punto() {
        $this->pantalla .= '.';
    }

    public function suma() { 
        $this->pantalla .= "+";
    }

    public function resta() { 
        $this->pantalla .= "-";
    }

    public function multiplicacion() { 
        $this->pantalla .= "*";
    }
    
    public function division() { 
        $this->pantalla .= "/";
    }

    public function activar() {
        if ($this->modoA==true) {
            $this->modoA=false;
        } else {
            $this->modoA=true;
        }
    }

    public function deg(){ 
        if($this->enGrados == true) {
            $this->enGrados = false;
        } else{
            $this->enGrados = true;
        }
    }

    public function fe()
    {
        if ($this->pantalla!="") {
            if ($this->notacionCientifica == true) {
                if(substr($this->pantalla, 0, 1) == "-") {
                    $this->pantalla = substr($this->pantalla, 1, strlen($this->pantalla));
                    $array = explode("e", $this->pantalla)[0];
                    $number = substr($this->pantalla, strlen($this->pantalla) - 1, strlen($this->pantalla));
                    $this->pantalla = "";
                    for ($i = 0; $i < strlen($array); $i++) {
                        if ($i!=1) {
                            if ($i==$number+1) {
                                $this->pantalla .= $array[$i] . ".";
                            } else {
                                $this->pantalla .= $array[$i];
                            }
                        }
                    }
                    if (substr($this->pantalla, strlen($this->pantalla) - 1, strlen($this->pantalla)) == ".") {
                        $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1);
                    }         
                    $this->pantalla = '-' . $this->pantalla; 
                } else if (str_contains($this->pantalla, "e+")) {
                    $array = explode("e", $this->pantalla)[0];
                    $number = substr($this->pantalla, strlen($this->pantalla) - 1, strlen($this->pantalla));
                    $this->pantalla = "";
                    for ($i = 0; $i < strlen($array); $i++) {
                        if ($i!=1) {
                            if ($i==$number+1) {
                                $this->pantalla .= $array[$i] . ".";
                            } else {
                                $this->pantalla .= $array[$i];
                            }
                        }
                    }
                    if (substr($this->pantalla, strlen($this->pantalla) - 1, strlen($this->pantalla)) == ".") {
                        $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1);
                    }     
                }
                else if (str_contains($this->pantalla, "+") ||
                    str_contains($this->pantalla, "-") ||
                    str_contains($this->pantalla, "*") ||
                    str_contains($this->pantalla, "/") ||
                    str_contains($this->pantalla, "%")) {
                } else {
                    $array = explode("e", $this->pantalla)[0];
                    $number = substr($this->pantalla, strlen($this->pantalla) - 1, strlen($this->pantalla));
                    $this->pantalla = "";
                    for ($i = 0; $i < strlen($array); $i++) {
                        if ($i!=1) {
                            if ($i==$number+1) {
                                $this->pantalla .= $array[$i] . ".";
                            } else {
                                $this->pantalla .= $array[$i];
                            }
                        }
                    }
                    if (substr($this->pantalla, strlen($this->pantalla) - 1, strlen($this->pantalla)) == ".") {
                        $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1);
                    }     
                }
                $this->notacionCientifica = false;
                
            } else {
                if(substr($this->pantalla, 0, 1) == "-") {
                    $this->pantalla = substr($this->pantalla, 1, strlen($this->pantalla));
                        $array = explode(".", $this->pantalla);
                        if (count($array) == 1) {
                            $string = $array[0];
                            $this->pantalla = $string[0] . ".";
                            $j = 0;
                            for ($i = 1; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                                $j++;
                            }
                            $this->pantalla .= "e+" . $j;

                        } else if (count($array) == 2) {
                            $string = $array[0];
                            $this->pantalla = $string[0] . ".";
                            $j = 0;
                            for ($i = 1; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                                $j++;
                            }
                            $string = $array[1];
                            for ($i = 0; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                            }
                            $this->pantalla .= "e+" . $j;
                        }
                    $this->pantalla = '-' . $this->pantalla; 
                } else if (str_contains($this->pantalla, "e+")) {
                    $array = explode(".", $this->pantalla);
                        if (count($array) == 1) {
                            $string = $array[0];
                            $this->pantalla = $string[0] . ".";
                            $j = 0;
                            for ($i = 1; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                                $j++;
                            }
                            $this->pantalla .= "e+" . $j;
            
                        } else if (count($array) == 2) {
                            $string = $array[0];
                            $this->pantalla = $string[0] . ".";
                            $j = 0;
                            for ($i = 1; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                                $j++;
                            }
                            $string = $array[1];
                            for ($i = 0; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                            }
                            $this->pantalla .= "e+" . $j;
                        }
                }
                else if (str_contains($this->pantalla, "+") ||
                    str_contains($this->pantalla, "-") ||
                    str_contains($this->pantalla, "*") ||
                    str_contains($this->pantalla, "/") ||
                    str_contains($this->pantalla, "%")) {
                } else {
                        $array = explode(".", $this->pantalla);
                        if (count($array) == 1) {
                            $string = $array[0];
                            $this->pantalla = $string[0] . ".";
                            $j = 0;
                            for ($i = 1; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                                $j++;
                            }
                            $this->pantalla .= "e+" . $j;
            
                        } else if (count($array) == 2) {
                            $string = $array[0];
                            $this->pantalla = $string[0] . ".";
                            $j = 0;
                            for ($i = 1; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                                $j++;
                            }
                            $string = $array[1];
                            for ($i = 0; $i < strlen($string); $i++) {
                                $this->pantalla .= $string[$i];
                            }
                            $this->pantalla .= "e+" . $j;
                        }
                }
                $this->notacionCientifica = true;
            }
        }
    }

    public function hyp() {
        if ($this->modoH==true) {
            $this->modoH=false;
        } else {
            $this->modoH=true;
        }
    }

    public function mr(){ 
        $this->pantalla = $this->guardarMemoria;
    }

    public function ms(){ 
        $this->guardarMemoria = $this->pantalla;
    }

    public function mc(){ 
        $this->guardarMemoria = "";
    }

    public function abrirParentesis() {
        $this->pantalla .= "(";
    }

    public function cerrarParentesis() {
        $this->pantalla .=  ")";
    }

    public function pi() {
        $this->pantalla .= pi();
    }

    public function pow() {
        $this->pantalla .= "**";
    }

    public function pow2() { 
        try {
            $this->pantalla = pow(eval("return $this->pantalla;"),2);
        } catch (Exception | Error) {
            $this->pantalla = "Error de sintaxis";
        }
    }

    public function sqrt() {
        try {
            $this->pantalla = sqrt(eval("return $this->pantalla;"));
        } catch (Exception | Error) {
            $this->pantalla = "Error de sintaxis";
        }
    }

    public function baseten() { 
        try {
            $this->pantalla = pow(10, eval("return $this->pantalla;"));
        } catch (Exception | Error) {
            $this->pantalla = "Error de sintaxis";
        }
    }
    
    public function log() {
        try {
            $this->pantalla = log10(eval("return $this->pantalla;"));
        } catch (Exception | Error) {
            $this->pantalla = "Error de sintaxis";
        }
    }

    public function exp() {
        if ($this->pantalla!="" && $this->notacionCientifica==true) {
            if (substr($this->pantalla,0,1) == '-') {
                $this->pantalla = substr($this->pantalla, 1, strlen($this->pantalla));
                if (! str_contains($this->pantalla, 'e+0')) {
                    if(strpos($this->pantalla, '.')){
                        $this->pantalla .= "e+0";
                    }else{
                        $this->pantalla .= ".e+0";
                    }
                } 
                $this->pantalla = "-" . $this->pantalla;
            } else {
                if (!str_contains($this->pantalla, 'e+')) {
                    if(strpos($this->pantalla, '.')){
                        $this->pantalla .= "e+0";
                    }else{
                        $this->pantalla .= ".e+0";
                    }
                }
            } 
        }
    }

    public function mod() { 
        $this->pantalla .= "%";
    }

    public function borrarUltimo() {
        $aux = $this->pantalla;
        $this->pantalla = substr($aux, 0, -1);
    }

    public function factorial() {
        $number = eval("return $this->pantalla;");;
        $result = 0;
        try {
            $result = $this->recursiveFactorial($number);
        } catch(Exception | Error) {
            $this->pantalla = "El numero es muy grande";
        }
        $this->pantalla = $result;
    }

    public function recursiveFactorial($number) {
        if ($number == 1 || $number == 0) {
            return 1;
        }
        return $number * $this->recursiveFactorial($number - 1);
    }

    public function sin() {
        try{
            if ($this->enGrados) {
                if ($this->modoA==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(asin($num));
                } else if($this->modoH==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(sinh($num));
                } else {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(sin($num));
                }
            } else {
                if ($this->modoA==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = asin($num);
                } else if($this->modoH==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = sinh($num);
                } else {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = sin($num);            
                }
            }     
        }catch(Exception $e){
            $this->pantalla = "operación inválida";
        }catch(Error $e){
            $this->pantalla = "operación inválida";
        }
    }

    public function cos() { 
        try{
            if ($this->enGrados) {
                if ($this->modoA==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(acos($num));
                } else if($this->modoH==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(cosh($num));
                } else {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(cos($num));
                }
            } else {
                if ($this->modoA==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = acos($num);
                } else if($this->modoH==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = cosh($num);
                } else {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = cos($num);            
                }
            }     
        }catch(Exception $e){
            $this->pantalla = "operación inválida";
        }catch(Error $e){
            $this->pantalla = "operación inválida";
        }
    }

    public function tan() { 
        try{
            if ($this->enGrados) {
                if ($this->modoA==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(atan($num));
                } else if($this->modoH==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(tanh($num));
                } else {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = rad2deg(tan($num));
                }
            } else {
                if ($this->modoA==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = atan($num);
                } else if($this->modoH==true) {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = tanh($num);
                } else {
                    $num = eval("return $this->pantalla;");
                    $this->pantalla = tan($num);            
                }
            }    
        }catch(Exception $e){
            $this->pantalla = "operación inválida";
        }catch(Error $e){
            $this->pantalla = "operación inválida";
        }
    }

    public function igual() { 
        try {
            if ($this->notacionCientifica==true) {
                $this->pantalla = eval("return $this->pantalla;");
                if (substr($this->pantalla, 0, 1) == "-") {
                    $this->pantalla = substr($this->pantalla, 1, strlen($this->pantalla));
                    $array = explode(".", $this->pantalla);
                    if (count($array) == 1) {
                        $string = $array[0];
                        $this->pantalla = $string[0] . ".";
                        $j = 0;
                        for ($i = 1; $i < strlen($string); $i++) {
                            $this->pantalla .= $string[$i];
                            $j++;
                        }
                        $this->pantalla .= "e+" . $j;

                    } else if (count($array) == 2) {
                        $string = $array[0];
                        $this->pantalla = $string[0] . ".";
                        $j = 0;
                        for ($i = 1; $i < strlen($string); $i++) {
                            $this->pantalla .= $string[$i];
                            $j++;
                        }
                        $string = $array[1];
                        for ($i = 0; $i < strlen($string); $i++) {
                            $this->pantalla .= $string[$i];
                        }
                        $this->pantalla .= "e+" . $j;
                    }
                    $this->pantalla = '-' . $this->pantalla;    
                } else {
                    $array = explode(".", $this->pantalla);
                    if (count($array) == 1) {
                        $string = $array[0];
                        $this->pantalla = $string[0] . ".";
                        $j = 0;
                        for ($i = 1; $i < strlen($string); $i++) {
                            $this->pantalla .= $string[$i];
                            $j++;
                        }
                        $this->pantalla .= "e+" . $j;
        
                    } else if (count($array) == 2) {
                        $string = $array[0];
                        $this->pantalla = $string[0] . ".";
                        $j = 0;
                        for ($i = 1; $i < strlen($string); $i++) {
                            $this->pantalla .= $string[$i];
                            $j++;
                        }
                        $string = $array[1];
                        for ($i = 0; $i < strlen($string); $i++) {
                            $this->pantalla .= $string[$i];
                        }
                        $this->pantalla .= "e+" . $j;
                    }
                }
            } else {
                $this->pantalla = eval("return $this->pantalla;");
            }
        } catch (Exception | Error) {
            $this->pantalla = "Error de sintaxis";
        }       
    }

}


if( isset( $_SESSION['operacionesCientificas'] ) ) {
    $calc = $_SESSION['operacionesCientificas'];
}else {
    $calc = new CalculadoraCientifica();
    $_SESSION['operacionesCientificas'] = $calc;
}

$resultado = "";

if (count($_POST)>0) 
    {   
        if(isset($_POST['MC'])) $calc->mc();
        if(isset($_POST['MR'])) $calc->mr();
        if(isset($_POST['MS'])) $calc->ms();
        if(isset($_POST['M+'])) $calc->mMas();
        if(isset($_POST['M-'])) $calc->mMenos();
        if(isset($_POST['F-E'])) $calc->fe();
        if(isset($_POST['HYP'])) $calc->hyp();
        if(isset($_POST['DEG'])) $calc->deg();
        if(isset($_POST['x²'])) $calc->pow2();
        if(isset($_POST['xⁿ'])) $calc->pow();
        if(isset($_POST['sin'])) $calc->sin();
        if(isset($_POST['cos'])) $calc->cos();
        if(isset($_POST['tan'])) $calc->tan();
        if(isset($_POST['log'])) $calc->log();
        if(isset($_POST['Mod'])) $calc->mod();
        if(isset($_POST['√'])) $calc->sqrt();
        if(isset($_POST['10ⁿ'])) $calc->baseten();
        if(isset($_POST['Exp'])) $calc->exp();
        if(isset($_POST['CE'])) $calc->ce();
        if(isset($_POST['C'])) $calc->borrar();
        if(isset($_POST['↑'])) $calc->activar();
        if(isset($_POST['⌫'])) $calc->borrarUltimo();
        if(isset($_POST['÷'])) $calc->division();
        if(isset($_POST['X'])) $calc->multiplicacion();
        if(isset($_POST['π'])) $calc->pi();
        if(isset($_POST['+-'])) $calc->cambiarSigno();
        if(isset($_POST['+'])) $calc->suma();
        if(isset($_POST['-'])) $calc->resta();
        if(isset($_POST['punto'])) $calc->punto();
        if(isset($_POST['0'])) $calc->digitos('0');
        if(isset($_POST['1'])) $calc->digitos('1');
        if(isset($_POST['2'])) $calc->digitos('2');
        if(isset($_POST['3'])) $calc->digitos('3');
        if(isset($_POST['4'])) $calc->digitos('4');
        if(isset($_POST['5'])) $calc->digitos('5');
        if(isset($_POST['6'])) $calc->digitos('6');
        if(isset($_POST['7'])) $calc->digitos('7');
        if(isset($_POST['8'])) $calc->digitos('8');
        if(isset($_POST['9'])) $calc->digitos('9');
        if(isset($_POST['='])) $calc->igual();
        if(isset($_POST['('])) $calc->abrirParentesis();
        if(isset($_POST[')'])) $calc->cerrarParentesis();
        if(isset($_POST['n!'])) $calc->factorial();

        $resultado = $_SESSION['operacionesCientificas']->getPantalla();
    }

echo "
<!DOCTYPE HTML>

<html lang='es'>
<head>
    <!-- Datos que describen el documento -->
    <meta charset='UTF-8' />
    <title>Calculadora Científica</title>
    
    <!--Metadatos de los documentos HTML5-->
    <meta name ='author' content ='Miguel González Navarro' />
    <meta name ='description' content ='Ejercicio 2 PHP' />
    <meta name ='keywords' content ='PHP, Calculadora Científica' />

    <!--Definición de la ventana gráfica-->
    <meta name ='viewport' content ='width=device-width, initial-scale=1.0' />
    <link rel='stylesheet' type='text/css' href='CalculadoraCientifica.css' />
</head>

<body>
    <h1>CALCULADORA CIENTIFICA</h1>
    <form action='#' method='post'>
        <label for='pantalla'>Resultado</label>
        <input type='text' name='pantalla' id='pantalla' value='$resultado' lang='es' readonly disabled>
        <!--Primera fila-->
        <input type='submit' title='Deg/Rad' value='DEG' name='DEG' />
        <input type='submit' title='Activar funciones hiperbólicas' value='HYP' name='HYP' />
        <input type='submit' title='Activar modo notación científica' value='F-E' name='F-E' />
        <!--Segunda fila-->
        <input type='submit' title='Vaciar memoria' value='MC' name='MC' />
        <input type='submit' title='Mostrar memoria' value='MR' name='MR' />
        <input type='submit' title='Sumar memoria' value='M+' name='M+' />
        <input type='submit' title='Restar memoria' value='M-' name='M-' />
        <input type='submit' title='Guardar en memoria' value='MS' name='MS' />
        <!--Tercera fila-->
        <input type='submit' title='Elevado al cuadrado' value='x²' name='x²' />
        <input type='submit' title='X elevado a n' value='xⁿ' name='xⁿ' />
        <input type='submit' title='Seno' value='sin' name='sin' />
        <input type='submit' title='Coseno' value='cos'  name='cos' />
        <input type='submit' title='Tangente' value='tan' name='tan' />
        <!--Cuarta fila-->
        <input type='submit' title='Raíz cuadrada' value='√' name='√' />
        <input type='submit' title='10 Elevado a n' value='10ⁿ' name='10ⁿ' />
        <input type='submit' title='Logaritmo' value='log' name='log' />
        <input type='submit' title='Notación científica' value='Exp' name='Exp' />
        <input type='submit' title='Modulo' value='Mod' name='Mod' />
        <!--Quinta fila-->
        <input type='submit' title='Activar funciones inversas trigonométricas' value='↑' name='↑' />
        <input type='submit' title='Borrar pantalla' value='CE' name='CE' />
        <input type='submit' title='Encender/borrar' value='C' name='C' />
        <input type='submit' title='Borrar último' value='⌫' name='⌫' />
        <input type='submit' title='Entre' value='÷' name='÷' />
        <!--Sexta fila-->
        <input type='submit' title='Pi' value='π' name='π' />
        <input type='submit' title='Siete' value='7' name='7' />
        <input type='submit' title='Ocho' value='8' name='8' />
        <input type='submit' title='Nueve' value='9' name='9' />
        <input type='submit' title='Por' value='X' name='X' />
        <!--Séptima fila-->
        <input type='submit' title='Factorial' value='n!' name='n!' />
        <input type='submit' title='Cuatro' value='4' name='4' />
        <input type='submit' title='Cinco' value='5' name='5'  />
        <input type='submit' title='Seis' value='6' name='6' />
        <input type='submit' title='Menos' value='-' name='-' />
        <!--Octava fila-->
        <input type='submit' title='Cambiar Signo' value='+-' name='+-' />
        <input type='submit' title='Uno' value='1'  name='1' />
        <input type='submit' title='Dos' value='2' name='2' />
        <input type='submit' title='Tres' value='3' name='3'/>
        <input type='submit' title='Más' value='+' name='+' />
        <!--Novena fila-->
        <input type='submit' title='Abre paréntesis' value='(' name='(' />
        <input type='submit' title='Cierra paréntesis' value=')' name=')' />
        <input type='submit' title='Cero' value='0' name='0' />
        <input type='submit' title='Punto' value='.' name='punto' />
        <input type='submit' title='Igual' value='=' name='=' />
    </form>
</body>
</html>";

?>