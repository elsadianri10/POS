<?php
$menus = generate_menu(session('userID'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My PoS</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<link rel="stylesheet" href="assets/plugins/jqvmap/jqvmap.min.css">

<link rel="stylesheet" href="assets/dist/css/adminlte.min.css?v=3.2.0">

<link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">

<!-- CSS Datatable -->
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="\logout">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>


<aside class="main-sidebar sidebar-dark-primary elevation-4">

<a href="index3.html" class="brand-link">
<img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
<span class="brand-text font-weight-light">My PoS</span>
</a>

<div class="sidebar">

<div class="user-panel mt-3 pb-3 mb-3 d-flex">
<div class="image">
<img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
</div>
<div class="info">
 <a href="#" class="d-block"><?= ucwords(cek_profile(session('userID'))->nama); ?></a>
</div>
</div>

<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
<?php foreach ($menus as $menu) : ?>
  <li class="nav-header"><?= $menu->menu; ?></li>
  <?php $submenus = generate_submenu($menu->id, session('userID')); ?>
  <?php foreach($submenus as $submenu): ?>
<a href="<?= $submenu->link; ?>" class="nav-link <?= ($active->submenu == $submenu->submenu) ? 'active' : ''; ?>">
  <i class="nav-icon <?= $submenu->icon; ?>"></i>
<p>
  <?= $submenu->submenu; ?>
</p>
</a>
</li>
<?php endforeach; ?>
<?php endforeach; ?>
</ul>
</nav>

</div>

</aside>

<div class="content-wrapper">

<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0"> <?= $title; ?>

</h1>
</div>
</div>
</div>
</div>


<section class="content">
<div class="container-fluid">

<?= $this->renderSection('content'); ?>

</div>
</section>

</div>

<footer class="main-footer">
<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
All rights reserved.
<div class="float-right d-none d-sm-inline-block">
<b>Version</b> 3.2.0
</div>
</footer>

<aside class="control-sidebar control-sidebar-dark">

</aside>

</div>


<script src="assets/plugins/jquery/jquery.min.js"></script>

<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/plugins/chart.js/Chart.min.js"></script>

<script src="assets/plugins/sparklines/sparkline.js"></script>

<script src="assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<script src="assets/plugins/jquery-knob/jquery.knob.min.js"></script>

<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>

<script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>

<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="assets/dist/js/adminlte.js?v=3.2.0"></script>

<script src="assets/dist/js/pages/dashboard.js"></script>

<!-- Script JS Datatable -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jszip/jszip.min.js"></script>
<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $('.datatable').DataTable();
</script>
</body>

</html>
