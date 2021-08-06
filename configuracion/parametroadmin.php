<?php 

require_once '../dashmenu/panel_menu.php'; 

$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : '';

$consulta = "CALL sp_Consulta_Datos(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(24,$_SESSION["i_emprcodigo"],'','','','','','',0,0,0,0,0,0));
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="content-wrapper">
    <input type="hidden" id="mensaje" value="<?php echo $mensaje ?>">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>DataTables</h1> -->
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content-fluid">
        <div class="container">
            <br />                
            <div class="row">            
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">                            
                            <button type="button" class="btn btn-outline-primary" id="btnNuevo" style="margin-bottom:10px"><i class="fas fa-plus"></i> Nuevo</button>
                        </div>
                        <div class="card-body">
                            <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Parámetro</th>
                                        <th>Descipción</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($data as $datos){
                                    ?>  
                                        <tr>
                                            <td><?php echo $dat['ParaId'] ?></td>
                                            <td><?php echo $dat['Parametro'] ?></td>
                                            <td><?php echo $dat['Descripcion'] ?></td>
                                            <td><?php echo $dat['Estado'] ?></td>
                                            <td>
                                                <div class="text-center">
                                                    <div class="btn-group">
                                                        <button class="btn btn-outline-info btn-sm ml-3" id="btnEditar">
                                                        <i class="fas fa-file"></i></button>
                                                        <button class="btn btn-outline-danger btn-sm ml-3" id="btnEliminar">
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
    <script src="../codejs/parametros.js" type="text/javascript"></script>

    </body>
</html>