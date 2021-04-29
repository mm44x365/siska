<header class="main-header">
    <!-- Logo -->
    <a class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>SKA</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>SISKA</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url(); ?>/img/<?= session()->get('img'); ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= session()->get('fullname'); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= base_url(); ?>/img/<?= session()->get('img'); ?>" class="img-circle" alt="User Image">

                            <p>
                                <?= session()->get('fullname'); ?>
                                <small>Terdaftar <?= session()->get('created_at'); ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= base_url('profile'); ?>" class="btn btn-default btn-flat">Profil</a>
                            </div>
                            <div class="pull-right">
                                <a onclick="logout()" class="btn btn-default btn-flat">Keluar</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>