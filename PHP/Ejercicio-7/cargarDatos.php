<?php
session_start();

echo "<!DOCTYPE HTML>

<html lang='es'>

<html lang='es'>
<head>
    <!-- Datos que describen el documento -->
    <meta charset='UTF-8' />
    <title>Ejercicio 7: Base de Datos</title>
    
    <!--Metadatos de los documentos HTML5-->
    <meta name ='author' content ='Miguel González Navarro' />
    <meta name ='description' content ='Ejercicio 7 PHP' />
    <meta name ='keywords' content ='PHP, MySQL' />

    <!--Definición de la ventana gráfica-->
    <meta name ='viewport' content ='width=device-width, initial-scale=1.0' />
    <link rel='stylesheet' type='text/css' href='Ejercicio7.css' />
</head>

<body>
    <h1>Fútbol BeSoccer: Creación e inserción de datos</h1>

    <form action='#' method='post'>
        <input type='submit' name='cargar' value='Cargar datos para la aplicación'>
    </form>

</body>
</html>";

class BaseDatos {

    private $db;

    public function cargar() {
        $this->crearBaseDatos();
        $this->crearTablas();
        $this->cargarDatos();
    }

    public function crearBaseDatos(){
        $servername = "localhost";
        $username = "DBUSER2022";
        $password = "DBPSWD2022";
      
        // Conexión al SGBD local con XAMPP con el usuario creado 
        $this->db = new mysqli($servername,$username,$password);
        
        //comprobamos conexión
        if($this->db->connect_error) {
            exit ("<p>ERROR de conexión:".$this->db->connect_error."</p>");  
        } else {echo "<p>Conexión establecida con " . $this->db->host_info . "</p>";}
       
        $cadenaSQL = "CREATE DATABASE IF NOT EXISTS futbol COLLATE utf8_spanish_ci";
        if($this->db->query($cadenaSQL) === TRUE){
            echo "<p>Base de datos 'futbol' creada con éxito</p>";
        } else { 
            echo "<p>ERROR en la creación de la Base de Datos 'futbol'. Error: " . $this->db->error . "</p>";
            exit();
        }   
        //cerrar la conexión
        $this->db->close();   
    }

    public function crearTablas(){
        $this->crearTablaEquipo();
        $this->crearTablaEstadio();
        $this->crearTablaJugador();
        $this->crearTablaPartido();
        $this->crearTablaGol();
    }

    public function crearTablaEquipo()
    {
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

        if ($this->db->connect_error) {
            exit("<p>ERROR de conexión:" . $this->db->connect_error . "</p>");
        } else {
            echo "<p>Conexión establecida con " . $this->db->host_info . "</p>";
        }

        $tabla = 'CREATE TABLE Equipo(
                nombre varchar(100) not null,
                presupuesto int,
                primary key(nombre),
                CHECK (presupuesto>0)
            )';
        if ($this->db->query($tabla) === TRUE) {
            echo "<p>Tabla 'Equipo' creada con éxito </p>";
        } else {
            echo "<p>ERROR en la creación de la tabla Equipo. Error : " . $this->db->error . "</p>";
            exit();
        }
        //cerrar la conexión
        $this->db->close();
    }
    public function crearTablaEstadio(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

        if ($this->db->connect_error) {
            exit("<p>ERROR de conexión:" . $this->db->connect_error . "</p>");
        } else {
            echo "<p>Conexión establecida con " . $this->db->host_info . "</p>";
        }

        $tabla = 'CREATE TABLE Estadio(
                nombre_estadio varchar(100) not null,
                capacidad int,
                equipo_nombre varchar(100) not null,
                primary key(nombre_estadio),
                foreign key(equipo_nombre) references Equipo(nombre),
                CHECK (capacidad>0)
            )';
        if ($this->db->query($tabla) === TRUE) {
            echo "<p>Tabla 'Estadio' creada con éxito </p>";
        } else {
            echo "<p>ERROR en la creación de la tabla Estadio. Error : " . $this->db->error . "</p>";
            exit();
        }
        //cerrar la conexión
        $this->db->close();
    }

    public function crearTablaJugador(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

        if ($this->db->connect_error) {
            exit("<p>ERROR de conexión:" . $this->db->connect_error . "</p>");
        } else {
            echo "<p>Conexión establecida con " . $this->db->host_info . "</p>";
        }

        $tabla = 'CREATE TABLE Jugador(
                nombre_jugador varchar(100) not null,
                dorsal int,
                equipo_nombree varchar(100) not null,
                primary key(nombre_jugador),
                foreign key(equipo_nombree) references Equipo(nombre),
                CHECK (dorsal>0)
            )';
        if ($this->db->query($tabla) === TRUE) {
            echo "<p>Tabla 'Jugador' creada con éxito </p>";
        } else {
            echo "<p>ERROR en la creación de la tabla Jugador. Error : " . $this->db->error . "</p>";
            exit();
        }
        //cerrar la conexión
        $this->db->close();
    }

    public function crearTablaPartido(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

        if ($this->db->connect_error) {
            exit("<p>ERROR de conexión:" . $this->db->connect_error . "</p>");
        } else {
            echo "<p>Conexión establecida con " . $this->db->host_info . "</p>";
        }

        $tabla = 'CREATE TABLE Partido(
                id_partido varchar(100) not null,
                fecha date,
                estadio_nombre varchar(100) not null,
                local_equipo varchar(100) not null,
                visitante_equipo varchar(100) not null,
                primary key(id_partido),
                foreign key(estadio_nombre) references Estadio(nombre_estadio),
                foreign key(local_equipo) references Equipo(nombre),
                foreign key(visitante_equipo) references Equipo(nombre)
            )';
        if ($this->db->query($tabla) === TRUE) {
            echo "<p>Tabla 'Partido' creada con éxito </p>";
        } else {
            echo "<p>ERROR en la creación de la tabla Partido. Error : " . $this->db->error . "</p>";
            exit();
        }
        //cerrar la conexión
        $this->db->close();
    }

    public function crearTablaGol(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

        if ($this->db->connect_error) {
            exit("<p>ERROR de conexión:" . $this->db->connect_error . "</p>");
        } else {
            echo "<p>Conexión establecida con " . $this->db->host_info . "</p>";
        }

        $tabla = 'CREATE TABLE Gol(
                id_gol varchar(100) not null,
                jugador_nombre varchar(100) not null,
                partido_id varchar(100) not null,
                minuto int,
                primary key(id_gol),
                foreign key(jugador_nombre) references Jugador(nombre_jugador),
                foreign key(partido_id) references Partido(id_partido),
                CHECK (minuto>0 && minuto<=90)
            )';
        if ($this->db->query($tabla) === TRUE) {
            echo "<p>Tabla 'Gol' creada con éxito </p>";
        } else {
            echo "<p>ERROR en la creación de la tabla Gol. Error : " . $this->db->error . "</p>";
            exit();
        }
        //cerrar la conexión
        $this->db->close();
    }

    public function cargarDatos() {
        $this->CargarDatosEquipo("datos_equipos.csv");
        $this->CargarDatosEstadio("datos_estadios.csv");
        $this->CargarDatosJugador("datos_jugadores.csv");
    }

    public function CargarDatosEquipo($fichero) {
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
    
        if($this->db->connect_error) {
            exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
        } else {echo "<h2>Conexión establecida</h2>";}
        
        $file = fopen($fichero, "r");
        while (($datos = fgetcsv($file, 10000, ";")) !== FALSE)
        {
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

            $resPre = $this->db->prepare("INSERT INTO Equipo VALUES(?,?)");
            $resPre->bind_param('ss', $datos[0],$datos[1]);
            $resPre->execute();
        }
        fclose($file);
        echo "<p>Datos cargados correctamente del fichero $fichero</p>";
        $this->db->close();
    }

    public function CargarDatosEstadio($fichero) {
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
    
        if($this->db->connect_error) {
            exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
        } else {echo "<h2>Conexión establecida</h2>";}
        
        $file = fopen($fichero, "r");
        while (($datos = fgetcsv($file, 10000, ";")) !== FALSE)
        {
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

            $resPre = $this->db->prepare("INSERT INTO Estadio VALUES(?,?,?)");
            $resPre->bind_param('sss', $datos[0],$datos[1],$datos[2]);
            $resPre->execute();
        }
        fclose($file);
        echo "<p>Datos cargados correctamente del fichero $fichero</p>";
        $this->db->close();
    }

    public function CargarDatosJugador($fichero) {
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
    
        if($this->db->connect_error) {
            exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
        } else {echo "<h2>Conexión establecida</h2>";}
        
        $file = fopen($fichero, "r");
        while (($datos = fgetcsv($file, 10000, ";")) !== FALSE)
        {
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

            $resPre = $this->db->prepare("INSERT INTO Jugador VALUES(?,?,?)");
            $resPre->bind_param('sss', $datos[0],$datos[1],$datos[2]);
            $resPre->execute();
        }
        fclose($file);
        echo "<p>Datos cargados correctamente del fichero $fichero</p>";
        $this->db->close();
    }   
}

if( isset( $_SESSION['futbol'] ) ) {
    $_SESSION['futbol'] = new BaseDatos();
}else {
    $_SESSION['futbol'] = new BaseDatos();
}

if (count($_POST)>0) 
    {   
        if(isset($_POST['cargar'])) $_SESSION['futbol']->cargar();
    }

?>
