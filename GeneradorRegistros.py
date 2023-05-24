import random


def generarNombre():
    nombres = ['Peluche', 'Correa', 'Harnes', 'Comida', 'Tazon para Comida', 'Shampoo', 'Jabon',
               'Desinfectante', 'Placas', 'Zapatos para perro', 'Disfras', 'Suplemento alimenticio', 'Cama', 'Juguete chillon',
               'Cobija', 'Premios para perro', 'Silla de ruedas']
    return nombres[random.randint(0, len(nombres)-1)]


def generarImg():
    nombres = "perroMot.png"
    return nombres


def generarNumero():
    precio = ['294.177', '563.377', '758.652', '1497.343', '864.088', '2236.788', '2344.561', '2581.171', '143.607', '2770.578', '964.889',
              '301.653', '2063.77', '644.647', '1145.605', '1618.717', '2894.724', '953.465', '1453.294', '2385.269', '1080.181', '1423.923',
              '641.975', '2814.984', '1114.304', '1525.084', '2184.18', '813.068', '2492.622', '2173.94', '2383.457', '2798.136', '2374.305',
              '2453.483', '724.789', '1251.453', '1791.816', '1625.249', '776.039', '2777.616', '1683.475', '2247.412', '485.947', '2400.394',
              '2827.098', '117.988', '2162.238', '2691.838', '2343.947', '2734.695', '1470.814', '2392.106', '2997.84', '1034.037', '1718.896']
    return precio[random.randint(0, len(precio)-1)]


# Generamos todos los registros que deseamos
# Registros con los campos (Nombre,precio,Imagen)
archivo = open('InsertarRegistros2.sql', 'w')
for i in range(1000):
    archivo.write("INSERT INTO productos (Id,Nombre,Precio,Imagen)  values(" "NULL,'" + generarNombre() + "','" +
                  generarNumero() + "','" + generarImg() + "');\n")
archivo.close()
