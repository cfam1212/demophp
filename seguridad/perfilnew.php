<?php 

require_once '../dashmenu/panel_menu.php'; 

$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : '';

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(13,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<input type="hidden" id="mensaje" value="<?php echo $mensaje ?>"></input>
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
                            <h5>Nuevo Perfil</h5>    
                        </div>                   
                        <div class="card-body">
                            <form class="form-horizontal" role="form">      
                                <div class="form-group row">
                                    <label for="perfilname" class="control-label col-md-2">Perfi:</label>
                                    <input type="text" required class="form-control col-md-4" id="txtPerfil" name="perfilname" maxlength="80" placeholder="Nombre del Perfil">                    
                                    <label for="descrip" class="control-label col-md-2">Descripción:</label>
                                    <textarea name="descrip" id="txtDescripcion" class="form-control col-md-4" maxlength="255" onkeydown = "return (event.keyCode!=13);"></textarea>                          
                                </div>

                                <div class="form-group row">
                                    <label for="chkcrear" class="control-label col-md-2">Crear Parámetro:</label>
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkCrear"></input>
                                        <label class="form-check-label" id="lblCrear">NO</label>
                                    </div>   
                                    <label for="chkmodificar" class="control-label col-md-2">Modificar Parámetro:</label> 
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkModificar"></input>
                                        <label class="form-check-label" id="lblModificar">NO</label>
                                    </div>                
                                </div>

                                <div class="form-group row">
                                    <label for="chkeliminar" class="control-label col-md-2">Eliminar Parámetro:</label>
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkEliminar"></input>
                                        <label class="form-check-label" id="lblEliminar">NO</label>
                                    </div>
                                    <label for="chkestado" class="control-label col-md-2">Estado:</label>
                                    <div class="checkbox col-md-4">
                                        <input type="checkbox" id="chkEstado" checked disabled></input>
                                        <label class="form-check-label" id="lblEstado">Activo</label>
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
                            <h5>Opciones Menú</h5> 
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
                                            <input type="checkbox" id="recs" name="check[]" value="<?php echo $dat['MentId'];?>"/>
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
<script src="../codejs/perfil.js" type="text/javascript"></script>

</body>

</html>