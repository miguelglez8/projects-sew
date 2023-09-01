// Ejercicio14.js

class Procesar {

    procesarFichero(files) {

        if (!(window.File && window.FileReader && window.FileList && window.Blob)) {
            document.write("<p>Este navegador no soporta el API File</p>");
        }
        
        if (!(window.indexedDB)) {
            document.write("<p>ERROR: La API IndexedDb no es compatible</p>");
        }

        var archivo = files[0];
        
        if (archivo.type.match(/text.plain/)) {
            var lector = new FileReader();
            lector.onload = function (evento) {
                var datos = lector.result;
                var lista = [];
                lista = datos.split("\n");  
                
                // creamos la solicitud de creación de la BD
                var request = window.indexedDB.open("BD Colegiados", 1);

                request.onsuccess = function(event) {
                    // Hacemos el proceso exitoso al abrir.

                    var bd = event.target.result;
                    transaccion = bd.transaction("Usuario", "readwrite");
                    const store = transaccion.objectStore("Usuario");
                    let el;
                    for (let j = 0; j < lista.length; j++) {
                        el = lista[j].substring(0, lista[j].length-1).split(";");
                        if (el[6]=="APTO") {
                            store.add({nombre: el[0], apellidos: el[1], dni: el[2], titulo: el[3], ciudad: el[4], telefono: el[5]});
                        } else {
                            console.log("Usuario con nombre " + el[0] + " no es apto");
                        }
                    }
                                        
                    transaccion.oncomplete = ev => {
                        console.log("Los datos se han añadido con exito")
                    }

                    var transaccion = bd.transaction(["Usuario"], "readonly");
                    var objectStore = transaccion.objectStore("Usuario");
                    var request = objectStore.openCursor();
                    
                    request.onsuccess = function (event) {
                        var cursor = event.target.result;
                        var tabla = document.querySelector('table');

                        if(cursor){
                            var tbody = document.createElement('tbody');
                            var trTotal = document.createElement('tr');

                            tbody.appendChild(trTotal);
                            tabla.appendChild(tbody); 
                            
                            var td = document.createElement('td');
                            td.innerText = cursor.value.nombre;
                            td.headers = "nombre";
                            trTotal.appendChild(td);

                            td = document.createElement('td');
                            td.innerText = cursor.value.apellidos;
                            td.headers = "apellidos";
                            trTotal.appendChild(td);

                            td = document.createElement('td');
                            td.innerText = cursor.value.dni;
                            td.headers = "dni";
                            trTotal.appendChild(td);

                            td = document.createElement('td');
                            td.innerText = cursor.value.titulo;
                            td.headers = "titulo";
                            trTotal.appendChild(td);

                            td = document.createElement('td');
                            td.innerText = cursor.value.ciudad;
                            td.headers = "ciudad";
                            trTotal.appendChild(td);

                            td = document.createElement('td');
                            td.innerText = cursor.value.telefono;
                            td.headers = "telefono";
                            trTotal.appendChild(td);

                            cursor.continue(); 
                        }
                    }
                };

                request.onerror = function(event) {
                    // Manejamos el error al abrir.
                    console.error("error",event.target.errorCode);
                };
                
                request.onupgradeneeded = function (event) {
                    var bd = event.target.result;
                    bd.createObjectStore("Usuario", { keyPath: "nombre" });
                }
            }
            lector.readAsText(archivo);
        } else{
            document.write("<p>ERROR: No ha seleccionado el tipo de fichero que se indicaba</p>");
        }

    }

}

class Screen {

    fullScreenMode(){
        document.documentElement.requestFullscreen();
    }
}

var procesar = new Procesar();
var screen = new Screen();