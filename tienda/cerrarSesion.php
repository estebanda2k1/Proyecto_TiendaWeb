<?php
session_start();


$_SESSION = array(); 
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

setcookie('selected_product_id', '', 1, '/');

if(isset($_COOKIE)){
    foreach($_COOKIE as $name => $value){
        if (in_array($name, ['c_nombre', 'c_clave', 'c_recordarme', 'c_lang_pref', 'selected_product_id'])) {
            continue; // Saltar la destrucción de estas cookies
        }
        setcookie($name, '', 1); 
    }
}

header("Location: index.php");

?>