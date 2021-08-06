<?php 

require_once '../dashmenu/panel_menu.php'; 

$idperfil = (isset($_POST['idperfil'])) ? $_POST['idperfil'] : '0';

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(16,$_SESSION["i_emprcodigo"],'','','','','','',$idperfil,0,0,0,0,0));
$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(13,$_SESSION["i_emprcodigo"],'','','','','','',$idperfil,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <section class="content-fluid">
        <div class="container">
            <br />
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">                         
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>     
                        </div>                   
                        <div class="card-body">
                            <form class="form-horizontal" role="form">      
                                <div class="form-group row">
                                    <label for="perfilname" class="control-label col-md-2">Perfi:</label>
                                    <input type="text" required class="form-control col-md-4" id="txtPerfil" name="perfilname" maxlength="80" placeholder="Nombre del Perfil" value="<?php echo $datos[0]['Perfil'] ?>">                    
                                    <label for="descrip" class="control-label col-md-2">Descripción:</label>
                                    <textarea name="descrip" id="txtDescripcion" class="form-control col-md-4" maxlength="255" onkeydown = "return (event.keyCode!=13);"><?php echo $datos[0]['Observacion'] ?></textarea>                          
                                </div>
                                <div class="form-group row">
                                    <label for="chkcrear" class="control-label col-md-2">Crear Parámetro:</label>
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkCrear"></input>
                                        <label class="form-check-label" id="lblCrear"><?php echo $datos[0]['Crear'] ?></label>
                                    </div>   
                                    <label for="chkmodificar" class="control-label col-md-2">Modificar Parámetro:</label> 
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkModificar"></input>
                                        <label class="form-check-label" id="lblModificar"><?php echo $datos[0]['Modificar'] ?></label>
                                    </div>                
                                </div>
                                <div class="form-group row">
                                    <label for="chkeliminar" class="control-label col-md-2">Eliminar Parámetro:</label>
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkEliminar"></input>
                                        <label class="form-check-label" id="lblEliminar"><?php echo $datos[0]['Eliminar'] ?></label>
                                    </div>
                                    <label for="chkestado" class="control-label col-md-2">Estado:</label>
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkEstado" checked></input>
                                        <label class="form-check-label" id="lblEstado"><?php echo $datos[0]['Estado'] ?></label>
                                    </div>
                                    <div class="form-group col-md-2" style="display:none">
                                        <input id="idPerfil" name="perfid" type="text" class="form-control" value="<?php echo $idperfil ?>">
                                    </div>                                       
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="container">
            <br />
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">  
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">              
                            <table id="tabledata" class="table table-striped table-border table-condensed" style="width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Seleccionar</th>
                                        <th>Menú</th>
                                        <th>Tarea</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>                        
                                <tbody>
                                    <?php
                                    foreach($data as $dat){
                                    ?>
                                    <tr>
                                        <td><?php echo $dat['MentId']; ?></td>
                                        <td style="text-align: center">
                                            <input type="checkbox" id="recs" name="check[]" <?php if ($dat['Ckeck'] == 'SI') {echo "checked='checked'"; } ?> value="<?php echo $dat['MentId'];?>"/>
                                        </td>                              
                                        <td><?php echo $dat['Menu']; ?></td>
                                        <td><?php echo $dat['Tarea']; ?></td>
                                        <td><?php echo $dat['Estado']; ?></td>
                                    </tr>
                                    <?php } ?>         
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class='btn-group'>
                <button class="btn btn-outline-secondary" id = "btnRegresar" ><i class='fas fa-undo'></i> Regresar
                </button>
                <button class="btn btn-outline-primary ml-3" id="btnSave"><i class='fas fa-bookmark'></i> Guardar
                </button>
            </div>
        </div>                 
    </section>
</div>

<?php require_once '../dashmenu/panel_footer.php'; ?>
<script src="../codejs/perfiledit.js" type="text/javascript"></script>

</body>

</html>