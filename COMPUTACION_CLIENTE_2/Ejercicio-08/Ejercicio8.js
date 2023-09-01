// Ejercicio8.js

class Tiempo {
    constructor(){
        this.apikey = "47b790fd0fc41878c80c57c9846132cb";
        this.ciudad = "";
        this.codigoPais = "ES";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
        this.url = "";
        this.correcto = "Â¡Todo correcto! JSON recibido de <a href='http://openweathermap.org'>OpenWeatherMap</a>";
    }
    cargarDatos(){
        $.ajax({
            dataType: "json",
            url: this.url,
            method: 'GET',
            success: function(datos){
                    $("pre").text(JSON.stringify(datos, null, 2)); //muestra el json en un elemento pre
                       
                    var stringDatos = "<h3>Tabla con información</h3><table><tr><th>Datos</th><th>Valores</th>"
                        stringDatos += "<tr><td>Ciudad</td><td>"+ datos.name + "</td></tr>";
                        stringDatos += "<tr><td>País</td><td>" + datos.sys.country + "</td></tr>";
                        stringDatos += "<tr><td>Latitud</td><td>" + datos.coord.lat + "º</td></tr>";
                        stringDatos += "<tr><td>Longitud</td><td>" + datos.coord.lon + "º</td></tr>";
                        stringDatos += "<tr><td>Temperatura</td><td>" + datos.main.temp + "ºC</td></tr>";
                        stringDatos += "<tr><td>Temperatura máxima</td><td>" + datos.main.temp_max + "ºC</td></tr>";
                        stringDatos += "<tr><td>Temperatura mí­nima</td><td>" + datos.main.temp_min + "ºC</td></tr>";
                        stringDatos += "<tr><td>Presión</td><td>" + datos.main.pressure + " milibares</td></tr>";
                        stringDatos += "<tr><td>Humedad</td><td>" + datos.main.humidity + " %</td></tr>";
                        stringDatos += "<tr><td>Amanece a las</td><td>" + new Date(datos.sys.sunrise *1000).toLocaleTimeString() + "</td></tr>";
                        stringDatos += "<tr><td>Oscurece a las</td><td>" + new Date(datos.sys.sunset *1000).toLocaleTimeString() + "</td></tr>";
                        stringDatos += "<tr><td>Dirección del viento</td><td>" + datos.wind.deg + "º</td></tr>";
                        stringDatos += "<tr><td>Velocidad del viento</td><td>" + datos.wind.speed + " m/s</td></tr>";
                        stringDatos += "<tr><td>Hora de la medida</td><td>" + new Date(datos.dt *1000).toLocaleTimeString() + "</td></tr>";
                        stringDatos += "<tr><td>Fecha de la medida</td><td>" + new Date(datos.dt *1000).toLocaleDateString() + "</td></tr>";
                        stringDatos += "<tr><td>Descripción</td><td>" + datos.weather[0].description + "</td></tr>";
                        stringDatos += "<tr><td>Visibilidad</td><td>" + datos.visibility + " m</td></tr>";
                        stringDatos += "<tr><td>Nubosidad</td><td>" + datos.clouds.all + " %</td></tr></table>";

                    $("section").html(stringDatos);

                    $("img").attr("src", "http://openweathermap.org/img/wn/" + datos.weather[0].icon + ".png");
                    $("img").attr("alt", "Imagen del tiempo");
                },
            error:function(){
                $("h3").html("¡Tenemos problemas! No puedo obtener JSON de <a href='http://openweathermap.org'>OpenWeatherMap</a>");
                $("p").remove();
            }
        });
    }

    eliminarDatos(){
        $("h2").remove();
        $("img").remove();
        $("section").remove();
    }
        

    verJSON(ciudad){
        this.ciudad=ciudad;
        this.url = "http://api.openweathermap.org/data/2.5/weather?q=" + ciudad + "," + this.codigoPais + this.unidades + this.idioma + "&APPID=" + this.apikey;
        this.eliminarDatos();
        $("footer").before($("<h2></h2>").text("Tiempo atmosférico de " + ciudad));
        $("footer").before(document.createElement("img"));
        $("footer").before(document.createElement("section"));
        this.cargarDatos();
    }

}

var tiempo = new Tiempo();