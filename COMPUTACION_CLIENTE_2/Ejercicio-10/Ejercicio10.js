// Ejercicio10.js

class PreciosGasolina {
    constructor(){
        this.apikey = "";
        this.ciudad = "";
        this.codigoPais = "ES";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
        this.url = "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/";
        this.correcto = "Â¡Todo correcto! XML recibido";
    }

    cargarDatos(ciudades){
        $.ajax({
            dataType: "xml",
            url: this.url,
            method: 'GET',
            success: function(datos){
                var stringDatos;
                var ciudad = $('EESSPrecio',datos).each(function (index, item) {

                    var localidad = $('Localidad', item).text();
    
                    if (ciudades==localidad) {
                        stringDatos = "<h3>Tabla con información</h3><table><tr><th>Dato</th><th>Valor</th>";
                        if ($('Direccion', item).text() == "") {
                            stringDatos += "<tr><td>Direccion</td><td>NO DISPONIBLE</td></tr>";
                        } else {
                            stringDatos += "<tr><td>Direccion</td><td>"+ $('Direccion', item).text() + "</td></tr>";
                        }
                        stringDatos += "<tr><td>Horario</td><td>" + $('Horario', item).text() + "</td></tr>";
                        stringDatos += "<tr><td>Latitud</td><td>" + $('Latitud', item).text() + "º</td></tr>";
                        stringDatos += "<tr><td>Longitud</td><td>" + $('Longitud_x0020__x0028_WGS84_x0029_', item).text() + "º</td></tr>";
                        stringDatos += "<tr><td>Localidad</td><td>" + $('Localidad', item).text() + "</td></tr>";
                        stringDatos += "<tr><td>Municipio</td><td>" + $('Municipio', item).text() + "</td></tr>";
                        stringDatos += "<tr><td>Provincia</td><td>" + $('Provincia', item).text() + "</td></tr>";
                        stringDatos += "<tr><td>Remisión</td><td>" + $('Remisión', item).text() + "</td></tr>";
                        stringDatos += "<tr><td>Rótulo</td><td>" + $('Rótulo', item).text() + "</td></tr>";
                        stringDatos += "<tr><td>Municipio</td><td>" + $('Municipio', item).text() +"</td></tr>";
                        stringDatos += "<tr><td>Tipo de Venta</td><td>" + $('Tipo_x0020_Venta', item).text() + "</td></tr>";
                        if ($('Precio_x0020_Gasolina_x0020_95_x0020_E10', item).text() == "") {
                            stringDatos += "<tr><td>Precio gasolina E10</td><td>NO DISPONIBLE</td></tr>";
                        } else {
                            stringDatos += "<tr><td>Precio gasolina E10</td><td>" + $('Precio_x0020_Gasolina_x0020_95_x0020_E10', item).text() + " €</td></tr>";
                        }
                        stringDatos += "<tr><td>Precio gasolina E5</td><td>" + $('Precio_x0020_Gasolina_x0020_95_x0020_E5', item).text() + " €</td></tr>";
                        if ($('Precio_x0020_Gasolina_x0020_95_x0020_E5_x0020_Premium', item).text() == "") {
                            stringDatos += "<tr><td>Precio gasolina Premium</td><td>NO DISPONIBLE</td></tr>";
                        } else {
                            stringDatos += "<tr><td>Precio gasolina Premium</td><td>" + $('Precio_x0020_Gasolina_x0020_95_x0020_E5_x0020_Premium', item).text() + " €</td></tr>";
                        }
                    }  

                });

                $("section").html(stringDatos);

                $("img").attr("src", "multimedia/surtidorGasolina.png");
                $("img").attr("alt", "Imagen del surtidor de gasolina");

            },
            error:function(){
                $("h3").html("¡Tenemos problemas! No puedo obtener ");
                $("p").remove();
            }
        });
    }

    verXML(ciudad){
        this.ciudad=ciudad;
        this.url = "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/";
        this.eliminarDatos();
        $("footer").before($("<h2></h2>").text("Precio en " + ciudad));
        $("footer").before(document.createElement("img"));
        $("footer").before(document.createElement("section"));
        this.cargarDatos(ciudad);
    }

    eliminarDatos(){
        $("h2").remove();
        $("img").remove();
        $("section").remove();
    }
}

var preciosGasolina = new PreciosGasolina();

