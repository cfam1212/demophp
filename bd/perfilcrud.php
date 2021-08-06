<?php

session_start();

require_once("conexion.php");
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$data = null;

$userid = $_SESSION["i_usuaid"];
$host = $_SESSION["s_namehost"];
$empreid = $_SESSION["i_emprcodigo"];

$nombreperfil = (isset($_POST['nombreperfil'])) ? $_POST['nombreperfil'] : '';
$observacion = (isset($_POST['observacion'])) ? $_POST['observacion'] : '';
$result = (isset($_POST['result'])) ? $_POST['result'] : '0';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : 'Activo';
$crear = (isset($_POST['crear'])) ? $_POST['crear'] : 'NO';
$modificar = (isset($_POST['modificar'])) ? $_POST['modificar'] : 'NO';
$eliminar = (isset($_POST['eliminar'])) ? $_POST['eliminar'] : 'NO';
$id = (isset($_POST['id'])) ? $_POST['id'] : '0';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '0';
$valestado = $estado == "Activo" ? true : false;
$valcrear = $crear == "SI" ? true : false;
$valmodificar = $modificar == "SI" ? true : false;
$valeliminar = $eliminar == "SI" ? true : false;

date_default_timezone_set("America/Guayaquil");
$currentdate = date('Y-m-d H:i:s');

switch($opcion){
    case 0: //NUEVO
        $consulta = "CALL sp_New_Perfil(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(array(0,$empreid,0,0,$nombreperfil,$observacion,$valestado,$valcrear,$valmodificar,$valeliminar,$currentdate,
        $userid,$host));
        //$id = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $id = $resultado->fetchColumn();
        foreach($result as $drfila){
            $consulta = "CALL sp_New_Perfil(?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array(1,$empreid,$id,$drfila,"","",false,false,false,false,$currentdate,$userid,$host));
        }
        $data = "OK";
        break;    
    case 1: //GRABAR EDITAR PERFIL
        try
        {
            $consulta = "CALL sp_New_Perfil(?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array(2,$empreid,$id,0,$nombreperfil,$observacion,$valestado,$valcrear,$valmodificar,$valeliminar,
            $currentdate,$userid,$host));
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            if($result != '0'){
                foreach($result as $drfila){
                    $consulta = "CALL sp_New_Perfil(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute(array(1,$empreid,$id,$drfila,'','',false,false,false,false,$currentdate,$userid,$host));
                }
            }
        }catch(Exception $e)
        {
            $data = $e->getMessage();
        }
    break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);

$conexion = null;