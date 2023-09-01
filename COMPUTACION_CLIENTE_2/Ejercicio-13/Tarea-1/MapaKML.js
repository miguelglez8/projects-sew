// MapaKML.js

class FileKML{

    procesarFichero(files) {

        var map;
        map = new google.maps.Map(document.querySelector('main'), {
            center: new google.maps.LatLng(40.42028, -3.70577),
            zoom: 2,
            mapTypeId: 'terrain'
        });

        if (!(window.File && window.FileReader && window.FileList && window.Blob)) {
            document.write("<p>Este navegador no soporta el API File</p>");
        }

        var archivo = files[0];
        var result;

        var lector = new FileReader();
        lector.onload = function (evento) {
            result = lector.result;
            var xml = $.parseXML(evento.target.result);
            var e = []
            e = $(xml).find('coordinates');
            for (let i = 0; i < e.length; i++) {
                let cadena = e[i].textContent;
                cadena = cadena.split(',');
                console.log(cadena)
                let long = Number(cadena[0]);
                let lat = Number(cadena[1]);
                
                var lugar = {lat: parseFloat(lat), lng: parseFloat(long)};
                console.log(lugar)
                var marcador = new google.maps.Marker({position:lugar,map:map});
            }      
        }
        lector.readAsText(archivo);
    }
}

var fileKML = new FileKML();