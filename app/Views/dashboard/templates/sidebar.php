<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Dashboard</li>
            <li <?php if ($title == "Dashboard") : ?> class="active" <?php endif; ?>>
                <a href="/dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php if (session()->get('role') == 2) : ?>
                <li class="header">Manajemen</li>
                <li <?php if ($title == "Data Admin") : ?> class="active" <?php endif; ?>>
                    <a href="/user">
                        <i class="fa fa- fa-user-secret"></i> <span>Data Admin</span>
                    </a>
                </li>
                <li <?php if ($title == "Data Karyawan") : ?> class="active" <?php endif; ?>>
                    <a href="/employe">
                        <i class="fa fa-users"></i> <span>Data Karyawan</span>
                    </a>
                </li>
                <li <?php if ($title == "Data Dokumen") : ?> class="active" <?php endif; ?>>
                    <a href="/document">
                        <i class="fa fa-book"></i> <span>Data Dokumen</span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="header">Akun</li>
            <li <?php if ($title == "Profil") : ?> class="active" <?php endif; ?>>
                <a href="/profile">
                    <i class="fa fa-user"></i> <span>Profil</span>
                </a>
            </li>
            <li>
                <a id="logout" onclick="logout()" href="#">
                    <i class="fa fa-sign-out"></i> <span>Keluar</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>