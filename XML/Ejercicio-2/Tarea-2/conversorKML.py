import xml.etree.ElementTree as ET

"""
Procesamiento de un XML para crear un KML
"""

def tratarPersona(elePersona):

    # sacamos el nombre y apellidos de la persona
    f.write("<Placemark>\n")
    nombre = elePersona.attrib.get('nombre')
    apellidos = elePersona.attrib.get('apellidos')

    # empezaremos escribiendo su lugar de nacimiento
    f.write('<name>Lugar de nacimiento de ' + nombre + ' ' + apellidos + '</name>\n')
    eleLugarNacimiento = elePersona.find('datos/lugar_nacimiento/nombre')
    lugarNacimiento = eleLugarNacimiento.text
    coordenadasA = elePersona.find('datos/lugar_nacimiento/coordenada')
    eleLugarResidencia = elePersona.find('datos/lugar_residencia/nombre')
    lugarResidencia = eleLugarResidencia.text
    coordenadasB = elePersona.find('datos/lugar_residencia/coordenada')

    longitud=coordenadasA.attrib.get('longitud')
    latitud=coordenadasA.attrib.get('latitud')
    f.write('<description>Nació en ' + lugarNacimiento + '</description>\n')
    # creamos una ubicacion
    f.write('<Point>\n')
    f.write('<coordinates>\n')
    f.write(longitud + ',' + latitud)
    f.write('</coordinates>\n')
    f.write('<altitudeMode>relativeToGround</altitudeMode>')
    f.write('</Point>\n')
    f.write("</Placemark>\n")

    # escribimos también su lugar de residencia
    f.write("<Placemark>\n")
    f.write('<name>Lugar de residencia de ' + nombre + ' ' + apellidos + '</name>\n')
    longitud=coordenadasB.attrib.get('longitud')
    latitud=coordenadasB.attrib.get('latitud')
    f.write('<description>Vive en ' + lugarResidencia + '</description>\n')
    # creamos otra ubicacion
    f.write('<Point>\n')
    f.write('<coordinates>\n')
    f.write(longitud + ',' + latitud)
    f.write('</coordinates>\n')
    f.write('<altitudeMode>relativeToGround</altitudeMode>')
    f.write('</Point>\n')
    f.write("</Placemark>\n")

    # obtenemos el resto de personas, y vamos procesando sus lugares de residencia y de nacimiento
    elePersonaHijos = elePersona.findall('persona')
    for eleHijo in elePersonaHijos:
        tratarPersona(eleHijo)


def main():
    try:
        # procesamos el xml inicial
        arbol = ET.parse('personas.xml')
    except IOError:
        # error
        print ('No se encuentra el archivo ')
        exit()
    except ET.ParseError:
        # error
        print("Error procesando en el archivo XML")
        exit()

    # vamos escribiendo la cabecera del kml
    f.write('<?xml version="1.0" encoding="UTF-8"?>\n')
    f.write('<kml xmlns="http://www.opengis.net/kml/2.2">\n')
    f.write("<Document>\n")
    # vamos tratando todas las personas, empezando por la raiz
    tratarPersona(arbol.getroot())
    # terminamos de escribir cerrando las etiquetas y el fichero kml
    f.write("</Document>\n")
    f.write("</kml>\n")
    f.close()

if __name__ == '__main__':
     # abrimos el kml donde escribiremos
     f = open('personas.kml', 'w')
     main()
