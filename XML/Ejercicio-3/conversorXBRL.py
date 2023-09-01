import xml.etree.ElementTree as ET

"""
Procesamiento de un XBRL para generar un CSV e imprimir por pantalla
"""

def tratarDatos(raiz):
    print('INFORME DE REVISION DE EROSKI')
    indice = 0
    sumaPeriodoActual = 0
    sumaCierreAnterior = 0
    valorPeriodoActual = 0
    sumaDif = 0
    for i in raiz:
        if (indice==0):
            indice = indice + 1
        elif (indice==1):
            print(i.text)
            indice = indice + 1
        else: 
            if (indice%2==0):
                # recogemos el valor del periodo actual, lo parseamos a int y lo sumamos al acumulador, imprimimos por pantalla
                valorPeriodoActual = int(float(i.text))
                sumaPeriodoActual = sumaPeriodoActual + valorPeriodoActual
                print('Valor periodo actual ' + str(indice-1) + ' = ' + i.text)
            else:
                # vamos acumulando la resta entre el valor del periodo actual y el valor del periodo de cierre anterior
                sumaDif = sumaDif + valorPeriodoActual - int(float(i.text))
                # recogemos el valor del periodo de cierre anterior, lo parseamos a int y lo sumamos al acumulador, imprimimos por pantalla y escribimos en el fichero
                f.write(str(valorPeriodoActual) + ';' + i.text + ';' + str(valorPeriodoActual - int(float(i.text))) + '\n')
                sumaCierreAnterior = sumaCierreAnterior + int(float(i.text))
                print('Valor cierre anterior ' + str(indice-1) + ' = ' + i.text)
            indice = indice + 1
    # imprimimos las sumas de los valores, la media de perdida y el balance total en las monedas más conocidas del mundo
    print('SUMA TOTAL DE PERIODO ACTUAL: ' + str(sumaPeriodoActual))
    print('SUMA TOTAL DE CIERRE ANTERIOR: ' + str(sumaCierreAnterior))
    dif = sumaPeriodoActual - sumaCierreAnterior
    print('MEDIA PERDIDA BALANCE POR Icur/Ipre: ' + str(int(sumaDif/25)))
    # euros
    print('BALANCE TOTAL (EUR) = ' + str(dif))
    # dolares
    print('BALANCE TOTAL (USD) = ' + str(int(0.99*dif)))
    # franco suizo
    print('BALANCE TOTAL (CHF) = ' + str(int(0.99*dif)))
    # yen japones
    print('BALANCE TOTAL (JPY) = ' + str(int(145.78*dif)))
    # libras esterlinas
    print('BALANCE TOTAL (GBP) = ' + str(int(0.88*dif))) 
    
def main():
    try:
        # procesamos el xbrl inicial
        arbol = ET.parse('periodos.xbrl')
    except IOError:
        # error
        print ('No se encuentra el archivo ')
        exit()
    except ET.ParseError:
        # error
        print("Error procesando en el archivo XBRL")
        exit()
    
    # escribimos la cabecera del fichero csv, donde se van a ir almacenando todos los datos a medida que recorremos las etiquetas
    f.write('BALANCE MIEMBRO\n')
    f.write('Periodo actual; Periodo cierre anterior; Diferencia\n')
    # tratamos todas las etiquetas, y recogemos el balance total
    tratarDatos(arbol.getroot()) 
    # cerramos el fichero
    f.close()

if __name__ == '__main__':
     # abrimos el csv, donde vamos a ir escribiendo los datos
     f = open('resultados.csv', 'w')
     main()