<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SISKA | <?= $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url(); ?>/templates/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/templates/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url(); ?>/templates/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/templates/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url(); ?>/templates/dist/css/skins/skin-blue.css">
    <!-- Pace style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/templates/plugins/pace/pace.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <!-- jQuery 3 -->
    <script src="<?= base_url(); ?>/templates/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url(); ?>/templates/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <script src="<?= base_url(); ?>/templates/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>/templates/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- =============================================== -->

        <!-- isi konten topbar -->
        <?= $this->include('dashboard/templates/topbar'); ?>
        <!-- =============================================== -->

        <!-- isi konten sidebar -->
        <?= $this->include('dashboard/templates/sidebar'); ?>
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <!-- render section dengan nama dashboard-content -->
        <?= $this->renderSection('dashboard-content'); ?>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> Beta
            </div>
            <strong>Copyright &copy; 2021 PRATAMA ARDY PRAYOGA.</strong> All rights
            reserved.
        </footer>

        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url(); ?>/templates/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- PACE -->
    <script src="<?= base_url(); ?>/templates/bower_components/PACE/pace.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?= base_url(); ?>/templates/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url(); ?>/templates/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/templates/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url(); ?>/templates/dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree()
        })
    </script>

    <script type="text/javascript">
        function logout() {
            Swal.fire({
                animation: true,
                title: 'Keluar',
                text: "Anda akan keluar dari dashboard, yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Saya yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    window.location.href = '/auth/logout'
                }
            })
        }
    </script>
    <script>
        var toastMixin = Swal.mixin({
            toast: true,
            title: 'Notification',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            width: 300,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function sweetalert2($title, $icon = 'success') {
            toastMixin.fire({
                animation: true,
                title: $title,
                icon: $icon
            });
        }

        <?php
        // jika ada flashdata dengan nama alert, maka keluarkan alert sesuai kondisi
        if (session()->getFlashdata('alert')) :
            $alertType = session()->getFlashdata('alert');
            $alertDescription = session()->getFlashdata('description');
        ?>
            toastMixin.fire({
                animation: true,
                title: '<?= $alertDescription; ?>',
                icon: '<?= $alertType; ?>'
            });
        <?php endif; ?>
    </script>
</body>

</html>