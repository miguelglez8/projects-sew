// Ejercicio9.js

class Tiempo {
    constructor(){
        this.apikey = "47b790fd0fc41878c80c57c9846132cb";
        this.ciudad = "";
        this.tipo = "&mode=xml";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
        this.codigoPais = "ES";
        this.url = "";
        this.correcto = "Â¡Todo correcto! JSON recibido de <a href='http://openweathermap.org'>OpenWeatherMap</a>";
    }

    cargarDatos(){
        $.ajax({
            dataType: "xml",
            url: this.url,
            method: 'GET',
            success: function(datos){

                    var totalNodos            = $('*',datos).length;
                    var ciudad                = $('city',datos).attr("name");
                    var longitud              = $('coord',datos).attr("lon");
                    var latitud               = $('coord',datos).attr("lat");
                    var pais                  = $('country',datos).text();
                    var amanecer              = $('sun',datos).attr("rise");
                    var minutosZonaHoraria    = new Date().getTimezoneOffset();
                    var amanecerMiliSeg1970   = Date.parse(amanecer);
                        amanecerMiliSeg1970  -= minutosZonaHoraria * 60 * 1000;
                    var amanecerLocal         = (new Date(amanecerMiliSeg1970)).toLocaleTimeString("es-ES");
                    var oscurecer             = $('sun',datos).attr("set");          
                    var oscurecerMiliSeg1970  = Date.parse(oscurecer);
                        oscurecerMiliSeg1970  -= minutosZonaHoraria * 60 * 1000;
                    var oscurecerLocal        = (new Date(oscurecerMiliSeg1970)).toLocaleTimeString("es-ES");
                    var temperatura           = $('temperature',datos).attr("value");
                    var temperaturaMin        = $('temperature',datos).attr("min");
                    var temperaturaMax        = $('temperature',datos).attr("max");
                    var temperaturaUnit       = $('temperature',datos).attr("unit");
                    var humedad               = $('humidity',datos).attr("value");
                    var humedadUnit           = $('humidity',datos).attr("unit");
                    var presion               = $('pressure',datos).attr("value");
                    var presionUnit           = $('pressure',datos).attr("unit");
                    var velocidadViento       = $('speed',datos).attr("value");
                    var nombreViento          = $('speed',datos).attr("name");
                    var direccionViento       = $('direction',datos).attr("value");
                    var codigoViento          = $('direction',datos).attr("code");
                    var nombreDireccionViento = $('direction',datos).attr("name");
                    var nubosidad             = $('clouds',datos).attr("value");
                    var nombreNubosidad       = $('clouds',datos).attr("name");
                    var visibilidad           = $('visibility',datos).attr("value");
                    var precipitacionValue    = $('precipitation',datos).attr("value");
                    var precipitacionMode     = $('precipitation',datos).attr("mode");
                    var descripcion           = $('weather',datos).attr("value");
                    var horaMedida            = $('lastupdate',datos).attr("value");
                    var horaMedidaMiliSeg1970 = Date.parse(horaMedida);
                        horaMedidaMiliSeg1970 -= minutosZonaHoraria * 60 * 1000;
                    var horaMedidaLocal       = (new Date(horaMedidaMiliSeg1970)).toLocaleTimeString("es-ES");
                    var fechaMedidaLocal      = (new Date(horaMedidaMiliSeg1970)).toLocaleDateString("es-ES");
                    

                    var stringDatos = "<h3>Tabla con información</h3><table><tr><th>Datos</th><th>Valores</th>"
                        stringDatos += "<tr><td>Ciudad</td><td>"+ ciudad + "</td></tr>";
                        stringDatos += "<tr><td>País</td><td>" + pais + "</td></tr>";
                        stringDatos += "<tr><td>Latitud</td><td>" + latitud + " º</td></tr>";
                        stringDatos += "<tr><td>Longitud</td><td>" + longitud + " º</td></tr>";
                        stringDatos += "<tr><td>Amanece a las</td><td>" + amanecerLocal + "</td></tr>";
                        stringDatos += "<tr><td>Oscurece a las</td><td>" + oscurecerLocal + "</td></tr>";
                        stringDatos += "<tr><td>Temperatura</td><td>" + temperatura + " ºC</td></tr>";
                        stringDatos += "<tr><td>Temperatura máxima</td><td>" + temperaturaMax + " ºC</td></tr>";
                        stringDatos += "<tr><td>Temperatura mí­nima</td><td>" + temperaturaMin + " ºC</td></tr>";
                        stringDatos += "<tr><td>Temperatura (unidades)</td><td>" + temperaturaUnit + "</td></tr>";
                        stringDatos += "<tr><td>Presión</td><td>" + presion + " " + presionUnit + "</td></tr>";
                        stringDatos += "<tr><td>Humedad</td><td>" + humedad + " " + humedadUnit + "</td></tr>";
                        stringDatos += "<tr><td>Nombre del viento</td><td>" + nombreViento + " º</td></tr>";
                        stringDatos += "<tr><td>Dirección del viento</td><td>" + direccionViento + " º</td></tr>";
                        stringDatos += "<tr><td>Código del viento</td><td>" + codigoViento + "</td></tr>";
                        stringDatos += "<tr><td>Velocidad del viento</td><td>" + velocidadViento + " m/s</td></tr>";
                        stringDatos += "<tr><td>Hora de la medida</td><td>" + horaMedidaLocal + "</td></tr>";
                        stringDatos += "<tr><td>Fecha de la medida</td><td>" + fechaMedidaLocal + "</td></tr>";
                        stringDatos += "<tr><td>Descripción</td><td>" + descripcion + "</td></tr>";
                        stringDatos += "<tr><td>Visibilidad</td><td>" + visibilidad + " m</td></tr>";
                        stringDatos += "<tr><td>Nubosidad</td><td>" + nubosidad + " %</td></tr>";
                        stringDatos += "<tr><td>Nombre de la nubosidad</td><td>" + nombreNubosidad + "</td></tr></table>";

                    $("section").html('<h3>Tabla con información</h3>');
                    $("section").html(stringDatos);

                    $("img").attr("src", "http://openweathermap.org/img/wn/" + $('weather',datos).attr("icon") + ".png");
                    $("img").attr("alt", "Imagen del tiempo");
                },
            error:function(){
                $("h3").html("¡Tenemos problemas! No puedo obtener JSON de <a href='http://openweathermap.org'>OpenWeatherMap</a>");
                $("p").remove();
            }
        });
    }

    verXML(ciudad){
        this.ciudad = ciudad;
        this.eliminarDatos();
        this.url = "http://api.openweathermap.org/data/2.5/weather?q=" + this.ciudad + this.tipo + this.unidades + this.idioma + "&APPID=" + this.apikey;
        $("footer").before($("<h2></h2>").text("Tiempo atmosférico de " + ciudad));
        $("footer").before(document.createElement("img"))
        $("footer").before(document.createElement("section"))
        this.cargarDatos();
    }

    eliminarDatos(){
        $("h2").remove();
        $("img").remove();
        $("section").remove();
    }

}

var tiempo = new Tiempo();

