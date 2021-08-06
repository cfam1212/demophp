<?php 

require_once '../dashmenu/panel_menu.php'; 

$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : '';

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(11,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<input type="hidden" id="mensaje" value="<?php echo $mensaje ?>">

<div class="content-wrapper">
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
                            <button type="button" class="btn btn-outline-primary" id="btnNuevo" style="margin-bottom:10px"><i class="fas fa-plus"></i> Nuevo
                            </button>                            
                        </div>
                        <div class="card-body">                 
                            <table id="tabledata" class="table table-striped table-border table-condensed" style="width: 100%;">
                                <thead>
                                    <tr>                            
                                        <th>Id</th>
                                        <th>Perfil</th>
                                        <th>Descipción</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>                        
                                <tbody>
                                    <?php
                                        if(count($data) == 1){
                                            $disablesub = 'disabled="disabled"';
                                        }else{
                                            $disablesub = '';
                                        }                                        
                                    foreach($data as $datos){
                                    ?>
                                        <?php

                                            if($datos['PerfilId']=='1'){
                                                $disabledel = 'disabled="disabled"';
                                            }else{
                                                $disabledel = '';
                                            }                                            
                                        ?>                                        
                                    <tr>
                                        <td><?php echo $datos['PerfilId'] ?></td>
                                        <td><?php echo $datos['Perfil'] ?></td>
                                        <td><?php echo $datos['Descripcion'] ?></td>
                                        <td><?php echo $datos['Estado'] ?></td>
                                        <td>
                                            <div class="text-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-outline-info btn-sm ml-3" id="btnEditar">
                                                    <i class="fas fa-file"></i></button>
                                                    <button class="btn btn-outline-danger btn-sm ml-3" <?php echo $disabledel ?> id="btnEliminar">
                                                    <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>                                                                                                     
                                        </td>
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
<script src="../codejs/perfil.js" type="text/javascript"></script>

</body>

</html>