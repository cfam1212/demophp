<?php 

require_once '../dashmenu/panel_menu.php';
$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : '';

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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="register_form">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Parámetros</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Detalle</a>
                                    </div>
                                </nav>
                                <br><br>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label>Parámetro</label>
                                                    <input type="text" name="parametro" id="txtParametro" class="form-control col-md-6" maxlength="80"/>
                                                    <span id="error_parametro" class="text-danger"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Descripción</label>
                                                    <textarea name="descrip" id="txtDescripcion" class="form-control" maxlength="255" onkeydown = "return (event.keyCode!=13);"></textarea>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div align="right" style="margin-bottom:5px;">
                                                    <button type="button" class="btn btn-outline-secondary" id="btnAdd"><i class='fas fa-plus'></i> Agregar</button>
                                                </div>
                                                <br />
                                                <form method="post" id="user_form">
                                                    <div class="table-responsive">
                                                        <table id="tblparameter" class="table table-striped table-border table-condensed"  style="width: 100%;">
                                                            <thead class="text-center">
                                                                <tr>                                            
                                                                    <th style="display: none;">NOrden</th>
                                                                    <th>Detalle</th>
                                                                    <th>Valor Texto</th>
                                                                    <th>Valor Entero</th>
                                                                    <th>Estado</th>
                                                                    <th>Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody> 
                                                        </table>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>            
                                </div>
                                <div align="center">
                                    <button type="button" class="btn btn-outline-primary" id="btnSave"><i class='fas fa-bookmark'></i> Guardar</button>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
    </section>
</div>

<div class="modal fade" id="modalPARAMETER" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formParam">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="detalle" class="col-form-label">Detalle</label>
                        <input type="text" id="txtDetalle" required class="form-control" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label for="valorv" class="col-form-label">Valor Text</label>
                        <input type="text" id="txtValorv" class="form-control" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="valori" class="col-form-label">Valor Entero</label>
                        <input type="text" id="txtValori" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" class="form-control" maxlength="5">
                    </div>                                            
                    <div class="form-check" id="divcheck">
                        <input type="checkbox" id="chkEstado" class="form-check-input">
                        <label for="estadolabel" class="form-check-label" id="lblEstado">Activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="row_id" id="hidden_row_id" />
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnAgregar" class="btn btn-outline-primary ml-3">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>| 

<?php require_once '../dashmenu/panel_footer.php'; ?>
<script src="../codejs/parametros.js" type="text/javascript"></script>

</body>

</html>