// Ejercicio11.js

class GoogleMaps {

    initMap(){
        var lugar = {lat: 43.3672702, lng: -5.8502461};
        var mapa = new google.maps.Map(document.querySelector('main'),{zoom: 8,center:lugar});
        var marcador = new google.maps.Marker({position:lugar,map:mapa});
    }

}

var maps = new GoogleMaps();
