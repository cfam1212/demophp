<?php

session_start();

if($_SESSION["s_usuario"] === null){
    header("Location: ../../index.php");
}

include_once('../bd/conexion.php');

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "CALL sp_consulta_menu_usuario(?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(0,$_SESSION["i_usuaid"]));
$menu = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta = "CALL sp_consulta_menu_padre(?,?)";
$resultado = $conexion->prepare($consulta);
$resultado->execute(array(0,$_SESSION["i_usuaid"]));
$padremenu = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SoftCob</title>
    <link rel="icon" type="image/png" href="../images/logo.png" >

    <link rel="stylesheet" href="../vendors/datatable/css/jquery.dataTables.min.css">

    <link href="../vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <link href="../vendors/fontawesome/css/font-awesome.min.css" rel="stylesheet" />

    <link href="../vendors/nprogress/css/nprogress.css" rel="stylesheet" />

    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" />

    <link href="../vendors/datatable/css/dataTables.bootstrap.min.css" rel="stylesheet" />

    <link href="../vendors/datatable/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />

    <link href="../vendors/jquery/css/jquery-ui.min.css" rel="stylesheet" />

    <link href="../vendors/jqvmap/css/jqvmap.min.css" rel="stylesheet" />

    <link href="../vendors/sweetalert2/css/sweetalert2.min.css" rel="stylesheet" />

    <link href="../vendors/bootstrap-daterangepicker/css/daterangepicker.css" rel="stylesheet" />

    <link href="../css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">              
              <a href="../dashmenu/panel_content.php" class="site_title">                
                <span>SoftCob</span>
              </a>             
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <img src="<?php echo $_SESSION["s_logoempresa"]; ?> " alt="..." width="100%">
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menú Principal</h3>
                <ul class="nav side-menu">
                  <?php
                      $tempmenu = null;
                      $menusuperior = null;
                      foreach($menu as $menurow)
                      {
                        if($menurow["CodigoMenuPadre"] == null)
                        {
                          if($tempmenu != $menurow["MenuId"])
                          {
                            echo "<li><a>";
                            echo "<i class='" . $menurow['IconoMenu'] . "'></i> ";                    
                            echo $menurow["Menu"];
                            echo " <span class='fa fa-chevron-down'></span></a>";
                            echo "<ul class='nav child_menu'>";
                            foreach($menu as $submenu)
                            {
                              if($submenu["MenuId"] == $menurow["MenuId"])
                              {
                                echo "<li>";
                                echo "<a href='" . $submenu["Accion"] . "'>" . $submenu["Tarea"] ."</a></li>";
                              }
                            }
                            echo "</ul></li>";
                          }
                        }
                        else
                        {
                          if($menusuperior != $menurow['CodigoMenuPadre'])
                          {
                            echo "<li class='nav-item'>";
                            echo "<a href='#' class='nav-link'>";
                            echo "<i class='" . "nav-icon " . $menurow['IconoMenu'] . "'></i>";                    
                            echo "<p>" . $menurow["Menu"];
                            echo "<i class='right fas fa-angle-left'></i>";
                            echo "</p></a>";
                            $tempmenu = null;
                            $menumain = $row['CodigoMenuPadre'];
                            echo "<ul class='nav nav-treeview'>";
                            foreach($menu as $menuinicio){
                              if($menuinicio['CodigoMenuPadre'] == $menumain){
                                if($tempmenu != $menuinicio['MenuId'])
                                {
                                  echo "<li class='nav-item'>";
                                  echo "<a href='#' class='nav-link'>";
                                  echo "<i class='" . "nav-icon " . $menuinicio['IconoMenu'] . "'></i>";                    
                                  echo "<p>" . $menuinicio["Menu"];
                                  echo "<i class='right fas fa-angle-left'></i>";
                                  echo "</p></a>"; 
                                }
                                $tempmenu = $menurow['MenuId'];
                              }
                            }
                            echo "</ul></li>";                                        
                          }
                        }
                        $tempmenu = $menurow['MenuId'];
                        $menusuperior = $menurow['CodigoMenuPadre'];                
                      }
                    ?>


                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      <img src="<?php echo $_SESSION["s_foto"] ?>" alt=""><?php echo $_SESSION["s_usuario"] ?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item"  href="javascript:;"> Profile</a>
                        <a class="dropdown-item"  href="javascript:;">
                          <span class="badge bg-red pull-right">50%</span>
                          <span>Settings</span>
                        </a>
                    <a class="dropdown-item"  href="javascript:;">Help</a>
                      <a class="dropdown-item"  href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                  </li>
  
                  <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <span class="badge bg-green">6</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="../images/user-icon.png" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="../images/user-icon.png" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="../images/user-icon.png" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="../images/user-icon.png" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <div class="text-center">
                          <a class="dropdown-item">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>