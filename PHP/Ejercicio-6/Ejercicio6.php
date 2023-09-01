<?php
session_start();

echo "<!DOCTYPE HTML>

<html lang='es'>

<html lang='es'>
<head>
    <!-- Datos que describen el documento -->
    <meta charset='UTF-8' />
    <title>Ejercicio 6: Base de Datos</title>
    
    <!--Metadatos de los documentos HTML5-->
    <meta name ='author' content ='Miguel González Navarro' />
    <meta name ='description' content ='Ejercicio 6 PHP' />
    <meta name ='keywords' content ='PHP, MySQL' />

    <!--Definición de la ventana gráfica-->
    <meta name ='viewport' content ='width=device-width, initial-scale=1.0' />
    <link rel='stylesheet' type='text/css' href='Ejercicio6.css' />
</head>

<body>
    <h1>Ejercicio 6: MySQL</h1>

    <form action='#' method='post'>
        <input type='submit' name='CrearBaseDatos' value='Crear Base de Datos'>
        <input type='submit' name='CrearTabla' value='Crear una tabla'>
        <input type='submit' name='Insertar' value='Insertar datos en una tabla'>
        <input type='submit' name='Buscar' value='Buscar datos en una tabla'>
        <input type='submit' name='Modificar' value='Modificar datos en una tabla'>
        <input type='submit' name='Eliminar' value='Eliminar datos de una tabla'>
        <input type='submit' name='GenerarInforme' value='Generar informe'>
        <label for='archivo'>selecciona un archivo</label>
        <input type='file' id='archivo' name='archivo'>
        <input type='submit'name='CargarCSV' value='Cargar datos desde un archivo CSV'>
        <input type='submit' name='ExportarCSV' value='Exportar datos a un archivo CSV'>
    </form>

</body>
</html>";

    class BaseDatos {

        private $db;

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
           
            $cadenaSQL = "CREATE DATABASE IF NOT EXISTS prueba COLLATE utf8_spanish_ci";
            if($this->db->query($cadenaSQL) === TRUE){
                echo "<p>Base de datos 'prueba' creada con éxito</p>";
            } else { 
                echo "<p>ERROR en la creación de la Base de Datos 'prueba'. Error: " . $this->db->error . "</p>";
                exit();
            }   
            //cerrar la conexión
            $this->db->close();   
        }

        public function crearTabla(){
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            if($this->db->connect_error) {
                exit ("<p>ERROR de conexión:".$this->db->connect_error."</p>");  
            } else {echo "<p>Conexión establecida con " . $this->db->host_info . "</p>";}
            
            $tabla = 'CREATE TABLE PruebasUsabilidad(
                dni varchar(100) not null,
                nombre varchar(100) not null,
                apellidos varchar(100) not null,
                correo varchar(100) not null,
                telefono int,
                edad int,
                sexo varchar(100) not null,
                nivel int,
                tiempoTarea int,
                tareaRealizadaCorrectamente varchar(100) not null,
                comentarios varchar(100) not null,
                propuestas varchar(100) not null,
                valoracion int,
                primary key(dni),
                CHECK (nivel>=0),
                CHECK (nivel<=10),
                CHECK (valoracion>=0),
                CHECK (valoracion<=10),
                CHECK (telefono > 0),
                CHECK (edad > 0),
                CHECK (tiempoTarea >= 0),
                CHECK (length(dni) = 9),
                CHECK (length(telefono) = 9),
                CHECK (sexo = "Masculino" || sexo = "Femenino"),
                CHECK (tareaRealizadaCorrectamente = "Correcto" || tareaRealizadaCorrectamente = "Incorrecto")
            )';
            if($this->db->query($tabla) === TRUE){
                echo "<p>Tabla 'PruebasUsabilidad' creada con éxito </p>";
            } else { 
                echo "<p>ERROR en la creación de la tabla PruebasUsabilidad. Error : ". $this->db->error . "</p>";
                exit();
            }   
            //cerrar la conexión
            $this->db->close();
        }

        public function insertarDatos($dni, $nombre, $apellidos, $correo, $telefono, $edad, $sexo, $nivelInformatico,
            $tiempoRealizacionTarea, $tareaRealizadaCorrectamente, $comentarios, $propuestas, $valoracion) {
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");
            
            if($this->db->connect_error) {
                exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
            } else {echo "<h2>Conexión establecida</h2>";}

            $resPre = $this->db->prepare("INSERT INTO PruebasUsabilidad VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $resPre->bind_param('sssssssssssss', $dni, $nombre, $apellidos, $correo, $telefono, $edad, $sexo,
                $nivelInformatico, $tiempoRealizacionTarea, $tareaRealizadaCorrectamente, $comentarios, $propuestas,$valoracion);

            $resPre->execute();
            echo "<p>Datos agregados correctamente</p>";

            $resPre->close();

            //cierra la base de datos
            $this->db->close(); 
        }

        public function insertaDatos(){
            echo "<h2>Datos a insertar</h2>";
            echo "<form action='#' method='post'>
    
                <label for='dni'>DNI</label>
                <input type='text' id='dni' name='dni'>
    
                <label for='nombre'>Nombre</label>
                <input type='text' id='nombre' name='nombre'>
    
                <label for='apellidos'>Apellidos</label>
                <input type='text' id='apellidos' name='apellidos'>
    
                <label for='correo'>Correo</label>
                <input type='text' id='correo' name='correo'>
    
                <label for='telefono'>Telefono</label>
                <input type='text' id='telefono' name='telefono'>
    
                <label for='edad'>Edad</label>
                <input type='text' id='edad' name='edad'>
    
                <fieldset>
                    <legend>Introduzca su sexo</legend>
                    <!-- los elementos agrupados-->
                        <p><label for='input-hombre'><input type='radio' value='Masculino' name='sexo' id='input-hombre'>Masculino</label></p>
                        <p><label for='input-mujer'><input type='radio' value='Femenino' name='sexo' id='input-mujer'>Femenino</label></p>
                </fieldset>

                <label for='nivelInformatico'>Nivel informatico</label>
                <input type='text' id='nivelInformatico' name='nivelInformatico'>
    
                <label for='tiempoDeTarea'>Tiempo de la tarea</label>
                <input type='text' id='tiempoDeTarea' name='tiempoDeTarea'>
    
                <fieldset>
                    <legend>Introduzca si la tarea esta bien realizada</legend>
                    <!-- los elementos agrupados-->
                        <p><label for='input-c'><input type='radio' value='Correcto' name='tareaRealizadaCorrectamente' id='input-c'>Correcto</label></p>
                        <p><label for='input-i'><input type='radio' value='Incorrecto' name='tareaRealizadaCorrectamente' id='input-i'>Incorrecto</label></p>
                </fieldset>
    
                <label for='comentarios'>Comentarios</label>
                <input type='text' id='comentarios' name='comentarios'>
    
                <label for='propuestas'>Propuestas</label>
                <input type='text' id='propuestas' name='propuestas'>
    
                <label for='valoracion'>Valoracion</label>
                <input type='text' id='valoracion' name='valoracion'>
    
                <input type='submit' name='insertar' value='Insertar datos'>
            </form>";
        }

        public function buscarDatos($dni){
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");
            if($this->db->connect_error) {
                exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
            } else {echo "<h2>Conexión establecida</h2>";}

            $res = $this->db->prepare("SELECT * FROM PruebasUsabilidad WHERE dni = ?");
            $res->bind_param('s', $dni);
    
            $res->execute();
    
            $res->bind_result($dni, $nombre, $apellidos, $correo, $telefono, $edad, $sexo, $nivInformatico, $tiempo, $tareaCorrectamente,
                $comentarios, $propuestas, $valoracion);
            $res->fetch();
            echo "<section>
                    <h2>Datos</h2>    
                    <p>Dni: $dni</p>
                    <p>Nombre: $nombre</p>
                    <p>Apellidos: $apellidos</p>
                    <p>Correo: $correo</p>
                    <p>Teléfono: $telefono</p>
                    <p>Edad: $edad</p>
                    <p>Sexo: $sexo</p>
                    <p>Nivel: $nivInformatico</p>
                    <p>Tiempo para realizar la tarea: $tiempo</p>
                    <p>Tarea realizada correctamente: $tareaCorrectamente</p>
                    <p>Comentarios: $comentarios</p>
                    <p>Propuestas: $propuestas</p>
                    <p>Valoración: $valoracion</p>
            </section>";
            $this->db->close();
        }

        public function buscaDatos(){
            echo "<h2>Busca por dni</h2>";
            echo "<form action='#' method='post'>
    
                <label for='buscarDni'>Introduce el dni</label>
                <input type='text' id='buscarDni' name='buscarDni'>
    
                <input type='submit' name='buscar' value='Buscar datos'>
            </form>
            ";
        }

        public function eliminarDatos($dni){
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");
        
            if($this->db->connect_error) {
                exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
            } else {echo "<h2>Conexión establecida</h2>";}
            
            $res = $this->db->prepare("DELETE FROM PruebasUsabilidad WHERE dni = ?");
    
            $res->bind_param('s', $dni);
    
            $res->execute();

            echo "<p>Datos eliminados correctamente</p>";

            $this->db->close();
        }

        public function eliminaDatos(){
            echo "<h2>Elimina por dni</h2>";
            echo "
            <form action='#' method='post'>
    
                <label for='dniElimina'>Especifica el dni que quieres eliminar</label>
                <input type='text' id='dniElimina' name='dniElimina'>
    
                <input type='submit' name='eliminar' value='Eliminar por dni'>
    
            </form>
            ";
        }

        public function modificarDatos($dni, $nombre, $apellidos, $correo, $telefono, $edad, $sexo, $nivelInformatico,
            $tiempoRealizacionTarea, $tareaRealizadaCorrectamente, $comentarios, $propuestas, $valoracion) {
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");
        
            if($this->db->connect_error) {
                exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
            } else {echo "<h2>Conexión establecida</h2>";}
            
            $res = $this->db->prepare("UPDATE PruebasUsabilidad SET nombre = ?, apellidos = ?, correo = ?, telefono = ?, edad = ?,
                sexo = ?, nivel = ?, tiempoTarea = ?, tareaRealizadaCorrectamente = ?, comentarios = ?, propuestas = ?, valoracion = ? WHERE dni = ?");

            $res->bind_param('sssssssssssss', $nombre, $apellidos, $correo, $telefono, $edad, $sexo, $nivelInformatico,
                $tiempoRealizacionTarea, $tareaRealizadaCorrectamente, $comentarios, $propuestas, $valoracion, $dni);

            $res->execute();

            echo "<p>Datos actualizados correctamente</p>";

            $this->db->close();
        }
    
        public function modificaDatos(){
            echo "<h2>Datos a modificar</h2>";
            echo "<form action='#' method='post'>
    
                <label for='dniNuevo'>Introduce nuevo Dni</label>
                <input type='text' id='dniNuevo' name='dniNuevo'>
    
                <label for='nombreNuevo'>Introduce nuevo nombre</label>
                <input type='text' id='nombreNuevo' name='nombreNuevo'>
    
                <label for='apellidosNuevos'>Introduce nuevos apellidos</label>
                <input type='text' id='apellidosNuevos' name='apellidosNuevos'>
    
                <label for='correoNuevo'>Introduce nuevo correo</label>
                <input type='text' id='correoNuevo' name='correoNuevo'>
    
                <label for='telefonoNuevo'>Introduce nuevo teléfono</label>
                <input type='text' id='telefonoNuevo' name='telefonoNuevo'>
    
                <label for='edadNueva'>Introduce nueva edad</label>
                <input type='text' id='edadNueva' name='edadNueva'>
    
                <fieldset>
                    <legend>Introduce su nuevo sexo</legend>
                    <!-- los elementos agrupados-->
                        <p><label for='input-hombre'><input type='radio' value='Masculino' name='sexoNuevo' id='input-hombre'>Masculino</label></p>
                        <p><label for='input-mujer'><input type='radio' value='Femenino' name='sexoNuevo' id='input-mujer'>Femenino</label></p>
                </fieldset>
                
                <label for='nivelInformaticoNuevo'>Introduce nuevo nivel informatico</label>
                <input type='text' id='nivelInformaticoNuevo' name='nivelInformaticoNuevo'>
    
                <label for='tiempoTareaNuevo'>Introduce nuevo tiempo de realización</label>
                <input type='text' id='tiempoTareaNuevo' name='tiempoTareaNuevo'>

                <fieldset>
                    <legend>Introduce nuevo valor de si la tarea esta bien realizada</legend>
                    <!-- los elementos agrupados-->
                        <p><label for='input-c'><input type='radio' value='Correcto' name='tareaRealizadaCorrectamenteNuevo' id='input-c'>Correcto</label></p>
                        <p><label for='input-i'><input type='radio' value='Incorrecto' name='tareaRealizadaCorrectamenteNuevo' id='input-i'>Incorrecto</label></p>
                </fieldset>
        
                <label for='comentariosNuevos'>Introduce nuevos comentarios</label>
                <input type='text' id='comentariosNuevos' name='comentariosNuevos'>
    
                <label for='propuestasNuevas'>Introduce nuevas propuestas</label>
                <input type='text' id='propuestasNuevas' name='propuestasNuevas'>
    
                <label for='valoracionNueva'>Introduce nueva valoracion</label>
                <input type='text' id='valoracionNueva' name='valoracionNueva'>
    
                <input type='submit' name='modificar' value='Modifica datos'>
            </form>
            ";
        }

        public function GenerarInforme(){
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");
        
            if($this->db->connect_error) {
                exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
            } else {echo "<h2>Conexión establecida</h2>";}
            
            // Edad media de los usuarios
            $res = $this->db->prepare("SELECT avg(edad) FROM PruebasUsabilidad");
            $res->execute();
            $res->bind_result($edadMedia);
            $res->fetch();
            
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            $res = $this->db->prepare("SELECT count(*) FROM PruebasUsabilidad");
            $res->execute();
            $res->bind_result($total);
            $res->fetch();

            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            // Hombres
            $res = $this->db->prepare("SELECT count(*) FROM PruebasUsabilidad WHERE sexo = 'masculino'");
            $res->execute();
            $res->bind_result($totalHombres);
            $res->fetch();
            $porcentajeHombres = ($totalHombres/$total) * 100;
            
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            // Mujeres
            $res = $this->db->prepare("SELECT count(*) FROM PruebasUsabilidad WHERE sexo = 'femenino'");
            $res->execute();
            $res->bind_result($totalMujeres);
            $res->fetch();
            $porcentajeMujeres = ($totalMujeres/$total) * 100;
    
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            // Nivel medio
            $res = $this->db->prepare("SELECT avg(nivel) FROM PruebasUsabilidad");
            $res->execute();
            $res->bind_result($nivelMedio);
            $res->fetch();
    
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            // Tiempo medio
            $res = $this->db->prepare("SELECT avg(tiempoTarea) FROM PruebasUsabilidad");
            $res->execute();
            $res->bind_result($tiempoMedio);
            $res->fetch();
    
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            // Porcentaje de usuarios que han realizado la tarea correctamente        
            $res = $this->db->prepare("SELECT count(*) FROM PruebasUsabilidad WHERE tareaRealizadaCorrectamente = 'correcto'");
            $res->execute();
            $res->bind_result($totalTareaCorrectas);
            $res->fetch();
            $porcentajeTareaCorrecta = ($totalTareaCorrectas/$total) * 100;
    
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

            // Valor medio valoraciones
            $res = $this->db->prepare("SELECT avg(valoracion) FROM PruebasUsabilidad");
            $res->execute();
            $res->bind_result($mediaValoracion);
            $res->fetch();

            echo "
                <section>
                    <h2>Informe realizado</h2>    
    
                    <p>Edad media: $edadMedia años</p>
                    <p>Frecuencia porcentaje hombres: $porcentajeHombres %</p>
                    <p>Frecuencia porcentaje mujeres: $porcentajeMujeres %</p>
                    <p>Nivel de pericia informática medio: $nivelMedio</p>
                    <p>Tiempo medio: $tiempoMedio segundos</p>
                    <p>Porcentaje de usuarios que han realizado la tarea correcta: $porcentajeTareaCorrecta %</p>
                    <p>Valor medio de la puntuacion: $mediaValoracion puntos</p>
                </section>";

            $this->db->close();
        }

        public function exportarCSV(){
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");
        
            if($this->db->connect_error) {
                exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
            } else {echo "<h2>Conexión establecida</h2>";}

            $res = $this->db->prepare("SELECT * FROM PruebasUsabilidad");
            $res->execute();
            $resultado = $res->get_result();
            $csv = "pruebasUsabilidad.csv";

            if ($resultado->fetch_assoc() != NULL) {
                $datos = "";
                $resultado->data_seek(0); //Se posiciona al inicio del resultado de búsqueda                
                while ($fila = $resultado->fetch_assoc()) {
                    $datos .= ($fila['dni'] . ";");
                    $datos .= ($fila['nombre'] . ";");
                    $datos .= ($fila['apellidos'] . ";");
                    $datos .= ($fila['correo'] . ";");
                    $datos .= ($fila['telefono'] . ";");
                    $datos .= ($fila['edad'] . ";");
                    $datos .= ($fila['sexo'] . ";");
                    $datos .= ($fila['nivel'] . ";");
                    $datos .= ($fila['tiempoTarea'] . ";");
                    $datos .= ($fila['tareaRealizadaCorrectamente'] . ";");
                    $datos .= ($fila['comentarios'] . ";");
                    $datos .= ($fila['propuestas'] . ";");
                    $datos .= ($fila['valoracion']) . "\n";
                }
                file_put_contents($csv, $datos);
            }
            
            echo "<p>Datos exportados correctamente al fichero pruebasUsabilidad.csv</p>";
            $this->db->close();
        }

        public function cargarCSV($fichero){
            if ($fichero=="") {
                echo "<h2>Introduce un fichero antes de seleccionar cargar CSV</h2>";
                return;
            }
            $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");
        
            if($this->db->connect_error) {
                exit ("<h2>ERROR de conexión:".$this->db->connect_error."</h2>");  
            } else {echo "<h2>Conexión establecida</h2>";}
            
            $file = fopen($fichero, "r");
            while (($datos = fgetcsv($file, 10000, ";")) !== FALSE)
            {
                $this->db = new mysqli("localhost", "DBUSER2022", "DBPSWD2022", "prueba");

                $resPre = $this->db->prepare("INSERT INTO PruebasUsabilidad VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resPre->bind_param('sssssssssssss', $datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6],$datos[7],$datos[8],
                    $datos[9],$datos[10],$datos[11],$datos[12]);
                $resPre->execute();
            }
            fclose($file);
            echo "<p>Datos cargados correctamente del fichero $fichero</p>";
            $this->db->close();
        }
}

if( isset( $_SESSION['base'] ) ) {
    $_SESSION['base'] = new BaseDatos();
}else {
    $_SESSION['base'] = new BaseDatos();
}

if (count($_POST)>0) 
    {   

        if(isset($_POST['CrearBaseDatos'])) $_SESSION['base']->crearBaseDatos();
        if(isset($_POST['CrearTabla'])) $_SESSION['base']->crearTabla();
        if(isset($_POST['Insertar'])) $_SESSION['base']->insertaDatos();

        if(isset($_POST['insertar'])) $_SESSION['base']->insertarDatos($_POST['dni'], $_POST['nombre'], $_POST['apellidos'],
            $_POST['correo'], $_POST['telefono'], $_POST['edad'], $_POST['sexo'], $_POST['nivelInformatico'], $_POST['tiempoDeTarea'],
            $_POST['tareaRealizadaCorrectamente'], $_POST['comentarios'], $_POST['propuestas'], $_POST['valoracion']);

        if(isset($_POST['Buscar'])) $_SESSION['base']->buscaDatos();
        if(isset($_POST['buscar'])) $_SESSION['base']->buscarDatos($_POST['buscarDni']);
        if(isset($_POST['Modificar'])) $_SESSION['base']->modificaDatos();
        if(isset($_POST['modificar'])) $_SESSION['base']->modificarDatos($_POST['dniNuevo'], $_POST['nombreNuevo'], $_POST['apellidosNuevos'],
            $_POST['correoNuevo'], $_POST['telefonoNuevo'], $_POST['edadNueva'], $_POST['sexoNuevo'], $_POST['nivelInformaticoNuevo'], $_POST['tiempoTareaNuevo'],
            $_POST['tareaRealizadaCorrectamenteNuevo'], $_POST['comentariosNuevos'], $_POST['propuestasNuevas'], $_POST['valoracionNueva']);

        if(isset($_POST['Eliminar'])) $_SESSION['base']->eliminaDatos();

        if(isset($_POST['eliminar'])) $_SESSION['base']->eliminarDatos($_POST['dniElimina']);

        if(isset($_POST['GenerarInforme'])) $_SESSION['base']->generarInforme();
        if(isset($_POST['CargarCSV'])) {
            $_SESSION['base']->cargarCSV($_POST['archivo']);
        }
        if(isset($_POST['ExportarCSV'])) $_SESSION['base']->exportarCSV();
    }

?>
