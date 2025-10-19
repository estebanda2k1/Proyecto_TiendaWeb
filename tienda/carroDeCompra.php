// mostrar el carrito de la compra con los datos(id, nombre, descripción, precio)

<?php
session_start();

if(!isset($_SESSION["nombre"]) || !isset ($_SESSION["clave"])){
    header("Location:index.php");
}


?>

<!DOCTYPE html>
<html>
<head>  
    <title>Carro de Compra</title>
</head>
<body>
    <h1>Carro de Compra</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
        </tr>
        <?php
        // Aquí se mostrarían los productos del carrito
        ?>
    </table>
</body>
<hr>
        <h2>Opciones</h2>
        <ul>
            <li><a href="panelPrincipal.php">Panel principal</a></li>
            <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
        </ul>
</html>