// cargar la base de datos 
// seleccionar idioma
// no olvidarse de los redireccionamientos
<html>
    <head>
    </head>
    <body>
        <h1>Panel Principal</h1>

        <h3>Bienvenido usuario: <?php  echo $_SESSION["nombre"]  ?></h3>
        
        <ul>
        <a href="panel.php?lang=es">ES (Español)</a> |
        <a href="panel.php?lang=en">EN (English)</a>
        <br><br>
        </ul>

        <hr>
        <h2>Opciones</h2>
        <ul>
            <li><a href="carroDeCompra.php">Carrito de compra</a></li>
            <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
        </ul>
        <hr>
    </body>
</html>