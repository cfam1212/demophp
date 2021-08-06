<?php 

require_once '../dashmenu/panel_menu.php'; 

$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : '';

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(1,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <input type="hidden" id="mensaje" value="<?php echo $mensaje ?>">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
            </div>
        </div>
    </section>
    <section class="content-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">                            
                            <button type="button" class="btn btn-outline-primary" id="btnNuevo" style="margin-bottom:10px"><i class="fas fa-plus"></i> Nuevo</button>
                        </div>
                        <div class="card-body">                 
                            <table id="tablenoorder" class="table table-striped table-border table-condensed" style="width: 100%;">
                                <thead>
                                    <tr>                            
                                        <th>Id</th>
                                        <th>Menu</th>
                                        <th>Icono</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>                        
                                <tbody>
                                    <?php
                                        if(count($data) == 0){
                                            $disablesub = 'disabled="disabled"';
                                        }else{
                                            $disablesub = '';
                                        }                                        
                                    foreach($data as $datos){
                                    ?>
                                        <?php

                                            if($datos['MenuId']=='200001'){
                                                $disabledel = 'disabled="disabled"';
                                            }else{
                                                $disabledel = '';
                                            }                                            
                                        ?>                                        
                                    <tr>
                                        <td><?php echo $datos['MenuId'] ?></td>
                                        <td><?php echo $datos['Menu'] ?></td>
                                        <td><?php echo $datos['Icono'] ?></td>
                                        <td><?php echo $datos['Estado'] ?></td>
                                        <td></td>
                                    </tr>
                                    <?php }
                                    ?>                          
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            </div>   
        </div>
    </section>
</div>

<?php require_once '../dashmenu/panel_footer.php'; ?>
<script src="../codejs/menu.js" type="text/javascript"></script>

</body>

</html>