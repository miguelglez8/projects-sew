// Ejercicio12.js

class Procesar {

    obtenerPropiedades(files) {

        if (!(window.File && window.FileReader && window.FileList && window.Blob)) {
            document.write("<p>Este navegador no soporta el API File</p>");
        }

        this.eliminar(); 

        var file = files[0];

        $("h3").after($("<p></p>").text("Nombre del file: " + file.name))
        $("h3").after($("<p></p>").text("Tamaño del file: " + file.size + " bytes"))
        $("h3").after($("<p></p>").text("Tipo del file: " + file.type));

        if (file.type.match(/text.plain/) || file.type.match(/text.xml/) || file.type.match(/application.json/)) {
            var reader = new FileReader();
            reader.onload = function (evento) {
                let contenido = reader.result;
                let lista = contenido.split("\r");
                for (let i = 0; i < lista.length; i++) {
                    var texto = document.createElement("p");
                    texto.textContent = lista[i];
                    document.querySelector('section').appendChild(texto);
                }
            }
            reader.readAsText(file);
        } else{
            $("h3").after($("<p></p>").text("El fichero no tiene formato TXT, ni XML, ni JSON"));
        }

    }

    eliminar() {
        $("section > p").remove();
        $("pre").remove();
    }

}

var procesar = new Procesar();