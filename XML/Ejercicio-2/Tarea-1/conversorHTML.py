import xml.etree.ElementTree as ET

"""
Procesamiento de un XML para crear un HTML
"""

def tratarPersona(elePersona):

    # abrimos la section
    f.write('       <section>\n')
    nombre = elePersona.attrib.get('nombre')
    apellidos = elePersona.attrib.get('apellidos')
    fecha_nacimiento = elePersona.attrib.get('fecha_nacimiento')
    comentarios = elePersona.attrib.get('comentarios')

    # como h3 ponemos el nombre y apellidos, seguido de la fecha de nacimiento y comentarios en dos párrafos
    f.write('               <h3>Nombre y apellidos: ' + nombre + ' ' + apellidos + '</h3>')
    f.write('<p>Fecha de nacimiento: ' + fecha_nacimiento + '</p>') 
    f.write('<p> Comentarios: ' + comentarios + '</p>')

    eleLugarNacimiento = elePersona.find('datos/lugar_nacimiento/nombre')
    lugarNacimiento = eleLugarNacimiento.text
    coordenadasA = elePersona.find('datos/lugar_nacimiento/coordenada')
    eleLugarResidencia = elePersona.find('datos/lugar_residencia/nombre')
    lugarResidencia = eleLugarResidencia.text
    coordenadasB = elePersona.find('datos/lugar_residencia/coordenada')

    longitud=coordenadasA.attrib.get('longitud')
    latitud=coordenadasA.attrib.get('latitud')
    altitud=coordenadasA.attrib.get('altitud')
    # escribimos los lugares y coordenadas en párrafos
    f.write('<p>Lugar de nacimiento: ' + lugarNacimiento + '</p>') 
    f.write('<p>Coordenadas:  ' + longitud + ', ' + latitud + ", " + altitud + '</p>')

    longitud=coordenadasB.attrib.get('longitud')
    latitud=coordenadasB.attrib.get('latitud')
    altitud=coordenadasB.attrib.get('altitud')
    f.write('<p>Lugar de residencia: ' + lugarResidencia + '</p>') 
    f.write('<p>Coordenadas:  ' + longitud + ', ' + latitud + ", " + altitud + '</p>')

    f.write('<p>Imagenes de ' + nombre + ':</p>')
    imagenes = elePersona.find('datos/imagenes')
    i = 0

    # se creará una lista de imágenes asociada a la persona
    f.write('<ul>')
    for imagen in imagenes:
        i = i + 1
        im = imagen.text.strip()
        f.write('<li>')
        f.write('<p>Imagen ' + str(i) + ' de ' + nombre + ':</p>')
        f.write('<img src= "' + im + '" alt= "' + nombre + '"/>') 
        f.write('</li>')
    f.write('</ul>')

    videos = elePersona.find('datos/videos')
    i = 0
    for video in videos:
        i = i + 1
    
    if (i!=0):
        # se creará una lista de vídeos asociada a la persona
        f.write('<p>Videos de ' + nombre + ':</p>')
        i = 0
        f.write('<ul>')
        for video in videos:
            i = i + 1
            vi = video.text.strip()
            f.write('<li>')
            f.write('<p>Video ' + str(i) + ' de ' + nombre + ':</p>')
            f.write('<video src= "' + vi + '" controls preload="auto"></video>')
            f.write('</li>')
        f.write('</ul>')

    # cerramos la section
    f.write('\n       </section>')

    elePersonaHijos = elePersona.findall('persona')
    i = 0
    for eleHijo in elePersonaHijos:
        i = i + 1
    
    if (i!=0):
        # dentro de cada nodo, se creara una lista con sus amigos
        f.write('<ul>\n')
        for eleHijo in elePersonaHijos:
            f.write('\t<li>\n')
            tratarPersona(eleHijo)
            f.write('\t</li>\n')
        f.write('           </ul>\n')


def main():
    try:
        # vamos a procesar el xml inicial
        arbol = ET.parse('personas.xml')
    except IOError:
        # error
        print ('No se encuentra el archivo ')
        exit()
    except ET.ParseError:
        # error
        print("Error procesando en el archivo XML")
        exit()

    # vamos escribiendo el html
    f.write('<!DOCTYPE HTML>\n')
    f.write('<html lang="es">\n')
    f.write('<head>\n')
    f.write('   <!-- Datos que describen el documento -->\n')
    f.write('   <meta charset="UTF-8" />\n')
    f.write('   <title>AMIGOS DE MIGUEL</title>\n')
    f.write('   <!--Metadatos de los documentos HTML5-->\n')
    f.write('   <meta name="author" content="Miguel Glez" />\n')
    f.write('   <meta name="description" content="Html de personas" />\n')
    f.write('   <meta name="keywords" content="Personas y amigos" />\n')
    f.write('   <!--Definicion de la ventana grafica-->\n')
    f.write('   <meta name ="viewport" content ="width=device-width, initial scale=1.0" />\n')
    f.write('   <link rel="stylesheet" type="text/css" href="estilo.css" />\n')
    f.write('</head>\n')
    f.write('<body>\n')
    f.write('   <header>\n')
    f.write('       <h1>Resumen de los amigos de Miguel</h1>\n')
    f.write('   </header>\n')
    f.write('   <main>\n')
    f.write('       <h2>LISTA DE AMIGOS DE MIGUEL</h2>\n')
    # aqui tratamos cada nodo del arbol, empezando por la raiz
    tratarPersona(arbol.getroot())
    # cerramos las etiquetas y el fichero
    f.write('   </main>\n')
    f.write('   <footer>\n')
    f.write('       <p> AUTOR: MIGUEL GONZALEZ NAVARRO</p>\n')
    f.write('       <p> RESUMEN DE LOS AMIGOS DE MIGUEL</p>\n')
    f.write('   </footer>\n')
    f.write('</body>\n')
    f.write('</html>\n')
    f.close()

if __name__ == '__main__':
     # creamos un html, donde iremos escribiendo el código con el programa
     f = open('index.html', 'w')
     main()
