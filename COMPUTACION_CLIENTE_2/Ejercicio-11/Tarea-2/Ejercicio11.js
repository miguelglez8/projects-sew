// Ejercicio11.js

class Geolocalizacion {
    constructor (){
        this.error=false;
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this), this.verErrores.bind(this));
    }
    getPosicion(posicion){
        this.mensaje = "Se ha realizado correctamente la peticion de geolocalizacion";
        this.longitud         = posicion.coords.longitude; 
        this.latitud          = posicion.coords.latitude;  
        this.precision        = posicion.coords.accuracy;
        this.altitud          = posicion.coords.altitude;
        this.precisionAltitud = posicion.coords.altitudeAccuracy;
        this.rumbo            = posicion.coords.heading;
        this.velocidad        = posicion.coords.speed;
    }

    verErrores(error){
        switch(error.code) {
        case error.PERMISSION_DENIED:
            this.mensaje = "El usuario no permite la peticion de geolocalizacion"
            this.error=true;
            break;
        case error.POSITION_UNAVAILABLE:
            this.mensaje = "Informacion de geolocalizacion no disponible"
            this.error=true;
            break;
        case error.TIMEOUT:
            this.mensaje = "La peticion de geolocalizacion ha caducado"
            this.error=true;
            break;
        case error.UNKNOWN_ERROR:
            this.mensaje = "Se ha producido un error desconocido"
            this.error=true;
            break;
        }
    }
    getLongitud(){
        return this.longitud;
    }
    getLatitud(){
        return this.latitud;
    }
    getAltitud(){
        return this.altitud;
    }
    verTodo(){
        if (this.error) {
            var datos='<p>'+ this.mensaje + '</p>'; 
            $("section").append(datos);
        } else {
            var datos='<p>'+ this.mensaje + '</p>'; 
            datos+='<p>Longitud: '+this.longitud +' grados</p>'; 
            datos+='<p>Latitud: '+this.latitud +' grados</p>';
            datos+='<p>Precision de la longitud y latitud: '+ this.precision +' metros</p>';
            datos+='<p>Altitud: '+ this.altitude +' metros</p>';
            datos+='<p>Precision de la altitud: '+ this.precisionAltitud +' metros</p>'; 
            datos+='<p>Rumbo: '+ this.rumbo +' grados</p>'; 
            datos+='<p>Velocidad: '+ this.velocidad +' metros/segundo</p>';
            $("section").append(datos);
        }
    }
}
var miPosicion = new Geolocalizacion();