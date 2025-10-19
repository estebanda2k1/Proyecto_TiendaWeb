// autenticacion correcta con el usuario quemado
// Iniciar sesion y setear las cookies para el recordar usuario
// setear las cookies en caso de recordar, organizar todos lo de las cookies para el if y si esta correcto
//Se puede “quemar” el usuario a test / test123.
// crear la sesion para el carrito

<?php
session_start();

// Poner en variables
$nombre = $_POST['nombre'];
$clave = $_POST['clave'] ;
$recordarme = isset($_POST['chkRecordarme']);


//credenciales quemadas
$usuarioValido = "test";
$claveValida = "test123";


//verificación de campo vacíos
if (empty($_POST['nombre']) || empty($_POST['clave'])) {
    header("Location: index.php?error=vacio");
}


if ($_POST['nombre'] == $usuarioValido && $_POST["clave"] == $claveValida) {
    //creo la sesión
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION["clave"] = $_POST["clave"];

     // Si existe cookie de idioma de sesión anterior, la usamos
    if (isset($_COOKIE['c_lang_pref']) && in_array($_COOKIE['c_lang_pref'], ['es', 'en'])) {
        $lenguajePreferido = $_COOKIE['c_lang_pref'];
    }

    //Cookies
    if ($recordarme) {
        // seteo cookies 
        setcookie('c_nombre', $nombre, 0);
        setcookie('c_clave', $clave, 0);
        setcookie('c_recordarme', $recordarme, 0);

    } else {
        //borro cualquera cookie que exista
        if(isset($_COOKIE)){
            foreach($_COOKIE as $name => $value){
                setcookie($name, '', 1); 
            }
        }
    }

    header("Location: panelPrincipal.php?lang={$lenguajePreferido}");
    

}else {
    header("Location: index.php?error=credenciales");
}

?>
    