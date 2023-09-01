// Ejercicio7.js

class Modificacion {
    constructor() {
        this.isOcultoE=false;
        this.isOcultoP=false;
    }

    ocultarMostrarParrafos() {
        if (this.isOcultoP==false) {
            $("p").hide();
            this.isOcultoP=true;
        } else {
            $("p").show();
            this.isOcultoP=false;
        }
    }

    ocultarMostrarEncabezados() {
        if (this.isOcultoE==false) {
            $("h1").hide();
            $("h2").hide();
            $("h3").hide();
            this.isOcultoE=true;
        } else {
            $("h1").show();
            $("h2").show();
            $("h3").show();
            this.isOcultoE=false;
        }
    }

    modificarElementos() {
        $("h1").text("Primer encabezado modificado por JQuery")
        $("p").text("Texto de todos los párrafos modificados con JQuery")
    }
    
    añadirElementos() {
        var parrafo = $("<p></p>").text("Nuevo párrafo con JQuery");
        $("h2").before(parrafo);

        var encabezado = $("<h4></h4>").text("Nuevo encabezado h4 con JQuery");
        $("h3").after(encabezado);
    }

    eliminarElementos() {
        $("h3").remove();
        $("h2").remove();
        $("h1").remove();
    }

    recorrerElementos() {
        $("*", document.body).each(function() {
            var etiquetaPadre = $(this).parent().get(0).tagName;
            $("table").after("<p>Etiqueta padre : "  + 
                etiquetaPadre + ", elemento : " + $(this).get(0).tagName +", tipo de elemento: " + 
                $(this).attr("Type") + "</p>");
        });
    }

    sumarFilasYColumnasTabla() {
        var heads = document.querySelectorAll('table thead tr');
    
        var filas = document.querySelectorAll('table tr');
        var lista = []

        for (let i = 0; i < filas.length; i++) {
            let subList = []
            if (i==0) {
                var head = document.createElement('th');
                head.scope = "col";
                head.id = "total";
                head.innerText = "TOTAL";
                heads[i].appendChild(head);
            } else {
                var valorTotal = 0;
                var celdas = filas[i].querySelectorAll('td');
                for (let j = 0; j < celdas.length; j++) {
                    subList.push(Number(celdas[j].textContent));
                    valorTotal += Number(celdas[j].textContent);
                }
                lista.push(subList);
                var filaTotal = document.createElement('td');
                filaTotal.headers = "total";
                filaTotal.appendChild(document.createTextNode(valorTotal));
                filas[i].appendChild(filaTotal);
            }
        }

        var tabla = document.querySelector('table');

        var tbody = document.createElement('tbody');
        var trTotal = document.createElement('tr');
        var th = document.createElement('th');
        th.headers = "valores";
        th.id = "totalR";
        th.scope = "row";
        th.innerText = "TOTAL";

        trTotal.appendChild(th);
        tbody.appendChild(trTotal);
        tabla.appendChild(tbody);
        
        
        for (let i = 0; i < lista[0].length; i++) {
            let precioTotal = 0;
            for (let j = 0; j < lista.length; j++) {
                precioTotal += lista[j][i];
            }
            var td = document.createElement('td');
            td.innerText = precioTotal;
            td.headers = "total";
            trTotal.appendChild(td);
        }

        var tdTotal = document.createElement('td');
        let totales = 0;
        for (let i = 0; i < lista[0].length; i++) {
            for (let j = 0; j < lista.length; j++) {
                totales += lista[j][i];
            }
        }
        tdTotal.innerText = totales;
        tdTotal.headers = "total";
        trTotal.appendChild(tdTotal);
    }
}

var modificacion = new Modificacion();
    