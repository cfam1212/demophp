<?php 

require_once '../dashmenu/panel_menu.php'; 

$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : '';

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(0,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(2,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$menump = $resultado->fetchAll(PDO::FETCH_ASSOC);

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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">                 
                            <form class="form-horizontal" role="form">      
                                <fieldset>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="menuname" class="control-label">Menu</label>
                                            <input type="text" required class="form-control" id="txtmenuname" name="menuname" placeholder="Nombre del Menu">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="iconome" class="control-label">Icono Menú</label>
                                            <input id="txticonome" name="iconome" type="text" placeholder="ej:. fas fa-user" class="form-control">
                                        </div>   
                                    </div>             

                                    <div class="form-group col-md-6"> 
                                        <label for="cbomenupadre" class="control-label">Menu Padre</label>
                                        <select class="form-control" id="cbomenupadre" name="cbomenupadre">
                                                <?php foreach($menump as $fila): ?>
                                                    <option value="<?=$fila['Codigo']?>"><?=$fila['MenuPadre']?></option>
                                                <?php endforeach ?>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4" id="divmp" style="display:none">
                                            <label for="menump" class="control-label">Nombre Menú Padre:</label>
                                            <input id="txtmenump" name="menump" type="text" placeholder="Menú Padre" 
                                                class="form-control">
                                        </div>

                                        <div class="form-group col-md-4" id="divip" style="display:none">
                                            <label for="iconomp" class="control-label">Icono Menú Padre:</label>
                                            <input id="txtsiconomp" name="iconomp" type="text" placeholder="ej.: fas fa-user" 
                                                class="form-control">
                                        </div>              
                                    </div>

                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="tabledata" class="table table-striped table-border table-condensed" style="width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Seleccionar</th>
                                        <th>Tarea</th>
                                        <th>Ruta</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>                        
                                <tbody>
                                    <?php
                                    foreach($data as $dat){
                                    ?>
                                    <tr>
                                        <td><?php echo $dat['TareaId']; ?></td>
                                        <td style="text-align: center">
                                            <input type="checkbox" id="recs" name="check[]" value="<?php echo $dat['TareaId'];?>"/>
                                        </td>                              
                                        <td><?php echo $dat['Tarea']; ?></td>
                                        <td><?php echo $dat['Ruta']; ?></td>
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
                <button class="btn btn-outline-secondary" id = "btnRegresar" ><i class='fas fa-undo'></i> Regresar</button>
                <button class="btn btn-outline-primary ml-3" id="btnSave"><i class='fas fa-bookmark'></i> Guardar</button>
            </div>
        </div>
    </section>
</div>

<?php require_once '../dashmenu/panel_footer.php'; ?>
<script src="../codejs/menu.js" type="text/javascript"></script>
<script src="../vendor/plugins/select2/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#cbomenupadre').select2();
    });

    $(document).ready(function() {        
		$("#cbomenupadre").change(function(){
            $('#menump').val('');
            $opcionmp = $.trim($("#cbomenupadre").val());
            document.getElementById("divmp").style.display= "none";
            document.getElementById("divip").style.display= "none";
            if($opcionmp == 2){
                document.getElementById("divmp").style.display= "block";
                document.getElementById("divip").style.display= "block";
            }
		});  
    });

</script>

</body>

</html>