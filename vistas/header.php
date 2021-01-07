<?php

  require_once("../config/conexion.php");

  if(isset($_SESSION['id_usuario']))
  {

?>


<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Sistema Compra - Venta | www.eyterhiguera.com</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../public/bower_components/Ionicons/css/ionicons.min.css">

  <!-- DataTables -->
  
  <!-- <link rel="stylesheet" href="../public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
  
  
  <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">


  <!-- Theme style -->
  <link rel="stylesheet" href="../public/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../public/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../public/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../public/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <!-- ESTILOS -->
  <link rel="stylesheet" href="../public/css/estilos.css">

</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">

      <!-- mini logo for sidebar mini 50x50 pixels -->

      <span class="logo-mini"><b>A</b>LT</span>

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Compra - Venta</b></span>

    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">

        <span class="sr-only">Toggle navigation</span>

      </a>

      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">
        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            
              <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
              <i class="fa fa-user" aria-hidden="true"></i>

              <span class="hidden-xs">Eyter Higuera</span>

            </a>

            <ul class="dropdown-menu">

              <!-- User image -->
              <li class="user-header">

                <!--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->

                <i class="fa fa-user" aria-hidden="true"></i>

                <p>

                  Eyter Higuera - Web Developer
                  <small>Administrador desde Noviembre 2017</small>

                </p>

              </li>

              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>-->
                <!-- /.row -->
              <!--</li>-->
              <!-- Menu Footer-->

              <li class="user-footer">

                <div class="pull-left">

                  <a href="#" class="btn btn-default btn-flat" onclick="mostrar_perfil('<?php echo $_SESSION['id_usuario']?>')" data-toggle="modal" data-target="#perfilModal">Perfil</a>

                </div>

                <div class="pull-right">

                  <a href="logout.php" class="btn btn-default btn-flat">Cerrar</a>

                </div>

              </li>

            </ul>

          </li>
      
        </ul>

      </div>

    </nav>

  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel -->
    
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="header">MENU</li>

        <li class="">

          <a href="home.php">

            <i class="fa fa-home" aria-hidden="true"></i> <span>Inicio</span>

          </a>
          
        </li>

        <li class="">

          <a href="categorias.php">

            <i class="fa fa-list" aria-hidden="true"></i> <span>Categoría</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">20</i>

            </span>

          </a>
        
        </li>

        <li class="">

          <a href="presentacion.php">

            <i class="fa fa-shopping-basket" aria-hidden="true"></i> <span>Presentación</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">20</i>

            </span>

          </a>
        
        </li>

        <li class="">

          <a href="productos.php">

            <i class="fa fa-tasks" aria-hidden="true"></i> <span>Productos</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">20</i>

            </span>

          </a>
        
        </li>

        <li class="">

              <a href="proveedores.php">

                <i class="fa fa-users"></i> <span>Proveedores</span>

                <span class="pull-right-container badge bg-blue">

                  <i class="fa fa-bell pull-right">5</i>

                </span>

              </a>

          </li>

          <li class="treeview">

          <a href="compras.php">

            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Compras</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">10</i>

              <i class="fa fa-angle-left pull-right"></i>

            </span>

            <ul class="treeview-menu">

              <li><a href="compras.php"><i class="fa fa-circle-o"></i> Compras</a></li>

              <li><a href="consultar_compras.php"><i class="fa fa-circle-o"></i> Consultar Compras</a></li>

              <li><a href="consultar_compras_fecha.php"><i class="fa fa-circle-o"></i> Consultar Compras Fecha</a></li>

              <li><a href="consultar_compras_mes.php"><i class="fa fa-circle-o"></i> Consultar Compras Mes</a></li>

            </ul>

          </a>
        
        </li>

          <li class="">

          <a href="clientes.php">

            <i class="fa fa-users"></i> <span>Clientes</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">3</i>

            </span>

          </a>
        
        </li>

        <li class="">

          <a href="ventas.php">

            <i class="fa fa-suitcase" aria-hidden="true"></i> <span>Ventas</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">8</i>

            </span>
          </a>
        
        </li>

        <li class="treeview">

          <a href="reporte_compras.php">

            <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Reportes de Compras</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">

            <li><a href="reporte_general_compras.php"><i class="fa fa-circle-o"></i>Reporte General Compras</a></li>
            
            <li><a href="reporte_compras_mensual.php"><i class="fa fa-circle-o"></i> Reporte Mensual Compras</a></li>

            <li><a href="reporte_compras_proveedor.php"><i class="fa fa-circle-o"></i> Reporte Compras-Proveedor</a></li>

          </ul>
        
        </li>

        <li class="treeview">

          <a href="reporte_ventas.php">

          <i class="fa fa-pie-chart" aria-hidden="true"></i> <span>Reportes de Ventas</span>

            <span class="pull-right-container badge bg-blue">

                <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

            <ul class="treeview-menu">

              <li><a href="reporte_general_ventas.php"><i class="fa fa-circle-o"></i>Reporte General Ventas</a></li>
              
              <li><a href="reporte_ventas_mensual.php"><i class="fa fa-circle-o"></i> Reporte Mensual Ventas</a></li>

              <li><a href="reporte_ventas_cliente.php"><i class="fa fa-circle-o"></i> Reporte Ventas-Cliente</a></li>

          
            </ul>
        
          </li>

        <li class="">

          <a href="usuarios.php">

            <i class="fa fa-user" aria-hidden="true"></i> <span>Usuarios</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">3</i>

            </span>

          </a>
        
        </li>

        <!-- <li class="">

          <a href="backup.php">

            <i class="fa fa-database" aria-hidden="true"></i> <span>BackUp</span>

            <span class="pull-right-container badge bg-blue">

              <i class="fa fa-bell pull-right">3</i>

            </span>

          </a>
        
        </li> -->

        <li class="">

          <a href="">
          
            <i class="fa fa-building" aria-hidden="true"></i> <span>Empresa</span>
            
          </a>
        
        </li>

      </ul>

    </section>
    <!-- /.sidebar -->

  </aside>





















      
<!-- =============================================================================
                          // FORMULARIO VENTANA MODAL
// ============================================================================= -->

<div id="resultados_ajax" class="text-center"></div>

<div id="perfilModal" class="modal fade">
  
  <div class="modal-dialog">
    
    <form method="post" id="perfil_form">

      <div class="modal-content">
        
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar perfil</h4>
          
        </div>


        <div class="modal-body">

          <label>Cédula</label>
          <input type="text" name="cedula_perfil" id="cedula_perfil" class="form-control" placeholder="Cédula" required pattern="[0-9]{0,15}"/>
          
          <br/>

          <label>Nombres</label>
          <input type="text" name="nombre_perfil" id="nombre_perfil" class="form-control" placeholder="Nombres" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          <br />
          
          <label>Apellidos</label>
          <input type="text" name="apellido_perfil" id="apellido_perfil" class="form-control" placeholder="Apellidos" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          <br />
          
          <label>Usuario</label>
          <input type="text" name="usuario_perfil" id="usuario_perfil" class="form-control" placeholder="Usuario" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          <br />
          
          <label>Password</label>
          <input type="password" name="password1_perfil" id="password1_perfil" class="form-control" placeholder="Password" required/>
          <br />
        
          <label>Repita Password</label>
          <input type="password" name="password2_perfil" id="password2_perfil" class="form-control" placeholder="Repita Password" required/>
          <br />
          
          <label>Teléfono</label>
          <input type="text" name="telefono_perfil" id="telefono_perfil" class="form-control" placeholder="Teléfono" required pattern="[0-9]{0,15}"/>
          <br />
          
          <label>Correo</label>
          <input type="email" name="email_perfil" id="email_perfil" class="form-control" placeholder="Correo" required="required"/>
          <br />
          
          <label>Dirección</label>
          <textarea cols="90" rows="3" id="direccion_perfil" class="form-control" name="direccion_perfil"  placeholder="Direccion ..." required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
          </textarea>
          <br />

        </div>


        <div class="modal-footer">

            <input type="hidden" name="id_usuario_perfil" id="id_usuario_perfil"/>

            <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            
            <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>

        </div>

      </div>
      
    </form>

  </div>

</div>


<script src="../public/bower_components/jquery/dist/jquery.min.js"></script>


<script src="js/perfil.js"></script>

<?php

  }
  else
  {
    header("Location:".Conectar::ruta()."vistas/index.php");
    exit();
  }

?>