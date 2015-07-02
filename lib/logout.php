<?php
// Inicializar la sesion.
// Si esta usando session_name("algo"), ¡no lo olvide ahora!
session_start();

include('tools.php');
insertLog(htmlentities($_SESSION['id_user']), 2);

// Destruir todas las variables de sesion.
$_SESSION = array();



// Para destruir la sesi—n completamente, se borra tambiŽn la cookie de sesi—n.
// Nota: ÁEsto destruir‡ la sesi—n, y no la informaci—n de la sesi—n!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesi—n.
session_destroy();
header('Location: ../login.php');
?>