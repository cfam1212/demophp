<?php 

require_once '../dashmenu/panel_menu.php'; 

$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : '';
$menuid = (isset($_POST['id'])) ? $_POST['id'] : '';

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(5,$_SESSION["i_emprcodigo"],'','','','','','',$menuid,0,0,0,0,0));
$datamenu = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(4,$_SESSION["i_emprcodigo"],'','','','','','',$menuid,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(2,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$menump = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content-wrapper">
    <input type="hidden" id="mensaje" value="<?php echo $mensaje ?>">
    <input type="hidden" id="menuid" value="<?php echo $menuid ?>">
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
                            <h5>Nuevo Menu</h5>    
                        </div>                      
                        <div class="card-body">                 
                            <form class="form-horizontal" role="form">      
                                <div class="form-group row">
                                    <label for="menuname" class="control-label col-md-2">Menu:</label>
                                    <input type="text" name="menuname" id="txtMenuname" required class="form-control col-md-4" 
                                    placeholder="Nombre del Menu" value="<?php echo $datamenu[0]['Menu'] ?>"></input>
                                    <label for="iconome" class="control-label col-md-2">Icono Menú:</label>
                                    <input type="text" name="iconome" id="txtIconome" class="form-control col-md-4" placeholder="ej:. fas fa-user" 
                                    value="<?php echo $datamenu[0]['Icono'] ?>"></input>
                                </div>

                                <div class="form-group row">
                                    <label for="cbomenupadre" class="control-label col-md-2">Menu Padre:</label>
                                    <select name="cbomenupadre" id="cboMenupadre" class="form-control col-md-4">
                                        <?php foreach($menump as $fila): ?>
                                            <option <?php if($datamenu[0]['CodMenuPadre'] == $fila['Codigo']) { ?> selected="<?php echo $fila['Codigo']; ?>" <?php } ?> 
                                            value="<?=$fila['Codigo']?>"><?=$fila['MenuPadre']?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="estado" class="control-label col-md-2">Estado:</label>
                                    <div class="form-check col-md-4" id="divcheck">                        
                                        <input type="checkbox" class="form-check-input" id="chkEstado">
                                        <label for="estadolabel" class="form-check-label" id="lblEstado"><?php echo $datamenu[0]['Estado'] ?></label>
                                    </div>                                    
                                </div>

                                <div id="divmp" class="form-group row" style="display:none">
                                    <label for="menump" class="control-label col-md-2">Nombre Menú Padre:</label>
                                    <input type="text" name="menump" id="txtMenump" class="form-control col-md-4" placeholder="Menú Padre">
                                    <label for="iconomp" class="control-label col-md-2">Icono Menú Padre:</label>
                                    <input type="text" name="iconomp" id="txtIconomp" class="form-control col-md-4" placeholder="ej.: fas fa-user"
                                    value="<?php echo $datamenu[0]['IconoPadre']; ?>">
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
                            <h5>Opciones Menú/Tarea</h5> 
                        </div>                    
                        <div class="card-body">
                            <table id="tableconorder" class="table table-striped table-border table-condensed" style="width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Check</th>
                                        <th>Seleccionar</th>
                                        <th>Tarea</th>
                                        <th>Ruta</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>                        
                                <tbody>
                                    <?php
                                    foreach($data as $dat){
                                    ?>
                                    <tr>
                                        <td><?php echo $dat['TareaId']; ?></td>
                                        <td><?php echo $dat['Ckeck']; ?></td>                                       
                                        <td style="text-align: center">
                                            <input type="checkbox" id="chkTarea" name="check[]" <?php if ($dat['Ckeck'] == 'SI') {echo "checked='checked'"; } ?>
                                            value="<?php echo $dat['TareaId'];?>"/>
                                        </td>                              
                                        <td><?php echo $dat['Tarea']; ?></td>
                                        <td><?php echo $dat['Ruta']; ?></td>
                                        <td><?php echo $dat['Estado']; ?></td>
                                        <td></td>
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
                <button class="btn btn-outline-secondary" id = "btnRegresar" ><i class='fas fa-undo'></i> Regresar</button>
                <button class="btn btn-outline-primary ml-3" id="btnSave"><i class='fas fa-bookmark'></i> Guardar</button>
            </div>
        </div>
    </section>
</div>

<?php require_once '../dashmenu/panel_footer.php'; ?>
<script src="../codejs/menuedit.js" type="text/javascript"></script>
<script src="../vendor/plugins/select2/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#cboMenupadre').select2();
    });

    $(document).ready(function() {        
		$("#cboMenupadre").change(function(){
            $('#menump').val('');
            $opcionmp = $.trim($("#cboMenupadre").val());
            document.getElementById("divmp").style.display= "none";
            if($opcionmp == 2){
                document.getElementById("divmp").style.display= "";
            }
		});  
    });

</script>

</body>

</html>