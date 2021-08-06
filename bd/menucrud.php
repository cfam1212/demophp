<?php

session_start();

require_once("conexion.php");
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$data = null;

$userid = $_SESSION["i_usuaid"];
$host = $_SESSION["s_namehost"];
$emprecodigo = $_SESSION["i_emprcodigo"];

$nombremenu = (isset($_POST['nombremenu'])) ? $_POST['nombremenu'] : '';
$iconome = (isset($_POST['iconome'])) ? $_POST['iconome'] : '';
$iconome = (empty($iconome)) ? 'fas fa-asterisk' : $iconome;
$opcionmp = (isset($_POST['opcionmp'])) ? $_POST['opcionmp'] : '';
$menupadre = (isset($_POST['menupadre'])) ? $_POST['menupadre'] : '';
$iconomp = (isset($_POST['iconomp'])) ? $_POST['iconomp'] : '';
$iconomp = (empty($iconomp)) ? 'fas fa-book' : $iconomp;
$result = (isset($_POST['result'])) ? $_POST['result'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$valestado = $estado == "Activo" ? true : false;

date_default_timezone_set("America/Guayaquil");
$currentdate = date('Y-m-d H:i:s');

switch($opcion){
    case "0": //NUEVO
        if($opcionmp == 2){
            $consulta = "SELECT COUNT(1) FROM menu_padre WHERE UPPER(mepa_descripcion)=? AND empr_id=?";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array(strtoupper($menupadre),$emprecodigo));
            $data = $resultado->fetchColumn();
        }else{
            $data = 0;
        }
        if($data == 0){
            $consulta = "SELECT COUNT(1) FROM menu WHERE UPPER(menu_descripcion)=? AND empr_id=?";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array(strtoupper($nombremenu),$emprecodigo));
            $data = $resultado->fetchColumn();
            if($data == 0){
                if($opcionmp == 2){
                    $consulta = "INSERT INTO menu_padre VALUES(?,?,?,?)";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute(array(null,$emprecodigo,$menupadre,$iconomp));
                    $opcionmp = $conexion->lastInsertId();
                }elseif($opcionmp == 1){
                    $opcionmp = -1;
                }
                $consulta = "SELECT MAX(menu_orden ) FROM menu WHERE empr_id='$emprecodigo'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $ordenmenu = $resultado->fetchColumn()+1;                
                $consulta = "INSERT INTO menu VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(null,$emprecodigo,$opcionmp,$nombremenu,0,true,$ordenmenu,$iconome,'','','',0,0,0,$currentdate,$userid,$host,
                    $currentdate,$userid,$host));
                $menuid = $conexion->lastInsertId();
                $ordenmt = 0;
                foreach($result as $drfila){
                    $consulta = "INSERT INTO menu_tarea VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute(array(null,$menuid,$drfila,$emprecodigo,true,$ordenmt,'','','',0,0,0,$currentdate,$userid,$host,
                    $currentdate,$userid,$host));
                    $ordenmt++;
                }
            } 
        }
        break;    
    case "1": //ELIMINAR
        $consulta = "SELECT COUNT(1) FROM menu_tarea WHERE menu_id='$id' AND empr_id='$emprecodigo'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchColumn();
        if($data == 0){
            $consulta = "DELETE FROM menu WHERE menu_id='$id' AND empr_id='$emprecodigo'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();  

            $consulta = "SELECT menu_id AS MenuId, menu_descripcion AS Menu, CASE menu_estado WHEN 1 THEN 'Activo' ELSE 'Inactivo' END AS Estado 
                        menu_icono AS Icono WHERE empr_id='$emprecodigo' FROM menu ORDER BY menu_orden";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $data = "NO";
        }
        break;
    case "2": // ORDER MENU
        $consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(array(3,$emprecodigo,'','','','','','',$id,0,0,0,0,0));

        $consulta = "SELECT menu_id AS MenuId, menu_descripcion AS Menu, menu_icono AS Icono, CASE menu_estado WHEN 1 THEN 'Activo' ELSE 'Inactivo' END AS Estado FROM menu ORDER BY menu_orden";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);          
    break;
    case "3": //GRABAR EDITAR MENU
        try
        {
            $consulta = "UPDATE menu SET menu_descripcion=?,menu_estado=?,menu_icono=?,menu_fum=?,menu_uum=?,menu_tum=? 
                        WHERE menu_id=? AND empr_id=?";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($nombremenu,$valestado,$iconome,$currentdate,$userid,$host,$id,$emprecodigo));
            // $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            if($opcionmp == 1)
            {
                $consulta = "UPDATE menu SET mepa_id=-1 WHERE MENU_ID='$id'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            } 
            elseif($opcionmp > 2){
                $consulta = "UPDATE menu SET mepa_id='$opcion' WHERE MENU_ID='$id'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            }else if($opcionmp == 2){
                $consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(9,$emprecodigo,'',$menupadre,$iconomp,'','','',$id,0,0,0,0,0)); 
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);                 
            }
            foreach($result as $drfila){
                $consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array(10,$emprecodigo,'',$host,$drfila['check'],'','','',$id,$drfila['tareaid'],$userid,0,0,0)); 
                // $data = $resultado->fetchAll(PDO::FETCH_ASSOC);                  
            }  
        }catch(Exception $e)
        {
            //echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            $data = $e->getMessage();
        }
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);

$conexion = null;