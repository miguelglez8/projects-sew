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
    <h1>Fútbol BeSoccer: Pantalla principal</h1>

    <form action='#' method='post'>
        <label for=equipos>Ver lista de equipos</label>
        <input type='submit' id='equipos' name='equipos' value='Ver equipos'>

        <label for=crearPartidos>Crear partido</label>
        <input type='submit' id='crearPartidos' name='crearPartidos' value='Crear partido'>

        <label for=crearGoles>Marca gol en un partido</label>
        <input type='submit' id='crearGoles' name='crearGoles' value='Marca gol en un partido'>

        <label for=partidos>Ver lista de partidos</label>
        <input type='submit' id='partidos' name='partidos' value='Ver partidos'>

        <label for=golesJugador>Ver lista de goles de un jugador</label>
        <input type='submit' id='golesJugador' name='golesJugador' value='Ver goles de un jugador'>

        <label for=golesPartido>Ver lista de goles de un partido</label>
        <input type='submit' id='golesPartido' name='golesPartido' value='Ver goles de un partido'>
    </form>

</body>
</html>";

class Futbol{

    private $db;

    public function verEquipos(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        echo "<section><h2>Datos de los equipos</h2>";

        $res = $this->db->prepare("SELECT * FROM Equipo");
        $res->execute();
        $resultado = $res->get_result();

        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                $str = str_replace(" ","",$fila['nombre']);
                echo "<h3>Nombre del equipo: " . $fila['nombre'] . "</h3>
                <p>Presupuesto: " . $fila['presupuesto'] . "</p>
                <picture>
                <img alt= 'Imagen del equipo' src='multimedia/" . $str . ".jpg'>
                </picture>
                </section>";
                echo "<form action='#' method='post'>
                    <label for=jugadores" . $str . ">Ver lista de jugadores</label>
                    <input type='submit' id='jugadores" . $str . "' value='Ver jugadores " . $fila['nombre'] . "' name='jugadores" . $str . "' value='Ver jugadores " . $fila['nombre'] . "'>
            
                    <label for=estadio" . $str . ">Detalles del estadio</label>
                    <input type='submit' id='estadio" . $str . "' value='Ver estadio " . $fila['nombre'] . "' name='estadio" . $str . "' value='Ver estadio " . $fila['nombre'] . "'>
                </form>";
            }
        }

        $this->db->close();     
    }

    public function verJugadores($equipo){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        
        $consultaPre = $this->db->prepare("SELECT nombre_jugador, dorsal FROM Jugador WHERE equipo_nombree = ?");   
        
        $consultaPre->bind_param('s', $equipo);    

        //ejecuta la consulta
        $consultaPre->execute();

        //Obtiene los resultados como un objeto de la clase mysqli_result
        $resultado = $consultaPre->get_result();

        echo "<section>
                    <h2>Jugadores de " . $equipo . "</h2>";
        //Visualización de los resultados de la búsqueda
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                echo "<p>Nombre del jugador: " . $fila['nombre_jugador'] . "</p>
                    <p>Dorsal: " . $fila['dorsal'] . "</p>";
            }               
        } 
        echo "</section>";
       
        // cierre de la consulta y la base de datos
        $consultaPre->close();

        $this->db->close();
    }

    public function verEstadio($equipo){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        
        $consultaPre = $this->db->prepare("SELECT nombre_estadio, capacidad FROM Estadio WHERE equipo_nombre = ?");   
        
        $consultaPre->bind_param('s', $equipo);    
        //ejecuta la consulta
        $consultaPre->execute();

        //Obtiene los resultados como un objeto de la clase mysqli_result
        $resultado = $consultaPre->get_result();

        echo "<section>
             <h2>Estadio del " . $equipo . "</h2>";
        //Visualización de los resultados de la búsqueda
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                echo "<p>Nombre del estadio: " . $fila['nombre_estadio'] . "</p>
                    <p>Capacidad: " . $fila['capacidad'] . "</p>
                    <picture>
                        <img alt= 'Imagen del estadio' src='multimedia/" . str_replace(" ","",$fila['nombre_estadio']) . ".jpg'>
                    </picture>";
            }               
        } 
        echo "</section>";
       
        // cierre de la consulta y la base de datos
        $consultaPre->close();

        $this->db->close();
        
    }

    public function verPartidos(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        
        $consultaPre = $this->db->prepare("SELECT * FROM Partido");   
        
        //ejecuta la consulta
        $consultaPre->execute();

        //Obtiene los resultados como un objeto de la clase mysqli_result
        $resultado = $consultaPre->get_result();

        echo "<section>
             <h2>Partidos realizados</h2>";
        //Visualización de los resultados de la búsqueda
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                echo "<h3>Partido: " . $fila['local_equipo'] . " vs " . $fila['visitante_equipo'] . "</h3>" .
                    "<p>Fecha: " . $fila['fecha'] . "</p>
                    <p>Nombre del estadio: " . $fila['estadio_nombre'] . "</p>
                    <picture>
                        <img alt= 'Imagen del estadio' src='multimedia/" . str_replace(" ","",$fila['estadio_nombre'])  . ".jpg'>
                    </picture>
                    <p>Equipo local: " . $fila['local_equipo'] . "</p>
                    <picture>
                        <img alt= 'Imagen del equipo local' src='multimedia/" . str_replace(" ","",$fila['local_equipo']) . ".jpg'>
                    </picture>
                    <p>Equipo visitante: " . $fila['visitante_equipo'] . "</p>
                    <picture>
                        <img alt= 'Imagen del equipo visitante' src='multimedia/" . str_replace(" ","",$fila['visitante_equipo']) . ".jpg'>
                    </picture>";
            }               
        } 
        echo "</section>";
       
        // cierre de la consulta y la base de datos
        $consultaPre->close();

        $this->db->close();
    }

    public function buscaGolesJugador(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        $res = $this->db->prepare("SELECT nombre_jugador FROM Jugador");
        $res->execute();
        $resultado = $res->get_result();
        $equipos = array();
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                array_push($equipos, $fila["nombre_jugador"]);
            }
        }
        $this->db->close(); 

        $comboLocal = "<select title='Selecciona el jugador' id='jugadorBuscarGol' name='jugadorBuscarGol'>";

        foreach($equipos as $v) {
            $comboLocal .=  "<option value='". $v ."'>" . $v . "</option>";
        }

        $comboLocal .= "</select>";

        echo "<h2>Busca goles por jugador</h2>";
        echo "<form action='#' method='post'>

            <label for='jugadorBuscarGol'>Selecciona el nombre del jugador</label>
            $comboLocal

            <input type='submit' name='buscarGolJugador' value='Buscar goles'>
        </form>
        ";
    }
    public function buscarGolesJugador($jugador){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

        $res = $this->db->prepare("SELECT * FROM Gol WHERE jugador_nombre = ?");
        $res->bind_param('s', $jugador);

        $res->execute();

        //Obtiene los resultados como un objeto de la clase mysqli_result
        $resultado = $res->get_result();

         echo "<section>
             <h2>Goles de $jugador</h2>";
        //Visualización de los resultados de la búsqueda
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                echo "<section>
                <h3>Id del gol: " . $fila['id_gol'] . "</h3>
                <p>Minuto: " . $fila['minuto'] . "</p>";
            }               
        } 
        echo "</section>";
       
        // cierre de la consulta y la base de datos
        $res->close();

        $this->db->close();    
    }

    public function buscaGolesPartido(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        $res = $this->db->prepare("SELECT id_partido FROM Partido");
        $res->execute();
        $resultado = $res->get_result();
        $equipos = array();
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                array_push($equipos, $fila["id_partido"]);
            }
        }
        $this->db->close(); 

        $comboLocal = "<select title='Selecciona el partido' id='partidoBuscarGol' name='partidoBuscarGol'>";

        foreach($equipos as $v) {
            $comboLocal .=  "<option value='". $v ."'>" . $v . "</option>";
        }

        $comboLocal .= "</select>";

        echo "<h2>Busca goles por partido</h2>";
        echo "<form action='#' method='post'>

            <label for='partidoBuscarGol'>Selecciona el id del partido</label>
            $comboLocal

            <input type='submit' name='buscarGolPartido' value='Buscar goles'>
        </form>
        ";
    }

    public function buscarGolesPartido($partido){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");

        $res = $this->db->prepare("SELECT * FROM Gol WHERE partido_id = ?");
        $res->bind_param('s', $partido);

        $res->execute();

        //Obtiene los resultados como un objeto de la clase mysqli_result
        $resultado = $res->get_result();

         echo "<section>
             <h2>Goles del partido en $partido</h2>";
        //Visualización de los resultados de la búsqueda
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                echo "<section>
                <h3>Id del gol: " . $fila['id_gol'] . "</h3>
                <p>Minuto: " . $fila['minuto'] . "</p>";
            }               
        } 
        echo "</section>";
       
        // cierre de la consulta y la base de datos
        $res->close();

        $this->db->close();  
    }

    public function creaPartidos(){
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        $res = $this->db->prepare("SELECT * FROM Equipo");
        $res->execute();
        $resultado = $res->get_result();
        $equipos = array();
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                array_push($equipos, $fila["nombre"]);
            }
        }
        $this->db->close(); 

        $comboLocal = "<select title='Selecciona el equipo local' id='equipoLocal' name='equipoLocal'>";

        foreach($equipos as $v) {
            $comboLocal .=  "<option value='". $v ."'>" . $v . "</option>";
        }

        $comboLocal .= "</select>";

        $comboVisitante = "<select title='Selecciona el equipo visitante' id='equipoVisitante' name='equipoVisitante'>";

        foreach($equipos as $v) {
            $comboVisitante .=  "<option value='". $v ."'>" . $v . "</option>";
        }

        $comboVisitante .= "</select>";

        echo "<h2>Crea partidos</h2>";
        echo "<form action='#' method='post'>

            <label for='equipoLocal'>Introduce el nombre del equipo local</label>
            $comboLocal

            <label for='equipoVisitante'>Introduce el nombre del equipo visitante</label>
            $comboVisitante

            <label title='Selecciona la fecha' for='seleccionaFecha'>Indique la fecha:</label>
            <input type='date' title='Selecciona la fecha' id='seleccionaFecha' name='seleccionaFecha' step='1' min='2019-01-01' value = '2022-12-11'/>

            <input type='submit' name='creaPartido' value='Crear partido'>
        </form>
        ";
    }

    public function creaPartido() {
        if ($_POST['equipoLocal'] == $_POST['equipoVisitante']) {
            echo "<h2>ERROR: No puedes añadir el mismo equipo en ambos lados</h2>";
            return;
        } else {
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        
            $res = $this->db->prepare("SELECT nombre_estadio FROM Estadio WHERE equipo_nombre=?");
            $res->bind_param('s', $_POST['equipoLocal']);
            $res->execute();
            $res->bind_result($campo);
            $res->fetch();   

            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
            $id = $campo . '-(' . $_POST['seleccionaFecha'] . ')';
        
            $resPre = $this->db->prepare("INSERT INTO Partido VALUES(?,?,?,?,?)");
            $resPre->bind_param('sssss', $id, $_POST['seleccionaFecha'],
                $campo, $_POST['equipoLocal'], $_POST['equipoVisitante']);
            $resPre->execute();

            echo "<p>Partido añadido correctamente ($id)</p>";

            $this->db->close();
        }
    }

    public function creaGoles() {
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        $res = $this->db->prepare("SELECT * FROM Partido");
        $res->execute();
        $resultado = $res->get_result();
        $partido = array();
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                array_push($partido, $fila["id_partido"]);
            }
        }
        $this->db->close(); 

        $comboLocal = "<select title='Selecciona el partido' id='partidoGoles' name='partidoGoles'>";

        foreach($partido as $v) {
            $comboLocal .=  "<option value='". $v ."'>" . $v . "</option>";
        }

        $comboLocal .= "</select>";

        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        $res = $this->db->prepare("SELECT * FROM Jugador");
        $res->execute();
        $resultado = $res->get_result();
        $jugador = array();
        if ($resultado->fetch_assoc()!=NULL) {
            $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda
            while($fila = $resultado->fetch_assoc()) {
                array_push($jugador, $fila["nombre_jugador"]);
            }
        }
        $this->db->close(); 

        $combo = "<select title='Selecciona el jugador' id='jugadorGoles' name='jugadorGoles'>";

        foreach($jugador as $v) {
            $combo .=  "<option value='". $v ."'>" . $v . "</option>";
        }

        $combo .= "</select>";

        $comboM = "<select title='Selecciona el minuto' id='minutos' name='minutos'>";

        for ($i = 1; $i <= 90; $i++) {
            $comboM .=  "<option value='". $i ."'>" . $i . "</option>";
        }

        $comboM .= "</select>";

        echo "<h2>Marca goles</h2>";
        echo "<form action='#' method='post'>

            <label for='partidoGoles'>Introduce el id del partido (estadio-fecha)</label>
            $comboLocal

            <label for='jugadorGoles'>Introduce el nombre del jugador que marca</label>
            $combo

            <label for='minutos'>Introduce el minuto del gol</label>
            $comboM
            
            <input type='submit' name='creaGol' value='Marcar gol'>
        </form>
        ";
    }

    public function creaGol() {
        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        
        $res = $this->db->prepare("SELECT local_equipo, visitante_equipo FROM Partido WHERE id_partido=?");
        $partido = $_POST['partidoGoles'];
        $res->bind_param('s', $partido);
        $res->execute();
        $res->bind_result($local, $visitante);
        $res->fetch();

        $this->db->close();

        $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
        
        $res = $this->db->prepare("SELECT equipo_nombree FROM Jugador WHERE nombre_jugador=?");
        $jugador = $_POST['jugadorGoles'];
        $res->bind_param('s', $jugador);
        $res->execute();
        $res->bind_result($equipo);
        $res->fetch();

        $this->db->close();

        if ($equipo != $local && $equipo != $visitante) {
            echo "<h2>ERROR: No puede marcar un gol un jugador que no está en el terreno de juego</h2>";
            return;
        } else {
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "futbol");
            $jugador = $_POST['jugadorGoles'];
            $minuto = $_POST['minutos'];
            $partidoId = $_POST['partidoGoles'];
            $id = $jugador . '-' . $partidoId . '-' . $minuto;
            $resPre = $this->db->prepare("INSERT INTO Gol VALUES(?,?,?,?)");
            $resPre->bind_param('ssss', $id, $jugador,
                $partidoId, $minuto);
            $resPre->execute();

            echo "<p>Gol añadido correctamente de $jugador en el minuto $minuto</p>";

            $this->db->close();
        }
    }
}


if( isset( $_SESSION['besoccer'] ) ) {
    $_SESSION['besoccer'] = new Futbol();
}else {
    $_SESSION['besoccer'] = new Futbol();
}

if (count($_POST)>0) 
    {   
        if(isset($_POST['equipos'])) $_SESSION['besoccer']->verEquipos();

        if(isset($_POST['crearPartidos'])) $_SESSION['besoccer']->creaPartidos();
        if(isset($_POST['creaPartido'])) $_SESSION['besoccer']->creaPartido();

        if(isset($_POST['crearGoles'])) $_SESSION['besoccer']->creaGoles();
        if(isset($_POST['creaGol'])) $_SESSION['besoccer']->creaGol();

        if(isset($_POST['partidos'])) $_SESSION['besoccer']->verPartidos();

        if(isset($_POST['golesJugador'])) $_SESSION['besoccer']->buscaGolesJugador();
        if(isset($_POST['buscarGolJugador'])) $_SESSION['besoccer']->buscarGolesJugador($_POST['jugadorBuscarGol']);

        if(isset($_POST['golesPartido'])) $_SESSION['besoccer']->buscaGolesPartido();
        if(isset($_POST['buscarGolPartido'])) $_SESSION['besoccer']->buscarGolesPartido($_POST['partidoBuscarGol']);

        if(isset($_POST['jugadoresRealMadrid'])) $_SESSION['besoccer']->verJugadores("Real Madrid");
        if(isset($_POST['jugadoresAlaves'])) $_SESSION['besoccer']->verJugadores("Alaves");
        if(isset($_POST['jugadoresAtleticodeMadrid'])) $_SESSION['besoccer']->verJugadores("Atletico de Madrid");
        if(isset($_POST['jugadoresFCBarcelona'])) $_SESSION['besoccer']->verJugadores("FC Barcelona");
        if(isset($_POST['jugadoresRealSociedad'])) $_SESSION['besoccer']->verJugadores("Real Sociedad");
        if(isset($_POST['jugadoresRealSporting'])) $_SESSION['besoccer']->verJugadores("Real Sporting");
        if(isset($_POST['jugadoresSevilla'])) $_SESSION['besoccer']->verJugadores("Sevilla");
        if(isset($_POST['jugadoresValencia'])) $_SESSION['besoccer']->verJugadores("Valencia");
        
        if(isset($_POST['estadioRealMadrid'])) $_SESSION['besoccer']->verEstadio("Real Madrid");
        if(isset($_POST['estadioAlaves'])) $_SESSION['besoccer']->verEstadio("Alaves");
        if(isset($_POST['estadioAtleticodeMadrid'])) $_SESSION['besoccer']->verEstadio("Atletico de Madrid");
        if(isset($_POST['estadioFCBarcelona'])) $_SESSION['besoccer']->verEstadio("FC Barcelona");
        if(isset($_POST['estadioRealSociedad'])) $_SESSION['besoccer']->verEstadio("Real Sociedad");
        if(isset($_POST['estadioRealSporting'])) $_SESSION['besoccer']->verEstadio("Real Sporting");
        if(isset($_POST['estadioSevilla'])) $_SESSION['besoccer']->verEstadio("Sevilla");
        if(isset($_POST['estadioValencia'])) $_SESSION['besoccer']->verEstadio("Valencia");
    }


?>
