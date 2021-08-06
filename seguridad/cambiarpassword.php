<?php 

require_once '../dashmenu/panel_menu.php'; 

$consulta = "CALL sp_consulta_datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(0,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div>
    </section>
    <section class="content-fluid">
        <div class="container">
            <br />                
            <div class="row justify-content-center">            
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">                            
                        </div>
                        <div class="card-body">
                            <div class="modal-body">                
                                <div class="form-group row">
                                    <label for="username" class="control-label col-md-2">Nombres:</label>
                                    <input type="text" required class="form-control col-md-4" id="txtUsername" name="username" 
                                    maxlength="80" placeholder="Nombre del Usuario"> 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-outline-primary ml-3" id="btnSave"><i class='fas fa-bookmark"></i>'></i> Guardar</button>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

    <?php require_once '../dashmenu/panel_footer.php'; ?>
    <script src="../codejs/tareas.js" type="text/javascript"></script>

    </body>
</html>