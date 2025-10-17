// cargar la base de datos 
// seleccionar idioma
// no olvidarse de los redireccionamientos
<?php
session_start();
require_once __DIR__ . '/DBConnection.php';

// Determine language - default to 'es' (productoses). Allow override via ?lang=es|en
$lang = 'es';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['es','en'])) {
    $lang = $_GET['lang'];
}

// Create DB connection and fetch products
$db = null;
$productsHtml = '';
try {
    $db = new DBConnection();
    $products = $db->fetchProducts($lang);
    $productsHtml = $db->renderProductsTable($products, $lang);
} catch (Exception $e){
    $productsHtml = '<p>Error al cargar productos: ' . htmlspecialchars($e->getMessage()) . '</p>';
} finally {
    if ($db) $db->close();
}
?>

<html>
    <head>
    </head>
    <body>
        <h1>Panel Principal</h1>

        <h3>Bienvenido usuario: <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Invitado'; ?></h3>
        
    <ul>
    <a href="?lang=es">ES (Español)</a> |
    <a href="?lang=en">EN (English)</a>
        <br><br>
        </ul>

        <hr>
        <h2>Productos</h2>
        <?php echo $productsHtml; ?>

        <hr>
        <h2>Opciones</h2>
        <ul>
            <li><a href="carroDeCompra.php">Carrito de compra</a></li>
            <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
        </ul>
        <hr>
    </body>
</html>