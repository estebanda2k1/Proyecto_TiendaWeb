<?php
session_start();
require_once __DIR__ . '/DBConnection.php';

if(!isset($_SESSION["nombre"]) || !isset($_SESSION["clave"])){
    header("Location:index.php");
    exit;
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['cantidad'])) {
    $id = (int)$_POST['product_id'];
    $cantidad = max(1, (int)$_POST['cantidad']); 
    $lang = in_array($_POST['product_lang'], ['es','en']) ? $_POST['product_lang'] : 'es';

    
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$id] = [
            'cantidad' => $cantidad,
            'lang' => $lang
        ];
    }

    header("Location: carroDeCompra.php");
    exit;
}


if (isset($_POST['vaciar_carrito'])) {
    $_SESSION['carrito'] = [];
    header("Location: carroDeCompra.php");
    exit;
}

$productosCarrito = [];
try {
    $db = new DBConnection();
    foreach ($_SESSION['carrito'] as $prodId => $info) {
        $prod = $db->fetchProductById($prodId, $info['lang']);
        if ($prod) {
            $prod['cantidad'] = $info['cantidad'];
            $productosCarrito[] = $prod;
        }
    }
} catch (Exception $e) {
    $error = "Error al cargar el carrito: " . $e->getMessage();
} finally {
    if ($db) $db->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compra</title>
</head>
<body>
    <h1>Carrito de Compra</h1>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (!empty($productosCarrito)): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
            <?php 
            $total = 0;
            foreach ($productosCarrito as $prod):
                $subtotal = $prod['price'] * $prod['cantidad'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($prod['id']); ?></td>
                    <td><?php echo htmlspecialchars($prod['title']); ?></td>
                    <td>$<?php echo number_format($prod['price'], 2); ?></td>
                    <td><?php echo $prod['cantidad']; ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" align="right"><strong>Total:</strong></td>
                <td>$<?php echo number_format($total, 2); ?></td>
            </tr>
        </table>

        <form method="post" style="margin-top:10px;">
            <button type="submit" name="vaciar_carrito">Vaciar carrito</button>
        </form>
    <?php else: ?>
        <p>El carrito está vacío.</p>
    <?php endif; ?>

    <p>
        <a href="panelPrincipal.php">Seguir comprando</a> |
        <a href="cerrarSesion.php">Cerrar sesión</a>
    </p>
</body>
</html>
