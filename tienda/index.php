<?php
    $nombre= $clave= "";
    $preferencias = false;
    if (isset($_COOKIE["c_recordarme"])&& $_COOKIE["c_recordarme"]){
        $preferencias = true;
        $nombre = $_COOKIE["c_nombre"];
        $clave = $_COOKIE["c_clave"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN</title>
</head>
<body>
    <h1>Login</h1>
    <form action="acceso.php" method="POST">
        <fieldset>
            Usuario* <br>
            <input type="text" name="nombre" value="<?php echo $nombre; ?>" id="" required><br>
            Clave*:<br>
            <input type="password" name="clave" value="<?php echo $clave; ?>" id="" required/><br><br>
            <input type="checkbox" name="chkRecordarme"<?php echo ($preferencias)?"checked":"";?>>Recordarme
            <br>
            <br>    
            <input type="submit" value="Ingresar">
        </fieldset>
    </form>
</body>
</html>
