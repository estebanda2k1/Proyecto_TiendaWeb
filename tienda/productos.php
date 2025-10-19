<?php
// productos.php - muestra detalle de producto y botón para agregar al carrito
session_start();
require_once __DIR__ . '/DBConnection.php';

if(!isset($_SESSION["nombre"]) || !isset ($_SESSION["clave"])){
    header("Location:index.php");
}


// Obtener id y lang desde GET o cookie, en caso que querer usar POST cambiarlo
$id = 0;
$lang = 'es';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['es','en'])) {
	$lang = $_GET['lang'];
}
// If id provided via GET, use it and set cookie; otherwise try cookie
if (isset($_GET['id']) && (int)$_GET['id'] > 0){
	$id = (int)$_GET['id'];
	// Set cookie for 1 day
	setcookie('selected_product_id', $id, time() + 86400, '/');
} elseif (isset($_COOKIE['selected_product_id'])) {
	$id = (int)$_COOKIE['selected_product_id'];
}


// Conectar base de datos y obtener producto
$db = null;
$product = null;
$error = '';
try {
	$db = new DBConnection();
	if ($id > 0){
		$product = $db->fetchProductById($id, $lang);
		if (!$product) $error = 'Producto no encontrado.';
	} else {
		$error = 'No hay producto seleccionado. Selecciona uno en el panel.';
	}
} catch (Exception $e){
	$error = 'Error al consultar el producto: ' . $e->getMessage();
} finally {
	if ($db) $db->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<title>Detalle del producto</title>
</head>
<body>
	<h1>Detalle del producto</h1>

	<?php if ($error): ?>
		<p style="color: red"><?php echo htmlspecialchars($error); ?></p>
		<p><a href="panelPrincipal.php">Volver al panel</a></p>
	<?php else: ?>
		<h2><?php echo htmlspecialchars($product['title']); ?></h2>
		<p><strong>ID:</strong> <?php echo htmlspecialchars($product['id']); ?></p>
		<p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
		<p><strong>Precio:</strong> $<?php echo number_format((float)$product['price'], 2); ?></p>

		<!-- Formulario para agregar al carrito -->
		<form action="carroDeCompra.php" method="post">
			<input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
			<input type="hidden" name="product_lang" value="<?php echo htmlspecialchars($lang); ?>">
			<label for="qty">Cantidad:</label>
			<input type="number" id="qty" name="cantidad" value="1" min="1">
			<button type="submit">Agregar al carrito</button>
		</form>

		<hr>
		<p>
			<a href="carroDeCompra.php">Ir al carrito de compras</a> |
			<a href="cerrarSesion.php">Cerrar sesión</a> |
			<a href="panelPrincipal.php">Volver al panel</a>
		</p>
	<?php endif; ?>

</body>
</html>