<?php

session_start();

require_once("conexion.php");
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$data = null;

$userid = $_SESSION["i_usuaid"];
$host = $_SESSION["s_namehost"];
$emprecodigo = $_SESSION["i_emprcodigo"];

$opcion = $_POST['opcion'];
$id = $_POST['id'];
$tarea = (isset($_POST['tarea'])) ? $_POST['tarea'] : '';
$ruta = (isset($_POST['ruta'])) ? $_POST['ruta'] : '';
$icono = (isset($_POST['icono'])) ? $_POST['icono'] : '';
$icono = (empty($icono))?'fas fa-user':$icono;
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

if($estado == 'Activo'){
    $nuevoestado = true;
}else $nuevoestado = false;

date_default_timezone_set("America/Guayaquil");
$currentdate = date('Y-m-d H:i:s');

switch($opcion){
    case "0": //NUEVO
        if($id == "0"){
            $consulta = "SELECT COUNT(*) FROM tarea WHERE tare_descripcion=?";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($tarea));
            $data = $resultado->fetchColumn();
            if($data == "0")
            {
                $consulta = "INSERT INTO tarea VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(null,$emprecodigo,$tarea,$ruta,$nuevoestado,0,$icono,'','','',0,0,0,$currentdate,$userid,
                $host,$currentdate,$userid,$host));
        
                $consulta = "SELECT tare_id AS TareaId, tare_descripcion AS Tarea, tare_accioncontroller AS Ruta, 
                            tare_icono AS Icono, CASE tare_estado WHEN 1 THEN 'Activo' ELSE 'Inactivo' END AS Estado FROM tarea 
                            ORDER BY tare_id DESC LIMIT 1";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            }else {
                $data = 'SI';
            }            
        }else{
            $consulta = "UPDATE tarea SET tare_descripcion='$tarea', tare_accioncontroller='$ruta', tare_icono='$icono', 
            tare_estado='$nuevoestado',tare_fum='$currentdate',tare_uum='$userid',tare_tum='$host' WHERE TARE_ID='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();     
            
            $consulta = "SELECT tare_id AS TareaId, tare_descripcion AS Tarea, tare_accioncontroller AS Ruta, 
                        tare_icono AS Icono,CASE tare_estado WHEN 1 THEN 'Activo' ELSE 'Inactivo' END AS Estado FROM tarea WHERE tare_id='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);               
        }
        break;    
    case "1": //ELIMINAR
        //verificar si no existe asociado al menu tarea
        $consulta = "SELECT COUNT(*) FROM menu_tarea WHERE tare_id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchColumn();
        if($data == 0){
            $consulta = "DELETE FROM tarea WHERE tare_id='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();  

            $consulta = "SELECT tare_id AS TareaId, tare_descripcion AS Tarea, tare_accioncontroller AS Ruta, 
                        CASE tare_estado WHEN 1 THEN 'Activo' ELSE 'Inactivo' END AS Estado FROM tarea";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);     
        }else{
            $data = "NO";
        }
        break;
    case "2":
        $consulta = "SELECT COUNT(*) FROM tarea WHERE tare_descripcion=?";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(array($tarea));
        $data = $resultado->fetchColumn();        
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);

$conexion = null;