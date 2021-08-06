<?php

session_start();

$_SESSION["s_usuario"] = null;
$_SESSION["i_usuaid"] = null;
$_SESSION["i_emprcodigo"] = null;
$_SESSION["s_logoempresa"] = null;
$_SESSION["s_namehost"] = gethostname();

include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//recepción de datos enviados mediante POST desde ajax
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';

$pass = md5($password); //encripto la clave enviada por el usuario para compararla con la clava encriptada y almacenada en la BD

$consulta = "SELECT usua_id,usua_nombres,usua_apellidos,usua_imagepath,empr_id
                FROM usuarios WHERE usua_login='$usuario' AND usua_password='$pass' AND usua_estado=TRUE ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if($resultado->rowCount() > 0){
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION["s_usuario"] = $data[0]['usua_nombres'] . ' ' .  $data[0]['usua_apellidos'];
    $_SESSION["i_usuaid"] = $data[0]['usua_id'];
    $_SESSION["i_emprcodigo"] = $data[0]['empr_id'];

    if($data[0]["usua_imagepath"] != ''){
        $_SESSION["s_foto"] = "../images/" . $data[0]['usua_imagepath'];
    }else{
        $_SESSION["s_foto"] = "../images/sin-user.png";
    }     

    $consulta = "SELECT empr_logomenu FROM empresa_datos WHERE empr_id=?";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute(array($_SESSION["i_emprcodigo"]));
    
    if($resultado->rowCount() > 0)
    {
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        if($data[0]["empr_logomenu"] != ''){
            $_SESSION["s_logoempresa"] = "../images/" . $data[0]["empr_logomenu"];
        }else{
            $_SESSION["s_logoempresa"] = "../images/logobbp.png";
        }
    }
    else{
        $_SESSION["s_logoempresa"] = "../images/logobbp.png";
    }
}else{
    $_SESSION["s_usuario"] = null;
    $_SESSION["i_usuaid"] = null;
    $_SESSION["s_foto"] = null;
    $data = null;
}

print json_encode($data);
$conexion = null;