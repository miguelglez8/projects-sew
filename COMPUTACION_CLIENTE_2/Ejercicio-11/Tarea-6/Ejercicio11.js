 // Ejercicio11.js

class Geolocalizacion {

    initMap() {
        var centro = {lat: 43.3672702, lng: -5.8502461};
        var mapaGeoposicionado = new google.maps.Map(document.querySelector('main'),{
            zoom: 8,
            center:centro
        });
        var infoWindow = new google.maps.InfoWindow;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };
    
                infoWindow.setPosition(pos);
                infoWindow.setContent('Localizacion encontrada');
                infoWindow.open(mapaGeoposicionado);
                mapaGeoposicionado.setCenter(pos);
              }, function() {
                handleLocationError(true, infoWindow, mapaGeoposicionado.getCenter());
              });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, mapaGeoposicionado.getCenter());
        }

        google.maps.event.addListener(mapaGeoposicionado, 'click', function(event) {
            const marker = new google.maps.Marker({
                position: event.latLng,
                map: mapaGeoposicionado
            });
            const infoWindow = new google.maps.InfoWindow();
            let html = "<h3>Ubicación seleccionada con el ratón</h3>";
            google.maps.event.addListener(marker, 'click', function(e) {
                infoWindow.setContent(html);
                infoWindow.open(mapaGeoposicionado, marker);
            });
        });
        
    }

    dibujaMarca() {
        var valoresAceptados = /^[0-9\-][0-9]*(.[0-9]+)?$/;

        let lat;
        let long;

        lat = $('input[value="latitud"]').val();
        long = $('input[value="longitud"]').val();
        if (lat.match(valoresAceptados) && long.match(valoresAceptados)){
            $("h2").text("Introduce los datos:")
        } else {
            this.error();
            return;
        }
    
        var centro = {lat: Number(lat), lng: Number(long)};
        var mapaGeoposicionado = new google.maps.Map(document.querySelector('main'),{
            zoom: 8,
            center:centro
        });
        var infoWindow = new google.maps.InfoWindow;

        if (!(lat==NaN || long==NaN)) {           
            var lugar = {lat: Number(lat), lng: Number(long)};
            var marker = new google.maps.Marker({position:lugar,map:mapaGeoposicionado});
            const infoWindow = new google.maps.InfoWindow();
            let html = "<h3>Ubicación introducida por teclado</h3>";
            google.maps.event.addListener(marker, 'click', function(e) {
                infoWindow.setContent(html);
                infoWindow.open(mapaGeoposicionado, marker);
            });
        }
    }
    
    handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: Ha fallado la geolocalizacion' :
                              'Error: Su navegador no soporta geolocalizacion');
        infoWindow.open(mapaGeoposicionado);
    }
    
    error() {
        $("h2").text("Introduce un valor númerico en lugar de una cadena")
        console.error("ERROR: Introduce un valor numérico en los campos de texto");
    }
    
}

var maps = new Geolocalizacion();
