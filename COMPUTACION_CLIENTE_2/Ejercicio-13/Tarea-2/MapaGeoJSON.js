// MapaGeoJSON.js

class FileGeoJSON{
    
    procesarFichero(files) {

        if (!(window.File && window.FileReader && window.FileList && window.Blob)) {
            document.write("<p>Este navegador no soporta el API File</p>");
        }

        var map;
        map = new google.maps.Map(document.querySelector('main'), {
            center: new google.maps.LatLng(40.42028, -3.70577),
            zoom: 2,
            mapTypeId: 'terrain'
        });

        var archivo = files[0];
        var result;

        var lector = new FileReader();
        lector.onload = function (evento) {
            result = lector.result;

            var json = $.parseJSON(evento.target.result);
            for (const feature of json.features) {
                var lugar = {lat: parseFloat(feature.geometry.coordinates[1]), lng: parseFloat(feature.geometry.coordinates[0])};
                console.log(lugar);
                var marcador = new google.maps.Marker({position:lugar,map:map});
            }   
        }
        lector.readAsText(archivo);
    }
}

var fileGeoJSON = new FileGeoJSON();