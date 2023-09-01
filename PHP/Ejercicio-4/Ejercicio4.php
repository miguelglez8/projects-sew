<?php
session_start();

class PrecioOro {
    private $precioOro;
    private $moneda;
    private $fecha;
    public function __construct() {
        $this->precioOro = "";
        $this->moneda = "";
        $this->fecha = "";
    }

    public function cargarDatos($moneda,$date)
    {
        $url = 'https://api.metalpriceapi.com/v1/' . $date . '?api_key=5e495fd8e4ee1dca7df6b8ce3972565e&base=' . $moneda;

        $this->moneda = $moneda;
        $this->fecha = $date;
     
        $datos = file_get_contents($url);
               
        $exchangeRates = json_decode($datos);

        $this->precioOro=$exchangeRates->rates->XAU;
    }

    public function crearComboBoxMonedas(){
        $monedas = array('AED' => 'AED - U.A.E Dirham',
                         'AUD' => 'AUD - Dólar australiano',
                         'BTC' => 'BTC - Bitcoin',
                         'CHF' => 'CHF - Franco Sueco',
                         'EUR' => 'EUR - Euro',
                         'GBP' => 'GBP - Libra Británica',
                         'JPY' => 'JPY - Yen Japonés',
                         'USD' => 'USD - Dolar USA'
                        );

        $combo = "<select title='Despliega todas las monedas' id='seleccionaMoneda' name='monedas'>";

        foreach($monedas as $v => $moneda) {
            $combo .=  "<option value='". $v ."'>" . $moneda . "</option>";
        }

        $combo .= "</select>";

        return $combo;
    }

    public function muestraValorOro() {
        $text = "<section><h2>Fecha seleccionada: $this->fecha</h2>";
        $text .= "<p>Precio del oro en " . $this->moneda .": " .  $this->precioOro . "</p>";
        $text .= "</section>";

        return $text;
    }

    public function getDate(){
        return "20". date('y-m-d',(strtotime ( '-1 day' , strtotime ( date('y-m-d')) ) ));
    }

}

if( isset( $_SESSION['precio'] ) ) {
    $precio = $_SESSION['precio'];
}else {
    $precio = new PrecioOro();
    $_SESSION['precio'] = $precio;
}

$valorOro = "";

if (count($_POST)>0) 
{    
    $moneda = $_POST['monedas'];

    $date = $_POST['seleccionaFecha'];

    if (isset($_POST['precioOro'])) $precio->cargarDatos($moneda, $date);

    $valorOro = $precio->muestraValorOro();
}

echo "

<!DOCTYPE HTML>

<html lang='es'>
<head>
    <!-- Datos que describen el documento -->
    <meta charset='UTF-8' />
    <title>Precio del Oro</title>
    
    <!--Metadatos de los documentos HTML5-->
    <meta name ='author' content ='Miguel González Navarro' />
    <meta name ='description' content ='Ejercicio 4 PHP' />
    <meta name ='keywords' content ='PHP, Precio del oro' />

    <!--Definición de la ventana gráfica-->
    <meta name ='viewport' content ='width=device-width, initial-scale=1.0' />
    <link rel='stylesheet' type='text/css' href='Ejercicio4.css' />
</head>

<body>
    <h1>Precio del oro</h1>
    <form action='#' method='post'>
        <label title='Selecciona la fecha' for='seleccionaFecha'>Indique la fecha:</label>
        <input type='date' title='Selecciona la fecha' id='seleccionaFecha' name='seleccionaFecha' step='1' min='2019-01-01' max='"; 
                
        echo $_SESSION['precio']->getDate();
        echo "' value = '";
        echo $_SESSION['precio']->getDate();
        echo"'/>";

        echo "<label title='Selecciona la moneda' for='seleccionaMoneda'>Indique la moneda:</label>";
        echo $_SESSION['precio']->crearComboBoxMonedas();
        echo "<input type='submit' title='Pulsa para obtener el precio' name='precioOro' value='Obtener precio'>
    </form>
    $valorOro
    <footer>
        <p>REALIZADO POR MIGUEL GONZÁLEZ NAVARRO</p>
        <p>SERVICIO DE ORO</p>
    </footer>

</body>
</html>";

?>