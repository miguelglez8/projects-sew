import xml.etree.ElementTree as ET

"""
Procesamiento de un XML para crear un SVG
"""

def tratarPersona(elePersona, x, y):
    # obtenemos todos los datos de la persona de manera similar que los anteriores ejercicios
    nombre = elePersona.attrib.get('nombre')
    apellidos = elePersona.attrib.get('apellidos')
    comentarios = elePersona.attrib.get('comentarios')
    fecha_nacimiento = elePersona.attrib.get('fecha_nacimiento')

    eleLugarNacimiento = elePersona.find('datos/lugar_nacimiento/nombre')
    lugarNacimiento = eleLugarNacimiento.text
    coordenadasA = elePersona.find('datos/lugar_nacimiento/coordenada')
    eleLugarResidencia = elePersona.find('datos/lugar_residencia/nombre')
    lugarResidencia = eleLugarResidencia.text
    coordenadasB = elePersona.find('datos/lugar_residencia/coordenada')

    longitud=coordenadasA.attrib.get('longitud')
    latitud=coordenadasA.attrib.get('latitud')
    altitud=coordenadasA.attrib.get('altitud')
   
    # escribimos los datos en un rectangulo, en las coordenadas indicadas como parámetros de la funcion
    f.write('<rect x="' + str(x-10) + '" y="' + str(y) + '" width="200" height="95" style="fill:white;stroke:black;stroke-width:1"/>\n')
    y = y + 10
    f.write('<text x="' + str(x) + '" y="' + str(y) + '" font-size="15" style="fill:blue">'+ nombre + ' ' + apellidos + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Fecha de nacimiento: ' + fecha_nacimiento + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Comentarios: ' + comentarios + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Lugar de nacimiento: ' + lugarNacimiento + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Coordenadas: ' + longitud + ', ' + latitud + ', ' + altitud + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Lugar de residencia: ' + lugarResidencia + '</text>\n')
    y = y + 10

    longitud=coordenadasB.attrib.get('longitud')
    latitud=coordenadasB.attrib.get('latitud')
    altitud=coordenadasB.attrib.get('altitud')

    imagenes = elePersona.find('datos/imagenes')
    i = 0
    y = y + 10
    for imagen in imagenes:
        i = i + 1
        im = imagen.text.strip()
        # escribimos la ruta donde se encuentra la imagen
        f.write('<text x="'+ str(x) +'" y="'+ str(y) +'" font-size="10" style="fill:black">Imagen ' + str(i) + ': ' + im + '</text>\n')
        y = y + 10

    videos = elePersona.find('datos/videos')
    i = 0
    for video in videos:
        i = i + 1

    if (i != 0):
        i = 0
        for video in videos:
            i = i + 1
            vi = video.text.strip()
            # escribimos la ruta donde se encuentra el video
            f.write('<text x="'+ str(x) +'" y="'+ str(y) +'" font-size="10" style="fill:black">Video ' + str(i) + ': ' + vi + '</text>\n')
            y = y + 10

    # tratamos los hijos del nodo, y asignamos a cada hijo unas coordenadas en el espacio, de manera que queden en formato de árbol como el resto de hijos
    elePersonaHijos = elePersona.findall('persona')
    x = x - 600
    for eleHijo in elePersonaHijos:
        f.write('<line x1="950" y1="150" x2="' + str(x + 100) + '" y2="' + str(y + 100) + '" stroke="red" stroke-width="3"></line>')
        tratarPersonaHijos(eleHijo, x, y+100)
        x = x + 600
    
    
def tratarPersonaHijos(eleHijo, x, y):
    v = x + 75
    # obtenemos todos los datos de la persona de manera similar que los anteriores ejercicios
    nombre = eleHijo.attrib.get('nombre')
    apellidos = eleHijo.attrib.get('apellidos')
    comentarios = eleHijo.attrib.get('comentarios')
    fecha_nacimiento = eleHijo.attrib.get('fecha_nacimiento')

    eleLugarNacimiento = eleHijo.find('datos/lugar_nacimiento/nombre')
    lugarNacimiento = eleLugarNacimiento.text
    coordenadasA = eleHijo.find('datos/lugar_nacimiento/coordenada')
    eleLugarResidencia = eleHijo.find('datos/lugar_residencia/nombre')
    lugarResidencia = eleLugarResidencia.text
    coordenadasB = eleHijo.find('datos/lugar_residencia/coordenada')

    longitud=coordenadasA.attrib.get('longitud')
    latitud=coordenadasA.attrib.get('latitud')
    altitud=coordenadasA.attrib.get('altitud')
   
    # escribimos los datos en un rectangulo, en las coordenadas indicadas como parámetros de la funcion
    f.write('<rect x="' + str(x-10) + '" y="' + str(y) + '" width="200" height="115" style="fill:white;stroke:black;stroke-width:1"/>\n')
    y = y + 10
    f.write('<text x="' + str(x) + '" y="' + str(y) + '" font-size="15" style="fill:blue">'+ nombre + ' ' + apellidos + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Fecha de nacimiento: ' + fecha_nacimiento + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Comentarios: ' + comentarios + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Lugar de nacimiento: ' + lugarNacimiento + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Coordenadas: ' + longitud + ', ' + latitud + ', ' + altitud + '</text>\n')
    y = y + 10
    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Lugar de residencia: ' + lugarResidencia + '</text>\n')
    y = y + 10

    longitud=coordenadasB.attrib.get('longitud')
    latitud=coordenadasB.attrib.get('latitud')
    altitud=coordenadasB.attrib.get('altitud')

    f.write('<text x="'+ str(x) +'" y="' + str(y) + '" font-size="10" style="fill:black">Coordenadas: ' + longitud + ', ' + latitud + ', ' + altitud + '</text>\n')
    
    imagenes = eleHijo.find('datos/imagenes')
    i = 0
    y = y + 10
    for imagen in imagenes:
        i = i + 1
        im = imagen.text.strip()
        # escribimos la ruta donde se encuentra la imagen
        f.write('<text x="'+ str(x) +'" y="'+ str(y) +'" font-size="10" style="fill:black">Imagen ' + str(i) + ': ' + im + '</text>\n')
        y = y + 10

    videos = eleHijo.find('datos/videos')
    i = 0
    for video in videos:
        i = i + 1

    if (i != 0):
        i = 0
        for video in videos:
            i = i + 1
            vi = video.text.strip()
            # escribimos la ruta donde se encuentra el video
            f.write('<text x="'+ str(x) +'" y="'+ str(y) +'" font-size="10" style="fill:black">Video ' + str(i) + ': ' + vi + '</text>\n')
            y = y + 10
    
    i = y
    # tratamos los hijos del nodo, y asignamos a cada hijo unas coordenadas en el espacio, de manera que queden en formato de árbol como el resto de hijos
    elePersonaHijos = eleHijo.findall('persona')
    x = x - 185
    for eleHijo in elePersonaHijos:
        f.write('<line x1="' + str(v) + '" y1="' + str(i) + '" x2="' + str(x + 100) + '" y2="' + str(y + 150) + '" stroke="red" stroke-width="3"></line>')
        tratarPersonaHijos(eleHijo, x, 500)
        x = x + 185

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
    
    # empezamos escribiendo la cabecera del svg
    f.write('<?xml version="1.0" encoding="utf-8"?>\n')
    f.write('<svg width="auto" height="8020" style="overflow:visible " version="1.1" xmlns="http://www.w3.org/2000/svg">\n')
    # tratamos cada nodo, empezando por la raiz, y asignamos unos valores iniciales de x e y para colocar el nodo inicial en el lienzo
    tratarPersona(arbol.getroot(), 850, 50)
    # cerramos el svg y el fichero
    f.write('</svg>')
    f.close()

if __name__ == '__main__':
     # creamos un fichero svg donde iremos escribiendo
     f = open('personas.svg', 'w')
     main()
