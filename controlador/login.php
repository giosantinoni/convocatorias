<?php


include_once 'conex.php';

if (isset($_POST["fUsuario"]) and isset($_POST["fClave"])) {
    $usuario = $_POST["fUsuario"];
    $clave = $_POST["fClave"];         
    
	$clave = md5($clave);
	echo $clave;
  
    try {
        $conn = conex::con();
        $sql= $conn->prepare('SELECT * FROM usuario WHERE username = :user AND pass = :pass');
        $sql->execute(array('user' => $usuario, 'pass' => $clave));
        $resultado = $sql->fetchAll();
       
        foreach ($resultado as $fila) {            
            session_start();
            $_SESSION["s_usuario_id"] = $fila["id"];
            $_SESSION["s_usuario"] = $fila["username"];
            $_SESSION["s_nombreusuario"] = $fila["nombre"];
            $_SESSION["s_apellidousuario"] = $fila["apellido"];   
             $_SESSION["s_organismo"] = $fila["id_organismo"];           
            $_SESSION["autentificado"] = "SI";
            $_SESSION["ultimoAcceso"] = date("Y-n-j H:i:s");            
            header("Location: ../vistas/consultar.php");
        }
        $mje = base64_encode("Por favor, introduzca un usuario y contraseña válido.");
        header("Location: ../form_login.php?mje=$mje");
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}
?>